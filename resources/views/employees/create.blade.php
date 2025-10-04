@extends('layouts.app')

@section('title', 'เพิ่มพนักงานใหม่')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/employees.css') }}">
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-1">
                        <i class="bi bi-person-plus-fill me-2"></i>เพิ่มพนักงานใหม่
                    </h2>
                    <p class="text-muted mb-0">กรอกข้อมูลพนักงานใหม่</p>
                </div>
                <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>กลับ
                </a>
            </div>

            <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data" id="employeeForm">
                @csrf

                <!-- Basic Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-person me-2"></i>ข้อมูลพื้นฐาน</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <!-- Photo Upload -->
                            <div class="col-12 text-center">
                                <div class="photo-upload-container">
                                    <div class="photo-preview" id="photoPreview">
                                        <i class="bi bi-person-circle"></i>
                                    </div>
                                    <input type="file" name="photo" id="photoInput" accept="image/*" class="d-none">
                                    <button type="button" class="btn btn-sm btn-primary mt-2" onclick="document.getElementById('photoInput').click()">
                                        <i class="bi bi-upload me-2"></i>อัปโหลดรูปภาพ
                                    </button>
                                    <p class="text-muted small mt-2 mb-0">JPEG, JPG, PNG, GIF (สูงสุด 2MB)</p>
                                </div>
                            </div>

                            <!-- Employee Code -->
                            <div class="col-md-4">
                                <label class="form-label required">รหัสพนักงาน</label>
                                <input type="text" name="employee_code" class="form-control @error('employee_code') is-invalid @enderror" 
                                       value="{{ old('employee_code') }}" required>
                                @error('employee_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="col-md-4">
                                <label class="form-label required">สถานะ</label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>ใช้งาน</option>
                                    <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>ไม่ใช้งาน</option>
                                </select>
                                @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Role -->
                            <div class="col-md-4">
                                <label class="form-label required">บทบาท</label>
                                <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                                    <option value="">เลือกบทบาท</option>
                                    <option value="employee" {{ old('role', 'employee') === 'employee' ? 'selected' : '' }}>Employee</option>
                                    <option value="express" {{ old('role') === 'express' ? 'selected' : '' }}>Express</option>
                                    @if(auth()->user()->role === 'super_admin' || auth()->user()->role === 'it_admin')
                                    <option value="hr" {{ old('role') === 'hr' ? 'selected' : '' }}>HR</option>
                                    <option value="it_admin" {{ old('role') === 'it_admin' ? 'selected' : '' }}>IT Admin</option>
                                    @endif
                                    @if(auth()->user()->role === 'super_admin')
                                    <option value="super_admin" {{ old('role') === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                                    @endif
                                </select>
                                @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Thai Name -->
                            <div class="col-md-6">
                                <label class="form-label required">ชื่อ (ภาษาไทย)</label>
                                <input type="text" name="first_name_th" class="form-control @error('first_name_th') is-invalid @enderror" 
                                       value="{{ old('first_name_th') }}" required>
                                @error('first_name_th')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label required">นามสกุล (ภาษาไทย)</label>
                                <input type="text" name="last_name_th" class="form-control @error('last_name_th') is-invalid @enderror" 
                                       value="{{ old('last_name_th') }}" required>
                                @error('last_name_th')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- English Name -->
                            <div class="col-md-6">
                                <label class="form-label">ชื่อ (English)</label>
                                <input type="text" name="first_name_en" class="form-control @error('first_name_en') is-invalid @enderror" 
                                       value="{{ old('first_name_en') }}">
                                @error('first_name_en')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">นามสกุล (English)</label>
                                <input type="text" name="last_name_en" class="form-control @error('last_name_en') is-invalid @enderror" 
                                       value="{{ old('last_name_en') }}">
                                @error('last_name_en')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Nickname -->
                            <div class="col-md-12">
                                <label class="form-label">ชื่อเล่น</label>
                                <input type="text" name="nickname" class="form-control @error('nickname') is-invalid @enderror" 
                                       value="{{ old('nickname') }}">
                                @error('nickname')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-envelope me-2"></i>ข้อมูลติดต่อ</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label required">อีเมล</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                       value="{{ old('email') }}" required>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">เบอร์โทร</label>
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                                       value="{{ old('phone') }}">
                                @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Organization -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-building me-2"></i>สังกัด</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label required">แผนก</label>
                                <select name="department_id" class="form-select @error('department_id') is-invalid @enderror" required>
                                    <option value="">เลือกแผนก</option>
                                    @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>
                                        {{ $dept->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('department_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">สาขา</label>
                                <select name="branch_id" class="form-select @error('branch_id') is-invalid @enderror">
                                    <option value="">ไม่ระบุสาขา</option>
                                    @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('branch_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">ตำแหน่ง</label>
                                <input type="text" name="position" class="form-control @error('position') is-invalid @enderror" 
                                       value="{{ old('position') }}">
                                @error('position')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Passwords -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-key me-2"></i>รหัสผ่าน</h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            หากไม่กรอกรหัสผ่าน ระบบจะสร้างรหัสผ่านอัตโนมัติ
                        </div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">รหัสผ่านเข้าระบบ</label>
                                <input type="password" name="login_password" class="form-control @error('login_password') is-invalid @enderror" 
                                       value="{{ old('login_password') }}">
                                @error('login_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">รหัสผ่านคอมพิวเตอร์</label>
                                <input type="password" name="computer_password" class="form-control @error('computer_password') is-invalid @enderror" 
                                       value="{{ old('computer_password') }}">
                                @error('computer_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">รหัสผ่านอีเมล</label>
                                <input type="password" name="email_password" class="form-control @error('email_password') is-invalid @enderror" 
                                       value="{{ old('email_password') }}">
                                @error('email_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Express System -->
                <div class="card mb-4" id="expressCard" style="display: none;">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-hdd-network me-2"></i>ระบบ Express</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Express Username</label>
                                <input type="text" name="express_username" class="form-control @error('express_username') is-invalid @enderror" 
                                       value="{{ old('express_username') }}" maxlength="7">
                                <small class="text-muted">สูงสุด 7 ตัวอักษร</small>
                                @error('express_username')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Express Password</label>
                                <input type="text" name="express_password" class="form-control @error('express_password') is-invalid @enderror" 
                                       value="{{ old('express_password') }}" maxlength="4" pattern="[0-9]{4}">
                                <small class="text-muted">ตัวเลข 4 หลัก</small>
                                @error('express_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Permissions -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-shield-check me-2"></i>สิทธิ์การใช้งาน</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="vpn_access" id="vpnAccess" 
                                           value="1" {{ old('vpn_access') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="vpnAccess">
                                        เข้าถึง VPN
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="color_printing" id="colorPrinting" 
                                           value="1" {{ old('color_printing') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="colorPrinting">
                                        พิมพ์สี
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="remote_work" id="remoteWork" 
                                           value="1" {{ old('remote_work') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remoteWork">
                                        ทำงานระยะไกล
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="admin_access" id="adminAccess" 
                                           value="1" {{ old('admin_access') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="adminAccess">
                                        สิทธิ์ผู้ดูแล
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('employees.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>ยกเลิก
                            </a>
                            <button type="submit" class="btn btn-gradient-primary">
                                <i class="bi bi-check-circle me-2"></i>บันทึกข้อมูล
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/employees.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Photo Preview
    const photoInput = document.getElementById('photoInput');
    const photoPreview = document.getElementById('photoPreview');

    photoInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                photoPreview.innerHTML = `<img src="${e.target.result}" alt="Preview" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">`;
            };
            reader.readAsDataURL(file);
        }
    });

    // Show/Hide Express Card based on Department
    const departmentSelect = document.querySelector('select[name="department_id"]');
    const expressCard = document.getElementById('expressCard');

    // Express-enabled departments (you should load this from backend)
    const expressDepartments = @json($departments->where('express_enabled', true)->pluck('id')->toArray());

    function toggleExpressCard() {
        const selectedDept = parseInt(departmentSelect.value);
        if (expressDepartments.includes(selectedDept)) {
            expressCard.style.display = 'block';
        } else {
            expressCard.style.display = 'none';
        }
    }

    departmentSelect.addEventListener('change', toggleExpressCard);
    toggleExpressCard(); // Initial check
});
</script>
@endsection