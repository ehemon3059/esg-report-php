<?php
session_start();

// ============================================================================
// AUTHENTICATION CHECK
// ============================================================================
// Uncomment these lines when you have auth system ready:
// require_once 'includes/auth.php';
// requireLogin();

// For testing without auth, use hardcoded values:
$_SESSION['user_id'] = $_SESSION['user_id'] ?? 'user-001';
$_SESSION['user_name'] = $_SESSION['user_name'] ?? 'Test User';
$_SESSION['company_id'] = $_SESSION['company_id'] ?? 'comp-001';
$_SESSION['user_role'] = $_SESSION['user_role'] ?? 'admin';

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
    die("Database connection failed: " . $e->getMessage());
}

// ============================================================================
// GET SITES FOR CURRENT COMPANY
// ============================================================================
$stmt = $pdo->prepare("
    SELECT 
        s.*,
        u1.name as creator_name,
        u2.name as updater_name
    FROM sites s
    LEFT JOIN users u1 ON s.created_by = u1.id
    LEFT JOIN users u2 ON s.updated_by = u2.id
    WHERE s.company_id = ?
    ORDER BY s.deleted_at IS NULL DESC, s.created_at DESC
");
$stmt->execute([$currentCompanyId]);
$sites = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Separate active and deleted sites
$activeSites = array_filter($sites, fn($s) => $s['deleted_at'] === null);
$deletedSites = array_filter($sites, fn($s) => $s['deleted_at'] !== null);

// ============================================================================
// GET COMPANY INFO FOR DISPLAY
// ============================================================================
$stmt = $pdo->prepare("SELECT name FROM companies WHERE id = ?");
$stmt->execute([$currentCompanyId]);
$companyName = $stmt->fetchColumn() ?? 'Unknown Company';

// ============================================================================
// STATISTICS
// ============================================================================
$totalSites = count($activeSites);
$countries = array_unique(array_column($activeSites, 'country'));
$countryCount = count($countries);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Management - ESG Reporting</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom animations */
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-slide-in { animation: slideIn 0.3s ease-out; }
        
        /* Modal backdrop */
        .modal-backdrop {
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased">

    <!-- Success/Error Messages -->
    <div id="message-container" class="fixed top-4 right-4 z-50"></div>

    <!-- MAIN LAYOUT -->
    <div class="min-h-screen">
        
        <!-- Header -->
        <header class="bg-white border-b border-slate-200 shadow-sm sticky top-0 z-40">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-slate-800">Site Management</h1>
                        <p class="text-sm text-slate-500 mt-1">
                            <span class="font-medium"><?= htmlspecialchars($companyName) ?></span> 
                            · Phase 2: Location & Facility Setup
                        </p>
                    </div>
                    <div class="flex gap-3">
                        <a href="dashboard.php" class="px-4 py-2 border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors text-sm font-medium">
                            ← Back to Dashboard
                        </a>
                        <button onclick="openAddModal()" class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors text-sm font-medium flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add New Site
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-600">Total Sites</p>
                            <p class="text-3xl font-bold text-slate-900 mt-2"><?= $totalSites ?></p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-600">Countries</p>
                            <p class="text-3xl font-bold text-slate-900 mt-2"><?= $countryCount ?></p>
                        </div>
                        <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-600">Active</p>
                            <p class="text-3xl font-bold text-emerald-600 mt-2"><?= count($activeSites) ?></p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-600">Archived</p>
                            <p class="text-3xl font-bold text-red-600 mt-2"><?= count($deletedSites) ?></p>
                        </div>
                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sites Table -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                    <h3 class="font-bold text-slate-700 flex items-center gap-2">
                        <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        Active Sites
                    </h3>
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                        <span class="text-xs text-slate-500"><?= count($activeSites) ?> location<?= count($activeSites) !== 1 ? 's' : '' ?></span>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50 text-xs uppercase text-slate-500 font-semibold">
                            <tr>
                                <th class="px-6 py-3 text-left">Site Name</th>
                                <th class="px-6 py-3 text-left">Address</th>
                                <th class="px-6 py-3 text-left">Country</th>
                                <th class="px-6 py-3 text-center">Audit Trail</th>
                                <th class="px-6 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php if (empty($activeSites)): ?>
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <svg class="w-16 h-16 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                            <p class="text-slate-500 font-medium">No sites found</p>
                                            <button onclick="openAddModal()" class="text-emerald-600 hover:text-emerald-700 text-sm font-medium">
                                                + Add your first site
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($activeSites as $site): ?>
                                    <tr class="hover:bg-slate-50 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-slate-900"><?= htmlspecialchars($site['name']) ?></div>
                                            <div class="text-xs text-slate-500">ID: <?= htmlspecialchars(substr($site['id'], 0, 8)) ?>...</div>
                                        </td>
                                        <td class="px-6 py-4 text-slate-600">
                                            <?= $site['address'] ? htmlspecialchars($site['address']) : '<span class="text-slate-400 italic">No address</span>' ?>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 py-1 bg-blue-50 text-blue-700 rounded text-xs font-medium">
                                                <?= htmlspecialchars($site['country']) ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex flex-col items-center text-[10px] text-slate-400 gap-1">
                                                <div class="flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <?= date('M d, Y', strtotime($site['created_at'])) ?>
                                                </div>
                                                <div class="text-slate-500">By: <?= htmlspecialchars($site['creator_name'] ?? 'System') ?></div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex justify-end gap-2">
                                                <button onclick='openEditModal(<?= json_encode($site) ?>)' 
                                                    class="text-blue-600 hover:text-blue-800 text-xs font-medium px-3 py-1 rounded hover:bg-blue-50 transition-colors">
                                                    Edit
                                                </button>
                                                <button onclick="confirmDelete('<?= htmlspecialchars($site['id']) ?>', '<?= htmlspecialchars($site['name']) ?>')" 
                                                    class="text-red-600 hover:text-red-800 text-xs font-medium px-3 py-1 rounded hover:bg-red-50 transition-colors">
                                                    Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Archived Sites (if any) -->
            <?php if (!empty($deletedSites)): ?>
                <div class="bg-white rounded-lg shadow-sm border border-red-200 overflow-hidden mt-8">
                    <div class="px-6 py-4 bg-red-50 border-b border-red-100 flex justify-between items-center">
                        <h3 class="font-bold text-red-700 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Archived Sites
                        </h3>
                        <span class="text-xs text-red-600"><?= count($deletedSites) ?> deleted</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-red-50 text-xs uppercase text-red-600 font-semibold">
                                <tr>
                                    <th class="px-6 py-3 text-left">Site Name</th>
                                    <th class="px-6 py-3 text-left">Deleted</th>
                                    <th class="px-6 py-3 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-red-100">
                                <?php foreach ($deletedSites as $site): ?>
                                    <tr class="opacity-60 hover:opacity-100 transition-opacity">
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-slate-900 line-through"><?= htmlspecialchars($site['name']) ?></div>
                                        </td>
                                        <td class="px-6 py-4 text-xs text-red-600">
                                            <?= date('M d, Y H:i', strtotime($site['deleted_at'])) ?>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <button onclick="restoreSite('<?= $site['id'] ?>', '<?= htmlspecialchars($site['name']) ?>')" 
                                                class="text-emerald-600 hover:text-emerald-800 text-xs font-medium px-3 py-1 rounded hover:bg-emerald-50 transition-colors">
                                                Restore
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>

        </main>
    </div>

    <!-- Add/Edit Modal -->
    <div id="siteModal" class="fixed inset-0 z-50 hidden">
        <div class="modal-backdrop absolute inset-0" onclick="closeModal()"></div>
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full relative z-10 animate-slide-in">
                <div class="px-6 py-4 border-b border-slate-200">
                    <h3 id="modalTitle" class="text-xl font-bold text-slate-800">Add New Site</h3>
                </div>
                
                <form id="siteForm" class="p-6 space-y-6">
                    <input type="hidden" id="siteId" name="siteId">
                    <input type="hidden" name="action" id="formAction" value="create">
                    
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Site Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="siteName" name="name" required 
                            class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none"
                            placeholder="e.g., Main Office Berlin">
                        <p class="text-xs text-slate-500 mt-1">Must be unique within your company</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Address
                        </label>
                        <textarea id="siteAddress" name="address" rows="3"
                            class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none resize-none"
                            placeholder="Street address, city, postal code"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Country <span class="text-red-500">*</span>
                        </label>
                        <select id="siteCountry" name="country" required
                            class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none bg-white">
                            <option value="DE">Germany (DE)</option>
                            <option value="US">United States (US)</option>
                            <option value="GB">United Kingdom (GB)</option>
                            <option value="FR">France (FR)</option>
                            <option value="ES">Spain (ES)</option>
                            <option value="IT">Italy (IT)</option>
                            <option value="NL">Netherlands (NL)</option>
                            <option value="BE">Belgium (BE)</option>
                            <option value="AT">Austria (AT)</option>
                            <option value="CH">Switzerland (CH)</option>
                        </select>
                    </div>

                    <div class="flex gap-3 pt-4 border-t border-slate-200">
                        <button type="button" onclick="closeModal()" 
                            class="flex-1 px-4 py-3 bg-white border border-slate-300 text-slate-700 font-medium rounded-lg hover:bg-slate-50 transition-colors">
                            Cancel
                        </button>
                        <button type="submit" 
                            class="flex-1 px-4 py-3 bg-emerald-600 text-white font-medium rounded-lg hover:bg-emerald-700 transition-colors">
                            <span id="submitButtonText">Create Site</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // ========================================================================
        // MODAL FUNCTIONS
        // ========================================================================
        function openAddModal() {
            document.getElementById('modalTitle').textContent = 'Add New Site';
            document.getElementById('formAction').value = 'create';
            document.getElementById('submitButtonText').textContent = 'Create Site';
            document.getElementById('siteId').value = '';
            document.getElementById('siteForm').reset();
            document.getElementById('siteModal').classList.remove('hidden');
        }

        function openEditModal(site) {
            document.getElementById('modalTitle').textContent = 'Edit Site';
            document.getElementById('formAction').value = 'update';
            document.getElementById('submitButtonText').textContent = 'Update Site';
            document.getElementById('siteId').value = site.id;
            document.getElementById('siteName').value = site.name;
            document.getElementById('siteAddress').value = site.address || '';
            document.getElementById('siteCountry').value = site.country;
            document.getElementById('siteModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('siteModal').classList.add('hidden');
        }

        // ========================================================================
        // FORM SUBMISSION
        // ========================================================================
        document.getElementById('siteForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            try {
                const response = await fetch('save_site.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showMessage(result.message, 'success');
                    closeModal();
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showMessage(result.message, 'error');
                }
            } catch (error) {
                showMessage('An error occurred. Please try again.', 'error');
                console.error('Error:', error);
            }
        });

        // ========================================================================
        // DELETE FUNCTION
        // ========================================================================
        async function confirmDelete(siteId, siteName) {
            if (!confirm(`Are you sure you want to delete "${siteName}"?\n\nThis is a soft delete and can be restored later.`)) {
                return;
            }
            
            try {
                const formData = new FormData();
                formData.append('action', 'delete');
                formData.append('siteId', siteId);
                
                const response = await fetch('save_site.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showMessage(result.message, 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showMessage(result.message, 'error');
                }
            } catch (error) {
                showMessage('An error occurred. Please try again.', 'error');
                console.error('Error:', error);
            }
        }

        // ========================================================================
        // RESTORE FUNCTION
        // ========================================================================
        async function restoreSite(siteId, siteName) {
            if (!confirm(`Restore "${siteName}"?`)) {
                return;
            }
            
            try {
                const formData = new FormData();
                formData.append('action', 'restore');
                formData.append('siteId', siteId);
                
                const response = await fetch('save_site.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showMessage(result.message, 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showMessage(result.message, 'error');
                }
            } catch (error) {
                showMessage('An error occurred. Please try again.', 'error');
                console.error('Error:', error);
            }
        }

        // ========================================================================
        // MESSAGE DISPLAY
        // ========================================================================
        function showMessage(message, type) {
            const container = document.getElementById('message-container');
            const bgColor = type === 'success' ? 'bg-green-50 border-green-200 text-green-800' : 'bg-red-50 border-red-200 text-red-800';
            const icon = type === 'success' 
                ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
                : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>';
            
            const messageDiv = document.createElement('div');
            messageDiv.className = `${bgColor} border px-4 py-3 rounded-lg shadow-lg mb-3 flex items-center gap-3 animate-slide-in`;
            messageDiv.innerHTML = `
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">${icon}</svg>
                <span class="font-medium">${message}</span>
            `;
            
            container.appendChild(messageDiv);
            
            setTimeout(() => {
                messageDiv.remove();
            }, 5000);
        }

        // Close modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
    </script>

</body>
</html>