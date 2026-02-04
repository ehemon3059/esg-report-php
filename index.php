<?php
session_start();

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    // User is authenticated, redirect to dashboard
    header('Location: pages/dashboard.php');
    exit;
} else {
    // User is not authenticated, redirect to login
    header('Location: pages/login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>ESG Reporting Platform</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Smooth Global Transitions */
        * { transition: all 200ms cubic-bezier(0.4, 0, 0.2, 1); }
        
        /* Active Link Styling */
        .nav-link.active { color: #047857; background-color: #ecfdf5; font-weight: 600; }
        .nav-link.active .indicator { opacity: 1; transform: translateX(-50%) scale(1); }
        
        .indicator { 
            opacity: 0; position: absolute; bottom: 2px; left: 50%; 
            transform: translateX(-50%) scale(0); 
            width: 5px; height: 5px; background-color: #10b981; 
            border-radius: 50%; transition: all 0.3s ease;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
    </style>
</head>

<body class="bg-gray-50 min-h-screen font-sans antialiased">

    <header class="bg-emerald-800 text-white p-6 shadow-lg">
        <h1 class="text-3xl font-bold text-center md:text-left">ESG Reporting Platform</h1>
    </header>

    <nav class="bg-white sticky top-0 z-50 border-b border-gray-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex-shrink-0">
                    <a href="/esg-report/" class="text-xl font-bold bg-gradient-to-r from-emerald-600 to-teal-500 bg-clip-text text-transparent">
                        ESG Portal
                    </a>
                </div>

                <ul class="hidden md:flex items-center space-x-1">
                    <?php 
                    $navItems = [
                        'phase-3' => 'Emissions',
                        'phase-4' => 'Environmental',
                        'phase-5' => 'Social & Gov',
                        'phase-6' => 'EU Taxonomy'
                    ];
                    foreach ($navItems as $slug => $label): ?>
                    <li>
                        <a href="/esg-report/<?php echo $slug; ?>" data-page="<?php echo $slug; ?>" 
                           class="nav-link relative px-4 py-2.5 rounded-lg text-gray-700 hover:text-emerald-700 hover:bg-emerald-50 transition-all group">
                            <span class="relative z-10"><?php echo $label; ?></span>
                            <span class="indicator"></span>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>

                <button class="hidden md:block px-5 py-2.5 bg-emerald-600 text-white font-medium rounded-lg hover:bg-emerald-700 transition-all">
                    Generate Report
                </button>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div id="app" class="min-h-[400px] bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex flex-col items-center justify-center py-20 text-gray-400">
                <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-emerald-600 mb-4"></div>
                <p>Loading ESG Module...</p>
            </div>
        </div>
    </main>

    <footer class="bg-gray-800 text-gray-400 py-6 text-center text-sm">
        <p>© 2026 ESG Reporting Platform • Built with PHP & JS SPA</p>
    </footer>

    <script>
        const app = document.getElementById("app");
        const links = document.querySelectorAll(".nav-link");
        const basePath = "/esg-report/";

        /**
         * Core Loader Function
         */
        async function load(page, push = true) {
            // Remove .php extension if provided by mistake
            const cleanPage = page.replace('.php', '');
            
            try {
                // Fetch from the /pages/ subfolder
                const response = await fetch(`pages/${cleanPage}.php`);
                
                if (!response.ok) throw new Error("Module not found");
                
                const html = await response.text();
                app.innerHTML = html;
                
                setActive(cleanPage);
                
                if (push) {
                    history.pushState({ page: cleanPage }, "", basePath + cleanPage);
                }
                
                window.scrollTo({ top: 0, behavior: 'smooth' });
                
            } catch (error) {
                app.innerHTML = `
                    <div class="text-center py-20">
                        <h2 class="text-2xl font-bold text-gray-800">Module Not Found</h2>
                        <p class="text-gray-500 mt-2">Could not load: <b>pages/${cleanPage}.php</b></p>
                        <button onclick="load('phase-3')" class="mt-6 px-4 py-2 bg-emerald-100 text-emerald-700 rounded-lg">Return to Phase 3</button>
                    </div>`;
            }
        }

        /**
         * Update UI state
         */
        function setActive(page) {
            links.forEach(a => {
                const isMatch = a.dataset.page === page;
                a.classList.toggle("active", isMatch);
            });
        }

        /**
         * Event Listeners
         */
        links.forEach(a => {
            a.addEventListener("click", e => {
                e.preventDefault();
                load(a.dataset.page);
            });
        });

        window.addEventListener("popstate", e => {
            const page = e.state?.page || "phase-3";
            load(page, false);
        });

        // Determine initial page on load
        const urlPath = location.pathname.replace(basePath, "").replace("/", "");
        const initialPage = urlPath || "phase-3";
        
        load(initialPage, false);
    </script>
</body>
</html>