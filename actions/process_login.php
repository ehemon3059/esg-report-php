<?php
session_start();
require_once 'config/database.php';

$email = $_POST['email'];
$password = $_POST['password'];

// Query user
$stmt = $pdo->prepare("SELECT id, name, email, role, company_id, password 
                       FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Verify password
if ($user && password_verify($password, $user['password'])) {
    // Set session variables
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['name'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['user_role'] = $user['role'];
    $_SESSION['company_id'] = $user['company_id'];
    
    // Redirect to dashboard
    header('Location: dashboard.php');
    exit;
} else {
    // Failed login
    header('Location: login.php?error=1');
    exit;
}
?>