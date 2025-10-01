/**
 * ITMS Main JavaScript File
 * ระบบ IT Management System
 */

// ===== Document Ready =====
document.addEventListener('DOMContentLoaded', function() {
    initializeApp();
});

// ===== Initialize Application =====
function initializeApp() {
    // Initialize tooltips
    initializeTooltips();
    
    // Initialize alerts auto-dismiss
    initializeAlerts();
    
    // Initialize form validation
    initializeFormValidation();
    
    // Initialize sidebar
    initializeSidebar();
    
    // Initialize data tables
    initializeDataTables();
    
    // Initialize modals
    initializeModals();
    
    console.log('ITMS Application initialized successfully');
}

// ===== Tooltip Initialization =====
function initializeTooltips() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
}

// ===== Auto-dismiss Alerts =====
function initializeAlerts() {
    // Auto-dismiss alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            if (bsAlert) {
                bsAlert.close();
            }
        }, 5000);
    });
}

// ===== Form Validation =====
function initializeFormValidation() {
    // Bootstrap form validation
    const forms = document.querySelectorAll('.needs-validation');
    Array.prototype.slice.call(forms).forEach(function(form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });

    // Custom validation for specific fields
    initializeCustomValidation();
}

// ===== Custom Validation =====
function initializeCustomValidation() {
    // Email validation
    const emailInputs = document.querySelectorAll('input[type="email"]');
    emailInputs.forEach(function(input) {
        input.addEventListener('blur', function() {
            validateEmail(this);
        });
    });

    // Password validation
    const passwordInputs = document.querySelectorAll('input[type="password"]');
    passwordInputs.forEach(function(input) {
        input.addEventListener('input', function() {
            if (this.name === 'password' || this.name === 'new_password') {
                validatePassword(this);
            }
        });
    });

    // Confirm password validation
    const confirmPasswordInputs = document.querySelectorAll('input[name="password_confirmation"]');
    confirmPasswordInputs.forEach(function(input) {
        input.addEventListener('input', function() {
            validatePasswordConfirmation(this);
        });
    });
}

// ===== Email Validation Function =====
function validateEmail(input) {
    const email = input.value;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
    if (email && !emailRegex.test(email)) {
        showFieldError(input, 'รูปแบบอีเมลไม่ถูกต้อง');
        return false;
    } else {
        clearFieldError(input);
        return true;
    }
}

// ===== Password Validation Function =====
function validatePassword(input) {
    const password = input.value;
    const minLength = 8;
    const hasUpperCase = /[A-Z]/.test(password);
    const hasLowerCase = /[a-z]/.test(password);
    const hasNumbers = /\d/.test(password);
    const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(password);

    let errors = [];

    if (password.length < minLength) {
        errors.push(`รหัสผ่านต้องมีอย่างน้อย ${minLength} ตัวอักษร`);
    }
    if (!hasUpperCase) {
        errors.push('รหัสผ่านต้องมีตัวอักษรพิมพ์ใหญ่อย่างน้อย 1 ตัว');
    }
    if (!hasLowerCase) {
        errors.push('รหัสผ่านต้องมีตัวอักษรพิมพ์เล็กอย่างน้อย 1 ตัว');
    }
    if (!hasNumbers) {
        errors.push('รหัสผ่านต้องมีตัวเลขอย่างน้อย 1 ตัว');
    }

    if (errors.length > 0) {
        showFieldError(input, errors.join('<br>'));
        return false;
    } else {
        clearFieldError(input);
        return true;
    }
}

// ===== Password Confirmation Validation =====
function validatePasswordConfirmation(input) {
    const password = document.querySelector('input[name="password"], input[name="new_password"]');
    const confirmation = input.value;

    if (password && confirmation !== password.value) {
        showFieldError(input, 'รหัสผ่านไม่ตรงกัน');
        return false;
    } else {
        clearFieldError(input);
        return true;
    }
}

// ===== Show Field Error =====
function showFieldError(input, message) {
    clearFieldError(input);
    
    input.classList.add('is-invalid');
    
    const errorDiv = document.createElement('div');
    errorDiv.className = 'invalid-feedback';
    errorDiv.innerHTML = message;
    
    input.parentNode.appendChild(errorDiv);
}

// ===== Clear Field Error =====
function clearFieldError(input) {
    input.classList.remove('is-invalid');
    
    const existingError = input.parentNode.querySelector('.invalid-feedback');
    if (existingError) {
        existingError.remove();
    }
}

// ===== Sidebar Functionality =====
function initializeSidebar() {
    // Add active class to current page
    const currentPath = window.location.pathname;
    const sidebarLinks = document.querySelectorAll('.sidebar .nav-link');
    
    sidebarLinks.forEach(function(link) {
        if (link.getAttribute('href') === currentPath) {
            link.classList.add('active');
        }
    });

    // Sidebar toggle for mobile
    const sidebarToggle = document.querySelector('[data-sidebar-toggle]');
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('show');
        });
    }
}

// ===== Data Tables =====
function initializeDataTables() {
    const tables = document.querySelectorAll('.data-table');
    
    tables.forEach(function(table) {
        // Add search functionality
        addTableSearch(table);
        
        // Add sorting functionality
        addTableSorting(table);
        
        // Add pagination
        addTablePagination(table);
    });
}

// ===== Table Search =====
function addTableSearch(table) {
    const searchInput = table.parentNode.querySelector('.table-search');
    if (!searchInput) return;

    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = table.querySelectorAll('tbody tr');

        rows.forEach(function(row) {
            const text = row.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
}

// ===== Table Sorting =====
function addTableSorting(table) {
    const headers = table.querySelectorAll('th[data-sortable]');
    
    headers.forEach(function(header, index) {
        header.style.cursor = 'pointer';
        header.addEventListener('click', function() {
            sortTable(table, index);
        });
    });
}

// ===== Sort Table Function =====
function sortTable(table, columnIndex) {
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    const isAscending = table.querySelector('th').dataset.sortDirection !== 'asc';

    rows.sort(function(a, b) {
        const aText = a.cells[columnIndex].textContent.trim();
        const bText = b.cells[columnIndex].textContent.trim();

        if (isAscending) {
            return aText.localeCompare(bText);
        } else {
            return bText.localeCompare(aText);
        }
    });

    // Update sort direction
    table.querySelectorAll('th').forEach(function(th) {
        delete th.dataset.sortDirection;
    });
    table.querySelectorAll('th')[columnIndex].dataset.sortDirection = isAscending ? 'asc' : 'desc';

    // Append sorted rows
    rows.forEach(function(row) {
        tbody.appendChild(row);
    });
}

// ===== Table Pagination =====
function addTablePagination(table) {
    // Placeholder for pagination functionality
    // Will be implemented when needed
}

// ===== Modal Initialization =====
function initializeModals() {
    // Auto-focus first input in modals
    const modals = document.querySelectorAll('.modal');
    modals.forEach(function(modal) {
        modal.addEventListener('shown.bs.modal', function() {
            const firstInput = this.querySelector('input, select, textarea');
            if (firstInput) {
                firstInput.focus();
            }
        });
    });
}

// ===== AJAX Utilities =====
function sendAjaxRequest(url, method = 'GET', data = null) {
    return new Promise(function(resolve, reject) {
        const xhr = new XMLHttpRequest();
        xhr.open(method, url);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        
        // Add CSRF token for POST requests
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (csrfToken && method !== 'GET') {
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken.getAttribute('content'));
        }

        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 300) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    resolve(response);
                } catch (e) {
                    resolve(xhr.responseText);
                }
            } else {
                reject(new Error('Request failed with status: ' + xhr.status));
            }
        };

        xhr.onerror = function() {
            reject(new Error('Network error'));
        };

        if (data) {
            xhr.send(JSON.stringify(data));
        } else {
            xhr.send();
        }
    });
}

// ===== Notification System =====
function showNotification(message, type = 'info', duration = 5000) {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    document.body.appendChild(notification);

    // Auto remove after duration
    setTimeout(function() {
        const bsAlert = new bootstrap.Alert(notification);
        if (bsAlert) {
            bsAlert.close();
        }
    }, duration);
}

// ===== Loading Indicator =====
function showLoading(element = null) {
    if (element) {
        element.innerHTML = '<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>';
    } else {
        document.body.style.cursor = 'wait';
    }
}

function hideLoading(element = null) {
    if (element) {
        // Restore original content
    } else {
        document.body.style.cursor = 'default';
    }
}

// ===== Utility Functions =====
function formatNumber(number) {
    return new Intl.NumberFormat('th-TH').format(number);
}

function formatDate(date) {
    return new Intl.DateTimeFormat('th-TH').format(new Date(date));
}

function formatDateTime(dateTime) {
    return new Intl.DateTimeFormat('th-TH', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
        hour: '2-digit',
        minute: '2-digit'
    }).format(new Date(dateTime));
}

// ===== Global Event Listeners =====
window.addEventListener('resize', function() {
    // Handle responsive adjustments
    handleResponsiveLayout();
});

function handleResponsiveLayout() {
    // Responsive handling logic
    const isMobile = window.innerWidth < 768;
    const sidebar = document.querySelector('.sidebar');
    
    if (sidebar) {
        if (isMobile) {
            sidebar.classList.add('mobile');
        } else {
            sidebar.classList.remove('mobile');
        }
    }
}

// ===== Export functions for global use =====
window.ITMSApp = {
    showNotification: showNotification,
    sendAjaxRequest: sendAjaxRequest,
    showLoading: showLoading,
    hideLoading: hideLoading,
    formatNumber: formatNumber,
    formatDate: formatDate,
    formatDateTime: formatDateTime
};