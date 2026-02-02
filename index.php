<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Pure JS SPA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <script src="https://cdn.tailwindcss.com"></script>

    <style>


        /* ===============================
        Global Transitions
        ================================ */
        * {
        transition-property: color, background-color, border-color, text-decoration-color,
            fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
        transition-duration: 200ms;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* ===============================
            Accordion
        ================================ */
        .accordion-content {
        transition: max-height 0.3s ease-out;
        }

        .accordion-item {
        transition: transform 0.3s ease;
        }

        .accordion-item:hover {
        transform: translateY(-2px);
        }

        /* ===============================
            Inputs – General
        ================================ */
        input,
        textarea,
        select {
        transition: all 0.2s ease;
        }

        input:focus,
        textarea:focus,
        select:focus {
        box-shadow: 0 0 0 3px rgba(100, 116, 139, 0.1);
        }

        /* ===============================
            Checkbox
        ================================ */
        input[type="checkbox"] {
        cursor: pointer;
        }

        input[type="checkbox"]:checked+label {
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
        }

        input[type="checkbox"]:checked {
        background-color: currentColor;
        border-color: transparent;
        background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3e%3cpath d='M12.207 4.793a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-2-2a1 1 0 011.414-1.414L6.5 9.086l4.293-4.293a1 1 0 011.414 0z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: center;
        background-size: 100% 100%;
        }

        /* ===============================
            Number Input
        ================================ */
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
        }

        /* ===============================
            Month & Date Inputs
        ================================ */
        input[type="month"]::-webkit-calendar-picker-indicator,
        input[type="date"]::-webkit-calendar-picker-indicator {
        background: transparent;
        cursor: pointer;
        padding: 0.5rem;
        position: absolute;
        inset: 0;
        }

        input[type="month"]:focus {
        background-color: #fff;
        }

        /* ===============================
            Select Dropdown
        ================================ */
        select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 1.5em;
        padding-right: 2.5rem;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
        }

        /* ===============================
            Scrollbar (Global & Textarea)
        ================================ */
        ::-webkit-scrollbar,
        textarea::-webkit-scrollbar {
        width: 6px;
        }

        ::-webkit-scrollbar-track,
        textarea::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb,
        textarea::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover,
        textarea::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
        }

        /* ===============================
            Animations
        ================================ */
        @keyframes shimmer {
        0% {
            transform: translateX(-100%);
        }

        100% {
            transform: translateX(100%);
        }
        }

        .animate-shimmer {
        animation: shimmer 2s infinite;
        }
    </style>

</head>

<body class="bg-gray-50 min-h-screen font-sans antialiased">

    <header class="bg-emerald-800 text-white p-6 shadow-lg">
        <h1 class="text-3xl font-bold text-center md:text-left">ESG Reporting Platform</h1>
    </header>

    <nav class="bg-white sticky top-0 z-50 backdrop-blur-sm bg-white/90 border-b border-gray-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo/Brand placeholder -->
                <div class="flex-shrink-0">
                    <a href="/"
                        class="text-xl font-bold bg-gradient-to-r from-emerald-600 to-teal-500 bg-clip-text text-transparent">
                        ESG Portal
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <ul class="hidden md:flex items-center space-x-1">
                    <li>
                        <a href="/phase-3" data-page="phase-3" class="nav-link relative px-4 py-2.5 rounded-lg text-gray-700 hover:text-emerald-700 transition-all duration-300 
                                hover:bg-emerald-50 group">
                            <span class="relative z-10">Phase 3 – Emissions</span>
                            <span
                                class="absolute inset-0 bg-emerald-100 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                        </a>
                    </li>

                    <li>
                        <a href="/phase-4" data-page="phase-4" class="nav-link relative px-4 py-2.5 rounded-lg text-gray-700 hover:text-emerald-700 transition-all duration-300 
                                hover:bg-emerald-50 group">
                            <span class="relative z-10">Phase 4 – Environmental</span>
                            <span
                                class="absolute inset-0 bg-emerald-100 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                        </a>
                    </li>

                    <li>
                        <a href="/phase-5" data-page="phase-5" class="nav-link relative px-4 py-2.5 rounded-lg text-gray-700 hover:text-emerald-700 transition-all duration-300 
                                hover:bg-emerald-50 group">
                            <span class="relative z-10">Phase 5 – Social & Governance</span>
                            <span
                                class="absolute inset-0 bg-emerald-100 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                        </a>
                    </li>

                    <li>
                        <a href="/phase-6" data-page="phase-6" class="nav-link relative px-4 py-2.5 rounded-lg text-gray-700 hover:text-emerald-700 transition-all duration-300 
                                hover:bg-emerald-50 group">
                            <span class="relative z-10">Phase 6 – EU Taxonomy & Assurance</span>
                            <span
                                class="absolute inset-0 bg-emerald-100 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                        </a>
                    </li>
                </ul>

                <!-- Optional: Action Button -->
                <div class="hidden md:block">
                    <button class="ml-4 px-5 py-2.5 bg-gradient-to-r from-emerald-600 to-teal-500 text-white font-medium rounded-lg 
                                hover:shadow-lg hover:shadow-emerald-100 hover:-translate-y-0.5 transition-all duration-300 
                                focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                        Get Started
                    </button>
                </div>

                <!-- Mobile menu button -->
                <button class="md:hidden p-2 rounded-lg text-gray-600 hover:bg-gray-100 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div class="md:hidden bg-white border-t border-gray-100">
            <ul class="py-2 px-4">
                <li class="border-b border-gray-100">
                    <a href="/phase-3" data-page="phase-3"
                        class="block py-3.5 text-gray-700 hover:text-emerald-700 hover:bg-emerald-50 rounded-lg px-3 transition-colors">
                        Phase 3 – Emissions
                    </a>
                </li>
                <li class="border-b border-gray-100">
                    <a href="/phase-4" data-page="phase-4"
                        class="block py-3.5 text-gray-700 hover:text-emerald-700 hover:bg-emerald-50 rounded-lg px-3 transition-colors">
                        Phase 4 – Environmental
                    </a>
                </li>
                <li class="border-b border-gray-100">
                    <a href="/phase-5" data-page="phase-5"
                        class="block py-3.5 text-gray-700 hover:text-emerald-700 hover:bg-emerald-50 rounded-lg px-3 transition-colors">
                        Phase 5 – Social & Governance
                    </a>
                </li>
                <li>
                    <a href="/phase-6" data-page="phase-6"
                        class="block py-3.5 text-gray-700 hover:text-emerald-700 hover:bg-emerald-50 rounded-lg px-3 transition-colors">
                        Phase 6 – EU Taxonomy & Assurance
                    </a>
                </li>
            </ul>
        </div>
    </nav>



<hr />


  <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">



      <main id="app">Loading…</main>

    
  </main>

    <footer class="bg-gray-800 text-gray-300 py-6 text-center text-sm">
    <p>© 2026 ESG Reporting Platform • All rights reserved</p>
  </footer>


<script>


document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('.nav-link');
    const currentPage = window.location.pathname;
    
    navLinks.forEach(link => {
        if (link.getAttribute('href') === currentPage) {
            link.classList.add('text-emerald-700', 'bg-emerald-50');
            link.classList.remove('text-gray-700', 'hover:text-emerald-700');
            
            // Add active indicator
            const activeIndicator = document.createElement('span');
            activeIndicator.className = 'absolute bottom-0 left-1/2 transform -translate-x-1/2 w-1.5 h-1.5 bg-emerald-500 rounded-full';
            link.querySelector('.relative').appendChild(activeIndicator);
        }
    });
});


  const app = document.getElementById("app");
  const links = document.querySelectorAll(".nav-link");

  function load(page, push = true) {
    fetch(`pages/${page}.html`)
      .then(res => res.text())
      .then(html => {
        app.innerHTML = html;
        setActive(page);
        if (push) history.pushState({ page }, "", "/" + page);
      })
      .catch(() => app.innerHTML = "<h2>Page not found</h2>");
  }

  function setActive(page) {
    links.forEach(a =>
      a.classList.toggle("active", a.dataset.page === page)
    );
  }

  links.forEach(a => {
    a.addEventListener("click", e => {
      e.preventDefault();           // 🔥 THIS IS CRITICAL
      load(a.dataset.page);
    });
  });

  window.addEventListener("popstate", e => {
    if (e.state?.page) load(e.state.page, false);
  });

  const page = location.pathname.replace("/", "") || "phase-3";
  load(page, false);
</script>


</body>
</html>
