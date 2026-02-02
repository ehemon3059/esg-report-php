<?php
session_start();
header('Content-Type: application/json');

// ============================================================================
// AUTHENTICATION CHECK
// ============================================================================
// Uncomment these lines when you have auth system ready:
// require_once 'includes/auth.php';
// requireLogin();

// For testing without auth:
$_SESSION['user_id'] = $_SESSION['user_id'] ?? 'user-001';
$_SESSION['company_id'] = $_SESSION['company_id'] ?? 'comp-001';

$currentUserId = $_SESSION['user_id'];
$currentCompanyId = $_SESSION['company_id'];

// ============================================================================
// DATABASE CONNECTION
// ============================================================================
// Uncomment this when you have database.php ready:
// require_once 'config/database.php';

// For testing, create connection here:
try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=esg_reporting_db;charset=utf8mb4',
        'root', // Change to your MySQL username
        '',     // Change to your MySQL password
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Database connection failed: ' . $e->getMessage()
    ]);
    exit;
}

// ============================================================================
// HELPER FUNCTION: Generate UUID
// ============================================================================
function generateUUID() {
    return sprintf(
        '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
}

// ============================================================================
// DETERMINE ACTION
// ============================================================================
$action = $_POST['action'] ?? '';

try {
    switch ($action) {
        
        // ====================================================================
        // CREATE NEW SITE
        // ====================================================================
        case 'create':
            $name = trim($_POST['name'] ?? '');
            $address = trim($_POST['address'] ?? '');
            $country = trim($_POST['country'] ?? 'DE');
            
            // Validate required fields
            if (empty($name)) {
                throw new Exception('Site name is required');
            }
            
            // Check for duplicate name within company (unique constraint)
            $stmt = $pdo->prepare("
                SELECT COUNT(*) FROM sites 
                WHERE company_id = ? AND name = ? AND deleted_at IS NULL
            ");
            $stmt->execute([$currentCompanyId, $name]);
            
            if ($stmt->fetchColumn() > 0) {
                throw new Exception('A site with this name already exists in your company');
            }
            
            // Insert new site
            $siteId = generateUUID();
            $stmt = $pdo->prepare("
                INSERT INTO sites 
                (id, company_id, name, address, country, created_by, created_at, updated_at)
                VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())
            ");
            
            $stmt->execute([
                $siteId,
                $currentCompanyId,
                $name,
                $address,
                $country,
                $currentUserId
            ]);
            
            echo json_encode([
                'success' => true,
                'message' => "Site '{$name}' created successfully",
                'site_id' => $siteId
            ]);
            break;
        
        // ====================================================================
        // UPDATE EXISTING SITE
        // ====================================================================
        case 'update':
            $siteId = $_POST['siteId'] ?? '';
            $name = trim($_POST['name'] ?? '');
            $address = trim($_POST['address'] ?? '');
            $country = trim($_POST['country'] ?? 'DE');
            
            // Validate
            if (empty($siteId) || empty($name)) {
                throw new Exception('Site ID and name are required');
            }
            
            // Verify site belongs to current company
            $stmt = $pdo->prepare("
                SELECT id FROM sites 
                WHERE id = ? AND company_id = ?
            ");
            $stmt->execute([$siteId, $currentCompanyId]);
            
            if (!$stmt->fetch()) {
                throw new Exception('Site not found or access denied');
            }
            
            // Check for duplicate name (excluding current site)
            $stmt = $pdo->prepare("
                SELECT COUNT(*) FROM sites 
                WHERE company_id = ? AND name = ? AND id != ? AND deleted_at IS NULL
            ");
            $stmt->execute([$currentCompanyId, $name, $siteId]);
            
            if ($stmt->fetchColumn() > 0) {
                throw new Exception('Another site with this name already exists');
            }
            
            // Update site
            $stmt = $pdo->prepare("
                UPDATE sites 
                SET name = ?, 
                    address = ?, 
                    country = ?,
                    updated_by = ?,
                    updated_at = NOW()
                WHERE id = ? AND company_id = ?
            ");
            
            $stmt->execute([
                $name,
                $address,
                $country,
                $currentUserId,
                $siteId,
                $currentCompanyId
            ]);
            
            echo json_encode([
                'success' => true,
                'message' => "Site '{$name}' updated successfully"
            ]);
            break;
        
        // ====================================================================
        // SOFT DELETE SITE
        // ====================================================================
        case 'delete':
            $siteId = $_POST['siteId'] ?? '';
            
            if (empty($siteId)) {
                throw new Exception('Site ID is required');
            }
            
            // Verify site belongs to current company
            $stmt = $pdo->prepare("
                SELECT name FROM sites 
                WHERE id = ? AND company_id = ? AND deleted_at IS NULL
            ");
            $stmt->execute([$siteId, $currentCompanyId]);
            $site = $stmt->fetch();
            
            if (!$site) {
                throw new Exception('Site not found or already deleted');
            }
            
            // Soft delete (set deleted_at timestamp)
            $stmt = $pdo->prepare("
                UPDATE sites 
                SET deleted_at = NOW(),
                    updated_by = ?,
                    updated_at = NOW()
                WHERE id = ? AND company_id = ?
            ");
            
            $stmt->execute([
                $currentUserId,
                $siteId,
                $currentCompanyId
            ]);
            
            echo json_encode([
                'success' => true,
                'message' => "Site '{$site['name']}' deleted successfully (can be restored)"
            ]);
            break;
        
        // ====================================================================
        // RESTORE DELETED SITE
        // ====================================================================
        case 'restore':
            $siteId = $_POST['siteId'] ?? '';
            
            if (empty($siteId)) {
                throw new Exception('Site ID is required');
            }
            
            // Verify site exists and is deleted
            $stmt = $pdo->prepare("
                SELECT name FROM sites 
                WHERE id = ? AND company_id = ? AND deleted_at IS NOT NULL
            ");
            $stmt->execute([$siteId, $currentCompanyId]);
            $site = $stmt->fetch();
            
            if (!$site) {
                throw new Exception('Site not found or not deleted');
            }
            
            // Restore (clear deleted_at)
            $stmt = $pdo->prepare("
                UPDATE sites 
                SET deleted_at = NULL,
                    updated_by = ?,
                    updated_at = NOW()
                WHERE id = ? AND company_id = ?
            ");
            
            $stmt->execute([
                $currentUserId,
                $siteId,
                $currentCompanyId
            ]);
            
            echo json_encode([
                'success' => true,
                'message' => "Site '{$site['name']}' restored successfully"
            ]);
            break;
        
        // ====================================================================
        // INVALID ACTION
        // ====================================================================
        default:
            throw new Exception('Invalid action specified');
    }
    
} catch (PDOException $e) {
    // Database error
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
    
} catch (Exception $e) {
    // Application error
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>  