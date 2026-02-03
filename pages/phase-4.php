<?php
session_start();
require_once 'includes/auth.php';
requireLogin();

$companyId = getCurrentCompanyId();
$reportingPeriod = $_GET['period'] ?? date('Y-m-01');

// Get aggregated emissions for this period
$stmt = $pdo->prepare("
    SELECT 
        scope,
        SUM(tco2e_calculated) as total
    FROM emission_records
    WHERE company_id = ? 
      AND DATE_FORMAT(date_calculated, '%Y-%m') = ?
    GROUP BY scope
");
$stmt->execute([$companyId, $reportingPeriod]);
$emissions = $stmt->fetchAll(PDO::FETCH_ASSOC);

$scope1 = 0;
$scope2 = 0;
foreach($emissions as $em) {
    if($em['scope'] == 'Scope 1') $scope1 = $em['total'];
    if(str_contains($em['scope'], 'Scope 2')) $scope2 += $em['total'];
}
$totalGHG = $scope1 + $scope2;
?>

<section id="phase-4" class="mb-20 scroll-mt-20">
  
  <!-- ✅ NEW: Global Company & Reporting Period Selection -->
  

  <!-- Phase Header -->
  <div class="mb-12">
    <div class="inline-flex items-center gap-4 mb-4">
      <div class="relative">
        <div
          class="w-10 h-10 rounded-xl bg-gradient-to-br from-teal-500 to-emerald-600 flex items-center justify-center shadow-lg">
          <span class="text-white font-bold text-lg">4</span>
        </div>
      <div class="absolute -inset-2 bg-gradient-to-r from-teal-500/20 to-emerald-600/20 blur-xl rounded-full">
        </div>
      </div>
      <div>
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Environmental Reporting</h2>
        <p class="text-gray-600 mt-2">ESRS E1–E5 Compliance & Disclosure Management</p>
      </div>
    </div>
    <div class="flex items-center gap-3 mt-6 text-sm">
      <span
        class="px-3 py-1.5 bg-gradient-to-r from-teal-100 to-emerald-100 text-teal-800 rounded-full font-medium">ESRS
        Standards</span>
      <span class="px-3 py-1.5 bg-gray-100 text-gray-700 rounded-full font-medium">Phase 4</span>
    </div>
  </div>


  <div class="bg-gradient-to-br from-indigo-50 to-purple-50 shadow-lg rounded-2xl p-6 mb-8 border border-indigo-200">
    <div class="flex items-center gap-3 mb-4">
      <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
      </svg>
      <h3 class="text-lg font-bold text-gray-900">Context Selection</h3>
      <span class="ml-auto text-xs font-medium text-indigo-700 bg-indigo-100 px-3 py-1 rounded-full">Required for all reporting</span>
    </div>
    
    <div class="grid md:grid-cols-2 gap-4">
      <div class="space-y-2">
        <label class="block text-sm font-semibold text-gray-700 flex items-center gap-1">
          Company <span class="text-red-500">*</span>
        </label>
        <div class="relative">
          <select id="phase4GlobalCompanyId" name="companyId" required
            class="w-full px-4 py-3.5 bg-white border-2 border-indigo-200 rounded-xl focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 outline-none transition-all appearance-none shadow-sm">
            <option value="">Select Company</option>
            <!-- Populated dynamically from Company table -->
          </select>
          <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
          </div>
        </div>
      </div>

      <div class="space-y-2">
        <label class="block text-sm font-semibold text-gray-700 flex items-center gap-1">
          Reporting Period <span class="text-red-500">*</span>
        </label>
        <input type="month" id="phase4GlobalReportingPeriod" name="reportingPeriod" required placeholder="YYYY-MM"
          class="w-full px-4 py-3.5 bg-white border-2 border-indigo-200 rounded-xl focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 outline-none transition-all shadow-sm">
      </div>
    </div>
  </div>

  <div class="grid lg:grid-cols-3 gap-8">

    <!-- Left Column - General Disclosures -->
    <div class="lg:col-span-2 space-y-8">

      <!-- ✅ FIXED: General Disclosures Card -->
      <div class="bg-gradient-to-br from-white to-gray-50 shadow-2xl rounded-2xl p-8 border border-gray-100">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-8">
          <div>
            <div class="flex items-center gap-3 mb-3">
              <div
                class="w-12 h-12 rounded-xl bg-gradient-to-br from-teal-100 to-emerald-100 flex items-center justify-center">
                <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                  </path>
                </svg>
              </div>
              <div>
                <h3 class="text-2xl font-bold text-gray-900">ESRS 2 – General Disclosures</h3>
                <p class="text-gray-600 mt-1">Basis for preparation and governance oversight</p>
              </div>
            </div>
          </div>
          <div class="bg-gradient-to-r from-teal-50 to-emerald-50 border border-teal-200 px-4 py-2.5 rounded-xl">
            <div class="flex items-center gap-2">
              <div class="w-2 h-2 bg-teal-500 rounded-full"></div>
              <span class="text-sm font-semibold text-teal-800">Compliance Phase 4A</span>
            </div>
            <p class="text-xs text-teal-600 mt-1">Last updated: Jan 26, 2024</p>
          </div>
        </div>

        <form id="esrs2GeneralDisclosuresForm" class="space-y-8">
          <!-- ✅ FIXED: Removed duplicate reportingPeriod - using global instead -->
          
          <!-- ESG Integration -->
          <div class="space-y-3">
            <label class="block text-sm font-semibold text-gray-800 flex items-center gap-2">
              <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                </path>
              </svg>
              ESG Integration in Remuneration
            </label>
            <div class="relative">
              <input type="number" name="esgIntegrationInRemuneration" min="0" max="100"
                placeholder="Enter percentage"
                class="w-full px-4 py-3.5 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 outline-none transition-all shadow-sm pr-12">
              <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                <span class="text-gray-500 font-medium">%</span>
              </div>
            </div>
            <p class="text-xs text-gray-500">Percentage of executive remuneration linked to ESG targets</p>
          </div>

          <!-- Text Areas Grid -->
          <div class="grid md:grid-cols-2 gap-6">
            <div class="space-y-3">
              <label class="block text-sm font-semibold text-gray-800">Consolidation Scope <span class="text-red-500">*</span></label>
              <div class="relative">
                <textarea name="consolidationScope" rows="4" required
                  placeholder="Describe the scope of the consolidated sustainability statement..."
                  class="w-full px-4 py-3.5 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 outline-none transition-all shadow-sm resize-none"></textarea>
                <div class="absolute bottom-3 right-3">
                  <span class="text-xs text-gray-400">0/500</span>
                </div>
              </div>
            </div>

            <div class="space-y-3">
              <label class="block text-sm font-semibold text-gray-800">Value Chain Boundaries <span class="text-red-500">*</span></label>
              <div class="relative">
                <textarea name="valueChainBoundaries" rows="4" required
                  placeholder="Outline upstream and downstream value chain boundaries..."
                  class="w-full px-4 py-3.5 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 outline-none transition-all shadow-sm resize-none"></textarea>
                <div class="absolute bottom-3 right-3">
                  <span class="text-xs text-gray-400">0/500</span>
                </div>
              </div>
            </div>

            <div class="space-y-3">
              <label class="block text-sm font-semibold text-gray-800">Board Role in Sustainability <span class="text-red-500">*</span></label>
              <div class="relative">
                <textarea name="boardRoleInSustainability" rows="4" required
                  placeholder="Detail the board's expertise and oversight of sustainability matters..."
                  class="w-full px-4 py-3.5 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 outline-none transition-all shadow-sm resize-none"></textarea>
                <div class="absolute bottom-3 right-3">
                  <span class="text-xs text-gray-400">0/500</span>
                </div>
              </div>
            </div>

            <div class="space-y-3">
              <label class="block text-sm font-semibold text-gray-800">Assessment Process <span class="text-red-500">*</span></label>
              <div class="relative">
                <textarea name="assessmentProcess" rows="4" required
                  placeholder="Explain the process for identifying impacts, risks, and opportunities..."
                  class="w-full px-4 py-3.5 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 outline-none transition-all shadow-sm resize-none"></textarea>
                <div class="absolute bottom-3 right-3">
                  <span class="text-xs text-gray-400">0/500</span>
                </div>
              </div>
            </div>
          </div>

          <!-- Form Actions -->
          <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-100">
            <button type="button"
              class="flex-1 px-6 py-3.5 bg-white border-2 border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-all duration-200 flex items-center justify-center gap-2">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4">
                </path>
              </svg>
              Save as Draft
            </button>
            <button type="submit"
              class="flex-1 px-6 py-3.5 bg-gradient-to-r from-teal-600 to-emerald-600 text-white font-semibold rounded-xl hover:from-teal-700 hover:to-emerald-700 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              Finalize Disclosure
            </button>
          </div>
        </form>
      </div>

      <!-- ✅ FIXED: Environmental Topics Form with Status Field -->
      <div class="bg-gradient-to-br from-white to-gray-50 shadow-2xl rounded-2xl p-8 border border-gray-100">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
          <div>
            <h3 class="text-2xl font-bold text-gray-900 mb-3">Environmental Topics (ESRS E1-E5)</h3>
            <div class="flex flex-wrap gap-3">
              <div class="flex items-center gap-2">
                <div class="w-2 h-2 bg-amber-500 rounded-full animate-pulse"></div>
                <span class="text-sm font-medium text-gray-700">Environmental Data Entry</span>
              </div>
            </div>
          </div>
        </div>

        <form id="environmentalTopicsForm" class="space-y-8">
          
          <!-- ✅ NEW: Status Field -->
          <div class="mb-6 p-5 bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl border border-gray-200">
            <label class="block text-sm font-semibold text-gray-800 mb-3 flex items-center gap-2">
              <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              Report Status <span class="text-red-500">*</span>
            </label>
            <div class="relative">
              <select name="status" required
                class="w-full px-4 py-3.5 bg-white border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 outline-none transition-all appearance-none shadow-sm">
                <option value="">Select Status</option>
                <option value="DRAFT" selected>Draft</option>
                <option value="UNDER_REVIEW">Under Review</option>
                <option value="APPROVED">Approved</option>
                <option value="PUBLISHED">Published</option>
                <option value="REJECTED">Rejected</option>
              </select>
              <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
              </div>
            </div>
            <p class="text-xs text-gray-500 mt-2">Set the current workflow status of this environmental report</p>
          </div>

          <!-- Accordion Items -->
          <div class="space-y-4">

            <!-- E1 - Climate Change -->
            <div
              class="accordion-item bg-white border border-gray-200 rounded-2xl overflow-hidden transition-all duration-300 hover:border-teal-300 hover:shadow-lg">
              <input type="checkbox" id="e1-accordion" class="hidden peer" checked>

              <label for="e1-accordion"
                class="flex items-center justify-between px-6 py-5 cursor-pointer bg-gradient-to-r from-teal-50 to-white peer-checked:from-teal-100 transition-all duration-300">
                <div class="flex items-center gap-4">
                  <div
                    class="w-10 h-10 rounded-xl bg-gradient-to-br from-teal-500 to-emerald-600 flex items-center justify-center shadow-md">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                  </div>
                  <div>
                    <h4 class="text-lg font-bold text-gray-900">E1 – Climate Change</h4>
                    <p class="text-sm text-gray-600 mt-1">Greenhouse gas emissions & climate strategy</p>
                  </div>
                </div>

                <div class="flex items-center gap-3">
                  <span
                    class="px-3 py-1 bg-gradient-to-r from-teal-100 to-emerald-100 text-teal-800 text-xs font-semibold rounded-full">Calculation
                    Linked</span>
                  <svg class="w-5 h-5 text-gray-400 transition-transform duration-300 peer-checked:rotate-180"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                  </svg>
                </div>
              </label>

              <div
                class="accordion-content px-6 overflow-hidden transition-all duration-500 max-h-0 peer-checked:max-h-[1000px] peer-checked:pb-6">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8 mt-4">
                  <div
                    class="bg-gradient-to-br from-teal-50 to-teal-100 border border-teal-200 p-5 rounded-2xl text-center">
                    <p class="text-sm font-semibold text-teal-800 mb-2">Scope 1</p>
                    <p class="text-2xl font-bold text-teal-900">1,240.5 <span class="text-sm font-normal">tCO₂e</span>
                    </p>
                    <div class="mt-2 text-xs text-teal-700">Direct emissions</div>
                  </div>
                  <div
                    class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 p-5 rounded-2xl text-center">
                    <p class="text-sm font-semibold text-blue-800 mb-2">Scope 2</p>
                    <p class="text-2xl font-bold text-blue-900">850.2 <span class="text-sm font-normal">tCO₂e</span>
                    </p>
                    <div class="mt-2 text-xs text-blue-700">Indirect energy</div>
                  </div>
                  <div
                    class="bg-gradient-to-br from-emerald-50 to-emerald-100 border border-emerald-200 p-5 rounded-2xl text-center">
                    <p class="text-sm font-semibold text-emerald-800 mb-2">Total GHG</p>
                    <p class="text-2xl font-bold text-emerald-900">2,090.7 <span
                        class="text-sm font-normal">tCO₂e</span></p>
                    <div class="mt-2 text-xs text-emerald-700">Carbon footprint</div>
                  </div>
                </div>

                <div class="space-y-6">
                  <div
                    class="flex items-center gap-3 p-4 bg-gradient-to-r from-teal-50 to-emerald-50 rounded-xl border border-teal-200">
                    <input type="checkbox" id="e1_material" name="e1_material"
                      class="w-5 h-5 text-teal-600 rounded-lg border-gray-300 focus:ring-2 focus:ring-teal-500/50">
                    <label for="e1_material" class="text-sm font-semibold text-teal-900">Is Climate Change a material
                      topic for this company?</label>
                  </div>

                  <div class="space-y-3">
                    <label class="block text-sm font-semibold text-gray-800">Climate Policy</label>
                    <textarea name="e1_climatePolicy" rows="3"
                      class="w-full px-4 py-3.5 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 outline-none transition-all shadow-sm resize-none"
                      placeholder="Describe the policy to mitigate climate change..."></textarea>
                  </div>

                  <div class="space-y-3">
                    <label class="block text-sm font-semibold text-gray-800">GHG Reduction Target</label>
                    <input type="text" name="e1_reductionTarget"
                      class="w-full px-4 py-3.5 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500/30 focus:border-teal-500 outline-none transition-all shadow-sm"
                      placeholder="e.g. 50% reduction by 2030">
                  </div>
                </div>
              </div>
            </div>

            <!-- E2 - Pollution -->
            <div
              class="accordion-item bg-white border border-gray-200 rounded-2xl overflow-hidden transition-all duration-300 hover:border-blue-300 hover:shadow-lg">
              <input type="checkbox" id="e2-accordion" class="hidden peer">
              <label for="e2-accordion"
                class="flex items-center justify-between px-6 py-5 cursor-pointer bg-gradient-to-r from-blue-50 to-white peer-checked:from-blue-100 transition-all duration-300">
                <div class="flex items-center gap-4">
                  <div
                    class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-cyan-600 flex items-center justify-center shadow-md">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z">
                      </path>
                    </svg>
                  </div>
                  <div>
                    <h4 class="text-lg font-bold text-gray-900">E2 – Pollution</h4>
                    <p class="text-sm text-gray-600 mt-1">NOx, SOx, and other pollutant emissions</p>
                  </div>
                </div>
                <div class="flex items-center gap-2">
                  <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded-full">NOx, SOx</span>
                  <svg class="w-5 h-5 text-gray-400 transition-transform duration-300 peer-checked:rotate-180"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                  </svg>
                </div>
              </label>

              <div
                class="accordion-content px-6 max-h-0 overflow-hidden transition-all duration-300 peer-checked:max-h-[300px] peer-checked:pb-6">
                <div class="grid md:grid-cols-2 gap-6 pt-4">
                  <div class="space-y-3">
                    <label class="block text-sm font-semibold text-gray-800">NOx Emissions</label>
                    <div class="relative">
                      <input type="number" step="0.01" name="e2_nox_t_per_year" placeholder="0.00"
                        class="w-full px-4 py-3.5 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 outline-none transition-all shadow-sm">
                      <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                        <span class="text-gray-500">t/year</span>
                      </div>
                    </div>
                  </div>
                  <div class="space-y-3">
                    <label class="block text-sm font-semibold text-gray-800">SOx Emissions</label>
                    <div class="relative">
                      <input type="number" step="0.01" name="e2_sox_t_per_year" placeholder="0.00"
                        class="w-full px-4 py-3.5 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 outline-none transition-all shadow-sm">
                      <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                        <span class="text-gray-500">t/year</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- E3 - Water & Marine Resources -->
            <div
              class="accordion-item bg-white border border-gray-200 rounded-2xl overflow-hidden transition-all duration-300 hover:border-cyan-300 hover:shadow-lg">
              <input type="checkbox" id="e3-accordion" class="hidden peer">
              <label for="e3-accordion"
                class="flex items-center justify-between px-6 py-5 cursor-pointer bg-gradient-to-r from-cyan-50 to-white peer-checked:from-cyan-100 transition-all duration-300">
                <div class="flex items-center gap-4">
                  <div
                    class="w-10 h-10 rounded-xl bg-gradient-to-br from-cyan-500 to-blue-600 flex items-center justify-center shadow-md">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                      </path>
                    </svg>
                  </div>
                  <div>
                    <h4 class="text-lg font-bold text-gray-900">E3 – Water & Marine Resources</h4>
                    <p class="text-sm text-gray-600 mt-1">Water usage, recycling, and marine impact</p>
                  </div>
                </div>
                <svg class="w-5 h-5 text-gray-400 transition-transform duration-300 peer-checked:rotate-180"
                  fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
              </label>

              <div
                class="accordion-content px-6 max-h-0 overflow-hidden transition-all duration-300 peer-checked:max-h-[300px] peer-checked:pb-6">
                <div class="grid md:grid-cols-2 gap-6 pt-4">
                  <div class="space-y-3">
                    <label class="block text-sm font-semibold text-gray-800">Total Water Withdrawal</label>
                    <div class="relative">
                      <input type="number" step="0.1" name="e3_water_withdrawal_m3" placeholder="0.0"
                        class="w-full px-4 py-3.5 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-cyan-500/30 focus:border-cyan-500 outline-none transition-all shadow-sm">
                      <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                        <span class="text-gray-500">m³</span>
                      </div>
                    </div>
                  </div>
                  <div class="space-y-3">
                    <label class="block text-sm font-semibold text-gray-800">Water Recycling Rate</label>
                    <div class="relative">
                      <input type="number" step="0.1" name="e3_water_recycling_rate_pct" min="0" max="100" placeholder="0.0"
                        class="w-full px-4 py-3.5 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-cyan-500/30 focus:border-cyan-500 outline-none transition-all shadow-sm pr-12">
                      <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                        <span class="text-gray-500">%</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- E4 - Biodiversity -->
            <div
              class="accordion-item bg-white border border-gray-200 rounded-2xl overflow-hidden transition-all duration-300 hover:border-emerald-300 hover:shadow-lg">
              <input type="checkbox" id="e4-accordion" class="hidden peer">
              <label for="e4-accordion"
                class="flex items-center justify-between px-6 py-5 cursor-pointer bg-gradient-to-r from-emerald-50 to-white peer-checked:from-emerald-100 transition-all duration-300">
                <div class="flex items-center gap-4">
                  <div
                    class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-green-600 flex items-center justify-center shadow-md">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z">
                      </path>
                    </svg>
                  </div>
                  <div>
                    <h4 class="text-lg font-bold text-gray-900">E4 – Biodiversity</h4>
                    <p class="text-sm text-gray-600 mt-1">Impact on ecosystems and protected areas</p>
                  </div>
                </div>
                <svg class="w-5 h-5 text-gray-400 transition-transform duration-300 peer-checked:rotate-180"
                  fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
              </label>

              <div
                class="accordion-content px-6 max-h-0 overflow-hidden transition-all duration-300 peer-checked:max-h-[300px] peer-checked:pb-6">
                <div class="pt-4 space-y-3">
                  <label class="block text-sm font-semibold text-gray-800">Impact on Protected Areas</label>
                  <textarea name="e4_protected_areas_impact" rows="4"
                    class="w-full px-4 py-3.5 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 outline-none transition-all shadow-sm resize-none"
                    placeholder="Provide narrative disclosure of impacts..."></textarea>
                </div>
              </div>
            </div>

            <!-- E5 - Circular Economy -->
            <div
              class="accordion-item bg-white border border-gray-200 rounded-2xl overflow-hidden transition-all duration-300 hover:border-amber-300 hover:shadow-lg">
              <input type="checkbox" id="e5-accordion" class="hidden peer">
              <label for="e5-accordion"
                class="flex items-center justify-between px-6 py-5 cursor-pointer bg-gradient-to-r from-amber-50 to-white peer-checked:from-amber-100 transition-all duration-300">
                <div class="flex items-center gap-4">
                  <div
                    class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center shadow-md">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                      </path>
                    </svg>
                  </div>
                  <div>
                    <h4 class="text-lg font-bold text-gray-900">E5 – Circular Economy</h4>
                    <p class="text-sm text-gray-600 mt-1">Waste management and resource efficiency</p>
                  </div>
                </div>
                <svg class="w-5 h-5 text-gray-400 transition-transform duration-300 peer-checked:rotate-180"
                  fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
              </label>

              <div
                class="accordion-content px-6 max-h-0 overflow-hidden transition-all duration-300 peer-checked:max-h-[300px] peer-checked:pb-6">
                <div class="grid md:grid-cols-2 gap-6 pt-4">
                  <div class="space-y-3">
                    <label class="block text-sm font-semibold text-gray-800">Waste Recycling Rate</label>
                    <div class="relative">
                      <input type="number" step="0.1" name="e5_recycling_rate_pct" min="0" max="100" placeholder="0.0"
                        class="w-full px-4 py-3.5 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500/30 focus:border-amber-500 outline-none transition-all shadow-sm pr-12">
                      <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                        <span class="text-gray-500">%</span>
                      </div>
                    </div>
                  </div>
                  <div class="space-y-3">
                    <label class="block text-sm font-semibold text-gray-800">Recycled Input Materials</label>
                    <div class="relative">
                      <input type="number" step="0.1" name="e5_recycled_input_materials_pct" min="0" max="100" placeholder="0.0"
                        class="w-full px-4 py-3.5 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500/30 focus:border-amber-500 outline-none transition-all shadow-sm pr-12">
                      <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                        <span class="text-gray-500">%</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Form Actions -->
          <div class="flex gap-3 pt-6 border-t border-gray-100">
            <button type="button"
              class="flex-1 px-5 py-2.5 bg-white border-2 border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-all duration-200 flex items-center justify-center gap-2">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              Save Progress
            </button>
            <button type="submit"
              class="flex-1 px-5 py-2.5 bg-gradient-to-r from-teal-600 to-emerald-600 text-white font-medium rounded-xl hover:from-teal-700 hover:to-emerald-700 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              Submit Report
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Right Column - Progress & Summary -->
    <div class="lg:col-span-1 space-y-8">

      <!-- Progress Tracker -->
      <div class="bg-gradient-to-br from-white to-gray-50 shadow-2xl rounded-2xl p-6 border border-gray-100">
        <h4 class="text-lg font-bold text-gray-900 mb-6">Reporting Progress</h4>
        <div class="space-y-6">
          <div>
            <div class="flex justify-between text-sm font-medium text-gray-700 mb-2">
              <span>ESRS 2 - General Disclosures</span>
              <span class="text-teal-600">85%</span>
            </div>
            <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
              <div class="h-full bg-gradient-to-r from-teal-500 to-emerald-600 rounded-full" style="width: 85%">
              </div>
            </div>
          </div>

          <div>
            <div class="flex justify-between text-sm font-medium text-gray-700 mb-2">
              <span>E1 - Climate Change</span>
              <span class="text-teal-600">100%</span>
            </div>
            <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
              <div class="h-full bg-gradient-to-r from-teal-500 to-emerald-600 rounded-full" style="width: 100%">
              </div>
            </div>
          </div>

          <div>
            <div class="flex justify-between text-sm font-medium text-gray-700 mb-2">
              <span>E2 - Pollution</span>
              <span class="text-blue-600">60%</span>
            </div>
            <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
              <div class="h-full bg-gradient-to-r from-blue-500 to-cyan-600 rounded-full" style="width: 60%"></div>
            </div>
          </div>

          <div>
            <div class="flex justify-between text-sm font-medium text-gray-700 mb-2">
              <span>E3 - Water Resources</span>
              <span class="text-cyan-600">40%</span>
            </div>
            <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
              <div class="h-full bg-gradient-to-r from-cyan-500 to-blue-600 rounded-full" style="width: 40%"></div>
            </div>
          </div>

          <div>
            <div class="flex justify-between text-sm font-medium text-gray-700 mb-2">
              <span>E4 - Biodiversity</span>
              <span class="text-emerald-600">25%</span>
            </div>
            <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
              <div class="h-full bg-gradient-to-r from-emerald-500 to-green-600 rounded-full" style="width: 25%">
              </div>
            </div>
          </div>

          <div>
            <div class="flex justify-between text-sm font-medium text-gray-700 mb-2">
              <span>E5 - Circular Economy</span>
              <span class="text-amber-600">50%</span>
            </div>
            <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
              <div class="h-full bg-gradient-to-r from-amber-500 to-orange-600 rounded-full" style="width: 50%">
              </div>
            </div>
          </div>
        </div>

        <div class="mt-8 pt-6 border-t border-gray-100">
          <div class="text-center">
            <p class="text-3xl font-bold text-gray-900">65%</p>
            <p class="text-sm text-gray-600">Overall Completion</p>
          </div>
        </div>
      </div>

      <!-- Next Steps -->
      <div class="bg-gradient-to-br from-white to-blue-50 shadow-2xl rounded-2xl p-6 border border-blue-100">
        <h4 class="text-lg font-bold text-gray-900 mb-6">Next Steps</h4>
        <div class="space-y-4">
          <div class="flex items-start gap-3">
            <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center flex-shrink-0">
              <span class="text-blue-600 font-bold text-sm">1</span>
            </div>
            <div>
              <p class="text-sm font-medium text-gray-800">Complete E2 Pollution data</p>
              <p class="text-xs text-gray-600 mt-1">Required: NOx and SOx emissions</p>
            </div>
          </div>

          <div class="flex items-start gap-3">
            <div class="w-8 h-8 rounded-lg bg-cyan-100 flex items-center justify-center flex-shrink-0">
              <span class="text-cyan-600 font-bold text-sm">2</span>
            </div>
            <div>
              <p class="text-sm font-medium text-gray-800">Finalize water usage metrics</p>
              <p class="text-xs text-gray-600 mt-1">Water withdrawal and recycling rates</p>
            </div>
          </div>

          <div class="flex items-start gap-3">
            <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center flex-shrink-0">
              <span class="text-emerald-600 font-bold text-sm">3</span>
            </div>
            <div>
              <p class="text-sm font-medium text-gray-800">Review board oversight statement</p>
              <p class="text-xs text-gray-600 mt-1">ESRS 2 - General Disclosures</p>
            </div>
          </div>
        </div>

        <div class="mt-8 pt-6 border-t border-blue-100">
          <button
            class="w-full px-4 py-3 bg-gradient-to-r from-blue-600 to-cyan-600 text-white font-medium rounded-xl hover:from-blue-700 hover:to-cyan-700 transition-all duration-200 shadow-md hover:shadow-lg">
            Generate Compliance Report
          </button>
        </div>
      </div>

      <!-- Deadline Widget -->
      <div class="bg-gradient-to-br from-white to-amber-50 shadow-2xl rounded-2xl p-6 border border-amber-100">
        <div class="flex items-center gap-3 mb-4">
          <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center">
            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
          <div>
            <h4 class="font-bold text-gray-900">Reporting Deadline</h4>
            <p class="text-sm text-gray-600">ESRS Compliance Submission</p>
          </div>
        </div>

        <div class="bg-gradient-to-r from-amber-100 to-orange-100 p-4 rounded-xl border border-amber-200">
          <div class="text-center">
            <p class="text-2xl font-bold text-amber-900">March 31, 2025</p>
            <p class="text-sm text-amber-700 mt-1">FY 2025 Reporting Deadline</p>
          </div>
          <div class="mt-4 text-center">
            <p class="text-3xl font-bold text-gray-900">64</p>
            <p class="text-sm text-gray-600">Days Remaining</p>
          </div>
        </div>

        <div class="mt-6 pt-6 border-t border-amber-100">
          <div class="flex justify-between text-sm">
            <span class="text-gray-600">Last submission:</span>
            <span class="font-medium text-gray-900">Dec 15, 2024</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
