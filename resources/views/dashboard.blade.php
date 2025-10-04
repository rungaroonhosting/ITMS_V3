@extends('layouts.app')

@section('title', 'Dashboard - ITMS')

@push('styles')
<link href="{{ asset('assets/css/dashboard.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="dashboard-container">
    <!-- Welcome Header -->
    <div class="welcome-header">
        <div class="header-icon">
            <i class="fas fa-tachometer-alt"></i>
        </div>
        <div class="header-content">
            <h1 class="header-title">Dashboard - IT Management System v2.1</h1>
        </div>
    </div>

    <!-- User Welcome Card -->
    <div class="user-welcome-card">
        <div class="welcome-content">
            <h2 class="greeting-title">ยินดีต้อนรับ, ผู้ดูแล ระบบ!</h2>
            
            <div class="user-info-grid">
                <div class="info-box">
                    <span class="info-label">บทบาท:</span>
                    <span class="info-badge role-badge">Super admin</span>
                </div>
                <div class="info-box">
                    <span class="info-label">แผนก:</span>
                    <span class="info-text">แผนกเทคโนโลยีสารสนเทศ</span>
                </div>
                <div class="info-box">
                    <span class="info-label">อีเมล:</span>
                    <span class="info-text">{{ $user->email }}</span>
                </div>
                <div class="info-box">
                    <span class="info-label">เข้าสู่ระบบเมื่อ:</span>
                    <span class="info-text">{{ $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i:s') : '03/10/2025 15:09:01' }}</span>
                </div>
                <div class="info-box">
                    <span class="info-label">รหัสพนักงาน:</span>
                    <span class="info-text">ADMIN001</span>
                </div>
            </div>
        </div>
        
        <div class="user-avatar">
            <div class="avatar-circle">
                <i class="fas fa-crown"></i>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card stat-primary">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">{{ $stats['active_employees'] }}</h3>
                <p class="stat-label">พนักงานทั้งหมด</p>
                <span class="stat-badge">ใช้งาน: {{ $stats['total_employees'] }} คน</span>
            </div>
        </div>

        <div class="stat-card stat-success">
            <div class="stat-icon">
                <i class="fas fa-building"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">{{ $stats['total_departments'] }}</h3>
                <p class="stat-label">แผนกทั้งหมด</p>
                <span class="stat-badge">มีข้อมูล {{ $stats['total_departments'] }} แผนก</span>
            </div>
        </div>

        <div class="stat-card stat-warning">
            <div class="stat-icon">
                <i class="fas fa-map-marker-alt"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">{{ $stats['total_branches'] }}</h3>
                <p class="stat-label">สาขาทั้งหมด</p>
                <span class="stat-badge">Expired: 4 แผนก</span>
            </div>
        </div>

        <div class="stat-card stat-info">
            <div class="stat-icon">
                <i class="fas fa-user-shield"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">{{ $stats['active_users'] }}</h3>
                <p class="stat-label">ผู้ใช้งาน</p>
                <span class="stat-badge">{{ round(($stats['active_users']/$stats['total_users'])*100) }}% ของทั้งหมด</span>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="section-header">
        <h2 class="section-title">
            <i class="fas fa-bolt"></i>
            การดำเนินการด่วน
        </h2>
    </div>

    <div class="quick-actions">
        <a href="{{ route('employees.create') }}" class="action-card action-primary">
            <div class="action-icon">
                <i class="fas fa-user-plus"></i>
            </div>
            <div class="action-content">
                <h4 class="action-title">จัดการพนักงาน</h4>
                <p class="action-desc">เพิ่มพนักงานใหม่ ดูสถิติ คน</p>
            </div>
        </a>

        <a href="#" class="action-card action-success">
            <div class="action-icon">
                <i class="fas fa-file-alt"></i>
            </div>
            <div class="action-content">
                <h4 class="action-title">เพิ่มใบคำขอใหม่</h4>
                <p class="action-desc">สร้างใบคำขอใหม่</p>
            </div>
        </a>

        <a href="#" class="action-card action-info">
            <div class="action-icon">
                <i class="fas fa-ticket-alt"></i>
            </div>
            <div class="action-content">
                <h4 class="action-title">จัดการขา</h4>
                <p class="action-desc">รายการแจ้งซ่อมทั้งหมด</p>
            </div>
        </a>

        <a href="#" class="action-card action-warning">
            <div class="action-icon">
                <i class="fas fa-users-cog"></i>
            </div>
            <div class="action-content">
                <h4 class="action-title">จัดการแผนก</h4>
                <p class="action-desc">เพิ่มแผนกหรือแก้ไขข้อมูล</p>
            </div>
        </a>

        <a href="#" class="action-card action-secondary">
            <div class="action-icon">
                <i class="fas fa-archive"></i>
            </div>
            <div class="action-content">
                <h4 class="action-title">ถังขยะ</h4>
                <p class="action-desc">คืนค่าข้อมูล</p>
            </div>
        </a>

        <a href="#" class="action-card action-danger">
            <div class="action-icon">
                <i class="fas fa-download"></i>
            </div>
            <div class="action-content">
                <h4 class="action-title">ส่งออกข้อมูล</h4>
                <p class="action-desc">Excel, CSV, PDF</p>
            </div>
        </a>
    </div>

    <!-- Charts and Recent Activities -->
    <div class="content-grid">
        <!-- Recent Activities -->
        <div class="activity-section">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="fas fa-history"></i>
                    กิจกรรมล่าสุด
                </h2>
            </div>

            <div class="activity-list">
                @foreach($recentActivities as $activity)
                <div class="activity-item">
                    <div class="activity-icon activity-{{ $activity['color'] }}">
                        <i class="fas {{ $activity['icon'] }}"></i>
                    </div>
                    <div class="activity-content">
                        <h4 class="activity-title">{{ $activity['title'] }}</h4>
                        <p class="activity-desc">{{ $activity['description'] }}</p>
                        <span class="activity-time">{{ $activity['time'] }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Right Sidebar with Employee Photos -->
        <div class="employee-sidebar">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="fas fa-users"></i>
                    พนักงานในทีม
                </h2>
            </div>

            <div class="employee-list">
                <div class="employee-card">
                    <div class="employee-avatar">
                        <img src="https://ui-avatars.com/api/?name=Somchai+Admin&background=667eea&color=fff&size=80" alt="Somchai">
                    </div>
                    <div class="employee-info">
                        <h4 class="employee-name">สมชาย ผู้ดูแลระบบ</h4>
                        <p class="employee-position">System Administrator</p>
                        <span class="employee-badge status-online">ออนไลน์</span>
                    </div>
                </div>

                <div class="employee-card">
                    <div class="employee-avatar">
                        <img src="https://ui-avatars.com/api/?name=Somying+IT&background=11998e&color=fff&size=80" alt="Somying">
                    </div>
                    <div class="employee-info">
                        <h4 class="employee-name">สมหญิง ไอที</h4>
                        <p class="employee-position">IT Support</p>
                        <span class="employee-badge status-online">ออนไลน์</span>
                    </div>
                </div>

                <div class="employee-card">
                    <div class="employee-avatar">
                        <img src="https://ui-avatars.com/api/?name=Somkid+Network&background=f093fb&color=fff&size=80" alt="Somkid">
                    </div>
                    <div class="employee-info">
                        <h4 class="employee-name">สมคิด เครือข่าย</h4>
                        <p class="employee-position">Network Engineer</p>
                        <span class="employee-badge status-away">ไม่อยู่</span>
                    </div>
                </div>

                <div class="employee-card">
                    <div class="employee-avatar">
                        <img src="https://ui-avatars.com/api/?name=Somsri+Dev&background=4facfe&color=fff&size=80" alt="Somsri">
                    </div>
                    <div class="employee-info">
                        <h4 class="employee-name">สมศรี นักพัฒนา</h4>
                        <p class="employee-position">Developer</p>
                        <span class="employee-badge status-offline">ออฟไลน์</span>
                    </div>
                </div>
            </div>

            <!-- User Stats -->
            <div class="user-stats">
                <h3 class="stats-title">สถิติผู้ใช้งาน</h3>
                <div class="stat-item">
                    <div class="stat-info">
                        <span class="stat-name">Super Admin</span>
                        <span class="stat-percent">25%</span>
                    </div>
                    <div class="stat-bar">
                        <div class="stat-progress" style="width: 25%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"></div>
                    </div>
                </div>

                <div class="stat-item">
                    <div class="stat-info">
                        <span class="stat-name">Employee</span>
                        <span class="stat-percent">75%</span>
                    </div>
                    <div class="stat-bar">
                        <div class="stat-progress" style="width: 75%; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);"></div>
                    </div>
                </div>

                <div class="total-users">
                    <span class="total-label">ผู้ใช้งานทั้งหมด</span>
                    <span class="total-number">{{ $stats['total_users'] }} คน</span>
                </div>
            </div>
        </div>

        <!-- Charts Section (Left) -->
        <div class="chart-section">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="fas fa-info-circle"></i>
                    ข้อมูลระบบ
                </h2>
            </div>

            <div class="info-cards">
                <div class="info-card">
                    <div class="info-card-header">
                        <span class="info-badge badge-laravel">v2.1</span>
                        <span class="info-title">Laravel</span>
                    </div>
                </div>

                <div class="info-card">
                    <div class="info-card-header">
                        <span class="info-badge badge-php">12.8.3</span>
                        <span class="info-title">PHP</span>
                    </div>
                </div>

                <div class="info-card">
                    <div class="info-card-header">
                        <span class="info-badge badge-env">8.3.6</span>
                        <span class="info-title">Environment</span>
                    </div>
                </div>

                <div class="info-card">
                    <div class="info-card-header">
                        <span class="info-badge badge-env">Local</span>
                    </div>
                    <p class="info-text">เวอร์ชันล่าสุด</p>
                </div>

                <div class="info-card">
                    <div class="info-card-header">
                        <span class="info-title">เซิร์ฟเวอร์ล่าสุด</span>
                    </div>
                    <p class="info-text">{{ now()->format('d/m/Y H:i:s') }}</p>
                </div>

                <div class="info-card">
                    <div class="info-card-header">
                        <span class="info-title">สถานะการเชื่อมต่อ</span>
                    </div>
                    <span class="status-badge status-success">ใช้งานได้ปกติต่อเนื่อง</span>
                </div>
            </div>

            <!-- Chart Placeholder -->
            <div class="chart-container">
                <canvas id="employeeChart"></canvas>
            </div>

            <!-- Development Tools -->
            <div class="dev-tools">
                <p class="dev-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    Development Tools
                </p>
                <a href="#" class="health-check-btn">
                    <i class="fas fa-heartbeat"></i>
                    Health Check
                </a>
            </div>
        </div>
    </div>

    <!-- System Status -->
    <div class="section-header">
        <h2 class="section-title">
            <i class="fas fa-server"></i>
            สถานะระบบ Express
        </h2>
    </div>

    <div class="system-status">
        <div class="status-item">
            <div class="status-number">{{ $stats['total_employees'] }}</div>
            <div class="status-label">แผนกมั้งมั้ง Express</div>
        </div>
        <div class="status-item">
            <div class="status-number">{{ $stats['total_departments'] }}</div>
            <div class="status-label">ผู้ใช้ Express</div>
        </div>
        <div class="status-item">
            <div class="status-number">{{ round(($stats['active_users']/$stats['total_users'])*100, 1) }}%</div>
            <div class="status-label">แผนกที่ใช้งาน</div>
        </div>
        <div class="status-item">
            <div class="status-number">50%</div>
            <div class="status-label">พนักงานใน Express</div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('assets/js/dashboard.js') }}"></script>
@endpush