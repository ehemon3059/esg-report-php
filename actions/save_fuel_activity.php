<?php
/**
 * ============================================================================
 * FUEL ACTIVITY HANDLER - Scope 1 Emissions
 * ============================================================================
 * 
 * Handles fuel consumption data entry and automatic emission calculation
 * 
 * Process Flow:
 * 1. Validate and sanitize input
 * 2. Insert fuel activity record
 * 3. Lookup emission factor
 * 4. Calculate tCO2e
 * 5. Insert emission record
 * 6. Return calculation result
 * 
 * @package ESG_Reporting
 * @version 1.0.0
 */

session_start();
require_once '../config/database.php';
require_once '../includes/auth.php';
requireLogin();

// Set JSON response header
header('Content-Type: application/json');

// ============================================================================
// GET CURRENT USER & COMPANY
// ============================================================================
$companyId = getCurrentCompanyId();
$userId = getCurrentUserId();

if (!$companyId || !$userId) {
    echo json_encode([
        'success' => false,
        'message' => 'Authentication error. Please login again.'
    ]);
    exit;
}

// ============================================================================
// VALIDATE INPUT
// ============================================================================
$required = ['siteId', 'date', 'fuelType', 'volume', 'unit'];
$missing = [];

foreach ($required as $field) {
    if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
        $missing[] = $field;
    }
}

if (!empty($missing)) {
    echo json_encode([
        'success' => false,
        'message' => 'Missing required fields: ' . implode(', ', $missing)
    ]);
    exit;
}

// Sanitize inputs
$siteId = trim($_POST['siteId']);
$date = trim($_POST['date']);
$fuelType = trim($_POST['fuelType']);
$volume = floatval($_POST['volume']);
$unit = trim($_POST['unit']);

// Validate volume is positive
if ($volume <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Volume must be greater than zero'
    ]);
    exit;
}

// ============================================================================
// VERIFY SITE BELONGS TO COMPANY
// ============================================================================
try {
    $stmt = $pdo->prepare("
        SELECT id FROM sites 
        WHERE id = ? AND company_id = ? AND deleted_at IS NULL
    ");
    $stmt->execute([$siteId, $companyId]);
    
    if (!$stmt->fetch()) {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid site selected or site does not belong to your company'
        ]);
        exit;
    }
} catch (PDOException $e) {
    error_log("Site verification error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Database error during site verification'
    ]);
    exit;
}

// ============================================================================
// START TRANSACTION
// ============================================================================
try {
    $pdo->beginTransaction();
    
    // ------------------------------------------------------------------------
    // STEP 1: Insert Fuel Activity
    // ------------------------------------------------------------------------
    $activityId = bin2hex(random_bytes(16)); // Generate UUID-like ID
    
    $stmt = $pdo->prepare("
        INSERT INTO fuel_activities (id, site_id, date, fuel_type, volume, unit)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    
    $stmt->execute([
        $activityId,
        $siteId,
        $date,
        $fuelType,
        $volume,
        $unit
    ]);
    
    // ------------------------------------------------------------------------
    // STEP 2: Get Emission Factor
    // ------------------------------------------------------------------------
    $stmt = $pdo->prepare("
        SELECT id, factor, unit as factor_unit, source, version
        FROM emission_factors
        WHERE activity_type = ? 
          AND scope = 'Scope 1'
          AND is_active = 1
          AND (valid_until IS NULL OR valid_until > NOW())
        ORDER BY valid_from DESC
        LIMIT 1
    ");
    
    $stmt->execute([$fuelType]);
    $factor = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$factor) {
        $pdo->rollBack();
        echo json_encode([
            'success' => false,
            'message' => "No active emission factor found for {$fuelType}. Please configure emission factors first."
        ]);
        exit;
    }
    
    // ------------------------------------------------------------------------
    // STEP 3: Calculate Emissions (tCO2e)
    // ------------------------------------------------------------------------
    // factor['factor'] is in kg CO2e per unit (e.g., kg CO2e/m³)
    // volume is in the specified unit
    // Result: (volume * factor) / 1000 = tonnes CO2e
    
    $emissionKg = $volume * $factor['factor'];
    $emissionTonnes = $emissionKg / 1000;
    
    // ------------------------------------------------------------------------
    // STEP 4: Insert Emission Record
    // ------------------------------------------------------------------------
    $emissionRecordId = bin2hex(random_bytes(16));
    
    $stmt = $pdo->prepare("
        INSERT INTO emission_records (
            id, company_id, scope, tco2e_calculated, 
            fuel_activity_id, emission_factor_id, date_calculated
        )
        VALUES (?, ?, 'Scope 1', ?, ?, ?, NOW())
    ");
    
    $stmt->execute([
        $emissionRecordId,
        $companyId,
        $emissionTonnes,
        $activityId,
        $factor['id']
    ]);
    
    // ------------------------------------------------------------------------
    // COMMIT TRANSACTION
    // ------------------------------------------------------------------------
    $pdo->commit();
    
    // ------------------------------------------------------------------------
    // SUCCESS RESPONSE
    // ------------------------------------------------------------------------
    echo json_encode([
        'success' => true,
        'message' => 'Fuel activity recorded and emissions calculated successfully',
        'data' => [
            'activityId' => $activityId,
            'emissionRecordId' => $emissionRecordId,
            'calculation' => [
                'volume' => $volume,
                'unit' => $unit,
                'fuelType' => $fuelType,
                'emissionFactor' => $factor['factor'],
                'factorUnit' => $factor['factor_unit'],
                'factorSource' => $factor['source'] ?? 'Custom',
                'factorVersion' => $factor['version'],
                'emissionKg' => round($emissionKg, 2),
                'emissionTonnes' => round($emissionTonnes, 4),
                'formula' => "{$volume} {$unit} × {$factor['factor']} {$factor['factor_unit']} = {$emissionKg} kg CO2e"
            ],
            'scope' => 'Scope 1',
            'date' => $date,
            'site' => $siteId
        ]
    ]);
    
} catch (PDOException $e) {
    // Rollback on error
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    
    error_log("Fuel activity save error: " . $e->getMessage());
    
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
?>
