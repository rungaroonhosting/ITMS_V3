<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>รีเซ็ตรหัสผ่าน - ITMS</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="{{ asset('assets/css/app.css') }}?v={{ time() }}" rel="stylesheet">
    <link href="{{ asset('assets/css/login.css') }}?v={{ time() }}" rel="stylesheet">
</head>
<body class="login-page">
    <!-- Background decorations -->
    <div class="decoration-plus plus-1">+</div>
    <div class="decoration-plus plus-2">+</div>
    <div class="decoration-plus plus-3">+</div>
    <div class="decoration-plus plus-4">+</div>
    
    <!-- Geometric decorations -->
    <div class="geometric-decoration circle-1"></div>
    <div class="geometric-decoration circle-2"></div>
    <div class="geometric-decoration triangle-1"></div>
    <div class="geometric-decoration square-1"></div>
    
    <!-- Starfield effect -->
    <div class="starfield">
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
        <div class="star"></div>
    </div>

    <div class="login-container">
        <!-- Left content section -->
        <div class="login-left">
            <h1 class="service-title">รีเซ็ตรหัสผ่าน</h1>
            <p class="service-subtitle">PASSWORD RESET</p>
            <p class="service-description">
                กรุณากรอกอีเมลของคุณ<br>
                เราจะส่งลิงก์สำหรับรีเซ็ตรหัสผ่านไปให้คุณ
            </p>
        </div>

        <!-- Character illustration -->
        <div class="character-illustration"></div>

        <!-- Reset Password form card -->
        <div class="login-card">
            <div class="card-header">
                <div class="company-logo">
                    &lt;RWD&gt; RWebDesign<br>
                    <small>www.rwd1989.com</small>
                </div>
                <h2 class="form-title">ลืมรหัสผ่าน?</h2>
            </div>

            <!-- Flash Messages -->
            @if(session('status'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('status') }}
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle me-2"></i>
                @foreach($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
            @endif

            <!-- Reset Password Form -->
            <form method="POST" action="{{ route('password.email') }}" class="login-form">
                @csrf
                
                <!-- Email Field -->
                <div class="form-group">
                    <label for="email" class="form-label">อีเมล</label>
                    <input type="email" 
                           class="form-input @error('email') is-invalid @enderror" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}"
                           placeholder="example@company.com"
                           required 
                           autofocus>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="login-button">
                    <i class="fas fa-paper-plane me-2"></i>
                    ส่งลิงก์รีเซ็ตรหัสผ่าน
                </button>
            </form>

            <!-- Back to Login -->
            <div class="demo-section">
                <div class="demo-title">จำรหัสผ่านได้แล้ว?</div>
                <div style="text-align: center; margin-top: 0.5rem;">
                    <a href="{{ route('login') }}" class="company-link">
                        <i class="fas fa-arrow-left me-1"></i> กลับไปหน้าเข้าสู่ระบบ
                    </a>
                </div>
            </div>

            <!-- Footer -->
            <div class="card-footer">
                <div class="footer-text">© 2025 IT Management System</div>
                <div class="footer-text">
                    System by <a href="#" class="company-link">Rungaroon Solution</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/app.js') }}?v={{ time() }}"></script>
    
    <script>
        // Form handling
        document.addEventListener('DOMContentLoaded', function() {
            const resetForm = document.querySelector('.login-form');
            const submitButton = document.querySelector('.login-button');
            
            resetForm.addEventListener('submit', function() {
                submitButton.classList.add('loading');
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>กำลังส่ง...';
            });
        });
    </script>
</body>
</html>