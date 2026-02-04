<?php
/**
 * ============================================================================
 * DATABASE HELPER FUNCTIONS - ESG Reporting System
 * ============================================================================
 * 
 * Database-specific utility functions for common operations
 * 
 * @package ESG_Reporting
 * @version 1.0.0
 */

// ============================================================================
// QUERY HELPERS
// ============================================================================

/**
 * Execute a SELECT query and return all results
 * 
 * @param PDO $pdo Database connection
 * @param string $sql SQL query with placeholders
 * @param array $params Parameters for prepared statement
 * @return array Query results
 */
function dbQuery($pdo, $sql, $params = []) {
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        logError("Query error: " . $e->getMessage());
        throw $e;
    }
}

/**
 * Execute a SELECT query and return single row
 * 
 * @param PDO $pdo Database connection
 * @param string $sql SQL query with placeholders
 * @param array $params Parameters for prepared statement
 * @return array|false Single row or false
 */
function dbQueryOne($pdo, $sql, $params = []) {
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        logError("Query error: " . $e->getMessage());
        throw $e;
    }
}

/**
 * Execute INSERT, UPDATE, or DELETE query
 * 
 * @param PDO $pdo Database connection
 * @param string $sql SQL query with placeholders
 * @param array $params Parameters for prepared statement
 * @return int Number of affected rows
 */
function dbExecute($pdo, $sql, $params = []) {
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->rowCount();
    } catch (PDOException $e) {
        logError("Execute error: " . $e->getMessage());
        throw $e;
    }
}

/**
 * Get single value from query
 * 
 * @param PDO $pdo Database connection
 * @param string $sql SQL query with placeholders
 * @param array $params Parameters for prepared statement
 * @return mixed Single value or null
 */
function dbGetValue($pdo, $sql, $params = []) {
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    } catch (PDOException $e) {
        logError("Get value error: " . $e->getMessage());
        throw $e;
    }
}

// ============================================================================
// RECORD EXISTENCE CHECKS
// ============================================================================

/**
 * Check if a record exists
 * 
 * @param PDO $pdo Database connection
 * @param string $table Table name
 * @param array $conditions Key-value pairs for WHERE clause
 * @return bool True if exists
 */
function recordExists($pdo, $table, $conditions) {
    $where = [];
    $params = [];
    
    foreach ($conditions as $column => $value) {
        $where[] = "{$column} = ?";
        $params[] = $value;
    }
    
    $sql = "SELECT 1 FROM {$table} WHERE " . implode(' AND ', $where) . " LIMIT 1";
    
    return dbGetValue($pdo, $sql, $params) !== false;
}

/**
 * Get record by ID
 * 
 * @param PDO $pdo Database connection
 * @param string $table Table name
 * @param string $id Record ID
 * @param string $idColumn ID column name (default: 'id')
 * @return array|false Record or false
 */
function getRecordById($pdo, $table, $id, $idColumn = 'id') {
    $sql = "SELECT * FROM {$table} WHERE {$idColumn} = ?";
    return dbQueryOne($pdo, $sql, [$id]);
}

// ============================================================================
// COMPANY & USER QUERIES
// ============================================================================

/**
 * Get company by ID
 * 
 * @param PDO $pdo Database connection
 * @param string $companyId Company ID
 * @return array|false Company data or false
 */
function getCompany($pdo, $companyId) {
    $sql = "SELECT * FROM companies WHERE id = ? AND deleted_at IS NULL";
    return dbQueryOne($pdo, $sql, [$companyId]);
}

/**
 * Get user by ID
 * 
 * @param PDO $pdo Database connection
 * @param string $userId User ID
 * @return array|false User data or false
 */
function getUser($pdo, $userId) {
    $sql = "SELECT * FROM users WHERE id = ?";
    return dbQueryOne($pdo, $sql, [$userId]);
}

/**
 * Get user by email
 * 
 * @param PDO $pdo Database connection
 * @param string $email User email
 * @return array|false User data or false
 */
function getUserByEmail($pdo, $email) {
    $sql = "SELECT * FROM users WHERE email = ?";
    return dbQueryOne($pdo, $sql, [$email]);
}

/**
 * Get all users for a company
 * 
 * @param PDO $pdo Database connection
 * @param string $companyId Company ID
 * @return array Array of users
 */
function getCompanyUsers($pdo, $companyId) {
    $sql = "SELECT * FROM users WHERE company_id = ? ORDER BY name";
    return dbQuery($pdo, $sql, [$companyId]);
}

// ============================================================================
// SITE QUERIES
// ============================================================================

/**
 * Get all sites for a company
 * 
 * @param PDO $pdo Database connection
 * @param string $companyId Company ID
 * @param bool $includeDeleted Include soft-deleted sites
 * @return array Array of sites
 */
function getCompanySites($pdo, $companyId, $includeDeleted = false) {
    $sql = "SELECT * FROM sites WHERE company_id = ?";
    
    if (!$includeDeleted) {
        $sql .= " AND deleted_at IS NULL";
    }
    
    $sql .= " ORDER BY name";
    
    return dbQuery($pdo, $sql, [$companyId]);
}

/**
 * Get site by ID with company verification
 * 
 * @param PDO $pdo Database connection
 * @param string $siteId Site ID
 * @param string $companyId Company ID for verification
 * @return array|false Site data or false
 */
function getSite($pdo, $siteId, $companyId) {
    $sql = "SELECT * FROM sites WHERE id = ? AND company_id = ? AND deleted_at IS NULL";
    return dbQueryOne($pdo, $sql, [$siteId, $companyId]);
}

// ============================================================================
// EMISSION QUERIES
// ============================================================================

/**
 * Get emission factors by activity type
 * 
 * @param PDO $pdo Database connection
 * @param string $activityType Activity type
 * @param string $scope Scope (optional)
 * @return array Array of emission factors
 */
function getEmissionFactors($pdo, $activityType, $scope = null) {
    $sql = "SELECT * FROM emission_factors WHERE activity_type = ? AND is_active = 1";
    $params = [$activityType];
    
    if ($scope) {
        $sql .= " AND scope = ?";
        $params[] = $scope;
    }
    
    $sql .= " ORDER BY valid_from DESC";
    
    return dbQuery($pdo, $sql, $params);
}

/**
 * Get active emission factor for calculation
 * 
 * @param PDO $pdo Database connection
 * @param string $activityType Activity type
 * @param string $scope Scope
 * @return array|false Emission factor or false
 */
function getActiveEmissionFactor($pdo, $activityType, $scope) {
    $sql = "
        SELECT * FROM emission_factors 
        WHERE activity_type = ? 
          AND scope = ? 
          AND is_active = 1
          AND (valid_until IS NULL OR valid_until > NOW())
        ORDER BY valid_from DESC
        LIMIT 1
    ";
    
    return dbQueryOne($pdo, $sql, [$activityType, $scope]);
}

/**
 * Get emission records for a company
 * 
 * @param PDO $pdo Database connection
 * @param string $companyId Company ID
 * @param string $reportingPeriod Reporting period (YYYY-MM format, optional)
 * @param string $scope Scope filter (optional)
 * @return array Array of emission records
 */
function getEmissionRecords($pdo, $companyId, $reportingPeriod = null, $scope = null) {
    $sql = "SELECT * FROM emission_records WHERE company_id = ?";
    $params = [$companyId];
    
    if ($reportingPeriod) {
        $sql .= " AND DATE_FORMAT(date_calculated, '%Y-%m') = ?";
        $params[] = $reportingPeriod;
    }
    
    if ($scope) {
        $sql .= " AND scope = ?";
        $params[] = $scope;
    }
    
    $sql .= " ORDER BY date_calculated DESC";
    
    return dbQuery($pdo, $sql, $params);
}

/**
 * Get aggregated emissions by scope
 * 
 * @param PDO $pdo Database connection
 * @param string $companyId Company ID
 * @param string $reportingPeriod Reporting period (YYYY-MM format)
 * @return array Array with scope as key and total as value
 */
function getAggregatedEmissions($pdo, $companyId, $reportingPeriod) {
    $sql = "
        SELECT scope, SUM(tco2e_calculated) as total
        FROM emission_records
        WHERE company_id = ? AND DATE_FORMAT(date_calculated, '%Y-%m') = ?
        GROUP BY scope
    ";
    
    $results = dbQuery($pdo, $sql, [$companyId, $reportingPeriod]);
    
    // Convert to associative array
    $aggregated = [];
    foreach ($results as $row) {
        $aggregated[$row['scope']] = floatval($row['total']);
    }
    
    return $aggregated;
}

// ============================================================================
// REPORTING QUERIES
// ============================================================================

/**
 * Get environmental report
 * 
 * @param PDO $pdo Database connection
 * @param string $companyId Company ID
 * @param string $reportingPeriod Reporting period
 * @return array|false Report data or false
 */
function getEnvironmentalReport($pdo, $companyId, $reportingPeriod) {
    $sql = "SELECT * FROM environmental_topics WHERE company_id = ? AND reporting_period = ?";
    return dbQueryOne($pdo, $sql, [$companyId, $reportingPeriod]);
}

/**
 * Get social report
 * 
 * @param PDO $pdo Database connection
 * @param string $companyId Company ID
 * @param string $reportingPeriod Reporting period
 * @return array|false Report data or false
 */
function getSocialReport($pdo, $companyId, $reportingPeriod) {
    $sql = "SELECT * FROM social_topics WHERE company_id = ? AND reporting_period = ?";
    return dbQueryOne($pdo, $sql, [$companyId, $reportingPeriod]);
}

/**
 * Get governance report
 * 
 * @param PDO $pdo Database connection
 * @param string $companyId Company ID
 * @param string $reportingPeriod Reporting period
 * @return array|false Report data or false
 */
function getGovernanceReport($pdo, $companyId, $reportingPeriod) {
    $sql = "SELECT * FROM s_governance WHERE company_id = ? AND reporting_period = ?";
    return dbQueryOne($pdo, $sql, [$companyId, $reportingPeriod]);
}

/**
 * Get taxonomy report
 * 
 * @param PDO $pdo Database connection
 * @param string $companyId Company ID
 * @param string $reportingPeriod Reporting period
 * @return array|false Report data or false
 */
function getTaxonomyReport($pdo, $companyId, $reportingPeriod) {
    $sql = "SELECT * FROM eu_taxonomy WHERE company_id = ? AND reporting_period = ?";
    return dbQueryOne($pdo, $sql, [$companyId, $reportingPeriod]);
}

/**
 * Get assurance report
 * 
 * @param PDO $pdo Database connection
 * @param string $companyId Company ID
 * @param string $reportingPeriod Reporting period
 * @return array|false Report data or false
 */
function getAssuranceReport($pdo, $companyId, $reportingPeriod) {
    $sql = "SELECT * FROM assurance WHERE company_id = ? AND reporting_period = ?";
    return dbQueryOne($pdo, $sql, [$companyId, $reportingPeriod]);
}

// ============================================================================
// SOFT DELETE FUNCTIONS
// ============================================================================

/**
 * Soft delete a record
 * 
 * @param PDO $pdo Database connection
 * @param string $table Table name
 * @param string $id Record ID
 * @param string $userId User performing the delete
 * @return bool Success
 */
function softDelete($pdo, $table, $id, $userId = null) {
    try {
        $sql = "UPDATE {$table} SET deleted_at = NOW()";
        $params = [];
        
        // Add deleted_by if column exists and userId provided
        if ($userId) {
            $sql .= ", deleted_by = ?";
            $params[] = $userId;
            $params[] = $id;
        } else {
            $params[] = $id;
        }
        
        $sql .= " WHERE id = ?";
        
        return dbExecute($pdo, $sql, $params) > 0;
    } catch (PDOException $e) {
        logError("Soft delete error: " . $e->getMessage());
        return false;
    }
}

/**
 * Restore a soft-deleted record
 * 
 * @param PDO $pdo Database connection
 * @param string $table Table name
 * @param string $id Record ID
 * @return bool Success
 */
function restoreRecord($pdo, $table, $id) {
    try {
        $sql = "UPDATE {$table} SET deleted_at = NULL, deleted_by = NULL WHERE id = ?";
        return dbExecute($pdo, $sql, [$id]) > 0;
    } catch (PDOException $e) {
        logError("Restore record error: " . $e->getMessage());
        return false;
    }
}

// ============================================================================
// TRANSACTION HELPERS
// ============================================================================

/**
 * Execute a callback within a database transaction
 * 
 * @param PDO $pdo Database connection
 * @param callable $callback Function to execute
 * @return mixed Result of callback
 * @throws Exception If callback fails
 */
function dbTransaction($pdo, $callback) {
    try {
        $pdo->beginTransaction();
        $result = $callback($pdo);
        $pdo->commit();
        return $result;
    } catch (Exception $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        throw $e;
    }
}

// ============================================================================
// PAGINATION HELPERS
// ============================================================================

/**
 * Get paginated results
 * 
 * @param PDO $pdo Database connection
 * @param string $sql Base SQL query (without LIMIT)
 * @param array $params Query parameters
 * @param int $page Current page (1-indexed)
 * @param int $perPage Items per page
 * @return array ['data' => rows, 'total' => count, 'pages' => total pages]
 */
function getPaginatedResults($pdo, $sql, $params = [], $page = 1, $perPage = 20) {
    // Get total count
    $countSql = "SELECT COUNT(*) FROM ({$sql}) as count_table";
    $total = dbGetValue($pdo, $countSql, $params);
    
    // Calculate pagination
    $totalPages = ceil($total / $perPage);
    $offset = ($page - 1) * $perPage;
    
    // Get paginated data
    $paginatedSql = "{$sql} LIMIT {$perPage} OFFSET {$offset}";
    $data = dbQuery($pdo, $paginatedSql, $params);
    
    return [
        'data' => $data,
        'total' => $total,
        'page' => $page,
        'perPage' => $perPage,
        'pages' => $totalPages
    ];
}
?>
