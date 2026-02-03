<?php
session_start();
require_once 'config/database.php';
require_once 'includes/auth.php';
requireLogin();

$companyId = getCurrentCompanyId();
$userId = getCurrentUserId();

$stmt = $pdo->prepare("
    INSERT INTO environmental_topics 
    (id, company_id, reporting_period, status, created_by,
     e1_material, e1_climate_policy, e1_reduction_target,
     e2_nox_t_per_year, e2_sox_t_per_year,
     e3_water_withdrawal_m3, e3_water_recycling_rate_pct,
     e4_protected_areas_impact,
     e5_recycling_rate_pct, e5_recycled_input_materials_pct,
     created_at, updated_at)
    VALUES (UUID(), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
    ON DUPLICATE KEY UPDATE
        e1_climate_policy = VALUES(e1_climate_policy),
        updated_by = ?,
        updated_at = NOW()
");

$stmt->execute([
    $companyId,
    $_POST['reporting_period'],
    $_POST['status'],
    $userId,
    isset($_POST['e1_material']) ? 1 : 0,
    $_POST['e1_climate_policy'],
    $_POST['e1_reduction_target'],
    $_POST['e2_nox_t_per_year'],
    $_POST['e2_sox_t_per_year'],
    $_POST['e3_water_withdrawal_m3'],
    $_POST['e3_water_recycling_rate_pct'],
    $_POST['e4_protected_areas_impact'],
    $_POST['e5_recycling_rate_pct'],
    $_POST['e5_recycled_input_materials_pct'],
    $userId // for UPDATE clause
]);

echo json_encode(['success' => true]);
?>