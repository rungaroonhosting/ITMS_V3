<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ส่งลิงก์สำเร็จ - ITMS</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('assets/css/app.css') }}?v={{ time() }}" rel="stylesheet">
    <link href="{{ asset('assets/css/login.css') }}?v={{ time() }}" rel="stylesheet">
</head>
<body class="login-page">
    <div class="decoration-plus plus-1">+</div>
    <div class="decoration-plus plus-2">+</div>
    <div class="decoration-plus plus-3">+</div>
    <div class="decoration-plus plus-4">+</div>
    
    <div class="geometric-decoration circle-1"></div>
    <div class="geometric-decoration circle-2"></div>
    <div class="geometric-decoration triangle-1"></div>
    <div class="geometric-decoration square-1"></div>
    
    <div class="starfield">
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
    </div>

    <div class="login-container">
        <div class="login-left">
            <h1 class="service-title">ส่งลิงก์สำเร็จ</h1>
            <p class="service-subtitle">EMAIL SENT SUCCESSFULLY</p>
            <p class="service-description">
                เราได้ส่งลิงก์สำหรับรีเซ็ตรหัสผ่านไปยังอีเมลของคุณแล้ว<br>
                กรุณาตรวจสอบอีเมลและคลิกลิงก์เพื่อตั้งรหัสผ่านใหม่
            </p>
        </div>

        <div class="character-illustration"></div>

        <div class="login-card">
            <div class="card-header">
                <div class="company-logo">
                    &lt;RWD&gt; RWebDesign<br>
                    <small>www.rwd1989.com</small>
                </div>
                <h2 class="form-title">
                    <i class="fas fa-check-circle" style="color: #10b981;"></i>
                    ส่งลิงก์สำเร็จ
                </h2>
            </div>

            <div class="alert alert-success" style="border-left: 4px solid #10b981; background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(16, 185, 129, 0.05)); border-radius: 0.75rem; padding: 1rem; margin-bottom: 1.5rem;">
                <i class="fas fa-envelope-open-text me-2"></i>
                <strong>เราได้ส่งลิงก์รีเซ็ตรหัสผ่านไปแล้ว</strong>
            </div>

            <div style="background: linear-gradient(135deg, rgba(102, 126, 234, 0.05), rgba(118, 75, 162, 0.05)); border-radius: 1rem; padding: 1.5rem; margin-bottom: 1.5rem;">
                <h6 style="font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 1rem;">
                    <i class="fas fa-info-circle me-2" style="color: #667eea;"></i>
                    ขั้นตอนต่อไป
                </h6>
                <ol style="font-size: 0.875rem; color: #6b7280; margin: 0; padding-left: 1.25rem; line-height: 1.8;">
                    <li>ตรวจสอบกล่องจดหมายของคุณ</li>
                    <li>คลิกลิงก์ในอีเมล (ลิงก์จะใช้งานได้ 60 นาที)</li>
                    <li>ตั้งรหัสผ่านใหม่</li>
                    <li>เข้าสู่ระบบด้วยรหัสผ่านใหม่</li>
                </ol>
            </div>

            <div style="background: linear-gradient(135deg, rgba(245, 158, 11, 0.1), rgba(245, 158, 11, 0.05)); border-radius: 1rem; padding: 1rem; margin-bottom: 1.5rem; border-left: 4px solid #f59e0b;">
                <p style="font-size: 0.8rem; color: #92400e; margin: 0;">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>ไม่ได้รับอีเมล?</strong> ลองตรวจสอบในโฟลเดอร์ Spam หรือ Junk
                </p>
            </div>

            <div class="demo-section">
                <div class="demo-title">ต้องการความช่วยเหลือ?</div>
                <div style="text-align: center; margin-top: 0.75rem;">
                    <a href="{{ route('password.request') }}" class="company-link" style="display: inline-block; margin-bottom: 0.5rem;">
                        <i class="fas fa-redo me-1"></i> ส่งลิงก์อีกครั้ง
                    </a>
                    <br>
                    <a href="{{ route('login') }}" class="company-link">
                        <i class="fas fa-arrow-left me-1"></i> กลับไปหน้าเข้าสู่ระบบ
                    </a>
                </div>
            </div>

            <div class="card-footer">
                <div class="footer-text">© 2025 IT Management System</div>
                <div class="footer-text">
                    System by <a href="#" class="company-link">Rungaroon Solution</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/app.js') }}?v={{ time() }}"></script>
</body>
</html>