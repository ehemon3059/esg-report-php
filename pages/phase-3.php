<?php
session_start();
require_once '../includes/auth.php';
require_once '../config/database.php';
requireLogin();

$companyId = getCurrentCompanyId();

// Get sites for dropdown
$stmt = $pdo->prepare("SELECT id, name FROM sites WHERE company_id = ?");
$stmt->execute([$companyId]);
$sites = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get emission factors
$stmt = $pdo->query("SELECT * FROM emission_factors WHERE is_active = 1");
$factors = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- ================================================ -->
<!-- PHASE 3 – FIXED VERSION WITH DATABASE ALIGNMENT -->
<!-- ================================================ -->

<section id="phase-3" class="mb-20 scroll-mt-20">
  <!-- Phase Header -->
  <div class="mb-10">


    <div class="inline-flex items-center gap-4 mb-4">
      <div class="relative">
        <div
          class="w-10 h-10 rounded-xl bg-gradient-to-br from-teal-500 to-emerald-600 flex items-center justify-center shadow-lg">
          <span class="text-white font-bold text-lg">3</span>
        </div>
      <div class="absolute -inset-2 bg-gradient-to-r from-teal-500/20 to-emerald-600/20 blur-xl rounded-full">
        </div>
      </div>
      <div>
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Emissions Data Collection</h2>
        <p class="text-gray-600 mt-2">Input your emission factors and activity data to calculate your carbon footprint</p>
      </div>
    </div>


  </div>

  <!-- ✅ NEW: Global Company Selection -->
  <div class="bg-gradient-to-br from-indigo-50 to-purple-50 shadow-lg rounded-2xl p-6 mb-8 border border-indigo-200">
    <div class="flex items-center gap-3 mb-4">
      <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
      </svg>
      <h3 class="text-lg font-bold text-gray-900">Context Selection</h3>
      <span class="ml-auto text-xs font-medium text-indigo-700 bg-indigo-100 px-3 py-1 rounded-full">Required for all entries</span>
    </div>
    
    <div class="grid md:grid-cols-2 gap-4">
      <div class="space-y-2">
        <label class="block text-sm font-semibold text-gray-700 flex items-center gap-1">
          Company <span class="text-red-500">*</span>
        </label>
        <div class="relative">
          <select id="globalCompanyId" name="companyId" required
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
        <div class="relative">
          <input type="month" id="globalReportingPeriod" name="reportingPeriod" required
            class="w-full px-4 py-3.5 bg-white border-2 border-indigo-200 rounded-xl focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 outline-none transition-all shadow-sm">
          <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="grid gap-8">

    <!-- ✅ FIXED: Emission Factors Library with proper field names -->
    <div class="bg-gradient-to-br from-white to-gray-50 shadow-xl rounded-2xl p-6 md:p-8 border border-gray-100">
      <div class="flex items-center justify-between mb-8">
        <div>
          <h3 class="text-xl font-bold text-gray-900 mb-2">Emission Factors Library</h3>
          <p class="text-gray-600 text-sm">Manage your master emission factors database</p>
        </div>
        <div class="bg-emerald-50 text-emerald-800 text-xs font-medium px-3 py-1.5 rounded-full">
          Master Data
        </div>
      </div>

      <form id="emissionFactorForm" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="space-y-2">
          <label class="block text-sm font-semibold text-gray-700 flex items-center gap-1">
            Scope <span class="text-red-500">*</span>
          </label>
          <div class="relative">
            <select name="scope" required
              class="w-full px-4 py-3.5 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 outline-none transition-all appearance-none shadow-sm">
              <option value="">Select Scope</option>
              <option value="Scope 1">Scope 1</option>
              <option value="Scope 2 Location-Based">Scope 2 Location-Based</option>
              <option value="Scope 2 Market-Based">Scope 2 Market-Based</option>
              <option value="Scope 3">Scope 3</option>
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
            Activity Type <span class="text-red-500">*</span>
          </label>
          <input type="text" name="activityType" required placeholder="e.g., Natural Gas, Purchased Electricity"
            class="w-full px-4 py-3.5 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 outline-none transition-all shadow-sm">
        </div>

        <div class="space-y-2">
          <label class="block text-sm font-semibold text-gray-700 flex items-center gap-1">
            Region <span class="text-red-500">*</span>
          </label>
          <input type="text" name="region" required placeholder="Germany, EU Grid, etc."
            class="w-full px-4 py-3.5 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 outline-none transition-all shadow-sm">
        </div>

        <div class="space-y-2">
          <label class="block text-sm font-semibold text-gray-700 flex items-center gap-1">
            Emission Factor Value <span class="text-red-500">*</span>
          </label>
          <div class="flex gap-2">
            <input type="number" name="factor" step="0.0001" required placeholder="0.0000"
              class="flex-1 px-4 py-3.5 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 outline-none transition-all shadow-sm">
            <select name="unit" required
              class="px-4 py-3.5 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 outline-none transition-all">
              <option value="kg CO2e / kWh">kg CO2e / kWh</option>
              <option value="kg CO2e / m³">kg CO2e / m³</option>
              <option value="kg CO2e / km">kg CO2e / km</option>
              <option value="kg CO2e / kg">kg CO2e / kg</option>
              <option value="kg CO2e / liter">kg CO2e / liter</option>
            </select>
          </div>
        </div>

        <!-- ✅ NEW: Version field (required by schema) -->
        <div class="space-y-2">
          <label class="block text-sm font-semibold text-gray-700 flex items-center gap-1">
            Version <span class="text-red-500">*</span>
          </label>
          <input type="text" name="version" required placeholder="e.g., 2024, v1.0"
            class="w-full px-4 py-3.5 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 outline-none transition-all shadow-sm">
          <p class="text-xs text-gray-500">Version identifier for this emission factor</p>
        </div>

        <div class="space-y-2">
          <label class="block text-sm font-semibold text-gray-700">Source</label>
          <div class="relative">
            <select name="source"
              class="w-full px-4 py-3.5 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 outline-none transition-all appearance-none shadow-sm">
              <option value="">Select Source</option>
              <option value="DEFRA">DEFRA</option>
              <option value="IEA">IEA</option>
              <option value="EPA">EPA</option>
              <option value="Custom">Custom</option>
            </select>
            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
              <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
              </svg>
            </div>
          </div>
        </div>

        <div class="space-y-2">
          <label class="block text-sm font-semibold text-gray-700">Valid From</label>
          <div class="relative">
            <input type="date" name="validFrom"
              class="w-full px-4 py-3.5 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 outline-none transition-all shadow-sm">
          </div>
        </div>

        <!-- ✅ NEW: Valid Until field (schema field) -->
        <div class="space-y-2">
          <label class="block text-sm font-semibold text-gray-700">Valid Until</label>
          <div class="relative">
            <input type="date" name="validUntil"
              class="w-full px-4 py-3.5 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 outline-none transition-all shadow-sm">
          </div>
          <p class="text-xs text-gray-500">Leave empty if still active</p>
        </div>

        <!-- ✅ NEW: Is Active checkbox (schema field) -->
        <div class="space-y-2">
          <label class="block text-sm font-semibold text-gray-700">Status</label>
          <label class="flex items-center gap-3 px-4 py-3.5 bg-white border border-gray-300 rounded-xl cursor-pointer hover:bg-gray-50 transition-all">
            <input type="checkbox" name="isActive" value="true" checked
              class="w-5 h-5 text-emerald-600 border-gray-300 rounded focus:ring-2 focus:ring-emerald-500/30">
            <span class="text-sm font-medium text-gray-700">Active Factor</span>
          </label>
          <p class="text-xs text-gray-500">Uncheck to deactivate this factor</p>
        </div>

        <div class="md:col-span-2 lg:col-span-3 flex justify-end gap-4 pt-6 border-t border-gray-100">
          <button type="button"
            class="px-6 py-3.5 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 transition-all duration-200">
            Cancel
          </button>
          <button type="submit"
            class="px-6 py-3.5 bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-medium rounded-xl hover:from-emerald-700 hover:to-teal-700 transition-all duration-200 shadow-md hover:shadow-lg">
            Save Emission Factor
          </button>
        </div>
      </form>
    </div>

    <!-- ✅ FIXED: Energy & Fuel Consumption Cards -->
    <div class="grid md:grid-cols-2 gap-8">
      
      <!-- ✅ FIXED: Energy Consumption Card with proper field names -->
      <div class="bg-gradient-to-br from-white to-blue-50 shadow-xl rounded-2xl p-6 md:p-8 border border-blue-100">
        <div class="flex items-center gap-3 mb-8">
          <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
          </div>
          <div>
            <h3 class="text-xl font-bold text-gray-900">Energy Consumption</h3>
            <p class="text-gray-600 text-sm">Scope 2 emissions calculation</p>
          </div>
        </div>

        <form id="energyActivityForm" class="space-y-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- ✅ FIXED: Site selector with proper name -->
            <div class="space-y-2">
              <label class="block text-sm font-semibold text-gray-700 flex items-center gap-1">
                Site <span class="text-red-500">*</span>
              </label>
              <div class="relative">
                <select name="siteId" required
                  class="w-full px-4 py-3.5 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 outline-none transition-all appearance-none shadow-sm">
                  <option value="">Select Site</option>
                  <!-- Populated dynamically based on selected company -->
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                  <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                  </svg>
                </div>
              </div>
            </div>

            <!-- ✅ FIXED: Date field with proper name -->
            <div class="space-y-2">
              <label class="block text-sm font-semibold text-gray-700 flex items-center gap-1">
                Date <span class="text-red-500">*</span>
              </label>
              <div class="relative">
                <input type="date" name="date" required
                  class="w-full px-4 py-3.5 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 outline-none transition-all shadow-sm">
              </div>
              <p class="text-xs text-gray-500">Activity date (not month)</p>
            </div>

            <!-- ✅ FIXED: Energy Type with proper name -->
            <div class="space-y-2">
              <label class="block text-sm font-semibold text-gray-700 flex items-center gap-1">
                Energy Type <span class="text-red-500">*</span>
              </label>
              <div class="relative">
                <select name="energyType" required
                  class="w-full px-4 py-3.5 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 outline-none transition-all appearance-none shadow-sm">
                  <option value="">Select Energy Type</option>
                  <option value="Purchased Electricity">Purchased Electricity</option>
                  <option value="District Heating">District Heating</option>
                  <option value="Steam">Steam</option>
                  <option value="Cooling">Cooling</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                  <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                  </svg>
                </div>
              </div>
            </div>

            <!-- ✅ FIXED: Unit with proper name -->
            <div class="space-y-2">
              <label class="block text-sm font-semibold text-gray-700 flex items-center gap-1">
                Unit <span class="text-red-500">*</span>
              </label>
              <div class="relative">
                <select name="unit" required
                  class="w-full px-4 py-3.5 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 outline-none transition-all appearance-none shadow-sm">
                  <option value="">Select Unit</option>
                  <option value="kWh">kWh</option>
                  <option value="MWh">MWh</option>
                  <option value="GJ">GJ</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                  <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                  </svg>
                </div>
              </div>
            </div>
          </div>

          <!-- ✅ FIXED: Consumption with proper name -->
          <div class="space-y-2">
            <label class="block text-sm font-semibold text-gray-700 flex items-center gap-1">
              Consumption <span class="text-red-500">*</span>
            </label>
            <div class="relative">
              <input type="number" name="consumption" step="0.01" required placeholder="0.00"
                class="w-full px-4 py-3.5 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 outline-none transition-all shadow-sm">
            </div>
          </div>

          <button type="submit"
            class="w-full md:w-auto px-8 py-3.5 bg-gradient-to-r from-blue-600 to-cyan-600 text-white font-medium rounded-xl hover:from-blue-700 hover:to-cyan-700 transition-all duration-200 shadow-md hover:shadow-lg">
            Calculate Energy Emissions
          </button>
        </form>
      </div>

      <!-- ✅ FIXED: Fuel Consumption Card with proper field names -->
      <div class="bg-gradient-to-br from-white to-amber-50 shadow-xl rounded-2xl p-6 md:p-8 border border-amber-100">
        <div class="flex items-center gap-3 mb-8">
          <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center">
            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z">
              </path>
            </svg>
          </div>
          <div>
            <h3 class="text-xl font-bold text-gray-900">Fuel Consumption</h3>
            <p class="text-gray-600 text-sm">Scope 1 emissions calculation</p>
          </div>
        </div>

        <form id="fuelActivityForm" class="space-y-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- ✅ NEW: Site selector (was missing!) -->
            <div class="space-y-2">
              <label class="block text-sm font-semibold text-gray-700 flex items-center gap-1">
                Site <span class="text-red-500">*</span>
              </label>
              <div class="relative">
                <select name="siteId" required
                  class="w-full px-4 py-3.5 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500/30 focus:border-amber-500 outline-none transition-all appearance-none shadow-sm">
                  <option value="">Select Site</option>
                  <!-- Populated dynamically based on selected company -->
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                  <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                  </svg>
                </div>
              </div>
            </div>

            <!-- ✅ FIXED: Date with proper name -->
            <div class="space-y-2">
              <label class="block text-sm font-semibold text-gray-700 flex items-center gap-1">
                Date <span class="text-red-500">*</span>
              </label>
              <div class="relative">
                <input type="date" name="date" required
                  class="w-full px-4 py-3.5 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500/30 focus:border-amber-500 outline-none transition-all shadow-sm">
              </div>
            </div>

            <!-- ✅ FIXED: Fuel Type with proper name -->
            <div class="space-y-2">
              <label class="block text-sm font-semibold text-gray-700 flex items-center gap-1">
                Fuel Type <span class="text-red-500">*</span>
              </label>
              <div class="relative">
                <select name="fuelType" required
                  class="w-full px-4 py-3.5 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500/30 focus:border-amber-500 outline-none transition-all appearance-none shadow-sm">
                  <option value="">Select Fuel Type</option>
                  <option value="Natural Gas">Natural Gas</option>
                  <option value="Diesel">Diesel</option>
                  <option value="Petrol">Petrol</option>
                  <option value="LPG">LPG</option>
                  <option value="Coal">Coal</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                  <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                  </svg>
                </div>
              </div>
            </div>

            <!-- ✅ FIXED: Unit with proper name -->
            <div class="space-y-2">
              <label class="block text-sm font-semibold text-gray-700 flex items-center gap-1">
                Unit <span class="text-red-500">*</span>
              </label>
              <div class="relative">
                <select name="unit" required
                  class="w-full px-4 py-3.5 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500/30 focus:border-amber-500 outline-none transition-all appearance-none shadow-sm">
                  <option value="">Select Unit</option>
                  <option value="m³">m³</option>
                  <option value="liters">Liters</option>
                  <option value="kg">kg</option>
                  <option value="tonnes">tonnes</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                  <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                  </svg>
                </div>
              </div>
            </div>

            <!-- ✅ FIXED: Volume with proper name -->
            <div class="md:col-span-2 space-y-2">
              <label class="block text-sm font-semibold text-gray-700 flex items-center gap-1">
                Volume <span class="text-red-500">*</span>
              </label>
              <input type="number" name="volume" step="0.01" required placeholder="0.00"
                class="w-full px-4 py-3.5 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500/30 focus:border-amber-500 outline-none transition-all shadow-sm">
            </div>
          </div>

          <button type="submit"
            class="w-full md:w-auto px-8 py-3.5 bg-gradient-to-r from-amber-600 to-orange-600 text-white font-medium rounded-xl hover:from-amber-700 hover:to-orange-700 transition-all duration-200 shadow-md hover:shadow-lg">
            Calculate Fuel Emissions
          </button>
        </form>
      </div>
    </div>

    <!-- Emissions Summary Dashboard (Display Only - No Changes Needed) -->
    <div class="bg-gradient-to-br from-white to-gray-50 shadow-xl rounded-2xl p-6 md:p-8 border border-gray-100">
      <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
          <h3 class="text-xl font-bold text-gray-900 mb-2">Emissions Dashboard</h3>
          <p class="text-gray-600 text-sm">Real-time overview of calculated emissions</p>
        </div>
        <div class="flex gap-3">
          <select
            class="px-4 py-2.5 bg-white border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 outline-none transition-all">
            <option>Last 30 Days</option>
            <option>Last Quarter</option>
            <option>Year to Date</option>
            <option>Full Year</option>
          </select>
          <button
            class="px-4 py-2.5 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 transition-all duration-200 text-sm flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
              </path>
            </svg>
            Export Report
          </button>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 border border-emerald-200 p-6 rounded-2xl">
          <div class="flex items-center justify-between mb-4">
            <div class="w-10 h-10 rounded-xl bg-emerald-500/20 flex items-center justify-center">
              <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                </path>
              </svg>
            </div>
            <span class="text-xs font-medium text-emerald-700 bg-emerald-200 px-2.5 py-1 rounded-full">Scope 1</span>
          </div>
          <p class="text-sm font-medium text-emerald-800 mb-1">Direct Emissions</p>
          <h4 class="text-2xl font-bold text-emerald-900">1,240.50 <span
              class="text-sm font-normal text-emerald-700">tCO₂e</span></h4>
          <div class="mt-3 pt-3 border-t border-emerald-200">
            <p class="text-xs text-emerald-600">↑ 12.5% from last period</p>
          </div>
        </div>

        <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 p-6 rounded-2xl">
          <div class="flex items-center justify-between mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-500/20 flex items-center justify-center">
              <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z">
                </path>
              </svg>
            </div>
            <span class="text-xs font-medium text-blue-700 bg-blue-200 px-2.5 py-1 rounded-full">Scope 2</span>
          </div>
          <p class="text-sm font-medium text-blue-800 mb-1">Indirect Energy</p>
          <h4 class="text-2xl font-bold text-blue-900">850.25 <span
              class="text-sm font-normal text-blue-700">tCO₂e</span></h4>
          <div class="mt-3 pt-3 border-t border-blue-200">
            <p class="text-xs text-blue-600">↓ 3.2% from last period</p>
          </div>
        </div>

        <div class="bg-gradient-to-br from-gray-50 to-gray-100 border border-gray-200 p-6 rounded-2xl">
          <div class="flex items-center justify-between mb-4">
            <div class="w-10 h-10 rounded-xl bg-gray-500/20 flex items-center justify-center">
              <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                </path>
              </svg>
            </div>
            <span class="text-xs font-medium text-gray-700 bg-gray-200 px-2.5 py-1 rounded-full">Total</span>
          </div>
          <p class="text-sm font-medium text-gray-800 mb-1">Carbon Footprint</p>
          <h4 class="text-2xl font-bold text-gray-900">2,090.75 <span
              class="text-sm font-normal text-gray-700">tCO₂e</span></h4>
          <div class="mt-3 pt-3 border-t border-gray-200">
            <p class="text-xs text-gray-600">↑ 5.4% from last period</p>
          </div>
        </div>
      </div>

      <!-- Recent Calculations Table -->
      <div class="overflow-hidden border border-gray-200 rounded-2xl">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
          <h4 class="font-semibold text-gray-800">Recent Emission Calculations</h4>
        </div>
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Activity
                </th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Scope</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Input Data
                </th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                  Calculation Details</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Emissions
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
              <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-6 py-4">
                  <div class="font-medium text-gray-900">Natural Gas Heating</div>
                  <div class="text-xs text-gray-500">Facility A • Jan 2026</div>
                </td>
                <td class="px-6 py-4">
                  <span class="px-3 py-1 text-xs font-medium bg-emerald-100 text-emerald-800 rounded-full">Scope
                    1</span>
                </td>
                <td class="px-6 py-4">
                  <div class="text-sm font-medium text-gray-900">2,500.00 m³</div>
                  <div class="text-xs text-gray-500">Natural Gas</div>
                </td>
                <td class="px-6 py-4">
                  <div class="text-sm text-gray-900">2.02135 × 2,500</div>
                  <div class="text-xs text-gray-500">DEFRA 2024 • kg CO2e/m³</div>
                </td>
                <td class="px-6 py-4">
                  <div class="text-lg font-bold text-emerald-700">5.053 tCO₂e</div>
                  <div class="text-xs text-gray-500">Calculated on Jan 26, 2026</div>
                </td>
              </tr>
              <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-6 py-4">
                  <div class="font-medium text-gray-900">Electricity Usage</div>
                  <div class="text-xs text-gray-500">Main Office • Jan 2026</div>
                </td>
                <td class="px-6 py-4">
                  <span class="px-3 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">Scope 2</span>
                </td>
                <td class="px-6 py-4">
                  <div class="text-sm font-medium text-gray-900">12,450.00 kWh</div>
                  <div class="text-xs text-gray-500">Grid Electricity</div>
                </td>
                <td class="px-6 py-4">
                  <div class="text-sm text-gray-900">0.2071 × 12,450</div>
                  <div class="text-xs text-gray-500">IEA 2024 • kg CO2e/kWh</div>
                </td>
                <td class="px-6 py-4">
                  <div class="text-lg font-bold text-emerald-700">2.578 tCO₂e</div>
                  <div class="text-xs text-gray-500">Calculated on Jan 25, 2026</div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>
