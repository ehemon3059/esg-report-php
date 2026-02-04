<?php
/**
 * ============================================================================
 * COMMON UTILITY FUNCTIONS - ESG Reporting System
 * ============================================================================
 * 
 * Reusable helper functions for the application
 * 
 * @package ESG_Reporting
 * @version 1.0.0
 */

// ============================================================================
// STRING UTILITIES
// ============================================================================

/**
 * Sanitize string input
 * 
 * @param string $input The input to sanitize
 * @return string Sanitized string
 */
function sanitizeString($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

/**
 * Sanitize email input
 * 
 * @param string $email The email to sanitize
 * @return string|false Sanitized email or false if invalid
 */
function sanitizeEmail($email) {
    $email = filter_var(trim($email), FILTER_SANITIZE_EMAIL);
    return filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : false;
}

/**
 * Generate a secure random UUID v4
 * 
 * @return string UUID
 */
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

/**
 * Truncate text to a specific length
 * 
 * @param string $text The text to truncate
 * @param int $length Maximum length
 * @param string $suffix Suffix to add (default: '...')
 * @return string Truncated text
 */
function truncateText($text, $length = 100, $suffix = '...') {
    if (mb_strlen($text) <= $length) {
        return $text;
    }
    return mb_substr($text, 0, $length) . $suffix;
}

// ============================================================================
// DATE & TIME UTILITIES
// ============================================================================

/**
 * Format date for display
 * 
 * @param string $date Date string
 * @param string $format Output format (default: 'M d, Y')
 * @return string Formatted date
 */
function formatDate($date, $format = 'M d, Y') {
    if (empty($date) || $date === '0000-00-00' || $date === '0000-00-00 00:00:00') {
        return 'N/A';
    }
    return date($format, strtotime($date));
}

/**
 * Format datetime for display
 * 
 * @param string $datetime Datetime string
 * @return string Formatted datetime
 */
function formatDateTime($datetime) {
    return formatDate($datetime, 'M d, Y H:i');
}

/**
 * Get relative time (e.g., "2 hours ago")
 * 
 * @param string $datetime Datetime string
 * @return string Relative time string
 */
function timeAgo($datetime) {
    $timestamp = strtotime($datetime);
    $diff = time() - $timestamp;
    
    if ($diff < 60) {
        return 'just now';
    } elseif ($diff < 3600) {
        $mins = floor($diff / 60);
        return $mins . ' minute' . ($mins > 1 ? 's' : '') . ' ago';
    } elseif ($diff < 86400) {
        $hours = floor($diff / 3600);
        return $hours . ' hour' . ($hours > 1 ? 's' : '') . ' ago';
    } elseif ($diff < 604800) {
        $days = floor($diff / 86400);
        return $days . ' day' . ($days > 1 ? 's' : '') . ' ago';
    } else {
        return formatDate($datetime);
    }
}

// ============================================================================
// NUMBER UTILITIES
// ============================================================================

/**
 * Format number with thousands separator
 * 
 * @param float $number The number to format
 * @param int $decimals Number of decimal places (default: 2)
 * @return string Formatted number
 */
function formatNumber($number, $decimals = 2) {
    if ($number === null || $number === '') {
        return 'N/A';
    }
    return number_format($number, $decimals, '.', ',');
}

/**
 * Format percentage
 * 
 * @param float $value The value to format
 * @param int $decimals Number of decimal places (default: 1)
 * @return string Formatted percentage
 */
function formatPercent($value, $decimals = 1) {
    if ($value === null || $value === '') {
        return 'N/A';
    }
    return number_format($value, $decimals, '.', ',') . '%';
}

/**
 * Format tCO2e emissions
 * 
 * @param float $tonnes Emissions in tonnes
 * @return string Formatted emissions
 */
function formatEmissions($tonnes) {
    if ($tonnes === null || $tonnes === '') {
        return 'N/A';
    }
    return formatNumber($tonnes, 3) . ' tCO₂e';
}

// ============================================================================
// VALIDATION UTILITIES
// ============================================================================

/**
 * Validate percentage value
 * 
 * @param mixed $value Value to validate
 * @return bool True if valid percentage (0-100)
 */
function isValidPercent($value) {
    if (!is_numeric($value)) {
        return false;
    }
    $num = floatval($value);
    return $num >= 0 && $num <= 100;
}

/**
 * Validate date format
 * 
 * @param string $date Date string
 * @param string $format Expected format (default: 'Y-m-d')
 * @return bool True if valid
 */
function isValidDate($date, $format = 'Y-m-d') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}

/**
 * Validate reporting period format (YYYY-MM)
 * 
 * @param string $period Period string
 * @return bool True if valid
 */
function isValidReportingPeriod($period) {
    return preg_match('/^\d{4}-\d{2}$/', $period) === 1;
}

// ============================================================================
// ARRAY UTILITIES
// ============================================================================

/**
 * Get array value safely with default
 * 
 * @param array $array The array
 * @param string|int $key The key
 * @param mixed $default Default value if key doesn't exist
 * @return mixed Value or default
 */
function getArrayValue($array, $key, $default = null) {
    return isset($array[$key]) ? $array[$key] : $default;
}

/**
 * Convert array to CSV row
 * 
 * @param array $data Array of values
 * @return string CSV row
 */
function arrayToCsv($data) {
    $output = fopen('php://temp', 'r+');
    fputcsv($output, $data);
    rewind($output);
    $csv = stream_get_contents($output);
    fclose($output);
    return trim($csv);
}

// ============================================================================
// STATUS & BADGE UTILITIES
// ============================================================================

/**
 * Get CSS class for status badge
 * 
 * @param string $status Status value
 * @return string CSS classes
 */
function getStatusBadgeClass($status) {
    $classes = [
        'DRAFT' => 'bg-gray-100 text-gray-800',
        'UNDER_REVIEW' => 'bg-blue-100 text-blue-800',
        'SUBMITTED' => 'bg-blue-100 text-blue-800',
        'APPROVED' => 'bg-green-100 text-green-800',
        'PUBLISHED' => 'bg-emerald-100 text-emerald-800',
        'REJECTED' => 'bg-red-100 text-red-800'
    ];
    
    return $classes[$status] ?? 'bg-gray-100 text-gray-800';
}

/**
 * Get human-readable status label
 * 
 * @param string $status Status value
 * @return string Label
 */
function getStatusLabel($status) {
    $labels = [
        'DRAFT' => 'Draft',
        'UNDER_REVIEW' => 'Under Review',
        'SUBMITTED' => 'Submitted',
        'APPROVED' => 'Approved',
        'PUBLISHED' => 'Published',
        'REJECTED' => 'Rejected'
    ];
    
    return $labels[$status] ?? $status;
}

// ============================================================================
// FILE UTILITIES
// ============================================================================

/**
 * Format file size
 * 
 * @param int $bytes File size in bytes
 * @return string Formatted file size
 */
function formatFileSize($bytes) {
    if ($bytes >= 1073741824) {
        return number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        return number_format($bytes / 1024, 2) . ' KB';
    } else {
        return $bytes . ' bytes';
    }
}

/**
 * Get file extension
 * 
 * @param string $filename Filename
 * @return string Extension (lowercase)
 */
function getFileExtension($filename) {
    return strtolower(pathinfo($filename, PATHINFO_EXTENSION));
}

// ============================================================================
// ERROR HANDLING UTILITIES
// ============================================================================

/**
 * Log error to file
 * 
 * @param string $message Error message
 * @param string $level Error level (ERROR, WARNING, INFO)
 * @return void
 */
function logError($message, $level = 'ERROR') {
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[{$timestamp}] [{$level}] {$message}\n";
    
    $logFile = __DIR__ . '/../logs/app.log';
    $logDir = dirname($logFile);
    
    if (!is_dir($logDir)) {
        mkdir($logDir, 0755, true);
    }
    
    error_log($logMessage, 3, $logFile);
}

/**
 * Create JSON response
 * 
 * @param bool $success Success status
 * @param string $message Message
 * @param array $data Optional data
 * @return void (outputs JSON)
 */
function jsonResponse($success, $message, $data = []) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data
    ]);
    exit;
}

// ============================================================================
// SECURITY UTILITIES
// ============================================================================

/**
 * Generate CSRF token
 * 
 * @return string CSRF token
 */
function generateCsrfToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verify CSRF token
 * 
 * @param string $token Token to verify
 * @return bool True if valid
 */
function verifyCsrfToken($token) {
    if (!isset($_SESSION['csrf_token'])) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Hash password securely
 * 
 * @param string $password Plain text password
 * @return string Hashed password
 */
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

/**
 * Verify password against hash
 * 
 * @param string $password Plain text password
 * @param string $hash Hashed password
 * @return bool True if password matches
 */
function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

// ============================================================================
// SCOPE UTILITIES (ESG Specific)
// ============================================================================

/**
 * Get scope label with icon
 * 
 * @param string $scope Scope identifier
 * @return string HTML with icon and label
 */
function getScopeLabel($scope) {
    $labels = [
        'Scope 1' => '<span class="text-emerald-700">🔥 Scope 1</span>',
        'Scope 2 Location-Based' => '<span class="text-blue-700">⚡ Scope 2 (Location)</span>',
        'Scope 2 Market-Based' => '<span class="text-blue-700">⚡ Scope 2 (Market)</span>',
        'Scope 3' => '<span class="text-purple-700">🔗 Scope 3</span>'
    ];
    
    return $labels[$scope] ?? $scope;
}

/**
 * Calculate progress percentage
 * 
 * @param int $completed Number of completed items
 * @param int $total Total number of items
 * @return float Percentage (0-100)
 */
function calculateProgress($completed, $total) {
    if ($total == 0) {
        return 0;
    }
    return round(($completed / $total) * 100, 1);
}
?>
