// Dashboard JavaScript
document.addEventListener('DOMContentLoaded', function() {
    
    // Initialize Chart
    initEmployeeChart();
    
    // Animate stats on load
    animateStats();
    
    // Add smooth scroll behavior
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });
});

// Initialize Employee Chart
function initEmployeeChart() {
    const ctx = document.getElementById('employeeChart');
    
    if (!ctx) return;
    
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['พนักงานทั้งหมด', 'แผนก', 'สาขา', 'ผู้ใช้งาน'],
            datasets: [{
                label: 'จำนวน',
                data: [4, 9, 8, 1],
                backgroundColor: [
                    'rgba(102, 126, 234, 0.8)',
                    'rgba(17, 153, 142, 0.8)',
                    'rgba(240, 147, 251, 0.8)',
                    'rgba(79, 172, 254, 0.8)'
                ],
                borderColor: [
                    'rgba(102, 126, 234, 1)',
                    'rgba(17, 153, 142, 1)',
                    'rgba(240, 147, 251, 1)',
                    'rgba(79, 172, 254, 1)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        font: {
                            size: 12,
                            family: "'Sarabun', sans-serif"
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleFont: {
                        size: 14,
                        family: "'Sarabun', sans-serif"
                    },
                    bodyFont: {
                        size: 13,
                        family: "'Sarabun', sans-serif"
                    },
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += context.parsed + ' รายการ';
                            return label;
                        }
                    }
                }
            },
            animation: {
                animateScale: true,
                animateRotate: true,
                duration: 1500,
                easing: 'easeInOutQuart'
            }
        }
    });
}

// Animate Statistics Numbers
function animateStats() {
    const statNumbers = document.querySelectorAll('.stat-number');
    
    statNumbers.forEach(stat => {
        const finalValue = parseInt(stat.textContent);
        let currentValue = 0;
        const increment = Math.ceil(finalValue / 50);
        const duration = 1500;
        const stepTime = duration / 50;
        
        const counter = setInterval(() => {
            currentValue += increment;
            
            if (currentValue >= finalValue) {
                stat.textContent = finalValue;
                clearInterval(counter);
            } else {
                stat.textContent = currentValue;
            }
        }, stepTime);
    });
}

// Real-time Clock (Optional)
function updateClock() {
    const now = new Date();
    const options = { 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
    };
    const dateTimeString = now.toLocaleDateString('th-TH', options);
    
    const clockElement = document.getElementById('real-time-clock');
    if (clockElement) {
        clockElement.textContent = dateTimeString;
    }
}

// Update clock every second
setInterval(updateClock, 1000);
updateClock();

// Add loading state to action cards
document.querySelectorAll('.action-card').forEach(card => {
    card.addEventListener('click', function(e) {
        // Add loading animation
        const icon = this.querySelector('.action-icon i');
        if (icon) {
            icon.classList.add('fa-spin');
            
            // Remove spin after 1 second
            setTimeout(() => {
                icon.classList.remove('fa-spin');
            }, 1000);
        }
    });
});

// Progress bar animation
function animateProgressBars() {
    const progressBars = document.querySelectorAll('.stat-progress');
    
    progressBars.forEach((bar, index) => {
        setTimeout(() => {
            const width = bar.style.width;
            bar.style.width = '0%';
            setTimeout(() => {
                bar.style.width = width;
            }, 100);
        }, index * 200);
    });
}

// Call on page load
animateProgressBars();

// Add ripple effect to cards
document.querySelectorAll('.stat-card, .action-card').forEach(card => {
    card.addEventListener('mousedown', function(e) {
        const ripple = document.createElement('span');
        ripple.classList.add('ripple');
        
        const rect = this.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = e.clientX - rect.left - size / 2;
        const y = e.clientY - rect.top - size / 2;
        
        ripple.style.width = ripple.style.height = size + 'px';
        ripple.style.left = x + 'px';
        ripple.style.top = y + 'px';
        
        this.appendChild(ripple);
        
        setTimeout(() => {
            ripple.remove();
        }, 600);
    });
});

// Add CSS for ripple effect
const style = document.createElement('style');
style.textContent = `
    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.5);
        transform: scale(0);
        animation: ripple-animation 0.6s ease-out;
        pointer-events: none;
    }
    
    @keyframes ripple-animation {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
    
    .stat-card, .action-card {
        position: relative;
        overflow: hidden;
    }
`;
document.head.appendChild(style);

// Refresh statistics (Optional - for real-time updates)
function refreshStatistics() {
    // You can add AJAX call here to fetch updated statistics
    console.log('Statistics refreshed');
}

// Auto-refresh every 5 minutes
setInterval(refreshStatistics, 300000);