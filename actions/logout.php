<?php
/**
 * ============================================================================
 * LOGOUT HANDLER - ESG Reporting System
 * ============================================================================
 * 
 * Safely destroys user session and redirects to login page
 * 
 * Security Features:
 * - Session destruction
 * - Cookie cleanup
 * - CSRF token invalidation
 * - Secure redirect
 * 
 * @package ESG_Reporting
 * @version 1.0.0
 */

// Start session
session_start();

// ============================================================================
// AUDIT LOG (Optional - uncomment if you want to track logouts)
// ============================================================================
/*
if (isset($_SESSION['user_id'])) {
    require_once '../config/database.php';
    
    try {
        $stmt = $pdo->prepare("
            INSERT INTO audit_log (user_id, action, ip_address, user_agent, created_at)
            VALUES (?, 'LOGOUT', ?, ?, NOW())
        ");
        $stmt->execute([
            $_SESSION['user_id'],
            $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            $_SERVER['HTTP_USER_AGENT'] ?? 'unknown'
        ]);
    } catch (PDOException $e) {
        // Silently fail - don't prevent logout on logging error
        error_log("Logout audit log error: " . $e->getMessage());
    }
}
*/

// ============================================================================
// DESTROY SESSION
// ============================================================================

// Unset all session variables
$_SESSION = array();

// Delete session cookie if it exists
if (isset($_COOKIE[session_name()])) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Destroy the session
session_destroy();

// ============================================================================
// REDIRECT TO LOGIN
// ============================================================================

// Prevent caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Redirect to login page
header("Location: ../pages/login.php?logout=success");
exit;
?>
