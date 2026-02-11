/**
 * ============================================================================
 * PHASE 3 & PHASE 4 - JAVASCRIPT FORM SUBMISSION HANDLERS
 * ============================================================================
 * Complete implementation for all form submissions in Phase 3 and Phase 4
 * ============================================================================
 */

// ============================================================================
// UTILITY FUNCTIONS
// ============================================================================

/**
 * Display success/error messages to user
 */
function showMessage(message, type = 'success') {
    const alertClass = type === 'success' 
        ? 'bg-green-50 border-green-500 text-green-800' 
        : 'bg-red-50 border-red-500 text-red-800';
    
    const icon = type === 'success'
        ? '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
        : '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
    
    const alertHTML = `
        <div class="${alertClass} border-l-4 p-4 mb-4 rounded-lg flex items-center gap-3 animate-slide-in">
            ${icon}
            <div>
                <p class="font-medium">${message}</p>
            </div>
        </div>
    `;
    
    // Find the first section to insert message
    const section = document.querySelector('section') || document.querySelector('main');
    if (section) {
        section.insertAdjacentHTML('afterbegin', alertHTML);
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            const alert = section.querySelector('div');
            if (alert) {
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 300);
            }
        }, 5000);
    } else {
        // Fallback to alert
        alert(message);
    }
}

/**
 * Get global reporting period value
 */
function getGlobalReportingPeriod() {
    const periodInput = document.getElementById('globalReportingPeriod') || 
                       document.getElementById('reportingPeriod');
    return periodInput ? periodInput.value : '';
}

/**
 * Get global company ID value
 */
function getGlobalCompanyId() {
    const companyInput = document.getElementById('globalCompanyId') || 
                        document.getElementById('companyId');
    return companyInput ? companyInput.value : '';
}

// ============================================================================
// PHASE 3: EMISSIONS DATA COLLECTION
// ============================================================================

/**
 * Phase 3 - Emission Factor Form Submission
 */
function initEmissionFactorForm() {
    const form = document.getElementById('emissionFactorForm');
    if (!form) return;
    
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        // Validate required fields
        const requiredFields = ['scope', 'activityType', 'region', 'factor', 'unit', 'version'];
        const missing = requiredFields.filter(field => !formData.get(field));
        
        if (missing.length > 0) {
            showMessage(`Missing required fields: ${missing.join(', ')}`, 'error');
            return;
        }
        
        try {
            const response = await fetch('../actions/save_emission_factor.php', {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            
            if (result.success) {
                showMessage(result.message || 'Emission factor saved successfully!', 'success');
                form.reset();
                
                // Optionally reload emission factors list
                if (typeof loadEmissionFactors === 'function') {
                    loadEmissionFactors();
                }
            } else {
                showMessage(result.message || 'Failed to save emission factor', 'error');
            }
        } catch (error) {
            console.error('Error saving emission factor:', error);
            showMessage('Network error. Please try again.', 'error');
        }
    });
}

/**
 * Phase 3 - Energy Activity Form Submission (Scope 2)
 */
function initEnergyActivityForm() {
    const form = document.getElementById('energyActivityForm');
    if (!form) return;
    
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        // Add global reporting period if available
        const reportingPeriod = getGlobalReportingPeriod();
        if (reportingPeriod) {
            formData.append('reportingPeriod', reportingPeriod);
        }
        
        // Validate required fields
        const requiredFields = ['siteId', 'date', 'energyType', 'consumption', 'unit'];
        const missing = requiredFields.filter(field => !formData.get(field));
        
        if (missing.length > 0) {
            showMessage(`Missing required fields: ${missing.join(', ')}`, 'error');
            return;
        }
        
        try {
            const response = await fetch('../actions/save_energy_activity.php', {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            
            if (result.success) {
                showMessage(
                    `Energy emissions calculated: ${result.data?.calculation?.emissionTonnes || 'N/A'} tCO₂e`, 
                    'success'
                );
                form.reset();
                
                // Optionally refresh emissions dashboard
                if (typeof refreshEmissionsDashboard === 'function') {
                    refreshEmissionsDashboard();
                }
            } else {
                showMessage(result.message || 'Failed to save energy activity', 'error');
            }
        } catch (error) {
            console.error('Error saving energy activity:', error);
            showMessage('Network error. Please try again.', 'error');
        }
    });
}

/**
 * Phase 3 - Fuel Activity Form Submission (Scope 1)
 */
function initFuelActivityForm() {
    const form = document.getElementById('fuelActivityForm');
    if (!form) return;
    
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        // Add global reporting period if available
        const reportingPeriod = getGlobalReportingPeriod();
        if (reportingPeriod) {
            formData.append('reportingPeriod', reportingPeriod);
        }
        
        // Validate required fields
        const requiredFields = ['siteId', 'date', 'fuelType', 'volume', 'unit'];
        const missing = requiredFields.filter(field => !formData.get(field));
        
        if (missing.length > 0) {
            showMessage(`Missing required fields: ${missing.join(', ')}`, 'error');
            return;
        }
        
        try {
            const response = await fetch('../actions/save_fuel_activity.php', {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            
            if (result.success) {
                showMessage(
                    `Fuel emissions calculated: ${result.data?.calculation?.emissionTonnes || 'N/A'} tCO₂e`, 
                    'success'
                );
                form.reset();
                
                // Optionally refresh emissions dashboard
                if (typeof refreshEmissionsDashboard === 'function') {
                    refreshEmissionsDashboard();
                }
            } else {
                showMessage(result.message || 'Failed to save fuel activity', 'error');
            }
        } catch (error) {
            console.error('Error saving fuel activity:', error);
            showMessage('Network error. Please try again.', 'error');
        }
    });
}

// ============================================================================
// PHASE 4: ENVIRONMENTAL REPORTING
// ============================================================================

/**
 * Phase 4 - ESRS 2 General Disclosures Form Submission
 */
function initEsrs2GeneralDisclosuresForm() {
    const form = document.getElementById('esrs2GeneralDisclosuresForm');
    if (!form) return;
    
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        // Add global reporting period
        const reportingPeriod = getGlobalReportingPeriod();
        if (!reportingPeriod) {
            showMessage('Please select a reporting period', 'error');
            return;
        }
        formData.append('reportingPeriod', reportingPeriod);
        
        // Validate required fields
        const requiredFields = [
            'consolidationScope', 
            'valueChainBoundaries', 
            'boardRoleInSustainability', 
            'assessmentProcess'
        ];
        const missing = requiredFields.filter(field => !formData.get(field) || formData.get(field).trim() === '');
        
        if (missing.length > 0) {
            showMessage(`Missing required fields: ${missing.join(', ')}`, 'error');
            return;
        }
        
        try {
            const response = await fetch('../actions/save_esrs2_general.php', {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            
            if (result.success) {
                showMessage('ESRS 2 General Disclosures saved successfully!', 'success');
            } else {
                showMessage(result.message || 'Failed to save general disclosures', 'error');
            }
        } catch (error) {
            console.error('Error saving general disclosures:', error);
            showMessage('Network error. Please try again.', 'error');
        }
    });
}

/**
 * Phase 4 - Environmental Topics Form Submission (E1-E5)
 */
function initEnvironmentalTopicsForm() {
    const form = document.getElementById('environmentalTopicsForm');
    if (!form) return;
    
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        // Add global reporting period
        const reportingPeriod = document.getElementById('phase4GlobalReportingPeriod')?.value || 
                               getGlobalReportingPeriod();
        
        if (!reportingPeriod) {
            showMessage('Please select a reporting period', 'error');
            return;
        }
        formData.append('reportingPeriod', reportingPeriod);
        
        // Get status field
        const status = formData.get('status');
        if (!status) {
            showMessage('Please select a report status', 'error');
            return;
        }
        
        try {
            const response = await fetch('../actions/save_environmental.php', {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            
            if (result.success) {
                showMessage('Environmental topics saved successfully!', 'success');
                
                // Optionally update progress indicators
                if (typeof updateEnvironmentalProgress === 'function') {
                    updateEnvironmentalProgress();
                }
            } else {
                showMessage(result.message || 'Failed to save environmental topics', 'error');
            }
        } catch (error) {
            console.error('Error saving environmental topics:', error);
            showMessage('Network error. Please try again.', 'error');
        }
    });
}

// ============================================================================
// INITIALIZATION
// ============================================================================

/**
 * Initialize all form handlers when DOM is ready
 */
document.addEventListener('DOMContentLoaded', function() {
    console.log('Initializing Phase 3 & 4 form handlers...');
    
    // Phase 3 - Emissions Data Collection
    initEmissionFactorForm();
    initEnergyActivityForm();
    initFuelActivityForm();
    
    // Phase 4 - Environmental Reporting
    initEsrs2GeneralDisclosuresForm();
    initEnvironmentalTopicsForm();
    
    console.log('All form handlers initialized successfully!');
});

// ============================================================================
// GLOBAL EXPORTS (for manual initialization if needed)
// ============================================================================
window.ESGFormHandlers = {
    // Phase 3
    initEmissionFactorForm,
    initEnergyActivityForm,
    initFuelActivityForm,
    
    // Phase 4
    initEsrs2GeneralDisclosuresForm,
    initEnvironmentalTopicsForm,
    
    // Utilities
    showMessage,
    getGlobalReportingPeriod,
    getGlobalCompanyId
};