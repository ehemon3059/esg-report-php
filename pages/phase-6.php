<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Phase 6: EU Taxonomy & Assurance</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
  
  <section id="phase-6" class="mb-16 scroll-mt-20 p-8">
    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-8 border-b border-emerald-200 pb-4">
      Phase 6: EU Taxonomy & Assurance
    </h2>

    <div class="grid gap-10">

      <!-- EU TAXONOMY START -->
      <div class="bg-gradient-to-br from-white to-indigo-50/50 shadow-2xl rounded-2xl p-8 border border-indigo-100">
        
        <form class="space-y-8">

          <!-- Header Section -->
          <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-10">
            <div class="flex items-center gap-4">
              <div class="relative">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center shadow-lg">
                  <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                  </svg>
                </div>
                <div class="absolute -inset-2 bg-gradient-to-r from-amber-500/20 to-orange-600/20 blur-xl rounded-full"></div>
              </div>
              <div>
                <h3 class="text-2xl font-bold text-gray-900">EU Taxonomy Reporting</h3>
                <div class="flex flex-wrap items-center gap-3 mt-2">
                  <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    <span class="text-sm font-medium text-gray-600">Regulation: <span class="text-amber-700 font-semibold">Article 8</span></span>
                  </div>
                  <div class="flex items-center gap-2 px-3 py-1 bg-gradient-to-r from-amber-100 to-amber-200 text-amber-800 text-xs font-semibold rounded-full border border-amber-300">
                    <div class="w-2 h-2 bg-amber-500 rounded-full animate-pulse"></div>
                    <span>Compliance Draft</span>
                  </div>
                  <span class="px-3 py-1 bg-gradient-to-r from-gray-100 to-gray-200 text-gray-800 text-xs font-semibold rounded-full border border-gray-300">EU Taxonomy</span>
                </div>
              </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-4">
              <div class="flex gap-3 self-end">
                <button type="button" class="px-5 py-2.5 bg-white border-2 border-amber-300 text-amber-700 font-medium rounded-xl hover:bg-amber-50 transition-all duration-200 flex items-center gap-2 shadow-sm hover:shadow-md">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                  </svg>
                  Save Draft
                </button>
                <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-amber-600 to-orange-600 text-white font-medium rounded-xl hover:from-amber-700 hover:to-orange-700 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center gap-2">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                  Update Records
                </button>
              </div>
            </div>
          </div>

          <!-- Progress Indicator -->
          <div class="mb-10">
            <div class="flex justify-between items-center mb-3">
              <div>
                <span class="text-sm font-semibold text-gray-700">Taxonomy Disclosure Progress</span>
                <p class="text-xs text-gray-500 mt-1">Completion status across all taxonomy metrics</p>
              </div>
              <span class="text-lg font-bold text-amber-900 bg-amber-100 px-3 py-1 rounded-full">60%</span>
            </div>
            <div class="h-3 bg-gray-200/80 rounded-full overflow-hidden shadow-inner">
              <div class="h-full bg-gradient-to-r from-amber-500 via-amber-600 to-orange-600 rounded-full relative" style="width: 60%">
                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent animate-shimmer"></div>
              </div>
            </div>
          </div>

          <!-- Reporting Period (MISSING FIELD ADDED) -->
          <div class="bg-white/90 backdrop-blur-sm border border-gray-200 rounded-2xl p-6 shadow-lg shadow-gray-200/30 hover:shadow-gray-300/40 transition-shadow duration-300">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
              <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-100 to-indigo-200 flex items-center justify-center shadow-inner">
                <svg class="w-5 h-5 text-indigo-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
              </div>
              <div>
                <h4 class="text-lg font-bold text-gray-900">Reporting Period</h4>
                <p class="text-sm text-gray-600 mt-1">Required field for taxonomy reporting</p>
              </div>
            </div>
            <div class="space-y-2">
              <label class="block text-sm font-semibold text-gray-700">Reporting Period <span class="text-red-500">*</span></label>
              <div class="relative group">
                <input type="date" name="reportingPeriod" required class="w-full px-4 py-2.5 bg-white border-2 border-indigo-200 rounded-xl focus:border-indigo-400 focus:ring-2 focus:ring-indigo-500/20 outline-none transition-all duration-200 shadow-sm hover:border-indigo-300">
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                  <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                  </svg>
                </div>
              </div>
              <p class="text-xs text-gray-500">Select the reporting period for this taxonomy assessment</p>
            </div>
          </div>

          <!-- Technical Screening Card -->
          <div class="bg-white/90 backdrop-blur-sm border border-gray-200 rounded-2xl p-6 shadow-lg shadow-gray-200/30 hover:shadow-gray-300/40 transition-shadow duration-300">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
              <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-100 to-purple-200 flex items-center justify-center shadow-inner">
                <svg class="w-5 h-5 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
              </div>
              <div>
                <h4 class="text-lg font-bold text-gray-900">Technical Screening</h4>
                <p class="text-sm text-gray-600 mt-1">Technical criteria assessment</p>
              </div>
            </div>

            <div class="space-y-6">
              <!-- Technical Screening Criteria Textarea -->
              <div class="space-y-3">
                <label class="block text-sm font-semibold text-gray-800">Technical Screening Criteria</label>
                <div class="relative group">
                  <textarea name="technicalScreeningCriteria" rows="6" placeholder="Evidence of substantial contribution to environmental objectives..." class="w-full px-4 py-3.5 bg-white border-2 border-gray-200 rounded-xl focus:border-purple-400 focus:ring-2 focus:ring-purple-500/20 outline-none transition-all duration-200 shadow-sm hover:border-purple-300 resize-none"></textarea>
                  <div class="absolute bottom-3 right-3">
                    <span class="text-xs text-gray-400">0/1500</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Section 1: Economic Activities -->
          <div class="bg-white/90 backdrop-blur-sm border border-gray-200 rounded-2xl p-6 shadow-lg shadow-gray-200/30 hover:shadow-gray-300/40 transition-shadow duration-300">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
              <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-100 to-amber-200 flex items-center justify-center shadow-inner">
                <span class="text-amber-800 font-bold text-lg">1</span>
              </div>
              <div>
                <h4 class="text-lg font-bold text-gray-900">Economic Activities & Turnover</h4>
                <p class="text-sm text-gray-600 mt-1">NACE codes and turnover alignment assessment</p>
              </div>
            </div>

            <div class="grid lg:grid-cols-3 gap-6">
              <div class="lg:col-span-2 space-y-4">
                <div class="space-y-3">
                  <label class="block text-sm font-semibold text-gray-800 flex items-center gap-2">
                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    Description of Economic Activities
                  </label>
                  <div class="relative group">
                    <textarea name="economicActivities" rows="5" placeholder="List and describe the NACE codes and activities identified..." class="w-full px-4 py-3.5 bg-white border-2 border-gray-200 rounded-xl focus:border-amber-400 focus:ring-2 focus:ring-amber-500/20 outline-none transition-all duration-200 shadow-sm hover:border-amber-300 resize-none"></textarea>
                    <div class="absolute bottom-3 right-3">
                      <span class="text-xs text-gray-400">0/1000</span>
                    </div>
                  </div>
                  <div class="flex items-center gap-2">
                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-xs text-gray-500">Include NACE codes and corresponding business activities</p>
                  </div>
                </div>
              </div>

              <div class="space-y-4">
                <!-- Eligible Revenue Card -->
                <div class="bg-gradient-to-br from-amber-50 to-amber-100/50 border border-amber-200 rounded-xl p-5">
                  <div class="flex items-center justify-between mb-3">
                    <label class="text-sm font-semibold text-amber-800">Eligible Revenue</label>
                    <span class="text-xs font-medium bg-amber-200 text-amber-800 px-2 py-1 rounded-full">Taxonomy</span>
                  </div>
                  <div class="space-y-2">
                    <div class="relative">
                      <input type="number" name="taxonomyEligibleRevenuePct" min="0" max="100" step="1" placeholder="0" class="w-full px-4 py-3.5 bg-white border-2 border-amber-200 rounded-xl focus:border-amber-400 focus:ring-2 focus:ring-amber-500/20 outline-none transition-all duration-200 shadow-sm hover:border-amber-300 text-xl font-bold text-amber-900 pr-12">
                      <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                        <span class="text-amber-700 font-bold">%</span>
                      </div>
                    </div>
                    <div class="flex items-center justify-between px-1">
                      <span class="text-xs text-amber-500">0%</span>
                      <div class="w-3/4 h-2 bg-amber-100 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-amber-300 to-amber-400 rounded-full" style="width: 30%"></div>
                      </div>
                      <span class="text-xs text-amber-500">100%</span>
                    </div>
                  </div>
                </div>

                <!-- Aligned Revenue Card -->
                <div class="bg-gradient-to-br from-emerald-50 to-emerald-100/50 border border-emerald-200 rounded-xl p-5">
                  <div class="flex items-center justify-between mb-3">
                    <label class="text-sm font-semibold text-emerald-800">Aligned Revenue</label>
                    <span class="text-xs font-medium bg-emerald-200 text-emerald-800 px-2 py-1 rounded-full">Compliant</span>
                  </div>
                  <div class="space-y-2">
                    <div class="relative">
                      <input type="number" name="taxonomyAlignedRevenuePct" min="0" max="100" step="1" placeholder="0" class="w-full px-4 py-3.5 bg-white border-2 border-emerald-200 rounded-xl focus:border-emerald-400 focus:ring-2 focus:ring-emerald-500/20 outline-none transition-all duration-200 shadow-sm hover:border-emerald-300 text-xl font-bold text-emerald-900 pr-12">
                      <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                        <span class="text-emerald-700 font-bold">%</span>
                      </div>
                    </div>
                    <div class="flex items-center justify-between px-1">
                      <span class="text-xs text-emerald-500">0%</span>
                      <div class="w-3/4 h-2 bg-emerald-100 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-emerald-300 to-emerald-400 rounded-full" style="width: 20%"></div>
                      </div>
                      <span class="text-xs text-emerald-500">100%</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Section 2: Compliance & Safeguards -->
          <div class="grid lg:grid-cols-2 gap-6">
            <div class="bg-white/90 backdrop-blur-sm border border-gray-200 rounded-2xl p-6 shadow-lg shadow-gray-200/30 hover:shadow-gray-300/40 transition-shadow duration-300">
              <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center shadow-inner">
                  <span class="text-blue-800 font-bold text-lg">2</span>
                </div>
                <div>
                  <h4 class="text-lg font-bold text-gray-900">Compliance & Safeguards</h4>
                  <p class="text-sm text-gray-600 mt-1">DNSH assessment and minimum social safeguards</p>
                </div>
              </div>

              <div class="space-y-6">
                <!-- DNSH Status Dropdown -->
                <div class="space-y-3">
                  <label class="block text-sm font-semibold text-gray-800 flex items-center gap-2">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    DNSH Status (Do No Significant Harm)
                  </label>
                  <div class="relative group">
                    <select name="dnsh_status" class="w-full px-4 py-3.5 bg-white border-2 border-gray-200 rounded-xl appearance-none focus:border-blue-400 focus:ring-2 focus:ring-blue-500/20 outline-none transition-all duration-200 shadow-sm hover:border-blue-300 cursor-pointer">
                      <option value="">Select DNSH assessment status</option>
                      <option value="ASSESSMENT_IN_PROGRESS">⏳ Assessment in Progress</option>
                      <option value="ALL_OBJECTIVES_PASSED">✅ All Objectives Passed</option>
                      <option value="SOME_OBJECTIVES_NOT_MET">⚠️ Some Objectives Not Met</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                      <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                      </svg>
                    </div>
                  </div>
                  <div class="flex items-center gap-2">
                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-xs text-gray-500">Assessment against DNSH criteria for each environmental objective</p>
                  </div>
                </div>

                <!-- Social Safeguards Dropdown -->
                <div class="space-y-3">
                  <label class="block text-sm font-semibold text-gray-800 flex items-center gap-2">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 0c-.66 0-1.293-.102-1.896-.294M4.5 20.5c.66 0 1.293-.102 1.896-.294m0 0A9 9 0 1021 12a9 9 0 00-9 9"></path>
                    </svg>
                    Minimum Social Safeguards
                  </label>
                  <div class="relative group">
                    <select name="social_safeguards_status" class="w-full px-4 py-3.5 bg-white border-2 border-gray-200 rounded-xl appearance-none focus:border-blue-400 focus:ring-2 focus:ring-blue-500/20 outline-none transition-all duration-200 shadow-sm hover:border-blue-300 cursor-pointer">
                      <option value="">Select social safeguards status</option>
                      <option value="FULL_COMPLIANCE">✅ Full Compliance</option>
                      <option value="PARTIAL_REMEDIATION">⚠️ Partial Remediation</option>
                      <option value="NON_COMPLIANCE">❌ Non-Compliance</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                      <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                      </svg>
                    </div>
                  </div>
                  <div class="flex items-center gap-2">
                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-xs text-gray-500">Alignment with OECD Guidelines and UN Guiding Principles</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Status Field (MISSING FROM ORIGINAL) -->
            <div class="bg-white/90 backdrop-blur-sm border border-gray-200 rounded-2xl p-6 shadow-lg shadow-gray-200/30 hover:shadow-gray-300/40 transition-shadow duration-300">
              <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-teal-100 to-teal-200 flex items-center justify-center shadow-inner">
                  <svg class="w-5 h-5 text-teal-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                  </svg>
                </div>
                <div>
                  <h4 class="text-lg font-bold text-gray-900">Status & Workflow</h4>
                  <p class="text-sm text-gray-600 mt-1">Document status and audit trail</p>
                </div>
              </div>

              <div class="space-y-6">
                <!-- Status Dropdown -->
                <div class="space-y-3">
                  <label class="block text-sm font-semibold text-gray-800 flex items-center gap-2">
                    <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Data Status <span class="text-red-500">*</span>
                  </label>
                  <div class="relative group">
                    <select name="status" required class="w-full px-4 py-3.5 bg-white border-2 border-gray-200 rounded-xl appearance-none focus:border-teal-400 focus:ring-2 focus:ring-teal-500/20 outline-none transition-all duration-200 shadow-sm hover:border-teal-300 cursor-pointer">
                      <option value="DRAFT" selected>📝 Draft</option>
                      <option value="SUBMITTED">📤 Submitted</option>
                      <option value="APPROVED">✅ Approved</option>
                      <option value="REJECTED">❌ Rejected</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                      <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                      </svg>
                    </div>
                  </div>
                  <div class="flex items-center gap-2">
                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-xs text-gray-500">Current status of this taxonomy record</p>
                  </div>
                </div>

                <!-- Audit Trail Info Box -->
                <div class="p-4 bg-gradient-to-r from-teal-50 to-teal-100/30 rounded-xl border border-teal-200">
                  <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-teal-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                      <p class="text-sm font-medium text-teal-800">Audit Trail</p>
                      <p class="text-xs text-teal-600 mt-1">Created by, updated by, and deleted at timestamps are automatically tracked in the system for compliance.</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Section 3: Capital & Operational Expenditure -->
          <div class="bg-gradient-to-br from-gray-50 to-gray-100/50 border border-gray-200 rounded-2xl p-6 shadow-lg shadow-gray-200/20">
            <div class="flex items-center justify-between mb-8">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center shadow-inner">
                  <span class="text-gray-800 font-bold text-lg">3</span>
                </div>
                <div>
                  <h4 class="text-lg font-bold text-gray-900">Capital & Operational Expenditure Alignment</h4>
                  <p class="text-sm text-gray-600 mt-1">Taxonomy-aligned CapEx and OpEx percentages</p>
                </div>
              </div>
              <span class="text-xs font-medium bg-gray-200 text-gray-800 px-3 py-1 rounded-full">Financial Metrics</span>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
              <!-- Eligible CapEx Card -->
              <div class="bg-white p-5 rounded-xl border-2 border-amber-200 shadow-sm hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center justify-between mb-4">
                  <label class="text-sm font-semibold text-gray-800">Eligible CapEx</label>
                  <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center">
                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                  </div>
                </div>
                <div class="space-y-3">
                  <div class="relative">
                    <input type="number" name="taxonomyEligibleCapexPct" min="0" max="100" step="1" placeholder="0" class="w-full px-4 py-3.5 bg-gray-50 border-2 border-amber-200 rounded-xl focus:border-amber-400 focus:ring-2 focus:ring-amber-500/20 outline-none transition-all duration-200 shadow-sm text-xl font-bold text-amber-900 pr-12">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                      <span class="text-amber-700 font-bold">%</span>
                    </div>
                  </div>
                  <p class="text-xs text-gray-500 text-center">Taxonomy-eligible capital expenditure</p>
                </div>
              </div>

              <!-- Aligned CapEx Card -->
              <div class="bg-gradient-to-br from-emerald-50 to-emerald-100/30 p-5 rounded-xl border-2 border-emerald-300 shadow-sm hover:shadow-md transition-shadow duration-200 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-16 h-16 bg-emerald-500/10 rounded-full -translate-y-8 translate-x-8"></div>
                <div class="flex items-center justify-between mb-4">
                  <label class="text-sm font-semibold text-emerald-800">Aligned CapEx</label>
                  <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                  </div>
                </div>
                <div class="space-y-3">
                  <div class="relative">
                    <input type="number" name="taxonomyAlignedCapexPct" min="0" max="100" step="1" placeholder="0" class="w-full px-4 py-3.5 bg-white border-2 border-emerald-300 rounded-xl focus:border-emerald-400 focus:ring-2 focus:ring-emerald-500/20 outline-none transition-all duration-200 shadow-sm text-xl font-bold text-emerald-900 pr-12">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                      <span class="text-emerald-700 font-bold">%</span>
                    </div>
                  </div>
                  <p class="text-xs text-emerald-600 text-center font-medium">Compliant with taxonomy criteria</p>
                </div>
              </div>

              <!-- Aligned OpEx Card -->
              <div class="bg-gradient-to-br from-teal-50 to-teal-100/30 p-5 rounded-xl border-2 border-teal-300 shadow-sm hover:shadow-md transition-shadow duration-200 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-16 h-16 bg-teal-500/10 rounded-full -translate-y-8 translate-x-8"></div>
                <div class="flex items-center justify-between mb-4">
                  <label class="text-sm font-semibold text-teal-800">Aligned OpEx</label>
                  <div class="w-8 h-8 rounded-lg bg-teal-100 flex items-center justify-center">
                    <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                  </div>
                </div>
                <div class="space-y-3">
                  <div class="relative">
                    <input type="number" name="taxonomyAlignedOpexPct" min="0" max="100" step="1" placeholder="0" class="w-full px-4 py-3.5 bg-white border-2 border-teal-300 rounded-xl focus:border-teal-400 focus:ring-2 focus:ring-teal-500/20 outline-none transition-all duration-200 shadow-sm text-xl font-bold text-teal-900 pr-12">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                      <span class="text-teal-700 font-bold">%</span>
                    </div>
                  </div>
                  <p class="text-xs text-teal-600 text-center font-medium">Operational expenditure meeting criteria</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Form Actions -->
          <div class="pt-8 border-t border-gray-200">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
              <div class="space-y-2">
                <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                  <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center shadow-sm">
                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                  </div>
                  <div>
                    <p class="text-sm font-medium text-gray-800">Disclosure Requirements</p>
                    <p class="text-xs text-gray-500">Based on Article 8 of EU Taxonomy Regulation</p>
                  </div>
                </div>
              </div>

              <div class="flex flex-col sm:flex-row gap-4">
                <button type="button" class="px-6 py-3.5 bg-white border-2 border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-all duration-200 flex items-center justify-center gap-2 shadow-sm hover:shadow-md">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                  </svg>
                  Reset Form
                </button>
                <button type="submit" class="px-6 py-3.5 bg-gradient-to-r from-amber-600 to-orange-600 text-white font-semibold rounded-xl hover:from-amber-700 hover:to-orange-700 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center justify-center gap-2 group relative overflow-hidden">
                  <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/10 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000"></div>
                  <svg class="w-5 h-5 text-white relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                  <span class="relative z-10">Update Taxonomy Records</span>
                </button>
              </div>
            </div>

            <!-- Compliance Note -->
            <div class="mt-6 p-4 bg-gradient-to-r from-amber-50 to-amber-100/30 rounded-xl border border-amber-200">
              <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                  <p class="text-sm font-medium text-amber-800">Compliance Note</p>
                  <p class="text-xs text-amber-600 mt-1">Ensure all data is cross-referenced with financial audits and validated by the finance department before submission. EU Taxonomy disclosures require board-level approval.</p>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <!-- EU TAXONOMY END -->

      <!-- ASSURANCE START -->
      <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-6 md:p-8">
        <h3 class="text-2xl font-bold text-gray-900 mb-2">Assurance & Audit</h3>
        <p class="text-gray-600 mb-8">Verification of sustainability disclosures for the current period</p>

        <!-- Modern Card Container -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl overflow-hidden border border-gray-200/50">

          <!-- Card Header with Gradient -->
          <div class="bg-gradient-to-r from-indigo-600 to-purple-700 p-6 md:p-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
              <div class="flex items-center gap-4">
                <div class="p-3 bg-white/10 backdrop-blur-sm rounded-xl border border-white/20">
                  <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                  </svg>
                </div>
                <div>
                  <h3 class="text-2xl font-bold text-white">Assurance & External Audit</h3>
                  <p class="text-white/80 text-sm mt-1">Complete your assurance verification process</p>
                </div>
              </div>
              <div class="bg-white/10 backdrop-blur-sm border border-white/20 px-5 py-2.5 rounded-xl">
                <span class="text-xs text-white/90 uppercase font-semibold tracking-wider">Status</span>
                <div class="flex items-center gap-2 mt-1">
                  <span class="w-2 h-2 bg-amber-400 rounded-full animate-pulse"></span>
                  <span class="text-white font-semibold">Ready for Review</span>
                </div>
              </div>
            </div>
          </div>

          <!-- Form Container -->
          <form class="p-6 md:p-8 space-y-10">

            <!-- Reporting Period (REQUIRED FIELD) -->
            <div class="bg-gradient-to-br from-indigo-50/50 to-white/50 backdrop-blur-sm rounded-2xl p-6 border border-indigo-200/50">
              <div class="flex items-center gap-3 mb-6 pb-4 border-b border-indigo-100">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-100 to-indigo-200 flex items-center justify-center shadow-inner">
                  <svg class="w-5 h-5 text-indigo-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                  </svg>
                </div>
                <div>
                  <h4 class="text-lg font-bold text-gray-900">Reporting Period</h4>
                  <p class="text-sm text-gray-600 mt-1">Required field for assurance reporting</p>
                </div>
              </div>
              <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-700">Reporting Period <span class="text-red-500">*</span></label>
                <div class="relative group">
                  <input type="date" name="reportingPeriod" required class="w-full px-4 py-2.5 bg-white border-2 border-indigo-200 rounded-xl focus:border-indigo-400 focus:ring-2 focus:ring-indigo-500/20 outline-none transition-all duration-200 shadow-sm hover:border-indigo-300">
                  <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                  </div>
                </div>
                <p class="text-xs text-gray-500">Select the reporting period for this assurance assessment</p>
              </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

              <!-- Left Column -->
              <div class="lg:col-span-1 space-y-8">
                <div class="space-y-6">
                  <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wider">Assurance Details</h4>

                  <!-- Assurance Provider -->
                  <div class="group">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Assurance Provider</label>
                    <div class="relative">
                      <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400 group-focus-within:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                      </svg>
                      <input type="text" name="assuranceProvider" class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200 bg-white/50 backdrop-blur-sm" placeholder="e.g. PwC, EY, Deloitte">
                    </div>
                  </div>

                  <!-- Scope of Assurance -->
                  <div class="group">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Scope of Assurance</label>
                    <div class="relative">
                      <select name="scopeOfAssurance" class="w-full pl-4 pr-10 py-3 rounded-xl border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 appearance-none bg-white/50 backdrop-blur-sm transition-all duration-200 cursor-pointer">
                        <option value="">Select scope</option>
                        <option value="LIMITED">Limited Assurance</option>
                        <option value="REASONABLE">Reasonable Assurance</option>
                        <option value="MIXED">Mixed Scope</option>
                      </select>
                      <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                      </svg>
                    </div>
                  </div>

                  <!-- Reporting Standards (MISSING FIELD ADDED) -->
                  <div class="group">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Reporting Standards</label>
                    <div class="relative">
                      <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400 group-focus-within:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                      </svg>
                      <input type="text" name="reportingStandards" class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200 bg-white/50 backdrop-blur-sm" placeholder="e.g. ISAE 3000, AA1000AS">
                    </div>
                  </div>

                  <!-- Status Field (MISSING FROM ORIGINAL) -->
                  <div class="group">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Data Status <span class="text-red-500">*</span></label>
                    <div class="relative">
                      <select name="status" required class="w-full pl-4 pr-10 py-3 rounded-xl border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 appearance-none bg-white/50 backdrop-blur-sm transition-all duration-200 cursor-pointer">
                        <option value="DRAFT" selected>📝 Draft</option>
                        <option value="SUBMITTED">📤 Submitted</option>
                        <option value="APPROVED">✅ Approved</option>
                        <option value="REJECTED">❌ Rejected</option>
                      </select>
                      <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                      </svg>
                    </div>
                  </div>
                </div>

                <!-- File Upload -->
                <div class="p-6 border-2 border-dashed border-gray-300 rounded-2xl bg-gradient-to-br from-white/50 to-gray-50/50 backdrop-blur-sm hover:border-indigo-400 hover:from-indigo-50/30 hover:to-white/50 transition-all duration-300 group cursor-pointer">
                  <div class="text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-2xl mb-4 group-hover:from-indigo-200 group-hover:to-purple-200 transition-all duration-300">
                      <svg class="w-8 h-8 text-indigo-600 group-hover:text-indigo-700 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                      </svg>
                    </div>
                    <div class="space-y-2">
                      <label class="cursor-pointer">
                        <span class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold px-6 py-3 rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 shadow-lg shadow-indigo-200">
                          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                          </svg>
                          Upload Audit Report
                        </span>
                        <input type="file" name="assuranceReport" class="sr-only" accept=".pdf,.doc,.docx">
                      </label>
                      <p class="text-sm text-gray-600">PDF, DOC up to 10MB</p>
                      <input type="hidden" name="assuranceReportUrl">
                      <input type="hidden" name="assuranceReportFilename">
                      <input type="hidden" name="assuranceReportMime">
                      <input type="hidden" name="assuranceReportSizeBytes">
                    </div>
                  </div>
                </div>
              </div>

              <!-- Right Column -->
              <div class="lg:col-span-2 space-y-8">
                <!-- Checklist Card -->
                <div class="bg-gradient-to-br from-gray-50/50 to-white/50 backdrop-blur-sm rounded-2xl p-6 border border-gray-200/50">
                  <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-6">Assurance Checklist</h4>
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    
                    <label class="flex items-center gap-3 p-4 bg-white/80 backdrop-blur-sm rounded-xl border border-gray-200/70 cursor-pointer hover:border-indigo-300 hover:shadow-md transition-all duration-200 group">
                      <div class="relative">
                        <input type="checkbox" name="checklist_data_collection_documented" class="w-5 h-5 rounded border-gray-300 text-indigo-600 focus:ring-2 focus:ring-indigo-500/30 cursor-pointer">
                      </div>
                      <span class="text-sm font-medium text-gray-700">Data Collection Documented</span>
                    </label>

                    <label class="flex items-center gap-3 p-4 bg-white/80 backdrop-blur-sm rounded-xl border border-gray-200/70 cursor-pointer hover:border-indigo-300 hover:shadow-md transition-all duration-200 group">
                      <div class="relative">
                        <input type="checkbox" name="checklist_internal_controls_tested" class="w-5 h-5 rounded border-gray-300 text-indigo-600 focus:ring-2 focus:ring-indigo-500/30 cursor-pointer">
                      </div>
                      <span class="text-sm font-medium text-gray-700">Internal Controls Tested</span>
                    </label>

                    <label class="flex items-center gap-3 p-4 bg-white/80 backdrop-blur-sm rounded-xl border border-gray-200/70 cursor-pointer hover:border-indigo-300 hover:shadow-md transition-all duration-200 group">
                      <div class="relative">
                        <input type="checkbox" name="checklist_source_documentation_trail" class="w-5 h-5 rounded border-gray-300 text-indigo-600 focus:ring-2 focus:ring-indigo-500/30 cursor-pointer">
                      </div>
                      <span class="text-sm font-medium text-gray-700">Audit Trail Validated</span>
                    </label>

                    <label class="flex items-center gap-3 p-4 bg-white/80 backdrop-blur-sm rounded-xl border border-gray-200/70 cursor-pointer hover:border-indigo-300 hover:shadow-md transition-all duration-200 group">
                      <div class="relative">
                        <input type="checkbox" name="checklist_calculation_method_validated" class="w-5 h-5 rounded border-gray-300 text-indigo-600 focus:ring-2 focus:ring-indigo-500/30 cursor-pointer">
                      </div>
                      <span class="text-sm font-medium text-gray-700">Methodology Validated</span>
                    </label>
                  </div>
                </div>

                <!-- Text Areas Section -->
                <div class="space-y-6">
                  <div class="group">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Assurance Conclusion Summary</label>
                    <div class="relative">
                      <textarea name="assuranceConclusionSummary" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 bg-white/50 backdrop-blur-sm transition-all duration-200 resize-none" placeholder="Summarize the auditor's opinion and key findings..."></textarea>
                      <div class="absolute bottom-3 right-3 text-xs text-gray-400">Max 500 characters</div>
                    </div>
                  </div>

                  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="group">
                      <label class="block text-sm font-semibold text-gray-700 mb-3">Material Misstatements</label>
                      <textarea name="materialMisstatementsIdentified" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-500/20 bg-white/50 backdrop-blur-sm transition-all duration-200 resize-none" placeholder="Any identified discrepancies or issues..."></textarea>
                    </div>
                    <div class="group">
                      <label class="block text-sm font-semibold text-gray-700 mb-3">Management Response</label>
                      <textarea name="managementResponse" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 bg-white/50 backdrop-blur-sm transition-all duration-200 resize-none" placeholder="Responses and corrective actions..."></textarea>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Action Buttons -->
            <div class="pt-8 border-t border-gray-200/50 flex flex-col sm:flex-row justify-end gap-4">
              <button type="button" class="px-8 py-3 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50/80 hover:shadow-sm transition-all duration-200 backdrop-blur-sm">
                Withdraw Review
              </button>
              <button type="submit" class="px-10 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold rounded-xl transition-all duration-200 shadow-lg shadow-indigo-200/50 hover:shadow-xl hover:shadow-indigo-300/50 backdrop-blur-sm">
                Finalize Assurance Report
              </button>
            </div>
          </form>
        </div>
      </div>
      <!-- ASSURANCE END -->

    </div>
  </section>

</body>
</html>