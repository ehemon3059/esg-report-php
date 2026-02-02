<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phase 5: Social & Governance Reporting (S1–S4, G1)</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .accordion-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }
        
        input[type="checkbox"]:checked ~ .accordion-content {
            max-height: 2000px;
            transition: max-height 0.5s ease-in;
        }
        
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        
        .animate-shimmer {
            animation: shimmer 2s infinite;
        }
    </style>
</head>
<body class="bg-gray-50">

<div class="max-w-7xl mx-auto px-4 py-8">
    
    <!-- Page Header -->
    <section id="phase-5" class="mb-16 scroll-mt-20">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-8 border-b border-emerald-200 pb-4">
            Phase 5: Social & Governance Reporting (S1–S4, G1)
        </h2>

        <!-- ========================================================================
             REPORTING PERIOD & STATUS SECTION (CRITICAL - MISSING FROM ORIGINAL)
        ======================================================================== -->
        <div class="bg-white shadow-xl rounded-2xl p-6 border border-gray-200 mb-6">
            <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-3">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                Report Configuration (Required Fields)
            </h3>
            
            <div class="grid md:grid-cols-3 gap-6">
                <!-- Reporting Period -->
                <div class="space-y-3">
                    <label class="block text-sm font-semibold text-gray-800 flex items-center gap-2">
                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Reporting Period *
                        <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="date" 
                        id="reportingPeriod"
                        name="reportingPeriod"
                        required
                        class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition-all"
                    />
                    <p class="text-xs text-gray-500">Database unique constraint: companyId + reportingPeriod</p>
                </div>

                <!-- Social Topics Status -->
                <div class="space-y-3">
                    <label class="block text-sm font-semibold text-gray-800 flex items-center gap-2">
                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Social Topics Status
                    </label>
                    <select 
                        id="socialStatus"
                        name="socialStatus"
                        class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition-all appearance-none cursor-pointer"
                    >
                        <option value="DRAFT">Draft</option>
                        <option value="SUBMITTED">Submitted</option>
                        <option value="APPROVED">Approved</option>
                        <option value="REJECTED">Rejected</option>
                    </select>
                    <p class="text-xs text-gray-500">Status field from database schema</p>
                </div>

                <!-- Governance Status -->
                <div class="space-y-3">
                    <label class="block text-sm font-semibold text-gray-800 flex items-center gap-2">
                        <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Governance Status
                    </label>
                    <select 
                        id="governanceStatus"
                        name="governanceStatus"
                        class="w-full px-4 py-3 bg-white border-2 border-gray-300 rounded-xl focus:border-slate-400 focus:ring-2 focus:ring-slate-500/20 outline-none transition-all appearance-none cursor-pointer"
                    >
                        <option value="DRAFT">Draft</option>
                        <option value="SUBMITTED">Submitted</option>
                        <option value="APPROVED">Approved</option>
                        <option value="REJECTED">Rejected</option>
                    </select>
                    <p class="text-xs text-gray-500">Status field from database schema</p>
                </div>
            </div>

            <!-- Audit Trail Info (Auto-populated fields from backend) -->
            <div class="mt-6 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-200">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="text-sm text-blue-900">
                        <p class="font-semibold mb-1">Audit Trail (Auto-populated by backend):</p>
                        <ul class="space-y-1 text-xs">
                            <li>• <strong>createdBy:</strong> User ID from session (backend sets automatically)</li>
                            <li>• <strong>updatedBy:</strong> User ID from session (backend updates on save)</li>
                            <li>• <strong>deletedAt:</strong> Timestamp for soft delete (null when active)</li>
                            <li>• <strong>createdAt / updatedAt:</strong> Automatic timestamps from Prisma</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- ========================================================================
             SOCIAL TOPICS (S1–S4)
        ======================================================================== -->
        <div class="bg-gradient-to-br from-white to-indigo-50/50 shadow-2xl rounded-2xl p-8 border border-indigo-100 mb-6">
            
            <!-- Header Section -->
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-10">
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 0c-.66 0-1.293-.102-1.896-.294M4.5 20.5c.66 0 1.293-.102 1.896-.294m0 0A9 9 0 1021 12a9 9 0 00-9 9"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">Social Topics (S1–S4)</h3>
                        <div class="flex flex-wrap items-center gap-3 mt-2">
                            <span class="px-3 py-1 bg-gradient-to-r from-indigo-100 to-purple-100 text-indigo-800 text-xs font-semibold rounded-full border border-indigo-200">
                                Social Pillar
                            </span>
                            <span class="px-3 py-1 bg-gradient-to-r from-amber-100 to-orange-100 text-amber-800 text-xs font-semibold rounded-full border border-amber-200">
                                Phase 5
                            </span>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3">
                    <button type="button" class="px-5 py-2.5 bg-white border-2 border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-all duration-200 flex items-center gap-2 shadow-sm hover:shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                        </svg>
                        Save Progress
                    </button>
                </div>
            </div>

            <!-- Progress Overview -->
            <div class="mb-10 p-5 bg-gradient-to-r from-indigo-50/80 to-purple-50/80 rounded-2xl border border-indigo-100">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-indigo-900">S1</div>
                        <div class="text-xs text-gray-600 mt-1">Own Workforce</div>
                        <div class="h-1.5 bg-gray-200 rounded-full mt-2 overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-full" style="width: 85%"></div>
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-indigo-900">S2</div>
                        <div class="text-xs text-gray-600 mt-1">Value Chain</div>
                        <div class="h-1.5 bg-gray-200 rounded-full mt-2 overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-purple-500 to-purple-600 rounded-full" style="width: 60%"></div>
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-indigo-900">S3</div>
                        <div class="text-xs text-gray-600 mt-1">Communities</div>
                        <div class="h-1.5 bg-gray-200 rounded-full mt-2 overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-blue-500 to-blue-600 rounded-full" style="width: 45%"></div>
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-indigo-900">S4</div>
                        <div class="text-xs text-gray-600 mt-1">Consumers</div>
                        <div class="h-1.5 bg-gray-200 rounded-full mt-2 overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-violet-500 to-violet-600 rounded-full" style="width: 70%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Social Topics Form Fields -->
            <div class="space-y-4">

                <!-- S1 - Own Workforce -->
                <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden transition-all duration-300 hover:border-indigo-300 hover:shadow-lg">
                    <input type="checkbox" id="s1-accordion" class="hidden peer" checked>
                    <label for="s1-accordion" class="flex items-center justify-between px-6 py-5 cursor-pointer bg-gradient-to-r from-indigo-50 to-white peer-checked:from-indigo-100 transition-all duration-300">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-600 flex items-center justify-center shadow-md">
                                <span class="text-white font-bold text-lg">S1</span>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-gray-900">Own Workforce</h4>
                                <p class="text-sm text-gray-600 mt-1">Employee welfare, training, and health & safety</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 bg-gradient-to-r from-indigo-100 to-indigo-50 text-indigo-800 text-xs font-semibold rounded-full border border-indigo-200">
                                85% Complete
                            </span>
                            <svg class="w-5 h-5 text-gray-400 transition-transform duration-300 peer-checked:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </label>

                    <div class="accordion-content px-6 pb-6 max-h-0 overflow-hidden transition-all duration-300 peer-checked:max-h-[1000px]">
                        <div class="space-y-6 pt-4">
                            <!-- Materiality Check -->
                            <div class="flex items-center gap-3 p-4 bg-gradient-to-r from-indigo-50 to-indigo-100/50 rounded-xl border border-indigo-200">
                                <input type="checkbox" id="s1_material" name="s1_material" class="w-5 h-5 text-indigo-600 rounded-lg border-gray-300 focus:ring-2 focus:ring-indigo-500/50">
                                <label for="s1_material" class="text-sm font-semibold text-indigo-900">
                                    Is Own Workforce a material topic for this organization?
                                </label>
                            </div>

                            <!-- Form Fields -->
                            <div class="grid md:grid-cols-2 gap-6">
                                <div class="space-y-3">
                                    <label class="block text-sm font-semibold text-gray-800 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                        Training Hours (Per Employee)
                                    </label>
                                    <div class="relative">
                                        <input 
                                            type="number" 
                                            name="s1_training_hours_per_employee" 
                                            placeholder="e.g. 24"
                                            class="w-full px-4 py-3.5 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 outline-none transition-all shadow-sm pr-24"
                                        />
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                            <span class="text-gray-500">hours/year</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    <label class="block text-sm font-semibold text-gray-800">Health & Safety Policy</label>
                                    <textarea 
                                        name="s1_health_and_safety" 
                                        rows="3"
                                        class="w-full px-4 py-3.5 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 outline-none transition-all shadow-sm resize-none"
                                        placeholder="Describe Occupational Health & Safety management systems..."
                                    ></textarea>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <label class="block text-sm font-semibold text-gray-800 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    Employee Count by Contract Type
                                </label>
                                <textarea 
                                    name="s1_employee_count_by_contract" 
                                    rows="2"
                                    class="w-full px-4 py-3.5 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 outline-none transition-all shadow-sm resize-none"
                                    placeholder="Permanent vs Temporary breakdown..."
                                ></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- S2 - Workers in Value Chain -->
                <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden transition-all duration-300 hover:border-purple-300 hover:shadow-lg">
                    <input type="checkbox" id="s2-accordion" class="hidden peer">
                    <label for="s2-accordion" class="flex items-center justify-between px-6 py-5 cursor-pointer bg-gradient-to-r from-purple-50 to-white peer-checked:from-purple-100 transition-all duration-300">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center shadow-md">
                                <span class="text-white font-bold text-lg">S2</span>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-gray-900">Workers in Value Chain</h4>
                                <p class="text-sm text-gray-600 mt-1">Supply chain due diligence and LkSG compliance</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 bg-gradient-to-r from-purple-100 to-purple-50 text-purple-800 text-xs font-semibold rounded-full border border-purple-200">
                                60% Complete
                            </span>
                            <svg class="w-5 h-5 text-gray-400 transition-transform duration-300 peer-checked:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </label>

                    <div class="accordion-content px-6 pb-6 max-h-0 overflow-hidden transition-all duration-300 peer-checked:max-h-[1000px]">
                        <div class="space-y-6 pt-4">
                            <!-- Materiality Check -->
                            <div class="flex items-center gap-3 p-4 bg-gradient-to-r from-purple-50 to-purple-100/50 rounded-xl border border-purple-200">
                                <input type="checkbox" id="s2_material" name="s2_material" class="w-5 h-5 text-purple-600 rounded-lg border-gray-300 focus:ring-2 focus:ring-purple-500/50">
                                <label for="s2_material" class="text-sm font-semibold text-purple-900">
                                    Material Topic (Supply Chain/LkSG Compliance)
                                </label>
                            </div>

                            <!-- Form Fields -->
                            <div class="grid md:grid-cols-2 gap-6">
                                <div class="space-y-3">
                                    <label class="block text-sm font-semibold text-gray-800">Suppliers Audited</label>
                                    <div class="relative">
                                        <input 
                                            type="number" 
                                            name="s2_pct_suppliers_audited"
                                            min="0"
                                            max="100"
                                            class="w-full px-4 py-3.5 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500/30 focus:border-purple-500 outline-none transition-all shadow-sm pr-12"
                                        />
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                            <span class="text-gray-500">%</span>
                                        </div>
                                    </div>
                                    <p class="text-xs text-gray-500">Percentage of suppliers audited for labor standards</p>
                                </div>

                                <div class="space-y-3">
                                    <label class="block text-sm font-semibold text-gray-800">Remediation Actions Taken</label>
                                    <textarea 
                                        name="s2_remediation_actions" 
                                        rows="3"
                                        class="w-full px-4 py-3.5 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500/30 focus:border-purple-500 outline-none transition-all shadow-sm resize-none"
                                        placeholder="Describe actions to address supply chain risks..."
                                    ></textarea>
                                </div>
                            </div>

                            <div class="p-4 bg-gradient-to-r from-purple-50/50 to-purple-100/30 rounded-xl border border-purple-200">
                                <div class="flex items-center gap-3">
                                    <svg class="w-5 h-5 text-purple-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="text-sm text-purple-800">Ensure compliance with the German Supply Chain Due Diligence Act (LkSG) requirements.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- S3 - Affected Communities -->
                <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden transition-all duration-300 hover:border-blue-300 hover:shadow-lg">
                    <input type="checkbox" id="s3-accordion" class="hidden peer">
                    <label for="s3-accordion" class="flex items-center justify-between px-6 py-5 cursor-pointer bg-gradient-to-r from-blue-50 to-white peer-checked:from-blue-100 transition-all duration-300">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-md">
                                <span class="text-white font-bold text-lg">S3</span>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-gray-900">Affected Communities</h4>
                                <p class="text-sm text-gray-600 mt-1">Community engagement and grievance mechanisms</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 bg-gradient-to-r from-blue-100 to-blue-50 text-blue-800 text-xs font-semibold rounded-full border border-blue-200">
                                45% Complete
                            </span>
                            <svg class="w-5 h-5 text-gray-400 transition-transform duration-300 peer-checked:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </label>

                    <div class="accordion-content px-6 pb-6 max-h-0 overflow-hidden transition-all duration-300 peer-checked:max-h-[1000px]">
                        <div class="space-y-6 pt-4">
                            <!-- Materiality Check -->
                            <div class="flex items-center gap-3 p-4 bg-gradient-to-r from-blue-50 to-blue-100/50 rounded-xl border border-blue-200">
                                <input type="checkbox" id="s3_material" name="s3_material" class="w-5 h-5 text-blue-600 rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500/50">
                                <label for="s3_material" class="text-sm font-semibold text-blue-900">
                                    Is this topic material for the organization?
                                </label>
                            </div>

                            <!-- Form Fields -->
                            <div class="space-y-6">
                                <div class="space-y-3">
                                    <label class="block text-sm font-semibold text-gray-800 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        Community Engagement
                                    </label>
                                    <textarea 
                                        name="s3_community_engagement" 
                                        rows="3"
                                        class="w-full px-4 py-3.5 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 outline-none transition-all shadow-sm resize-none"
                                        placeholder="How do you engage with local communities?"
                                    ></textarea>
                                </div>

                                <div class="space-y-3">
                                    <label class="block text-sm font-semibold text-gray-800 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                        </svg>
                                        Complaints & Outcomes
                                    </label>
                                    <input 
                                        type="text" 
                                        name="s3_complaints_and_outcomes"
                                        class="w-full px-4 py-3.5 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 outline-none transition-all shadow-sm"
                                        placeholder="Number of grievances and their resolution status"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- S4 - Consumers & End Users -->
                <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden transition-all duration-300 hover:border-violet-300 hover:shadow-lg">
                    <input type="checkbox" id="s4-accordion" class="hidden peer">
                    <label for="s4-accordion" class="flex items-center justify-between px-6 py-5 cursor-pointer bg-gradient-to-r from-violet-50 to-white peer-checked:from-violet-100 transition-all duration-300">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-violet-500 to-violet-600 flex items-center justify-center shadow-md">
                                <span class="text-white font-bold text-lg">S4</span>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-gray-900">Consumers & End Users</h4>
                                <p class="text-sm text-gray-600 mt-1">Product safety and consumer protection</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 bg-gradient-to-r from-violet-100 to-violet-50 text-violet-800 text-xs font-semibold rounded-full border border-violet-200">
                                70% Complete
                            </span>
                            <svg class="w-5 h-5 text-gray-400 transition-transform duration-300 peer-checked:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </label>

                    <div class="accordion-content px-6 pb-6 max-h-0 overflow-hidden transition-all duration-300 peer-checked:max-h-[1000px]">
                        <div class="space-y-6 pt-4">
                            <!-- Materiality Check -->
                            <div class="flex items-center gap-3 p-4 bg-gradient-to-r from-violet-50 to-violet-100/50 rounded-xl border border-violet-200">
                                <input type="checkbox" id="s4_material" name="s4_material" class="w-5 h-5 text-violet-600 rounded-lg border-gray-300 focus:ring-2 focus:ring-violet-500/50">
                                <label for="s4_material" class="text-sm font-semibold text-violet-900">
                                    Is this topic material for the organization?
                                </label>
                            </div>

                            <!-- Form Fields -->
                            <div class="grid md:grid-cols-2 gap-6">
                                <div class="space-y-3">
                                    <label class="block text-sm font-semibold text-gray-800 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.768 0L6.342 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                        </svg>
                                        Product Safety Incidents
                                    </label>
                                    <input 
                                        type="number" 
                                        name="s4_product_safety_incidents" 
                                        placeholder="0"
                                        min="0"
                                        class="w-full px-4 py-3.5 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-violet-500/30 focus:border-violet-500 outline-none transition-all shadow-sm"
                                    />
                                    <p class="text-xs text-gray-500">Number of reported product safety incidents in reporting period</p>
                                </div>

                                <div class="space-y-3">
                                    <label class="block text-sm font-semibold text-gray-800">Consumer Remediation</label>
                                    <textarea 
                                        name="s4_consumer_remediation" 
                                        rows="3"
                                        class="w-full px-4 py-3.5 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-violet-500/30 focus:border-violet-500 outline-none transition-all shadow-sm resize-none"
                                        placeholder="Describe recall or remediation processes..."
                                    ></textarea>
                                </div>
                            </div>

                            <div class="p-4 bg-gradient-to-r from-violet-50/50 to-violet-100/30 rounded-xl border border-violet-200">
                                <div class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-violet-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="text-sm text-violet-800">Include details on product recall procedures, consumer complaints handling, and data privacy protection measures.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Summary Stats -->
            <div class="mt-10 pt-8 border-t border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="p-5 bg-gradient-to-br from-indigo-50 to-indigo-100/50 rounded-2xl border border-indigo-200">
                        <div class="text-sm font-semibold text-indigo-800 mb-2">Total Material Topics</div>
                        <div class="text-3xl font-bold text-indigo-900">3</div>
                        <div class="text-xs text-indigo-600 mt-2">out of 4 identified</div>
                    </div>

                    <div class="p-5 bg-gradient-to-br from-purple-50 to-purple-100/50 rounded-2xl border border-purple-200">
                        <div class="text-sm font-semibold text-purple-800 mb-2">Overall Progress</div>
                        <div class="text-3xl font-bold text-purple-900">65%</div>
                        <div class="text-xs text-purple-600 mt-2">Social reporting completion</div>
                    </div>

                    <div class="p-5 bg-gradient-to-br from-blue-50 to-blue-100/50 rounded-2xl border border-blue-200">
                        <div class="text-sm font-semibold text-blue-800 mb-2">Next Review</div>
                        <div class="text-3xl font-bold text-blue-900">Q2 2025</div>
                        <div class="text-xs text-blue-600 mt-2">Social compliance audit</div>
                    </div>
                </div>
            </div>

        </div>

        <!-- ========================================================================
             GOVERNANCE (G1)
        ======================================================================== -->
        <div class="bg-gradient-to-br from-white to-slate-50/80 shadow-2xl rounded-2xl p-8 border border-slate-100 mt-6">
            
            <!-- Header Section -->
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-10">
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-slate-600 to-slate-800 flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">Governance (G1)</h3>
                        <div class="flex flex-wrap items-center gap-3 mt-2">
                            <span class="px-3 py-1 bg-gradient-to-r from-slate-100 to-slate-200 text-slate-800 text-xs font-semibold rounded-full border border-slate-300">
                                Governance Pillar
                            </span>
                            <div class="flex items-center gap-2 px-3 py-1 bg-gradient-to-r from-amber-100 to-amber-200 text-amber-800 text-xs font-semibold rounded-full border border-amber-300">
                                <div class="w-2 h-2 bg-amber-500 rounded-full animate-pulse"></div>
                                <span>Draft Mode</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3">
                    <button type="button" class="px-5 py-2.5 bg-white border-2 border-slate-300 text-slate-700 font-medium rounded-xl hover:bg-slate-50 transition-all duration-200 flex items-center gap-2 shadow-sm hover:shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                        </svg>
                        Save Draft
                    </button>
                    <button type="button" class="px-5 py-2.5 bg-gradient-to-r from-slate-700 to-slate-900 text-white font-medium rounded-xl hover:from-slate-800 hover:to-slate-950 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Submit Disclosure
                    </button>
                </div>
            </div>

            <!-- Progress Indicator -->
            <div class="mb-10">
                <div class="flex justify-between items-center mb-3">
                    <div>
                        <span class="text-sm font-semibold text-slate-700">Governance Disclosure Progress</span>
                        <p class="text-xs text-slate-500 mt-1">Completion status across all sections</p>
                    </div>
                    <span class="text-lg font-bold text-slate-900 bg-slate-100 px-3 py-1 rounded-full">75%</span>
                </div>
                <div class="h-3 bg-slate-200/80 rounded-full overflow-hidden shadow-inner">
                    <div class="h-full bg-gradient-to-r from-slate-500 via-slate-600 to-slate-800 rounded-full relative" style="width: 75%">
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent animate-shimmer"></div>
                    </div>
                </div>
                <div class="flex justify-between text-xs text-slate-500 mt-3">
                    <div class="flex items-center gap-2">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Last updated: <span class="font-medium text-slate-700">Jan 26, 2026</span></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span>By: <span class="font-medium text-slate-700">John Doe</span></span>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid lg:grid-cols-2 gap-8">

                <!-- Left Column - Board Structure -->
                <div class="space-y-8">
                    <div class="bg-white/90 backdrop-blur-sm border border-slate-200 rounded-2xl p-6 shadow-lg shadow-slate-200/30 hover:shadow-slate-300/40 transition-shadow duration-300">
                        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center shadow-inner">
                                <svg class="w-5 h-5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-slate-900">Board Structure & Composition</h4>
                                <p class="text-sm text-slate-600 mt-1">Governance oversight and diversity metrics</p>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div class="space-y-3">
                                <label class="block text-sm font-semibold text-gray-800 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 0c-.66 0-1.293-.102-1.896-.294M4.5 20.5c.66 0 1.293-.102 1.896-.294m0 0A9 9 0 1021 12a9 9 0 00-9 9"></path>
                                    </svg>
                                    Gender Diversity
                                </label>
                                <div class="space-y-2">
                                    <div class="relative group">
                                        <input 
                                            type="number" 
                                            name="g1_gender_diversity_pct" 
                                            min="0" 
                                            max="100" 
                                            step="5"
                                            placeholder="Enter percentage (0-100)"
                                            class="w-full px-4 py-3.5 bg-white border-2 border-slate-200 rounded-xl focus:border-slate-400 focus:ring-2 focus:ring-slate-500/20 outline-none transition-all duration-200 shadow-sm group-hover:border-slate-300 pr-12"
                                        />
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                            <span class="text-slate-600 font-medium">%</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between px-1">
                                        <span class="text-xs text-slate-400">0%</span>
                                        <div class="w-3/4 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                            <div class="h-full bg-gradient-to-r from-slate-300 to-slate-400 rounded-full" style="width: 40%"></div>
                                        </div>
                                        <span class="text-xs text-slate-400">100%</span>
                                    </div>
                                </div>
                                <p class="text-xs text-slate-500 mt-2">Percentage of female representation on the board</p>
                            </div>

                            <div class="space-y-3">
                                <label class="block text-sm font-semibold text-gray-800 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                    Board Independence
                                </label>
                                <div class="relative">
                                    <input 
                                        type="text" 
                                        name="g1_board_composition_independence"
                                        placeholder="e.g. 4/6 Independent Directors"
                                        class="w-full px-4 py-3.5 bg-white border-2 border-slate-200 rounded-xl focus:border-slate-400 focus:ring-2 focus:ring-slate-500/20 outline-none transition-all duration-200 shadow-sm hover:border-slate-300"
                                    />
                                    <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                                        <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center">
                                            <svg class="w-3 h-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 mt-2">
                                    <div class="w-2 h-2 bg-slate-300 rounded-full animate-pulse"></div>
                                    <p class="text-xs text-slate-500">Format: [Number]/[Total] Independent Directors</p>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <label class="block text-sm font-semibold text-gray-800 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                    Board Meeting Frequency
                                </label>
                                <div class="relative group">
                                    <select class="w-full px-4 py-3.5 bg-white border-2 border-slate-200 rounded-xl appearance-none focus:border-slate-400 focus:ring-2 focus:ring-slate-500/20 outline-none transition-all duration-200 shadow-sm hover:border-slate-300 cursor-pointer pr-10">
                                        <option value="" disabled selected>Select meeting frequency</option>
                                        <option value="monthly">Monthly</option>
                                        <option value="quarterly">Quarterly</option>
                                        <option value="biannually">Bi-annually</option>
                                        <option value="annually">Annually</option>
                                        <option value="adhoc">As needed (Ad-hoc)</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <svg class="w-5 h-5 text-slate-400 group-hover:text-slate-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Stats Card -->
                    <div class="bg-gradient-to-br from-slate-50 to-slate-100/50 border border-slate-200 rounded-2xl p-6 shadow-lg shadow-slate-200/20">
                        <div class="flex items-center justify-between mb-6">
                            <h5 class="text-sm font-semibold text-slate-800">Governance Snapshot</h5>
                            <span class="text-xs text-slate-500 bg-slate-100 px-2 py-1 rounded-full">Current Year</span>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-3 bg-white/50 rounded-xl hover:bg-white/80 transition-colors duration-200">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <span class="text-sm text-slate-600">Board Meetings Held</span>
                                </div>
                                <span class="font-bold text-slate-900 text-lg">12</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-white/50 rounded-xl hover:bg-white/80 transition-colors duration-200">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                    </div>
                                    <span class="text-sm text-slate-600">Committee Composition</span>
                                </div>
                                <span class="font-bold text-slate-900 text-lg">4</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-white/50 rounded-xl hover:bg-white/80 transition-colors duration-200">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                    </div>
                                    <span class="text-sm text-slate-600">ESG Training Hours</span>
                                </div>
                                <span class="font-bold text-slate-900 text-lg">48 <span class="text-sm text-slate-500">hrs</span></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Business Conduct -->
                <div class="space-y-8">
                    <div class="bg-white/90 backdrop-blur-sm border border-slate-200 rounded-2xl p-6 shadow-lg shadow-slate-200/30 hover:shadow-slate-300/40 transition-shadow duration-300">
                        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center shadow-inner">
                                <svg class="w-5 h-5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-slate-900">Business Conduct & Ethics</h4>
                                <p class="text-sm text-slate-600 mt-1">Compliance, anti-corruption and whistleblower protection</p>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div class="space-y-3">
                                <label class="block text-sm font-semibold text-gray-800 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Policy Last Updated
                                </label>
                                <div class="relative group">
                                    <input 
                                        type="date"
                                        class="w-full px-4 py-3.5 bg-white border-2 border-slate-200 rounded-xl focus:border-slate-400 focus:ring-2 focus:ring-slate-500/20 outline-none transition-all duration-200 shadow-sm hover:border-slate-300 appearance-none"
                                    />
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <label class="block text-sm font-semibold text-gray-800 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                    Anti-Corruption Policies
                                </label>
                                <div class="relative group">
                                    <input 
                                        type="text" 
                                        name="g1_anti_corruption_policies"
                                        placeholder="https://company.com/policies/anti-corruption"
                                        class="w-full px-4 py-3.5 bg-white border-2 border-slate-200 rounded-xl focus:border-slate-400 focus:ring-2 focus:ring-slate-500/20 outline-none transition-all duration-200 shadow-sm hover:border-slate-300 pl-10"
                                    />
                                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 mt-2">
                                    <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="text-xs text-slate-500">Provide URL or document reference for anti-corruption policy</p>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <label class="block text-sm font-semibold text-gray-800 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                    Related Party Controls
                                </label>
                                <div class="relative">
                                    <input 
                                        type="text" 
                                        name="g1_related_party_controls"
                                        placeholder="Mechanisms for controlling related party transactions"
                                        class="w-full px-4 py-3.5 bg-white border-2 border-slate-200 rounded-xl focus:border-slate-400 focus:ring-2 focus:ring-slate-500/20 outline-none transition-all duration-200 shadow-sm hover:border-slate-300"
                                    />
                                    <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                                        <span class="text-xs font-medium bg-amber-100 text-amber-800 px-2 py-1 rounded-full">High Priority</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Fields Card -->
                    <div class="bg-white/90 backdrop-blur-sm border border-slate-200 rounded-2xl p-6 shadow-lg shadow-slate-200/30 hover:shadow-slate-300/40 transition-shadow duration-300">
                        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center shadow-inner">
                                <svg class="w-5 h-5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-slate-900">Reporting & Communication</h4>
                                <p class="text-sm text-slate-600 mt-1">Internal controls and disclosure mechanisms</p>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div class="space-y-3">
                                <label class="block text-sm font-semibold text-gray-800">ESG Oversight Mechanism</label>
                                <div class="relative group">
                                    <textarea 
                                        name="g1_esg_oversight" 
                                        rows="4"
                                        placeholder="Detail how the board monitors ESG performance and strategy..."
                                        class="w-full px-4 py-3.5 bg-white border-2 border-slate-200 rounded-xl focus:border-slate-400 focus:ring-2 focus:ring-slate-500/20 outline-none transition-all duration-200 shadow-sm hover:border-slate-300 resize-none group-hover:border-slate-300"
                                    ></textarea>
                                    <div class="absolute bottom-3 right-3 flex items-center gap-2">
                                        <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                                        <span class="text-xs text-slate-400">0/500</span>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between text-xs text-slate-500">
                                    <span>Provide specific oversight mechanisms</span>
                                    <span class="font-medium">Required</span>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <label class="block text-sm font-semibold text-gray-800">Whistleblower Cases & Protection</label>
                                <div class="relative group">
                                    <textarea 
                                        name="g1_whistleblower_cases" 
                                        rows="4"
                                        placeholder="Summarize cases reported and remediation outcomes..."
                                        class="w-full px-4 py-3.5 bg-white border-2 border-slate-200 rounded-xl focus:border-slate-400 focus:ring-2 focus:ring-slate-500/20 outline-none transition-all duration-200 shadow-sm hover:border-slate-300 resize-none"
                                    ></textarea>
                                    <div class="absolute bottom-3 right-3 flex items-center gap-2">
                                        <span class="text-xs text-slate-400">0/500</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 mt-2">
                                    <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="text-xs text-slate-500">Include number of cases, investigation outcomes, and protection measures</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="mt-10 pt-8 border-t border-slate-200">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                    <div class="space-y-3">
                        <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl">
                            <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center shadow-sm">
                                <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-800">Last edited by <span class="text-slate-900">John Doe</span></p>
                                <p class="text-xs text-slate-500">Compliance Officer • Jan 26, 2026 14:30</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4">
                        <button type="button" class="px-6 py-3.5 bg-white border-2 border-slate-300 text-slate-700 font-semibold rounded-xl hover:bg-slate-50 hover:border-slate-400 transition-all duration-200 flex items-center justify-center gap-2 shadow-sm hover:shadow-md group">
                            <svg class="w-5 h-5 text-slate-600 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Reset Form
                        </button>
                        <button type="submit" class="px-6 py-3.5 bg-gradient-to-r from-slate-700 to-slate-900 text-white font-semibold rounded-xl hover:from-slate-800 hover:to-slate-950 hover:shadow-xl transition-all duration-200 shadow-lg flex items-center justify-center gap-2 group relative overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/10 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000"></div>
                            <svg class="w-5 h-5 text-white relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="relative z-10">Submit Governance Disclosure</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Validation Status -->
            <div class="mt-8 p-4 bg-gradient-to-r from-slate-50 to-slate-100/50 rounded-xl border border-slate-200 shadow-inner">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center shadow-sm">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-slate-800">All required fields are complete</p>
                        <p class="text-xs text-slate-600 mt-1">Ready for submission. Review your entries before finalizing.</p>
                    </div>
                    <div class="text-right">
                        <div class="text-xs font-medium text-slate-500">Validation</div>
                        <div class="text-sm font-bold text-green-600">✓ Complete</div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Final Submit Button -->
        <div class="mt-10 flex justify-center">
            <button type="submit" class="px-8 py-4 bg-gradient-to-r from-emerald-600 to-teal-600 text-white text-lg font-semibold rounded-xl hover:from-emerald-700 hover:to-teal-700 transition-all duration-200 shadow-xl hover:shadow-2xl flex items-center gap-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Submit Complete Phase 5 Report
            </button>
        </div>

    </section>

</div>

</body>
</html>
