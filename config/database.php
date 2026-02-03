<?php
/**
 * ============================================================================
 * DATABASE CONNECTION - ESG Reporting System
 * ============================================================================
 * 
 * PDO Database Connection with:
 * - Error handling
 * - UTF-8 character set
 * - Prepared statement emulation disabled
 * - Persistent connections (optional)
 * - Environment-based configuration
 * 
 * @package ESG_Reporting
 * @version 1.0.0
 */

// ============================================================================
// DATABASE CONFIGURATION
// ============================================================================

// Development Environment
define('DB_HOST', 'localhost');
define('DB_NAME', 'esg_reporting_db');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Optional: For production, you can use environment variables
// define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
// define('DB_NAME', getenv('DB_NAME') ?: 'esg_reporting_db');
// define('DB_USER', getenv('DB_USER') ?: 'root');
// define('DB_PASS', getenv('DB_PASS') ?: '');

// ============================================================================
// PDO OPTIONS
// ============================================================================

$options = [
    // Set error mode to exceptions (CRITICAL for debugging)
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    
    // Set default fetch mode to associative array
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    
    // Disable emulated prepared statements (better security)
    PDO::ATTR_EMULATE_PREPARES => false,
    
    // Set character set to UTF-8
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES " . DB_CHARSET,
    
    // Enable persistent connections (optional - improves performance)
    // PDO::ATTR_PERSISTENT => true,
    
    // Set timeout (optional)
    PDO::ATTR_TIMEOUT => 5,
];

// ============================================================================
// CREATE PDO CONNECTION
// ============================================================================

try {
    // Create DSN (Data Source Name)
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
    
    // Create PDO instance
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    
    // Optional: Set time zone
    $pdo->exec("SET time_zone = '+00:00'"); // UTC
    
} catch (PDOException $e) {
    // ========================================================================
    // ERROR HANDLING
    // ========================================================================
    
    // Log error (in production, log to file instead of displaying)
    error_log("Database Connection Error: " . $e->getMessage());
    
    // Display user-friendly error message
    // IMPORTANT: In production, don't show actual error details to users!
    if (getenv('APP_ENV') === 'production') {
        die("Sorry, we're experiencing technical difficulties. Please try again later.");
    } else {
        // Development mode - show detailed error
        die("
            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; border: 2px solid #ef4444; border-radius: 10px; background: #fef2f2;'>
                <h2 style='color: #dc2626; margin: 0 0 10px 0;'>Database Connection Failed</h2>
                <p style='color: #991b1b; margin: 10px 0;'><strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>
                <hr style='border: none; border-top: 1px solid #fca5a5; margin: 15px 0;'>
                <h3 style='color: #dc2626; font-size: 14px;'>Troubleshooting Steps:</h3>
                <ol style='color: #991b1b; font-size: 14px; line-height: 1.6;'>
                    <li>Check if MySQL server is running</li>
                    <li>Verify database name: <code style='background: #fee2e2; padding: 2px 6px; border-radius: 3px;'>" . DB_NAME . "</code></li>
                    <li>Verify username: <code style='background: #fee2e2; padding: 2px 6px; border-radius: 3px;'>" . DB_USER . "</code></li>
                    <li>Verify host: <code style='background: #fee2e2; padding: 2px 6px; border-radius: 3px;'>" . DB_HOST . "</code></li>
                    <li>Check if the database exists: <code style='background: #fee2e2; padding: 2px 6px; border-radius: 3px;'>CREATE DATABASE IF NOT EXISTS esg_reporting_db;</code></li>
                </ol>
            </div>
        ");
    }
}

// ============================================================================
// HELPER FUNCTIONS (Optional but recommended)
// ============================================================================

/**
 * Test database connection
 * 
 * @return bool True if connected, false otherwise
 */
function testConnection() {
    global $pdo;
    try {
        $pdo->query("SELECT 1");
        return true;
    } catch (PDOException $e) {
        return false;
    }
}

/**
 * Get database version
 * 
 * @return string MySQL version
 */
function getDatabaseVersion() {
    global $pdo;
    try {
        $stmt = $pdo->query("SELECT VERSION()");
        return $stmt->fetchColumn();
    } catch (PDOException $e) {
        return "Unknown";
    }
}

/**
 * Execute a query and return results
 * 
 * @param string $sql SQL query
 * @param array $params Parameters for prepared statement
 * @return array Query results
 */
function query($sql, $params = []) {
    global $pdo;
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Query Error: " . $e->getMessage());
        throw $e;
    }
}

/**
 * Execute an INSERT, UPDATE, or DELETE query
 * 
 * @param string $sql SQL query
 * @param array $params Parameters for prepared statement
 * @return int Number of affected rows
 */
function execute($sql, $params = []) {
    global $pdo;
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->rowCount();
    } catch (PDOException $e) {
        error_log("Execute Error: " . $e->getMessage());
        throw $e;
    }
}

/**
 * Get the last inserted ID
 * 
 * @return string Last insert ID
 */
function lastInsertId() {
    global $pdo;
    return $pdo->lastInsertId();
}

/**
 * Begin a transaction
 */
function beginTransaction() {
    global $pdo;
    $pdo->beginTransaction();
}

/**
 * Commit a transaction
 */
function commit() {
    global $pdo;
    $pdo->commit();
}

/**
 * Rollback a transaction
 */
function rollback() {
    global $pdo;
    $pdo->rollBack();
}

// ============================================================================
// CONNECTION SUCCESS (Optional logging)
// ============================================================================

// Uncomment for debugging in development
// error_log("Database connected successfully to: " . DB_NAME);

?>
