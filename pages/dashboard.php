<?php
session_start();
require_once 'includes/auth.php';
require_once 'config/database.php';
requireLogin(); // Must be logged in

// Get current user's company
$companyId = getCurrentCompanyId();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phase 1: Auth & Company Management (Updated)</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Smooth fade for tabs */
        .tab-pane { display: none; animation: fadeIn 0.3s ease; }
        .tab-pane.active { display: block; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased h-screen flex overflow-hidden">

    <!-- SIDEBAR NAVIGATION -->
    <aside class="w-64 bg-slate-900 text-slate-400 flex flex-col hidden md:flex">
        <div class="h-16 flex items-center px-6 border-b border-slate-800">
            <span class="text-white font-bold text-xl tracking-tight">ESG<span class="text-emerald-500">Admin</span></span>
        </div>
        
        <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
            <div class="px-2 mb-2 text-xs font-semibold text-slate-600 uppercase">Foundation</div>
            
            <!-- Nav: Companies -->
            <button onclick="switchTab('companies')" id="nav-companies" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-slate-800 hover:text-white transition-colors text-left bg-slate-800 text-white font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                Companies
            </button>
            
            <!-- Nav: Users -->
            <button onclick="switchTab('users')" id="nav-users" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-slate-800 hover:text-white transition-colors text-left">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                Users & Access
            </button>

            <div class="mt-8 px-2 mb-2 text-xs font-semibold text-slate-600 uppercase">ESG Data (Phase 2)</div>
            <button class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-500 cursor-not-allowed opacity-50">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"></path></svg>
                Sites
            </button>
            <button class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-500 cursor-not-allowed opacity-50">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Reports
            </button>
        </nav>

        <div class="p-4 border-t border-slate-800">
            <div class="flex items-center gap-3">
                <div class="w-2 h-2 rounded-full bg-green-500"></div>
                <div>
                    <p class="text-xs text-white">Super Admin</p>
                    <p class="text-[10px] text-slate-500">System Access</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 flex flex-col min-w-0 bg-slate-50">
        
        <!-- Header -->
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-8 shadow-sm flex-shrink-0">
            <div>
                <h1 id="page-title" class="text-xl font-bold text-slate-800">Company Management</h1>
                <p class="text-xs text-slate-500">Foundation: Authentication & Setup</p>
            </div>
            <div class="flex gap-3">
                 <button class="text-sm bg-white border border-slate-300 text-slate-700 px-3 py-1.5 rounded hover:bg-slate-50">System Logs</button>
            </div>
        </header>

        <!-- Body -->
        <div class="flex-1 overflow-auto p-4 md:p-8">
            
            <!-- ========================= TAB: COMPANIES ========================= -->
            <div id="tab-companies" class="tab-pane active max-w-7xl mx-auto">
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <!-- Left: Company List Table -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
                            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                                <h3 class="font-bold text-slate-700">Registered Companies</h3>
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                    <span class="text-xs text-slate-500">Including Soft-Deleted</span>
                                </div>
                            </div>
                            <table class="w-full text-sm text-left">
                                <thead class="bg-slate-50 text-xs uppercase text-slate-500 font-semibold">
                                    <tr>
                                        <th class="px-6 py-3">Company Details</th>
                                        <th class="px-6 py-3">Industry</th>
                                        <th class="px-6 py-3">Location</th>
                                        <th class="px-6 py-3 text-center">Audit Trail</th>
                                        <th class="px-6 py-3 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    
                                    <!-- Row: Deleted Company (Soft Delete Status) -->
                                    <tr class="hover:bg-slate-50 opacity-50">
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-slate-900">
                                                Archived Company Ltd
                                                <span class="ml-2 px-2 py-0.5 bg-red-100 text-red-700 text-xs rounded">Deleted</span>
                                            </div>
                                            <div class="text-xs text-slate-500">Legal: Archived AG</div>
                                        </td>
                                        <td class="px-6 py-4"><span class="px-2 py-1 bg-slate-100 text-slate-600 rounded text-xs font-medium">Manufacturing</span></td>
                                        <td class="px-6 py-4 text-slate-600">Germany 🇩🇪</td>
                                        <td class="px-6 py-4">
                                            <div class="flex flex-col items-center text-[10px] text-slate-400 gap-1">
                                                <div class="flex items-center gap-1 text-red-400">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    Deleted Oct 30
                                                </div>
                                                <div class="text-slate-500">By: SysAdmin</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <button class="text-slate-400 hover:text-slate-600 text-xs font-medium cursor-not-allowed">Edit</button>
                                        </td>
                                    </tr>

                                    <!-- Row 1 -->
                                    <tr class="hover:bg-slate-50 transition-colors group">
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-slate-900">Green Energy Corp</div>
                                            <div class="text-xs text-slate-500">Legal: Green Energy GmbH</div>
                                        </td>
                                        <td class="px-6 py-4"><span class="px-2 py-1 bg-green-50 text-green-700 rounded text-xs font-medium">Renewable Energy</span></td>
                                        <td class="px-6 py-4 text-slate-600">Germany 🇩🇪</td>
                                        <td class="px-6 py-4">
                                            <div class="flex flex-col items-center text-[10px] text-slate-400 gap-1">
                                                <div class="flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    Oct 24, 2023
                                                </div>
                                                <div class="text-slate-500">By: J. Doe</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <button class="text-blue-600 hover:text-blue-800 text-xs font-medium mr-3">Edit</button>
                                            <button class="text-red-600 hover:text-red-800 text-xs font-medium">Delete</button>
                                        </td>
                                    </tr>
                                    
                                    <!-- Row 2 -->
                                    <tr class="hover:bg-slate-50 transition-colors group">
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-slate-900">TechFlow Solutions</div>
                                            <div class="text-xs text-slate-500">Legal: TechFlow AG</div>
                                        </td>
                                        <td class="px-6 py-4"><span class="px-2 py-1 bg-blue-50 text-blue-700 rounded text-xs font-medium">Technology</span></td>
                                        <td class="px-6 py-4 text-slate-600">Germany 🇩🇪</td>
                                        <td class="px-6 py-4">
                                            <div class="flex flex-col items-center text-[10px] text-slate-400 gap-1">
                                                <div class="flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    Nov 02, 2023
                                                </div>
                                                <div class="text-slate-500">By: SysAdmin</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <button class="text-blue-600 hover:text-blue-800 text-xs font-medium mr-3">Edit</button>
                                            <button class="text-red-600 hover:text-red-800 text-xs font-medium">Delete</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Right: Create Company Form -->
                    <div class="lg:col-span-1">
                        <div class="bg-white p-6 rounded-lg shadow-sm border border-slate-200 sticky top-4">
                            <h3 class="font-bold text-slate-800 mb-4">Register New Company</h3>
                            
                            <!-- Success Message Container -->
                            <div id="success-alert" class="hidden p-3 bg-green-50 border border-green-200 rounded-lg mb-4">
                                <div class="flex items-center gap-2 text-sm text-green-800">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Company "Green Energy Corp" created successfully!
                                </div>
                            </div>
                            
                            <form class="space-y-4">
                                <!-- Name (Unique Constraint) -->
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 mb-1">Company Name <span class="text-red-500">*</span></label>
                                    <input type="text" required class="w-full rounded-md border-slate-300 border shadow-sm focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm px-3 py-2 outline-none" placeholder="e.g. Acme Ltd">
                                    <p class="text-[10px] text-slate-400 mt-1">Must be unique across the system.</p>
                                    
                                    <!-- Validation Message -->
                                    <div class="hidden error-message mt-2 p-2 bg-red-50 border border-red-200 rounded text-xs text-red-700">
                                        ❌ Company name already exists. Please choose a different name.
                                    </div>
                                </div>

                                <!-- Legal Entity -->
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 mb-1">Legal Entity <span class="text-red-500">*</span></label>
                                    <input type="text" required class="w-full rounded-md border-slate-300 border shadow-sm focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm px-3 py-2 outline-none" placeholder="e.g. GmbH, AG, LLC">
                                </div>

                                <!-- Industry -->
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 mb-1">Industry Sector</label>
                                    <select class="w-full rounded-md border-slate-300 border shadow-sm focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm px-3 py-2 outline-none bg-white">
                                        <option>Renewable Energy</option>
                                        <option>Manufacturing</option>
                                        <option>Technology</option>
                                        <option>Finance</option>
                                        <option>Healthcare</option>
                                    </select>
                                </div>

                                <!-- Country -->
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 mb-1">Country of Registration</label>
                                    <select class="w-full rounded-md border-slate-300 border shadow-sm focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm px-3 py-2 outline-none bg-white">
                                        <option selected>Germany</option>
                                        <option>United States</option>
                                        <option>United Kingdom</option>
                                        <option>France</option>
                                    </select>
                                </div>

                                <!-- Audit Trail (Feature 1) -->
                                <div class="p-3 bg-slate-50 rounded-lg border border-slate-200 mt-4">
                                    <p class="text-xs text-slate-500 mb-2">Audit Trail (Auto-populated)</p>
                                    <div class="text-xs text-slate-600">
                                        <div>Created By: <span class="font-medium">Current User ID</span></div>
                                        <div>Created At: <span class="font-medium">Auto-timestamp</span></div>
                                    </div>
                                </div>

                                <button type="button" onclick="document.getElementById('success-alert').classList.remove('hidden')" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-2.5 rounded-md text-sm font-medium shadow-sm transition-colors">
                                    Create Company
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>

            <!-- ========================= TAB: USERS ========================= -->
            <div id="tab-users" class="tab-pane max-w-7xl mx-auto">
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <!-- Left: Users Table -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
                            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                                <h3 class="font-bold text-slate-700">System Users</h3>
                                <div class="flex gap-2">
                                    <select class="text-xs border-slate-300 border rounded px-2 py-1 bg-white">
                                        <option>All Roles</option>
                                        <option>Admin</option>
                                        <option>Manager</option>
                                    </select>
                                </div>
                            </div>
                            <table class="w-full text-sm text-left">
                                <thead class="bg-slate-50 text-xs uppercase text-slate-500 font-semibold">
                                    <tr>
                                        <th class="px-6 py-3">User Profile</th>
                                        <th class="px-6 py-3">Role (Access Level)</th>
                                        <th class="px-6 py-3">Company Membership</th>
                                        <th class="px-6 py-3 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    <!-- User 1 -->
                                    <tr class="hover:bg-slate-50">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center text-white text-xs font-bold">SA</div>
                                                <div>
                                                    <div class="font-medium text-slate-900">Super Admin</div>
                                                    <div class="text-xs text-slate-500">super@admin.com</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4"><span class="px-2 py-1 bg-slate-800 text-white rounded text-xs font-bold border border-slate-600">Super Admin</span></td>
                                        <td class="px-6 py-4 text-xs text-slate-500 italic">System Level</td>
                                        <td class="px-6 py-4 text-right">
                                            <button class="text-blue-600 hover:text-blue-800 text-xs font-medium mr-3">Edit</button>
                                            <button class="text-red-600 hover:text-red-800 text-xs font-medium">Delete</button>
                                        </td>
                                    </tr>
                                    <!-- User 2 -->
                                    <tr class="hover:bg-slate-50">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs font-bold">MK</div>
                                                <div>
                                                    <div class="font-medium text-slate-900">Michael Klein</div>
                                                    <div class="text-xs text-slate-500">m.klein@greenenergy.com</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs font-semibold border border-blue-200">Manager</span>
                                            <div class="text-[10px] text-slate-400 mt-1">Can create/edit reports</div>
                                        </td>
                                        <td class="px-6 py-4 text-xs font-medium text-slate-700">Green Energy Corp</td>
                                        <td class="px-6 py-4 text-right">
                                            <button class="text-blue-600 hover:text-blue-800 text-xs font-medium mr-3">Edit</button>
                                            <button class="text-red-600 hover:text-red-800 text-xs font-medium">Delete</button>
                                        </td>
                                    </tr>
                                    <!-- User 3 -->
                                    <tr class="hover:bg-slate-50">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center text-xs font-bold">SJ</div>
                                                <div>
                                                    <div class="font-medium text-slate-900">Sarah Jones</div>
                                                    <div class="text-xs text-slate-500">s.jones@auditfirm.com</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 py-1 bg-orange-100 text-orange-700 rounded text-xs font-semibold border border-orange-200">Auditor</span>
                                            <div class="text-[10px] text-slate-400 mt-1">Read-only verification</div>
                                        </td>
                                        <td class="px-6 py-4 text-xs font-medium text-slate-700">Green Energy Corp</td>
                                        <td class="px-6 py-4 text-right">
                                            <button class="text-blue-600 hover:text-blue-800 text-xs font-medium mr-3">Edit</button>
                                            <button class="text-red-600 hover:text-red-800 text-xs font-medium">Delete</button>
                                        </td>
                                    </tr>
                                    <!-- User 4 -->
                                    <tr class="hover:bg-slate-50">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full bg-gray-100 text-gray-600 flex items-center justify-center text-xs font-bold">AL</div>
                                                <div>
                                                    <div class="font-medium text-slate-900">Anna Lee</div>
                                                    <div class="text-xs text-slate-500">a.lee@techflow.com</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs font-medium border border-gray-200">User</span>
                                        </td>
                                        <td class="px-6 py-4 text-xs font-medium text-slate-700">TechFlow Solutions</td>
                                        <td class="px-6 py-4 text-right">
                                            <button class="text-blue-600 hover:text-blue-800 text-xs font-medium mr-3">Edit</button>
                                            <button class="text-red-600 hover:text-red-800 text-xs font-medium">Delete</button>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Right: Add User Form -->
                    <div class="lg:col-span-1">
                        <div class="bg-white p-6 rounded-lg shadow-sm border border-slate-200 sticky top-4">
                            <h3 class="font-bold text-slate-800 mb-4">Add New User</h3>
                            
                            <form class="space-y-4">
                                <!-- Name -->
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 mb-1">Full Name</label>
                                    <input type="text" class="w-full rounded-md border-slate-300 border px-3 py-2 text-sm focus:ring-emerald-500 focus:border-emerald-500 outline-none" placeholder="Jane Doe">
                                </div>

                                <!-- Email (Unique Constraint) -->
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 mb-1">Email Address (Login ID)</label>
                                    <input type="email" class="w-full rounded-md border-slate-300 border px-3 py-2 text-sm focus:ring-emerald-500 focus:border-emerald-500 outline-none" placeholder="jane@company.com">
                                    <p class="text-[10px] text-slate-400 mt-1">Must be unique system-wide.</p>
                                </div>

                                <!-- Role (Authorization) -->
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 mb-1">Role & Permissions</label>
                                    <select class="w-full rounded-md border-slate-300 border px-3 py-2 text-sm bg-white focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                                        <option value="user">User (Data Entry)</option>
                                        <option value="auditor">Auditor (Read-only)</option>
                                        <option value="manager">Manager (Reports)</option>
                                        <option value="admin">Admin (Full Access)</option>
                                    </select>
                                </div>

                                <!-- Company (Enhanced Dropdown - Feature 6) -->
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 mb-1">Assign to Company</label>
                                    <select class="w-full rounded-md border-slate-300 border px-3 py-2 text-sm bg-white focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                                        <option value="" disabled selected>Select Company...</option>
                                        <option value="comp-001">Green Energy Corp (Renewable Energy)</option>
                                        <option value="comp-002">TechFlow Solutions (Technology)</option>
                                    </select>
                                    <p class="text-[10px] text-slate-400 mt-1">Determines which ESG data they see.</p>
                                </div>

                                <!-- Password -->
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 mb-1">Password</label>
                                    <input type="password" class="w-full rounded-md border-slate-300 border px-3 py-2 text-sm focus:ring-emerald-500 focus:border-emerald-500 outline-none" placeholder="••••••••">
                                </div>

                                <!-- Password Confirmation (Feature 7) -->
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 mb-1">Confirm Password</label>
                                    <input type="password" name="password_confirm" class="w-full rounded-md border-slate-300 border px-3 py-2 text-sm focus:ring-emerald-500 focus:border-emerald-500 outline-none" placeholder="••••••••">
                                </div>

                                <button type="button" class="w-full bg-slate-800 hover:bg-slate-900 text-white py-2.5 rounded-md text-sm font-medium shadow-sm transition-colors">
                                    Create User
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </main>

    <script>
        function switchTab(tabId) {
            // Toggle Content
            document.querySelectorAll('.tab-pane').forEach(el => el.classList.remove('active'));
            document.getElementById('tab-' + tabId).classList.add('active');

            // Toggle Nav Styles
            document.getElementById('nav-companies').classList.remove('bg-slate-800', 'text-white', 'font-medium');
            document.getElementById('nav-users').classList.remove('bg-slate-800', 'text-white', 'font-medium');
            
            document.getElementById('nav-' + tabId).classList.add('bg-slate-800', 'text-white', 'font-medium');

            // Update Header Title
            const titles = {
                'companies': 'Company Management',
                'users': 'Users & Access Control'
            };
            document.getElementById('page-title').innerText = titles[tabId];
        }
    </script>
</body>
</html>