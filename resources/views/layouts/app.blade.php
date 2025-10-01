<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ITMS - IT Management System')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    
    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="fas fa-laptop-code me-2"></i>
                ITMS - IT Management System
            </a>
            
            <div class="navbar-nav ms-auto">
                @auth
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle me-1"></i>
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('profile') }}">
                            <i class="fas fa-user me-2"></i>โปรไฟล์
                        </a></li>
                        <li><a class="dropdown-item" href="{{ route('password.change') }}">
                            <i class="fas fa-lock me-2"></i>เปลี่ยนรหัสผ่าน
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i>ออกจากระบบ
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            @auth
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0">
                <div class="sidebar p-3">
                    <nav class="nav flex-column">
                        @if(Auth::user()->hasAdminPrivileges())
                        <!-- Admin Menu -->
                        <div class="nav-header mb-3">
                            <h6 class="text-white-50 text-uppercase fw-bold">การจัดการ</h6>
                        </div>
                        
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                           href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i>แดชบอร์ดผู้ดูแล
                        </a>
                        
                        <a class="nav-link {{ request()->routeIs('admin.employees*') ? 'active' : '' }}" 
                           href="{{ route('admin.employees.index') }}">
                            <i class="fas fa-users me-2"></i>จัดการพนักงาน
                        </a>
                        
                        <a class="nav-link {{ request()->routeIs('admin.departments*') ? 'active' : '' }}" 
                           href="{{ route('admin.departments.index') }}">
                            <i class="fas fa-building me-2"></i>จัดการแผนก
                        </a>
                        
                        <a class="nav-link {{ request()->routeIs('admin.computers*') ? 'active' : '' }}" 
                           href="{{ route('admin.computers.index') }}">
                            <i class="fas fa-desktop me-2"></i>จัดการครุภัณฑ์
                        </a>
                        
                        <a class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}" 
                           href="{{ route('admin.users.index') }}">
                            <i class="fas fa-user-cog me-2"></i>จัดการผู้ใช้งาน
                        </a>

                        <hr class="my-3">
                        @endif
                        
                        <!-- User Menu -->
                        <div class="nav-header mb-3">
                            <h6 class="text-white-50 text-uppercase fw-bold">เมนูหลัก</h6>
                        </div>
                        
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" 
                           href="{{ route('dashboard') }}">
                            <i class="fas fa-home me-2"></i>หน้าหลัก
                        </a>
                    </nav>
                </div>
            </div>
            @endauth
            
            <!-- Main Content -->
            <div class="@auth col-md-9 col-lg-10 @else col-12 @endauth">
                @if(isset($page_header))
                <div class="page-header">
                    <div class="container">
                        <h1 class="mb-0">{{ $page_header }}</h1>
                        @isset($page_description)
                        <p class="mb-0 opacity-75">{{ $page_description }}</p>
                        @endisset
                    </div>
                </div>
                @endif
                
                <div class="container-fluid py-4">
                    <!-- Flash Messages -->
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif
                    
                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif
                    
                    @if(session('message'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="fas fa-info-circle me-2"></i>
                        {{ session('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif
                    
                    @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>เกิดข้อผิดพลาด:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif
                    
                    <!-- Page Content -->
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script src="{{ asset('assets/js/app.js') }}"></script>
    
    @stack('scripts')
</body>
</html>