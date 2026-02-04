1. ✅ Database Setup (MySQL tables - DONE)
2. 🔐 Login System (Authentication)
3. 🏢 Dashboard (Company & User Management - DONE)
4. 📍 Sites Management (NEW - Must build before Phase 3)
5. 🌍 Phase 3: Emissions Data Collection
6. 🌱 Phase 4: Environmental Reporting
7. 👥 Phase 5: Social & Governance
8. 📊 Phase 6: EU Taxonomy & Assurance
9. 📄 Final ESG Report Generator


## **📂 FINAL FILE STRUCTURE**
   
/esg-reporting/
├── config/
│   └── database.php
│
├── includes/
│   ├── auth.php
│   ├── functions.php
│   └── db_functions.php
│
├── pages/
│   ├── login.php
│   ├── dashboard.php (dashboard-2.html)
│   ├── sites.php
│   ├── phase3.php 
│   ├── phase4.php
│   ├── phase5.php
│   ├── phase6.php
│   └── generate_report.php
│
├── actions/
│   ├── process_login.php
│   ├── logout.php
│   ├── save_site.php
│   ├── save_energy_activity.php
│   ├── save_fuel_activity.php
│   ├── save_environmental.php
│   ├── save_social.php
│   ├── save_governance.php
│   └── save_taxonomy.php
│
└── index.php (redirects to login or dashboard)

