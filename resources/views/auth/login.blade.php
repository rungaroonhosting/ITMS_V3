<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>เข้าสู่ระบบ - ITMS</title>
    
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
            <h1 class="service-title">บริการออนไลน์</h1>
            <p class="service-subtitle">PROFESSIONAL IT MANAGEMENT SOLUTIONS</p>
            <p class="service-description">
                ให้คุณจัดการเรื่องต่าง ๆ ด้วยตัวคุณเอง ตลอด 24 ชั่วโมง<br>
                ระบบจัดการ IT ที่ครอบคลุมและใช้งานง่าย
            </p>
        </div>

        <!-- Character illustration (placeholder for now) -->
        <div class="character-illustration">
        </div>

        <!-- Login form card -->
        <div class="login-card">
            <div class="card-header">
                <div class="company-logo">
                    &lt;RWD&gt; RWebDesign<br>
                    <small>www.rwd1989.com</small>
                </div>
                <h2 class="form-title">เข้าสู่ระบบ</h2>
            </div>

            <!-- Flash Messages -->
            @if(session('message'))
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                {{ session('message') }}
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

            <!-- Login Form -->
            <form method="POST" action="{{ route('auth.login') }}" class="login-form">
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

                <!-- Password Field -->
                <div class="form-group">
                    <label for="password" class="form-label">รหัสผ่าน</label>
                    <div class="password-container">
                        <input type="password" 
                               class="form-input @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password" 
                               placeholder="รหัสผ่าน"
                               required>
                        <button type="button" class="password-toggle" onclick="togglePassword()">
                            <i class="fas fa-eye" id="password-icon"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="checkbox-group">
                    <div class="checkbox-container">
                        <input type="checkbox" id="remember" name="remember" class="checkbox-input">
                        <label for="remember" class="checkbox-label">จดจำการเข้าสู่ระบบ</label>
                    </div>
                    <a href="{{ route('password.request') }}" class="forgot-password">ลืมรหัสผ่าน?</a>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="login-button">
                    เข้าสู่ระบบ
                </button>
            </form>

            <!-- Demo Credentials -->
            <div class="demo-section">
                <div class="demo-title">ข้อมูลทดสอบ</div>
                <div class="demo-credentials">
                    <strong>Super Admin:</strong>
                    <code>wittaya.j@better-groups.com</code><br>
                    <code>Admin@123</code>
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
    <script src="{{ asset('assets/js/app.js') }}"></script>
    
    <script>
        // Toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const passwordIcon = document.getElementById('password-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
            }
        }

        // Login form handling
        document.addEventListener('DOMContentLoaded', function() {
            const loginForm = document.querySelector('.login-form');
            const submitButton = document.querySelector('.login-button');
            
            loginForm.addEventListener('submit', function() {
                submitButton.classList.add('loading');
                submitButton.disabled = true;
            });

            // Auto-fill demo credentials
            const demoCredentials = document.querySelector('.demo-credentials code');
            if (demoCredentials) {
                demoCredentials.addEventListener('click', function() {
                    if (this.textContent === 'wittaya.j@better-groups.com') {
                        document.getElementById('email').value = this.textContent;
                    }
                    if (this.textContent === 'Admin@123') {
                        document.getElementById('password').value = this.textContent;
                    }
                });
            }
        });
    </script>
</body>
</html>