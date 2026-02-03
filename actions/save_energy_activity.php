<?php
session_start();
require_once 'config/database.php';
require_once 'includes/auth.php';
requireLogin();

$companyId = getCurrentCompanyId();
$userId = getCurrentUserId();

// 1. Insert energy activity
$stmt = $pdo->prepare("
    INSERT INTO energy_activities (id, site_id, date, energy_type, consumption, unit)
    VALUES (UUID(), ?, ?, ?, ?, ?)
");
$stmt->execute([
    $_POST['site_id'],
    $_POST['date'],
    $_POST['energy_type'],
    $_POST['consumption'],
    $_POST['unit']
]);
$energyActivityId = $pdo->lastInsertId();

// 2. Get emission factor
$stmt = $pdo->prepare("
    SELECT id, factor FROM emission_factors 
    WHERE activity_type = ? AND region = ? AND is_active = 1 
    LIMIT 1
");
$stmt->execute([$_POST['energy_type'], 'Germany']);
$factor = $stmt->fetch(PDO::FETCH_ASSOC);

// 3. Calculate emissions
$tco2e = $_POST['consumption'] * $factor['factor'] / 1000; // Convert to tonnes

// 4. Insert emission record
$stmt = $pdo->prepare("
    INSERT INTO emission_records 
    (id, company_id, scope, tco2e_calculated, energy_activity_id, emission_factor_id, date_calculated)
    VALUES (UUID(), ?, 'Scope 2 Location-Based', ?, ?, ?, NOW())
");
$stmt->execute([
    $companyId,
    $tco2e,
    $energyActivityId,
    $factor['id']
]);

// Return success
echo json_encode(['success' => true, 'tco2e' => $tco2e]);
?>