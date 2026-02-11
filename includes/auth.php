<?php
function requireLogin() {
    if (!isset($_SESSION['user_id'])) {
        // Fix: Use correct path from includes/ to pages/
        header('Location: ../pages/login.php');
        exit;
    }
}

function getCurrentUserId() {
    return $_SESSION['user_id'] ?? null;
}

function getCurrentCompanyId() {
    return $_SESSION['company_id'] ?? null;
}

function getUserRole() {
    return $_SESSION['user_role'] ?? 'user';
}
?>