@extends('layouts.app')

@section('title', 'แดชบอร์ด - ITMS')

@section('content')
<div class="container-fluid">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body text-white p-4">
                    <div class="row align-items-center">
                        <div class="col">
                            <h2 class="mb-1">สวัสดี, {{ Auth::user()->name }}!</h2>
                            <p class="mb-0 opacity-75">
                                ยินดีต้อนรับสู่ระบบ IT Management System
                                @if(Auth::user()->hasAdminPrivileges())
                                    <span class="badge bg-warning text-dark ms-2">{{ Auth::user()->role == 'super_admin' ? 'Super Admin' : 'IT Admin' }}</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-circle fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 h-100">
                <div class="card-body text-center">
                    <div class="text-primary mb-3">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                    <h3 class="fw-bold text-primary">{{ $stats['total_users'] ?? 0 }}</h3>
                    <p class="text-muted mb-0">ผู้ใช้งานทั้งหมด</p>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 h-100">
                <div class="card-body text-center">
                    <div class="text-success mb-3">
                        <i class="fas fa-user-tie fa-2x"></i>
                    </div>
                    <h3 class="fw-bold text-success">{{ $stats['total_employees'] ?? 0 }}</h3>
                    <p class="text-muted mb-0">พนักงานทั้งหมด</p>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 h-100">
                <div class="card-body text-center">
                    <div class="text-info mb-3">
                        <i class="fas fa-desktop fa-2x"></i>
                    </div>
                    <h3 class="fw-bold text-info">{{ $stats['total_computers'] ?? 0 }}</h3>
                    <p class="text-muted mb-0">ครุภัณฑ์ทั้งหมด</p>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 h-100">
                <div class="card-body text-center">
                    <div class="text-warning mb-3">
                        <i class="fas fa-building fa-2x"></i>
                    </div>
                    <h3 class="fw-bold text-warning">{{ $stats['total_departments'] ?? 0 }}</h3>
                    <p class="text-muted mb-0">แผนกทั้งหมด</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-bolt me-2 text-primary"></i>
                        การดำเนินการด่วน
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if(Auth::user()->hasAdminPrivileges())
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('admin.employees.index') }}" class="text-decoration-none">
                                <div class="card border-0 bg-light h-100 hover-card">
                                    <div class="card-body text-center">
                                        <i class="fas fa-user-plus fa-2x text-primary mb-3"></i>
                                        <h6 class="fw-bold">จัดการพนักงาน</h6>
                                        <p class="text-muted small mb-0">เพิ่ม แก้ไข ข้อมูลพนักงาน</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('admin.computers.index') }}" class="text-decoration-none">
                                <div class="card border-0 bg-light h-100 hover-card">
                                    <div class="card-body text-center">
                                        <i class="fas fa-desktop fa-2x text-success mb-3"></i>
                                        <h6 class="fw-bold">จัดการครุภัณฑ์</h6>
                                        <p class="text-muted small mb-0">เพิ่มครุภัณฑ์ใหม่ สร้าง QR Code</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('admin.departments.index') }}" class="text-decoration-none">
                                <div class="card border-0 bg-light h-100 hover-card">
                                    <div class="card-body text-center">
                                        <i class="fas fa-building fa-2x text-info mb-3"></i>
                                        <h6 class="fw-bold">จัดการแผนก</h6>
                                        <p class="text-muted small mb-0">จัดการแผนกงาน</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('admin.users.index') }}" class="text-decoration-none">
                                <div class="card border-0 bg-light h-100 hover-card">
                                    <div class="card-body text-center">
                                        <i class="fas fa-user-cog fa-2x text-warning mb-3"></i>
                                        <h6 class="fw-bold">จัดการผู้ใช้งาน</h6>
                                        <p class="text-muted small mb-0">จัดการสิทธิ์ผู้ใช้งาน</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @else
                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="card border-0 bg-light h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-tools fa-2x text-primary mb-3"></i>
                                    <h6 class="fw-bold">แจ้งซ่อม</h6>
                                    <p class="text-muted small mb-0">แจ้งปัญหาครุภัณฑ์</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="card border-0 bg-light h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-clipboard-list fa-2x text-success mb-3"></i>
                                    <h6 class="fw-bold">ขอใช้บริการ</h6>
                                    <p class="text-muted small mb-0">ขอใช้บริการ IT</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="card border-0 bg-light h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-file-contract fa-2x text-info mb-3"></i>
                                    <h6 class="fw-bold">ข้อตกลง IT</h6>
                                    <p class="text-muted small mb-0">ดูข้อตกลงการใช้งาน</p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card border-0">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-clock me-2 text-primary"></i>
                        กิจกรรมล่าสุด
                    </h5>
                </div>
                <div class="card-body">
                    @if(empty($recent_activities))
                    <div class="text-center py-4">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <h6 class="text-muted">ยังไม่มีกิจกรรมล่าสุด</h6>
                        <p class="text-muted small">กิจกรรมจะแสดงที่นี่เมื่อมีการใช้งานระบบ</p>
                    </div>
                    @else
                    <!-- Activities will be shown here -->
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card border-0">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-user me-2 text-primary"></i>
                        ข้อมูลส่วนตัว
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <i class="fas fa-user-circle fa-4x text-muted"></i>
                    </div>
                    
                    <table class="table table-borderless table-sm">
                        <tr>
                            <td class="text-muted">ชื่อ:</td>
                            <td class="fw-medium">{{ Auth::user()->name }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">อีเมล:</td>
                            <td class="fw-medium">{{ Auth::user()->email }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">บทบาท:</td>
                            <td>
                                @if(Auth::user()->role == 'super_admin')
                                    <span class="badge bg-danger">Super Admin</span>
                                @elseif(Auth::user()->role == 'it_admin')
                                    <span class="badge bg-warning">IT Admin</span>
                                @else
                                    <span class="badge bg-secondary">Employee</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">เข้าระบบล่าสุด:</td>
                            <td class="fw-medium">
                                {{ Auth::user()->last_login_at ? Auth::user()->last_login_at->format('d/m/Y H:i') : 'ไม่ระบุ' }}
                            </td>
                        </tr>
                    </table>

                    <div class="d-grid gap-2 mt-3">
                        <a href="{{ route('profile') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-edit me-1"></i>แก้ไขโปรไฟล์
                        </a>
                        <a href="{{ route('password.change') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-lock me-1"></i>เปลี่ยนรหัสผ่าน
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hover-card {
    transition: all 0.3s ease;
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}
</style>
@endsection
