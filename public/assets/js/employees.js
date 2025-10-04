/**
 * ITMS Employee Management JavaScript
 * Path: public/assets/js/employees.js
 */

// Global variables
let selectedEmployees = new Set();

// ==================== Document Ready ====================
document.addEventListener('DOMContentLoaded', function() {
    initializeEmployeeManagement();
});

// ==================== Initialize Functions ====================
function initializeEmployeeManagement() {
    initializeCheckboxes();
    initializeStatusToggle();
    initializeDeleteButtons();
    initializePhotoUpload();
    initializeFilters();
    initializeBulkActions();
    initializePasswordToggle();
    initializeFormValidation();
}

// ==================== Checkbox Management ====================
function initializeCheckboxes() {
    // Select all checkbox
    const selectAllCheckbox = document.getElementById('select-all');
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.employee-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
                updateSelectedEmployees(checkbox.value, this.checked);
            });
            updateBulkActionsBar();
        });
    }

    // Individual checkboxes
    const checkboxes = document.querySelectorAll('.employee-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateSelectedEmployees(this.value, this.checked);
            updateSelectAllCheckbox();
            updateBulkActionsBar();
        });
    });
}

function updateSelectedEmployees(employeeId, isChecked) {
    if (isChecked) {
        selectedEmployees.add(employeeId);
    } else {
        selectedEmployees.delete(employeeId);
    }
}

function updateSelectAllCheckbox() {
    const selectAllCheckbox = document.getElementById('select-all');
    const checkboxes = document.querySelectorAll('.employee-checkbox');
    const checkedCount = document.querySelectorAll('.employee-checkbox:checked').length;
    
    if (selectAllCheckbox) {
        selectAllCheckbox.checked = checkedCount === checkboxes.length;
        selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < checkboxes.length;
    }
}

function updateBulkActionsBar() {
    const bulkActionsBar = document.getElementById('bulk-actions-bar');
    const bulkCount = document.getElementById('bulk-count');
    
    if (bulkActionsBar && bulkCount) {
        if (selectedEmployees.size > 0) {
            bulkActionsBar.classList.add('show');
            bulkCount.textContent = `เลือกแล้ว ${selectedEmployees.size} คน`;
        } else {
            bulkActionsBar.classList.remove('show');
        }
    }
}

// ==================== Status Toggle ====================
function initializeStatusToggle() {
    const statusToggles = document.querySelectorAll('.status-toggle');
    
    statusToggles.forEach(toggle => {
        toggle.addEventListener('change', async function() {
            const employeeId = this.dataset.employeeId;
            const newStatus = this.checked ? 'active' : 'inactive';
            
            try {
                const response = await fetch(`/employees/${employeeId}/status`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ status: newStatus })
                });

                const data = await response.json();

                if (data.success) {
                    showNotification('success', data.message);
                } else {
                    this.checked = !this.checked; // Revert toggle
                    showNotification('error', data.message);
                }
            } catch (error) {
                this.checked = !this.checked; // Revert toggle
                showNotification('error', 'เกิดข้อผิดพลาดในการอัปเดตสถานะ');
            }
        });
    });
}

// ==================== Delete Functionality ====================
function initializeDeleteButtons() {
    const deleteButtons = document.querySelectorAll('.btn-delete-employee');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', async function(e) {
            e.preventDefault();
            
            const employeeId = this.dataset.employeeId;
            const employeeName = this.dataset.employeeName;
            
            const confirmed = await showConfirmDialog(
                'ยืนยันการลบ',
                `คุณต้องการย้ายพนักงาน ${selectedEmployees.size} คนไปถังขยะใช่หรือไม่?`,
                'danger'
            );
            
            if (confirmed) {
                await bulkMoveToTrash();
            }
        });
    }
    
    // Clear selection
    const clearSelectionBtn = document.getElementById('clear-selection-btn');
    if (clearSelectionBtn) {
        clearSelectionBtn.addEventListener('click', function() {
            selectedEmployees.clear();
            document.querySelectorAll('.employee-checkbox').forEach(cb => cb.checked = false);
            updateSelectAllCheckbox();
            updateBulkActionsBar();
        });
    }
}

async function bulkUpdateStatus(status) {
    try {
        const response = await fetch('/employees/bulk/status', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                employee_ids: Array.from(selectedEmployees),
                status: status
            })
        });

        const data = await response.json();

        if (data.success) {
            showNotification('success', data.message);
            setTimeout(() => location.reload(), 1000);
        } else {
            showNotification('error', data.message);
        }
    } catch (error) {
        showNotification('error', 'เกิดข้อผิดพลาดในการอัปเดตสถานะ');
    }
}

async function bulkMoveToTrash() {
    try {
        const response = await fetch('/employees/bulk/trash', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                employee_ids: Array.from(selectedEmployees)
            })
        });

        const data = await response.json();

        if (data.success) {
            showNotification('success', data.message);
            setTimeout(() => location.reload(), 1000);
        } else {
            showNotification('error', data.message);
        }
    } catch (error) {
        showNotification('error', 'เกิดข้อผิดพลาดในการลบข้อมูล');
    }
}

// ==================== Password Toggle ====================
function initializePasswordToggle() {
    const toggleButtons = document.querySelectorAll('.password-toggle');
    
    toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            const input = this.previousElementSibling;
            const icon = this.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });
    });
}

// ==================== Form Validation ====================
function initializeFormValidation() {
    const forms = document.querySelectorAll('.needs-validation');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            
            form.classList.add('was-validated');
        });
    });
}

// ==================== Notification System ====================
function showNotification(type, message) {
    // Remove existing notifications
    const existingNotifications = document.querySelectorAll('.notification-toast');
    existingNotifications.forEach(notif => notif.remove());
    
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification-toast alert alert-${type}`;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 300px;
        animation: slideInRight 0.3s ease;
    `;
    
    const icon = type === 'success' ? 'bi-check-circle' : 'bi-exclamation-circle';
    notification.innerHTML = `
        <i class="bi ${icon} me-2"></i>
        <span>${message}</span>
    `;
    
    document.body.appendChild(notification);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// ==================== Confirmation Dialog ====================
async function showConfirmDialog(title, message, type = 'warning') {
    return new Promise((resolve) => {
        // Remove existing modals
        const existingModals = document.querySelectorAll('.confirm-modal');
        existingModals.forEach(modal => modal.remove());
        
        // Create modal
        const modal = document.createElement('div');
        modal.className = 'confirm-modal';
        modal.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10000;
            animation: fadeIn 0.3s ease;
        `;
        
        const typeColors = {
            danger: '#ef4444',
            warning: '#f59e0b',
            info: '#3b82f6'
        };
        
        modal.innerHTML = `
            <div class="modal-content" style="
                background: white;
                border-radius: 1rem;
                padding: 2rem;
                max-width: 500px;
                width: 90%;
                box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
                animation: slideUp 0.3s ease;
            ">
                <h3 style="color: ${typeColors[type]}; margin-bottom: 1rem;">
                    <i class="bi bi-exclamation-triangle me-2"></i>${title}
                </h3>
                <p style="margin-bottom: 2rem;">${message}</p>
                <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                    <button class="btn btn-secondary cancel-btn">ยกเลิก</button>
                    <button class="btn btn-${type === 'danger' ? 'danger' : 'primary'} confirm-btn">ยืนยัน</button>
                </div>
            </div>
        `;
        
        document.body.appendChild(modal);
        
        // Event listeners
        const confirmBtn = modal.querySelector('.confirm-btn');
        const cancelBtn = modal.querySelector('.cancel-btn');
        
        confirmBtn.addEventListener('click', () => {
            modal.remove();
            resolve(true);
        });
        
        cancelBtn.addEventListener('click', () => {
            modal.remove();
            resolve(false);
        });
        
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.remove();
                resolve(false);
            }
        });
    });
}

// ==================== Select Dialog ====================
async function showSelectDialog(title, message, options) {
    return new Promise((resolve) => {
        const modal = document.createElement('div');
        modal.className = 'confirm-modal';
        modal.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10000;
            animation: fadeIn 0.3s ease;
        `;
        
        const optionsHtml = options.map(opt => 
            `<option value="${opt.value}">${opt.label}</option>`
        ).join('');
        
        modal.innerHTML = `
            <div class="modal-content" style="
                background: white;
                border-radius: 1rem;
                padding: 2rem;
                max-width: 500px;
                width: 90%;
                box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
                animation: slideUp 0.3s ease;
            ">
                <h3 style="margin-bottom: 1rem;">${title}</h3>
                <p style="margin-bottom: 1rem;">${message}</p>
                <select class="form-select mb-3" id="select-option">
                    <option value="">-- เลือก --</option>
                    ${optionsHtml}
                </select>
                <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                    <button class="btn btn-secondary cancel-btn">ยกเลิก</button>
                    <button class="btn btn-primary confirm-btn">ยืนยัน</button>
                </div>
            </div>
        `;
        
        document.body.appendChild(modal);
        
        const confirmBtn = modal.querySelector('.confirm-btn');
        const cancelBtn = modal.querySelector('.cancel-btn');
        const select = modal.querySelector('#select-option');
        
        confirmBtn.addEventListener('click', () => {
            const value = select.value;
            modal.remove();
            resolve(value || null);
        });
        
        cancelBtn.addEventListener('click', () => {
            modal.remove();
            resolve(null);
        });
        
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.remove();
                resolve(null);
            }
        });
    });
}

// ==================== Utility Functions ====================
function formatDate(dateString) {
    if (!dateString) return '-';
    const date = new Date(dateString);
    return date.toLocaleDateString('th-TH', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
}

function formatCurrency(amount) {
    if (!amount) return '-';
    return new Intl.NumberFormat('th-TH', {
        style: 'currency',
        currency: 'THB'
    }).format(amount);
}

// Export functions for use in other scripts
window.employeeManagement = {
    showNotification,
    showConfirmDialog,
    showSelectDialog,
    formatDate,
    formatCurrency
};'ยืนยันการลบ',
                `คุณต้องการลบพนักงาน "${employeeName}" ใช่หรือไม่?<br><small class="text-muted">ข้อมูลจะถูกย้ายไปยังถังขยะ</small>`,
                'danger'
            );
            
            if (confirmed) {
                try {
                    const response = await fetch(`/employees/${employeeId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });

                    const data = await response.json();

                    if (data.success) {
                        showNotification('success', data.message);
                        // Remove row with animation
                        const row = this.closest('tr');
                        row.style.opacity = '0';
                        setTimeout(() => row.remove(), 300);
                    } else {
                        showNotification('error', data.message);
                    }
                } catch (error) {
                    showNotification('error', 'เกิดข้อผิดพลาดในการลบข้อมูล');
                }
            }
        });
    });
}

// ==================== Photo Upload ====================
function initializePhotoUpload() {
    const photoInput = document.getElementById('photo-input');
    const photoPreview = document.getElementById('photo-preview');
    const uploadBtn = document.getElementById('upload-photo-btn');
    const deleteBtn = document.getElementById('delete-photo-btn');
    
    if (photoInput && photoPreview) {
        photoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validate file
                if (!file.type.match('image.*')) {
                    showNotification('error', 'กรุณาเลือกไฟล์รูปภาพเท่านั้น');
                    return;
                }
                
                if (file.size > 2 * 1024 * 1024) {
                    showNotification('error', 'ขนาดไฟล์ต้องไม่เกิน 2MB');
                    return;
                }
                
                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    photoPreview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
                };
                reader.readAsDataURL(file);
            }
        });
    }
    
    if (uploadBtn) {
        uploadBtn.addEventListener('click', function() {
            photoInput?.click();
        });
    }
    
    if (deleteBtn) {
        deleteBtn.addEventListener('click', async function() {
            const confirmed = await showConfirmDialog(
                'ยืนยันการลบรูปภาพ',
                'คุณต้องการลบรูปภาพพนักงานใช่หรือไม่?'
            );
            
            if (confirmed) {
                const employeeId = this.dataset.employeeId;
                
                try {
                    const response = await fetch(`/employees/${employeeId}/photo`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });

                    const data = await response.json();

                    if (data.success) {
                        showNotification('success', data.message);
                        photoPreview.innerHTML = '<div class="photo-preview-placeholder"><i class="bi bi-person"></i></div>';
                    } else {
                        showNotification('error', data.message);
                    }
                } catch (error) {
                    showNotification('error', 'เกิดข้อผิดพลาดในการลบรูปภาพ');
                }
            }
        });
    }
}

// ==================== Filter Functions ====================
function initializeFilters() {
    const filterForm = document.getElementById('filter-form');
    const resetFilterBtn = document.getElementById('reset-filter-btn');
    
    if (resetFilterBtn) {
        resetFilterBtn.addEventListener('click', function() {
            if (filterForm) {
                filterForm.reset();
                filterForm.submit();
            }
        });
    }
}

// ==================== Bulk Actions ====================
function initializeBulkActions() {
    // Bulk status update
    const bulkStatusBtn = document.getElementById('bulk-status-btn');
    if (bulkStatusBtn) {
        bulkStatusBtn.addEventListener('click', async function() {
            const status = await showSelectDialog(
                'เปลี่ยนสถานะพนักงาน',
                'เลือกสถานะที่ต้องการ',
                [
                    { value: 'active', label: 'ใช้งาน' },
                    { value: 'inactive', label: 'ไม่ใช้งาน' }
                ]
            );
            
            if (status) {
                await bulkUpdateStatus(status);
            }
        });
    }
    
    // Bulk delete
    const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
    if (bulkDeleteBtn) {
        bulkDeleteBtn.addEventListener('click', async function() {
            const confirmed = await showConfirmDialog(