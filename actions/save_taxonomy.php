<?php
/**
 * ============================================================================
 * EU TAXONOMY HANDLER
 * ============================================================================
 * 
 * Handles EU Taxonomy reporting data entry
 * 
 * Coverage:
 * - Economic activities alignment
 * - Eligible and aligned revenue/CapEx/OpEx percentages
 * - DNSH (Do No Significant Harm) assessment
 * - Social safeguards compliance
 * - Technical screening criteria
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
        'message' => 'Invalid status value'
    ]);
    exit;
}

// Economic Activities
$economicActivities = trim($_POST['economicActivities'] ?? '');
$technicalScreeningCriteria = trim($_POST['technicalScreeningCriteria'] ?? '');

// Revenue Alignment
$taxonomyEligibleRevenuePct = !empty($_POST['taxonomyEligibleRevenuePct']) 
    ? intval($_POST['taxonomyEligibleRevenuePct']) 
    : null;
$taxonomyAlignedRevenuePct = !empty($_POST['taxonomyAlignedRevenuePct']) 
    ? intval($_POST['taxonomyAlignedRevenuePct']) 
    : null;

// CapEx & OpEx Alignment
$taxonomyEligibleCapexPct = !empty($_POST['taxonomyEligibleCapexPct']) 
    ? intval($_POST['taxonomyEligibleCapexPct']) 
    : null;
$taxonomyAlignedCapexPct = !empty($_POST['taxonomyAlignedCapexPct']) 
    ? intval($_POST['taxonomyAlignedCapexPct']) 
    : null;
$taxonomyAlignedOpexPct = !empty($_POST['taxonomyAlignedOpexPct']) 
    ? intval($_POST['taxonomyAlignedOpexPct']) 
    : null;

// DNSH Status
$dnsh_status = !empty($_POST['dnsh_status']) ? trim($_POST['dnsh_status']) : null;
$validDNSH = ['ALL_OBJECTIVES_PASSED', 'SOME_OBJECTIVES_NOT_MET', 'ASSESSMENT_IN_PROGRESS'];
if ($dnsh_status !== null && !in_array($dnsh_status, $validDNSH)) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid DNSH status value'
    ]);
    exit;
}

// Social Safeguards Status
$social_safeguards_status = !empty($_POST['social_safeguards_status']) 
    ? trim($_POST['social_safeguards_status']) 
    : null;
$validSafeguards = ['FULL_COMPLIANCE', 'NON_COMPLIANCE', 'PARTIAL_REMEDIATION'];
if ($social_safeguards_status !== null && !in_array($social_safeguards_status, $validSafeguards)) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid social safeguards status value'
    ]);
    exit;
}

// ============================================================================
// VALIDATE PERCENTAGE RANGES
// ============================================================================
$percentages = [
    'taxonomyEligibleRevenuePct' => $taxonomyEligibleRevenuePct,
    'taxonomyAlignedRevenuePct' => $taxonomyAlignedRevenuePct,
    'taxonomyEligibleCapexPct' => $taxonomyEligibleCapexPct,
    'taxonomyAlignedCapexPct' => $taxonomyAlignedCapexPct,
    'taxonomyAlignedOpexPct' => $taxonomyAlignedOpexPct
];

foreach ($percentages as $field => $value) {
    if ($value !== null && ($value < 0 || $value > 100)) {
        echo json_encode([
            'success' => false,
            'message' => "{$field} must be between 0 and 100"
        ]);
        exit;
    }
}

// Validate aligned <= eligible
if ($taxonomyAlignedRevenuePct !== null && $taxonomyEligibleRevenuePct !== null) {
    if ($taxonomyAlignedRevenuePct > $taxonomyEligibleRevenuePct) {
        echo json_encode([
            'success' => false,
            'message' => 'Aligned revenue cannot exceed eligible revenue'
        ]);
        exit;
    }
}

if ($taxonomyAlignedCapexPct !== null && $taxonomyEligibleCapexPct !== null) {
    if ($taxonomyAlignedCapexPct > $taxonomyEligibleCapexPct) {
        echo json_encode([
            'success' => false,
            'message' => 'Aligned CapEx cannot exceed eligible CapEx'
        ]);
        exit;
    }
}

// ============================================================================
// UPSERT TAXONOMY RECORD
// ============================================================================
try {
    // Check if record exists
    $stmt = $pdo->prepare("
        SELECT id FROM eu_taxonomy 
        WHERE company_id = ? AND reporting_period = ?
    ");
    $stmt->execute([$companyId, $reportingPeriod]);
    $existing = $stmt->fetch();
    
    if ($existing) {
        // UPDATE existing record
        $stmt = $pdo->prepare("
            UPDATE eu_taxonomy SET
                status = ?,
                updated_by = ?,
                
                -- Economic Activities
                economic_activities = ?,
                technical_screening_criteria = ?,
                
                -- Revenue Alignment
                taxonomy_eligible_revenue_pct = ?,
                taxonomy_aligned_revenue_pct = ?,
                
                -- CapEx & OpEx
                taxonomy_eligible_capex_pct = ?,
                taxonomy_aligned_capex_pct = ?,
                taxonomy_aligned_opex_pct = ?,
                
                -- Compliance
                dnsh_status = ?,
                social_safeguards_status = ?,
                
                updated_at = NOW()
            WHERE id = ?
        ");
        
        $stmt->execute([
            $status,
            $userId,
            $economicActivities,
            $technicalScreeningCriteria,
            $taxonomyEligibleRevenuePct,
            $taxonomyAlignedRevenuePct,
            $taxonomyEligibleCapexPct,
            $taxonomyAlignedCapexPct,
            $taxonomyAlignedOpexPct,
            $dnsh_status,
            $social_safeguards_status,
            $existing['id']
        ]);
        
        $recordId = $existing['id'];
        $action = 'updated';
        
    } else {
        // INSERT new record
        $recordId = bin2hex(random_bytes(16));
        
        $stmt = $pdo->prepare("
            INSERT INTO eu_taxonomy (
                id, company_id, reporting_period, status, created_by,
                
                economic_activities,
                technical_screening_criteria,
                taxonomy_eligible_revenue_pct,
                taxonomy_aligned_revenue_pct,
                taxonomy_eligible_capex_pct,
                taxonomy_aligned_capex_pct,
                taxonomy_aligned_opex_pct,
                dnsh_status,
                social_safeguards_status,
                
                created_at, updated_at
            )
            VALUES (
                ?, ?, ?, ?, ?,
                ?, ?, ?, ?, ?, ?, ?,
                ?, ?,
                NOW(), NOW()
            )
        ");
        
        $stmt->execute([
            $recordId,
            $companyId,
            $reportingPeriod,
            $status,
            $userId,
            $economicActivities,
            $technicalScreeningCriteria,
            $taxonomyEligibleRevenuePct,
            $taxonomyAlignedRevenuePct,
            $taxonomyEligibleCapexPct,
            $taxonomyAlignedCapexPct,
            $taxonomyAlignedOpexPct,
            $dnsh_status,
            $social_safeguards_status
        ]);
        
        $action = 'created';
    }
    
    // ========================================================================
    // CALCULATE ALIGNMENT RATIO
    // ========================================================================
    $alignmentRatio = null;
    if ($taxonomyEligibleRevenuePct !== null && $taxonomyEligibleRevenuePct > 0) {
        $alignmentRatio = $taxonomyAlignedRevenuePct !== null 
            ? round(($taxonomyAlignedRevenuePct / $taxonomyEligibleRevenuePct) * 100, 1)
            : 0;
    }
    
    // ========================================================================
    // SUCCESS RESPONSE
    // ========================================================================
    echo json_encode([
        'success' => true,
        'message' => "EU Taxonomy report {$action} successfully",
        'data' => [
            'recordId' => $recordId,
            'action' => $action,
            'companyId' => $companyId,
            'reportingPeriod' => $reportingPeriod,
            'status' => $status,
            'alignment' => [
                'eligibleRevenue' => $taxonomyEligibleRevenuePct,
                'alignedRevenue' => $taxonomyAlignedRevenuePct,
                'alignmentRatio' => $alignmentRatio,
                'eligibleCapEx' => $taxonomyEligibleCapexPct,
                'alignedCapEx' => $taxonomyAlignedCapexPct,
                'alignedOpEx' => $taxonomyAlignedOpexPct
            ],
            'compliance' => [
                'dnshStatus' => $dnsh_status,
                'socialSafeguardsStatus' => $social_safeguards_status,
                'hasTechnicalScreening' => !empty($technicalScreeningCriteria),
                'hasEconomicActivities' => !empty($economicActivities)
            ]
        ]
    ]);
    
} catch (PDOException $e) {
    error_log("EU Taxonomy save error: " . $e->getMessage());
    
    // Check for duplicate key error
    if ($e->getCode() == 23000) {
        echo json_encode([
            'success' => false,
            'message' => 'An EU Taxonomy report for this period already exists'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Database error: ' . $e->getMessage()
        ]);
    }
}
?>
