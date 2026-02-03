<?php
/**
 * ============================================================================
 * DATABASE CONNECTION TEST
 * ============================================================================
 * 
 * This file tests the database connection and displays diagnostic information.
 * 
 * USAGE:
 * 1. Upload this file to your server
 * 2. Navigate to: http://localhost/esg-reporting/test_connection.php
 * 3. Check if connection is successful
 * 4. DELETE this file after testing (security risk to leave it)
 * 
 * ============================================================================
 */

// Include database connection
require_once 'config/database.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Connection Test - ESG Reporting</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-2xl w-full">
        
        <!-- Success Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border-2 border-green-500">
            
            <!-- Header -->
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-6 py-4">
                <div class="flex items-center gap-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h1 class="text-2xl font-bold">Database Connection Successful!</h1>
                        <p class="text-green-100 text-sm">ESG Reporting System</p>
                    </div>
                </div>
            </div>
            
            <!-- Connection Details -->
            <div class="p-6 space-y-4">
                
                <!-- Server Information -->
                <div class="bg-slate-50 rounded-lg p-4 border border-slate-200">
                    <h2 class="font-bold text-slate-800 mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                        </svg>
                        Server Information
                    </h2>
                    <div class="grid grid-cols-2 gap-3 text-sm">
                        <div>
                            <span class="text-slate-500">Host:</span>
                            <span class="font-mono font-semibold text-slate-800"><?= DB_HOST ?></span>
                        </div>
                        <div>
                            <span class="text-slate-500">Database:</span>
                            <span class="font-mono font-semibold text-slate-800"><?= DB_NAME ?></span>
                        </div>
                        <div>
                            <span class="text-slate-500">User:</span>
                            <span class="font-mono font-semibold text-slate-800"><?= DB_USER ?></span>
                        </div>
                        <div>
                            <span class="text-slate-500">Charset:</span>
                            <span class="font-mono font-semibold text-slate-800"><?= DB_CHARSET ?></span>
                        </div>
                    </div>
                </div>
                
                <!-- MySQL Version -->
                <?php
                try {
                    $version = getDatabaseVersion();
                    echo "<div class='bg-blue-50 rounded-lg p-4 border border-blue-200'>
                            <h3 class='font-semibold text-blue-900 mb-1'>MySQL Version</h3>
                            <p class='font-mono text-blue-700'>{$version}</p>
                          </div>";
                } catch (Exception $e) {
                    echo "<div class='bg-red-50 rounded-lg p-4 border border-red-200'>
                            <p class='text-red-700'>Could not retrieve MySQL version</p>
                          </div>";
                }
                ?>
                
                <!-- Table Count -->
                <?php
                try {
                    $stmt = $pdo->query("SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = '" . DB_NAME . "'");
                    $tableCount = $stmt->fetchColumn();
                    
                    echo "<div class='bg-emerald-50 rounded-lg p-4 border border-emerald-200'>
                            <h3 class='font-semibold text-emerald-900 mb-1'>Database Tables</h3>
                            <p class='text-emerald-700'><span class='font-bold text-2xl'>{$tableCount}</span> tables found</p>
                          </div>";
                } catch (Exception $e) {
                    echo "<div class='bg-yellow-50 rounded-lg p-4 border border-yellow-200'>
                            <p class='text-yellow-700'>Could not count tables</p>
                          </div>";
                }
                ?>
                
                <!-- List Tables -->
                <?php
                try {
                    $stmt = $pdo->query("SHOW TABLES");
                    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
                    
                    if (!empty($tables)) {
                        echo "<div class='bg-slate-50 rounded-lg p-4 border border-slate-200'>
                                <h3 class='font-semibold text-slate-900 mb-3'>Available Tables:</h3>
                                <div class='grid grid-cols-2 md:grid-cols-3 gap-2'>";
                        
                        foreach ($tables as $table) {
                            echo "<div class='flex items-center gap-2 text-sm'>
                                    <svg class='w-4 h-4 text-green-500' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'></path>
                                    </svg>
                                    <span class='font-mono text-slate-700'>{$table}</span>
                                  </div>";
                        }
                        
                        echo "    </div>
                              </div>";
                    } else {
                        echo "<div class='bg-yellow-50 rounded-lg p-4 border border-yellow-200'>
                                <p class='text-yellow-800'>⚠️ No tables found. Run the SQL scripts to create tables.</p>
                              </div>";
                    }
                } catch (Exception $e) {
                    echo "<div class='bg-red-50 rounded-lg p-4 border border-red-200'>
                            <p class='text-red-700'>Error listing tables: " . htmlspecialchars($e->getMessage()) . "</p>
                          </div>";
                }
                ?>
                
                <!-- Test Query -->
                <?php
                try {
                    // Test query on companies table
                    $stmt = $pdo->query("SELECT COUNT(*) FROM companies");
                    $companyCount = $stmt->fetchColumn();
                    
                    echo "<div class='bg-indigo-50 rounded-lg p-4 border border-indigo-200'>
                            <h3 class='font-semibold text-indigo-900 mb-1'>Test Query (Companies Table)</h3>
                            <p class='text-indigo-700'><span class='font-bold text-xl'>{$companyCount}</span> companies in database</p>
                          </div>";
                } catch (Exception $e) {
                    echo "<div class='bg-yellow-50 rounded-lg p-4 border border-yellow-200'>
                            <p class='text-yellow-700'>⚠️ Companies table not found or empty</p>
                          </div>";
                }
                ?>
                
            </div>
            
            <!-- Actions -->
            <div class="bg-slate-50 px-6 py-4 border-t border-slate-200 flex flex-wrap gap-3">
                <a href="dashboard.php" class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors text-sm font-medium">
                    Go to Dashboard
                </a>
                <a href="sites.php" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                    Manage Sites
                </a>
                <button onclick="location.reload()" class="px-4 py-2 bg-slate-600 text-white rounded-lg hover:bg-slate-700 transition-colors text-sm font-medium">
                    Refresh Test
                </button>
            </div>
            
            <!-- Security Warning -->
            <div class="bg-red-50 border-t-2 border-red-500 px-6 py-4">
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-1.998-1.333-2.768 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <div>
                        <h3 class="font-bold text-red-800 mb-1">Security Warning</h3>
                        <p class="text-sm text-red-700">
                            <strong>DELETE THIS FILE IMMEDIATELY</strong> after testing! 
                            This file exposes sensitive database information and should never be accessible in production.
                        </p>
                    </div>
                </div>
            </div>
            
        </div>
        
        <!-- Next Steps -->
        <div class="mt-6 bg-white rounded-lg shadow p-6 border border-slate-200">
            <h3 class="font-bold text-slate-800 mb-3">✅ Next Steps:</h3>
            <ol class="space-y-2 text-sm text-slate-700">
                <li class="flex items-start gap-2">
                    <span class="font-bold text-emerald-600">1.</span>
                    <span>Database connection is working! You can now use the ESG Reporting System.</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="font-bold text-emerald-600">2.</span>
                    <span>If tables are missing, run <code class="bg-slate-100 px-2 py-0.5 rounded">create_all_tables.sql</code></span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="font-bold text-emerald-600">3.</span>
                    <span>Run <code class="bg-slate-100 px-2 py-0.5 rounded">seed_test_data.sql</code> to add sample data</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="font-bold text-red-600">4.</span>
                    <span><strong>DELETE this test_connection.php file</strong> for security</span>
                </li>
            </ol>
        </div>
        
    </div>
</body>
</html>
