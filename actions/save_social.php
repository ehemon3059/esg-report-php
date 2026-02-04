<?php
/**
 * ============================================================================
 * SOCIAL TOPICS HANDLER - ESRS S1-S4
 * ============================================================================
 * 
 * Handles social reporting data entry (S1-S4)
 * 
 * Coverage:
 * - S1: Own Workforce
 * - S2: Workers in Value Chain
 * - S3: Affected Communities
 * - S4: Consumers & End Users
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
$validStatuses = ['DRAFT', 'UNDER_REVIEW', 'APPROVED', 'PUBLISHED', 'REJECTED'];
if (!in_array($status, $validStatuses)) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid status value'
    ]);
    exit;
}

// S1 - Own Workforce
$s1_material = isset($_POST['s1_material']) ? 1 : 0;
$s1_employee_count_by_contract = trim($_POST['s1_employee_count_by_contract'] ?? '');
$s1_health_and_safety = trim($_POST['s1_health_and_safety'] ?? '');
$s1_training_hours_per_employee = !empty($_POST['s1_training_hours_per_employee']) 
    ? intval($_POST['s1_training_hours_per_employee']) 
    : null;

// S2 - Workers in Value Chain
$s2_material = isset($_POST['s2_material']) ? 1 : 0;
$s2_pct_suppliers_audited = !empty($_POST['s2_pct_suppliers_audited']) 
    ? intval($_POST['s2_pct_suppliers_audited']) 
    : null;
$s2_remediation_actions = trim($_POST['s2_remediation_actions'] ?? '');

// S3 - Affected Communities
$s3_material = isset($_POST['s3_material']) ? 1 : 0;
$s3_community_engagement = trim($_POST['s3_community_engagement'] ?? '');
$s3_complaints_and_outcomes = trim($_POST['s3_complaints_and_outcomes'] ?? '');

// S4 - Consumers & End Users
$s4_material = isset($_POST['s4_material']) ? 1 : 0;
$s4_product_safety_incidents = !empty($_POST['s4_product_safety_incidents']) 
    ? intval($_POST['s4_product_safety_incidents']) 
    : null;
$s4_consumer_remediation = trim($_POST['s4_consumer_remediation'] ?? '');

// ============================================================================
// UPSERT SOCIAL TOPICS RECORD
// ============================================================================
try {
    // Check if record exists
    $stmt = $pdo->prepare("
        SELECT id FROM social_topics 
        WHERE company_id = ? AND reporting_period = ?
    ");
    $stmt->execute([$companyId, $reportingPeriod]);
    $existing = $stmt->fetch();
    
    if ($existing) {
        // UPDATE existing record
        $stmt = $pdo->prepare("
            UPDATE social_topics SET
                status = ?,
                updated_by = ?,
                
                -- S1: Own Workforce
                s1_material = ?,
                s1_employee_count_by_contract = ?,
                s1_health_and_safety = ?,
                s1_training_hours_per_employee = ?,
                
                -- S2: Workers in Value Chain
                s2_material = ?,
                s2_pct_suppliers_audited = ?,
                s2_remediation_actions = ?,
                
                -- S3: Affected Communities
                s3_material = ?,
                s3_community_engagement = ?,
                s3_complaints_and_outcomes = ?,
                
                -- S4: Consumers & End Users
                s4_material = ?,
                s4_product_safety_incidents = ?,
                s4_consumer_remediation = ?,
                
                updated_at = NOW()
            WHERE id = ?
        ");
        
        $stmt->execute([
            $status,
            $userId,
            // S1
            $s1_material,
            $s1_employee_count_by_contract,
            $s1_health_and_safety,
            $s1_training_hours_per_employee,
            // S2
            $s2_material,
            $s2_pct_suppliers_audited,
            $s2_remediation_actions,
            // S3
            $s3_material,
            $s3_community_engagement,
            $s3_complaints_and_outcomes,
            // S4
            $s4_material,
            $s4_product_safety_incidents,
            $s4_consumer_remediation,
            // WHERE
            $existing['id']
        ]);
        
        $recordId = $existing['id'];
        $action = 'updated';
        
    } else {
        // INSERT new record
        $recordId = bin2hex(random_bytes(16));
        
        $stmt = $pdo->prepare("
            INSERT INTO social_topics (
                id, company_id, reporting_period, status, created_by,
                
                -- S1: Own Workforce
                s1_material, s1_employee_count_by_contract, 
                s1_health_and_safety, s1_training_hours_per_employee,
                
                -- S2: Workers in Value Chain
                s2_material, s2_pct_suppliers_audited, s2_remediation_actions,
                
                -- S3: Affected Communities
                s3_material, s3_community_engagement, s3_complaints_and_outcomes,
                
                -- S4: Consumers & End Users
                s4_material, s4_product_safety_incidents, s4_consumer_remediation,
                
                created_at, updated_at
            )
            VALUES (
                ?, ?, ?, ?, ?,
                ?, ?, ?, ?,
                ?, ?, ?,
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
            // S1
            $s1_material,
            $s1_employee_count_by_contract,
            $s1_health_and_safety,
            $s1_training_hours_per_employee,
            // S2
            $s2_material,
            $s2_pct_suppliers_audited,
            $s2_remediation_actions,
            // S3
            $s3_material,
            $s3_community_engagement,
            $s3_complaints_and_outcomes,
            // S4
            $s4_material,
            $s4_product_safety_incidents,
            $s4_consumer_remediation
        ]);
        
        $action = 'created';
    }
    
    // ========================================================================
    // SUCCESS RESPONSE
    // ========================================================================
    echo json_encode([
        'success' => true,
        'message' => "Social topics report {$action} successfully",
        'data' => [
            'recordId' => $recordId,
            'action' => $action,
            'companyId' => $companyId,
            'reportingPeriod' => $reportingPeriod,
            'status' => $status,
            'materialTopics' => [
                'S1_OwnWorkforce' => (bool)$s1_material,
                'S2_ValueChain' => (bool)$s2_material,
                'S3_Communities' => (bool)$s3_material,
                'S4_Consumers' => (bool)$s4_material
            ]
        ]
    ]);
    
} catch (PDOException $e) {
    error_log("Social topics save error: " . $e->getMessage());
    
    // Check for duplicate key error
    if ($e->getCode() == 23000) {
        echo json_encode([
            'success' => false,
            'message' => 'A social report for this period already exists'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Database error: ' . $e->getMessage()
        ]);
    }
}
?>
