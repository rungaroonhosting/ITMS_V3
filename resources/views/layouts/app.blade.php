<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ITMS - IT Management System')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    
    @stack('styles')
</head>
<body>
<!-- Top Navbar - Fixed -->
<nav class="navbar-top">
    <div class="container-fluid">
        <div class="navbar-left">
            <!-- Logo in Navbar -->
            <div class="navbar-logo-box">
                <div class="navbar-logo">
                    <i class="fas fa-laptop-code"></i>
                    <div class="logo-text">
                        <h4>ITMS</h4>
                        <p>IT Management System</p>
                    </div>
                </div>
            </div>
            
            <button class="menu-toggle" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
            
            <div class="breadcrumb-nav">
                <a href="{{ route('dashboard') }}" class="breadcrumb-link">หน้าหลัก</a>
                <span class="breadcrumb-separator">/</span>
                <span class="breadcrumb-current">Dashboard</span>
            </div>
        </div>
        
        <div class="navbar-right">
            <span class="navbar-date">ศุกร์, 03 ตุลาคม 2025</span>
            <span class="navbar-badge">SUPER ADMIN</span>
            
            @auth
            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="fas fa-bell"></i>
                    แจ้งเตือน
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
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

    <div class="layout-wrapper">
        @auth
        <!-- Sidebar with Logo -->
        <aside class="sidebar" id="sidebar"> 
            <div class="sidebar-content">
                <div class="sidebar-section">
                    <a class="sidebar-link active" href="{{ route('dashboard') }}">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </div>
                
                @if(Auth::user()->isSuperAdmin() || Auth::user()->isItAdmin())
                <div class="sidebar-section">
                    <h6 class="sidebar-title">จัดการบุคลากร</h6>
                    <a class="sidebar-link" href="{{ route('employees.index') }}">
                        <i class="fas fa-users"></i>
                        <span>จัดการพนักงาน</span>
                    </a>
                    <a class="sidebar-link" href="#">
                        <i class="fas fa-building"></i>
                        <span>จัดการสาขา</span>
                        <span class="badge-new">NEW</span>
                    </a>
                    <a class="sidebar-link" href="#">
                        <i class="fas fa-sitemap"></i>
                        <span>จัดการแผนก</span>
                    </a>
                </div>
                
                <div class="sidebar-section">
                    <h6 class="sidebar-title">จัดการ IT</h6>
                    <a class="sidebar-link" href="#">
                        <i class="fas fa-desktop"></i>
                        <span>จัดการอุปกรณ์ IT</span>
                    </a>
                    <a class="sidebar-link" href="#">
                        <i class="fas fa-clipboard-list"></i>
                        <span>จัดการข้อตกลง IT</span>
                    </a>
                    <a class="sidebar-link" href="#">
                        <i class="fas fa-tools"></i>
                        <span>จัดการแจ้งซ่อม</span>
                    </a>
                    <a class="sidebar-link" href="#">
                        <i class="fas fa-archive"></i>
                        <span>จัดการคำขอบริการ</span>
                    </a>
                    <a class="sidebar-link" href="#">
                        <i class="fas fa-list-alt"></i>
                        <span>รายงานทั้งหมด</span>
                    </a>
                </div>
                
                <div class="sidebar-section">
                    <h6 class="sidebar-title">เพิ่มข้อมูล</h6>
                    <a class="sidebar-link" href="{{ route('employees.create') }}">
                        <i class="fas fa-user-plus"></i>
                        <span>เพิ่มพนักงาน</span>
                    </a>
                    <a class="sidebar-link" href="#">
                        <i class="fas fa-building"></i>
                        <span>เพิ่มสาขา</span>
                        <span class="badge-new">NEW</span>
                    </a>
                    <a class="sidebar-link" href="#">
                        <i class="fas fa-sitemap"></i>
                        <span>เพิ่มแผนก</span>
                    </a>
                </div>
                
                <div class="sidebar-section">
                    <h6 class="sidebar-title">ระบบการตั้งค่า</h6>
                    <a class="sidebar-link" href="#">
                        <i class="fas fa-list"></i>
                        <span>รายการย่อยทั้งหมด</span>
                    </a>
                    <a class="sidebar-link" href="#">
                        <i class="fas fa-plus-circle"></i>
                        <span>เพิ่มข้อมูล</span>
                    </a>
                    <a class="sidebar-link" href="#">
                        <i class="fas fa-download"></i>
                        <span>ส่งออกข้อมูล</span>
                    </a>
                    <a class="sidebar-link" href="#">
                        <i class="fas fa-cog"></i>
                        <span>ตั้งค่าระบบ</span>
                    </a>
                </div>
                @endif
            </div>
        </aside>
        @endauth
        
        <!-- Main Content -->
        <main class="main-content" id="mainContent">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    
    <script>
    document.getElementById('sidebarToggle')?.addEventListener('click', function() {
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        
        sidebar?.classList.toggle('sidebar-collapsed');
        mainContent?.classList.toggle('content-expanded');
    });
    </script>
    
    @stack('scripts')
    
</body>
</html>