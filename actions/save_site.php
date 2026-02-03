<?php
session_start();
require_once 'config/database.php';
require_once 'includes/auth.php';
requireLogin();

$companyId = getCurrentCompanyId();
$userId = getCurrentUserId();

$stmt = $pdo->prepare("
    INSERT INTO sites (id, company_id, name, address, country, created_by, created_at, updated_at)
    VALUES (UUID(), ?, ?, ?, ?, ?, NOW(), NOW())
");

$stmt->execute([
    $companyId,
    $_POST['name'],
    $_POST['address'],
    $_POST['country'],
    $userId
]);

header('Location: sites.php');
?>