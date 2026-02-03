<?php
session_start();
require_once 'config/database.php';
require_once 'includes/auth.php';
requireLogin();

$companyId = getCurrentCompanyId();
$reportingPeriod = $_GET['period'] ?? date('Y-m-01');

// Get company info
$stmt = $pdo->prepare("SELECT * FROM companies WHERE id = ?");
$stmt->execute([$companyId]);
$company = $stmt->fetch(PDO::FETCH_ASSOC);

// Get emissions
$stmt = $pdo->prepare("
    SELECT scope, SUM(tco2e_calculated) as total
    FROM emission_records
    WHERE company_id = ? AND DATE_FORMAT(date_calculated, '%Y-%m') = ?
    GROUP BY scope
");
$stmt->execute([$companyId, $reportingPeriod]);
$emissions = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

// Get environmental data
$stmt = $pdo->prepare("SELECT * FROM environmental_topics WHERE company_id = ? AND reporting_period = ?");
$stmt->execute([$companyId, $reportingPeriod]);
$environmental = $stmt->fetch(PDO::FETCH_ASSOC);

// Get social data
$stmt = $pdo->prepare("SELECT * FROM social_topics WHERE company_id = ? AND reporting_period = ?");
$stmt->execute([$companyId, $reportingPeriod]);
$social = $stmt->fetch(PDO::FETCH_ASSOC);

// Get governance
$stmt = $pdo->prepare("SELECT * FROM s_governance WHERE company_id = ? AND reporting_period = ?");
$stmt->execute([$companyId, $reportingPeriod]);
$governance = $stmt->fetch(PDO::FETCH_ASSOC);

// Get taxonomy
$stmt = $pdo->prepare("SELECT * FROM eu_taxonomy WHERE company_id = ? AND reporting_period = ?");
$stmt->execute([$companyId, $reportingPeriod]);
$taxonomy = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>ESG Report - <?= $company['name'] ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white">
    <div class="max-w-4xl mx-auto p-8">
        <!-- Report Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold mb-2"><?= $company['name'] ?></h1>
            <h2 class="text-2xl text-gray-600">ESG Sustainability Report</h2>
            <p class="text-gray-500 mt-2">Reporting Period: <?= date('F Y', strtotime($reportingPeriod)) ?></p>
        </div>

        <!-- Executive Summary -->
        <section class="mb-12">
            <h3 class="text-2xl font-bold border-b-2 border-emerald-500 pb-2 mb-4">Executive Summary</h3>
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-teal-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-600">Scope 1 Emissions</p>
                    <p class="text-3xl font-bold text-teal-900"><?= number_format($emissions['Scope 1'] ?? 0, 2) ?> tCO₂e</p>
                </div>
                <div class="bg-blue-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-600">Scope 2 Emissions</p>
                    <p class="text-3xl font-bold text-blue-900"><?= number_format($emissions['Scope 2 Location-Based'] ?? 0, 2) ?> tCO₂e</p>
                </div>
                <div class="bg-emerald-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-600">Total GHG Emissions</p>
                    <p class="text-3xl font-bold text-emerald-900">
                        <?= number_format(($emissions['Scope 1'] ?? 0) + ($emissions['Scope 2 Location-Based'] ?? 0), 2) ?> tCO₂e
                    </p>
                </div>
            </div>
        </section>

        <!-- Environmental (E1-E5) -->
        <section class="mb-12">
            <h3 class="text-2xl font-bold border-b-2 border-emerald-500 pb-2 mb-4">Environmental Performance (ESRS E1-E5)</h3>
            
            <!-- E1 - Climate Change -->
            <div class="mb-6">
                <h4 class="text-lg font-semibold mb-2">E1 - Climate Change</h4>
                <p class="text-gray-700"><?= $environmental['e1_climate_policy'] ?? 'No policy reported' ?></p>
                <p class="text-sm text-gray-600 mt-2">Reduction Target: <?= $environmental['e1_reduction_target'] ?? 'Not set' ?></p>
            </div>

            <!-- E2 - Pollution -->
            <div class="mb-6">
                <h4 class="text-lg font-semibold mb-2">E2 - Pollution</h4>
                <p>NOx Emissions: <?= $environmental['e2_nox_t_per_year'] ?? 0 ?> t/year</p>
                <p>SOx Emissions: <?= $environmental['e2_sox_t_per_year'] ?? 0 ?> t/year</p>
            </div>

            <!-- E3 - Water -->
            <div class="mb-6">
                <h4 class="text-lg font-semibold mb-2">E3 - Water & Marine Resources</h4>
                <p>Water Withdrawal: <?= number_format($environmental['e3_water_withdrawal_m3'] ?? 0) ?> m³</p>
                <p>Recycling Rate: <?= $environmental['e3_water_recycling_rate_pct'] ?? 0 ?>%</p>
            </div>

            <!-- E4 - Biodiversity -->
            <div class="mb-6">
                <h4 class="text-lg font-semibold mb-2">E4 - Biodiversity</h4>
                <p class="text-gray-700"><?= $environmental['e4_protected_areas_impact'] ?? 'No impact reported' ?></p>
            </div>

            <!-- E5 - Circular Economy -->
            <div class="mb-6">
                <h4 class="text-lg font-semibold mb-2">E5 - Circular Economy</h4>
                <p>Recycling Rate: <?= $environmental['e5_recycling_rate_pct'] ?? 0 ?>%</p>
                <p>Recycled Input Materials: <?= $environmental['e5_recycled_input_materials_pct'] ?? 0 ?>%</p>
            </div>
        </section>

        <!-- Social (S1-S4) -->
        <section class="mb-12">
            <h3 class="text-2xl font-bold border-b-2 border-indigo-500 pb-2 mb-4">Social Performance (ESRS S1-S4)</h3>
            
            <div class="mb-4">
                <h4 class="text-lg font-semibold">S1 - Own Workforce</h4>
                <p>Training Hours per Employee: <?= $social['s1_training_hours_per_employee'] ?? 0 ?> hours</p>
                <p class="text-sm text-gray-600"><?= $social['s1_employee_count_by_contract'] ?? '' ?></p>
            </div>

            <div class="mb-4">
                <h4 class="text-lg font-semibold">S2 - Workers in Value Chain</h4>
                <p>Suppliers Audited: <?= $social['s2_pct_suppliers_audited'] ?? 0 ?>%</p>
            </div>

            <div class="mb-4">
                <h4 class="text-lg font-semibold">S3 - Affected Communities</h4>
                <p class="text-gray-700"><?= $social['s3_community_engagement'] ?? 'Not reported' ?></p>
            </div>

            <div class="mb-4">
                <h4 class="text-lg font-semibold">S4 - Consumers & End Users</h4>
                <p>Product Safety Incidents: <?= $social['s4_product_safety_incidents'] ?? 0 ?></p>
            </div>
        </section>

        <!-- Governance (G1) -->
        <section class="mb-12">
            <h3 class="text-2xl font-bold border-b-2 border-slate-600 pb-2 mb-4">Governance (ESRS G1)</h3>
            
            <div class="mb-4">
                <h4 class="text-lg font-semibold">Board Composition</h4>
                <p>Independence: <?= $governance['g1_board_composition_independence'] ?? 'Not reported' ?></p>
                <p>Gender Diversity: <?= $governance['g1_gender_diversity_pct'] ?? 0 ?>%</p>
            </div>

            <div class="mb-4">
                <h4 class="text-lg font-semibold">ESG Oversight</h4>
                <p class="text-gray-700"><?= $governance['g1_esg_oversight'] ?? 'Not reported' ?></p>
            </div>

            <div class="mb-4">
                <h4 class="text-lg font-semibold">Anti-Corruption</h4>
                <p><?= $governance['g1_anti_corruption_policies'] ?? 'No policies reported' ?></p>
            </div>
        </section>

        <!-- EU Taxonomy -->
        <section class="mb-12">
            <h3 class="text-2xl font-bold border-b-2 border-amber-500 pb-2 mb-4">EU Taxonomy Alignment</h3>
            
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-amber-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-600">Eligible Revenue</p>
                    <p class="text-2xl font-bold text-amber-900"><?= $taxonomy['taxonomy_eligible_revenue_pct'] ?? 0 ?>%</p>
                </div>
                <div class="bg-emerald-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-600">Aligned Revenue</p>
                    <p class="text-2xl font-bold text-emerald-900"><?= $taxonomy['taxonomy_aligned_revenue_pct'] ?? 0 ?>%</p>
                </div>
                <div class="bg-teal-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-600">Aligned CapEx</p>
                    <p class="text-2xl font-bold text-teal-900"><?= $taxonomy['taxonomy_aligned_capex_pct'] ?? 0 ?>%</p>
                </div>
            </div>

            <div class="mt-4">
                <p class="text-sm text-gray-600">DNSH Status: 
                    <span class="font-semibold"><?= $taxonomy['dnsh_status'] ?? 'Not assessed' ?></span>
                </p>
                <p class="text-sm text-gray-600">Social Safeguards: 
                    <span class="font-semibold"><?= $taxonomy['social_safeguards_status'] ?? 'Not assessed' ?></span>
                </p>
            </div>
        </section>

        <!-- Footer -->
        <div class="border-t-2 border-gray-300 pt-6 mt-12 text-center text-sm text-gray-500">
            <p>Report generated on <?= date('F j, Y') ?></p>
            <p><?= $company['name'] ?> | <?= $company['country_of_registration'] ?></p>
        </div>

        <!-- Print Button -->
        <div class="text-center mt-8 no-print">
            <button onclick="window.print()" 
                class="bg-emerald-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-emerald-700">
                Download PDF
            </button>
        </div>
    </div>

    <style>
        @media print {
            .no-print { display: none; }
        }
    </style>
</body>
</html>
