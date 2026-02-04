<?php
/**
 * ============================================================================
 * GOVERNANCE HANDLER - ESRS G1
 * ============================================================================
 * 
 * Handles governance reporting data entry (G1)
 * 
 * Coverage:
 * - Board structure and composition
 * - ESG oversight mechanisms
 * - Business conduct and ethics
 * - Anti-corruption policies
 * - Whistleblower protection
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
// VALIDATE REQUIRED FIELDS
// ============================================================================
$required = ['reportingPeriod', 'status'];
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

// ============================================================================
// SANITIZE INPUTS
// ============================================================================
$reportingPeriod = trim($_POST['reportingPeriod']);
$status = trim($_POST['status']);

// Validate status enum
$validStatuses = ['DRAFT', 'SUBMITTED', 'APPROVED', 'REJECTED'];
if (!in_array($status, $validStatuses)) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid status value. Must be one of: ' . implode(', ', $validStatuses)
    ]);
    exit;
}

// Board Structure & Composition
$g1_board_composition_independence = trim($_POST['g1_board_composition_independence'] ?? '');
$g1_gender_diversity_pct = !empty($_POST['g1_gender_diversity_pct']) 
    ? intval($_POST['g1_gender_diversity_pct']) 
    : null;
$g1_esg_oversight = trim($_POST['g1_esg_oversight'] ?? '');

// Business Conduct & Ethics
$g1_whistleblower_cases = trim($_POST['g1_whistleblower_cases'] ?? '');
$g1_anti_corruption_policies = trim($_POST['g1_anti_corruption_policies'] ?? '');
$g1_related_party_controls = trim($_POST['g1_related_party_controls'] ?? '');

// Validate percentage if provided
if ($g1_gender_diversity_pct !== null) {
    if ($g1_gender_diversity_pct < 0 || $g1_gender_diversity_pct > 100) {
        echo json_encode([
            'success' => false,
            'message' => 'Gender diversity percentage must be between 0 and 100'
        ]);
        exit;
    }
}

// ============================================================================
// UPSERT GOVERNANCE RECORD
// ============================================================================
try {
    // Check if record exists
    $stmt = $pdo->prepare("
        SELECT id FROM s_governance 
        WHERE company_id = ? AND reporting_period = ?
    ");
    $stmt->execute([$companyId, $reportingPeriod]);
    $existing = $stmt->fetch();
    
    if ($existing) {
        // UPDATE existing record
        $stmt = $pdo->prepare("
            UPDATE s_governance SET
                status = ?,
                updated_by = ?,
                
                -- Board Structure
                g1_board_composition_independence = ?,
                g1_gender_diversity_pct = ?,
                g1_esg_oversight = ?,
                
                -- Business Conduct
                g1_whistleblower_cases = ?,
                g1_anti_corruption_policies = ?,
                g1_related_party_controls = ?,
                
                updated_at = NOW()
            WHERE id = ?
        ");
        
        $stmt->execute([
            $status,
            $userId,
            $g1_board_composition_independence,
            $g1_gender_diversity_pct,
            $g1_esg_oversight,
            $g1_whistleblower_cases,
            $g1_anti_corruption_policies,
            $g1_related_party_controls,
            $existing['id']
        ]);
        
        $recordId = $existing['id'];
        $action = 'updated';
        
    } else {
        // INSERT new record
        $recordId = bin2hex(random_bytes(16));
        
        $stmt = $pdo->prepare("
            INSERT INTO s_governance (
                id, company_id, reporting_period, status, created_by,
                
                -- Board Structure
                g1_board_composition_independence,
                g1_gender_diversity_pct,
                g1_esg_oversight,
                
                -- Business Conduct
                g1_whistleblower_cases,
                g1_anti_corruption_policies,
                g1_related_party_controls,
                
                created_at, updated_at
            )
            VALUES (
                ?, ?, ?, ?, ?,
                ?, ?, ?,
                ?, ?, ?,
                NOW(), NOW()
            )
        ");
        
        $stmt->execute([
            $recordId,
            $companyId,
            $reportingPeriod,
            $status,
            $userId,
            $g1_board_composition_independence,
            $g1_gender_diversity_pct,
            $g1_esg_oversight,
            $g1_whistleblower_cases,
            $g1_anti_corruption_policies,
            $g1_related_party_controls
        ]);
        
        $action = 'created';
    }
    
    // ========================================================================
    // CALCULATE COMPLETION PERCENTAGE
    // ========================================================================
    $completedFields = 0;
    $totalFields = 6;
    
    if (!empty($g1_board_composition_independence)) $completedFields++;
    if ($g1_gender_diversity_pct !== null) $completedFields++;
    if (!empty($g1_esg_oversight)) $completedFields++;
    if (!empty($g1_whistleblower_cases)) $completedFields++;
    if (!empty($g1_anti_corruption_policies)) $completedFields++;
    if (!empty($g1_related_party_controls)) $completedFields++;
    
    $completionPercentage = round(($completedFields / $totalFields) * 100);
    
    // ========================================================================
    // SUCCESS RESPONSE
    // ========================================================================
    echo json_encode([
        'success' => true,
        'message' => "Governance report {$action} successfully",
        'data' => [
            'recordId' => $recordId,
            'action' => $action,
            'companyId' => $companyId,
            'reportingPeriod' => $reportingPeriod,
            'status' => $status,
            'completion' => [
                'percentage' => $completionPercentage,
                'completedFields' => $completedFields,
                'totalFields' => $totalFields
            ],
            'governance' => [
                'boardIndependence' => $g1_board_composition_independence,
                'genderDiversity' => $g1_gender_diversity_pct,
                'hasESGOversight' => !empty($g1_esg_oversight),
                'hasWhistleblowerMechanism' => !empty($g1_whistleblower_cases),
                'hasAntiCorruptionPolicy' => !empty($g1_anti_corruption_policies),
                'hasRelatedPartyControls' => !empty($g1_related_party_controls)
            ]
        ]
    ]);
    
} catch (PDOException $e) {
    error_log("Governance save error: " . $e->getMessage());
    
    // Check for duplicate key error
    if ($e->getCode() == 23000) {
        echo json_encode([
            'success' => false,
            'message' => 'A governance report for this period already exists'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Database error: ' . $e->getMessage()
        ]);
    }
}
?>
