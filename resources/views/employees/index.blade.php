@extends('layouts.app')

@section('title', 'จัดการพนักงาน')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/employees.css') }}">
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">
                <i class="bi bi-people-fill me-2"></i>จัดการพนักงาน
            </h2>
            <p class="text-muted mb-0">รายการพนักงานทั้งหมดในระบบ</p>
        </div>
        <div>
            @can('create', App\Models\Employee::class)
            <a href="{{ route('employees.create') }}" class="btn btn-gradient-primary">
                <i class="bi bi-plus-circle me-2"></i>เพิ่มพนักงานใหม่
            </a>
            @endcan
            @if(auth()->user()->role === 'super_admin')
            <a href="{{ route('employees.trash') }}" class="btn btn-outline-danger">
                <i class="bi bi-trash me-2"></i>ถังขยะ ({{ $stats['trash_count'] ?? 0 }})
            </a>
            @endif
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-primary">
                    <i class="bi bi-people"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-label">พนักงานทั้งหมด</div>
                    <div class="stat-value">{{ $stats['total'] ?? 0 }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-success">
                    <i class="bi bi-person-check"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-label">พนักงานที่ใช้งาน</div>
                    <div class="stat-value">{{ $stats['active'] ?? 0 }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-info">
                    <i class="bi bi-hdd-network"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-label">ผู้ใช้ Express</div>
                    <div class="stat-value">{{ $stats['express_users'] ?? 0 }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-warning">
                    <i class="bi bi-images"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-label">มีรูปภาพ</div>
                    <div class="stat-value">{{ $stats['with_photo'] ?? 0 }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('employees.index') }}" id="filterForm">
                <div class="row g-3">
                    <!-- Search -->
                    <div class="col-md-4">
                        <label class="form-label">ค้นหา</label>
                        <input type="text" name="search" class="form-control" 
                               placeholder="รหัส, ชื่อ, อีเมล, เบอร์โทร..." 
                               value="{{ request('search') }}">
                    </div>

                    <!-- Department Filter -->
                    <div class="col-md-3">
                        <label class="form-label">แผนก</label>
                        <select name="department" class="form-select">
                            <option value="">ทั้งหมด</option>
                            @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ request('department') == $dept->id ? 'selected' : '' }}>
                                {{ $dept->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Branch Filter -->
                    <div class="col-md-3">
                        <label class="form-label">สาขา</label>
                        <select name="branch" class="form-select">
                            <option value="">ทั้งหมด</option>
                            @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ request('branch') == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div class="col-md-2">
                        <label class="form-label">สถานะ</label>
                        <select name="status" class="form-select">
                            <option value="">ทั้งหมด</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>ใช้งาน</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>ไม่ใช้งาน</option>
                        </select>
                    </div>

                    <!-- Buttons -->
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search me-2"></i>ค้นหา
                        </button>
                        <a href="{{ route('employees.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-counterclockwise me-2"></i>ล้างตัวกรอง
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Employees Table -->
    <div class="card">
        <div class="card-body">
            @if($employees->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-inbox" style="font-size: 4rem; color: #dee2e6;"></i>
                <p class="text-muted mt-3 mb-0">ไม่พบข้อมูลพนักงาน</p>
            </div>
            @else
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th style="width: 80px;">รูปภาพ</th>
                            <th>รหัสพนักงาน</th>
                            <th>ชื่อ-นามสกุล</th>
                            <th>แผนก</th>
                            <th>สาขา</th>
                            <th>อีเมล</th>
                            <th>บทบาท</th>
                            <th>สถานะ</th>
                            <th class="text-center" style="width: 120px;">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employees as $employee)
                        <tr>
                            <td>
                                @if($employee->has_photo)
                                <img src="{{ $employee->photo_url }}" 
                                     alt="{{ $employee->full_name_th }}" 
                                     class="employee-photo-sm">
                                @else
                                <div class="employee-photo-placeholder-sm">
                                    {{ mb_substr($employee->first_name_th, 0, 1) }}
                                </div>
                                @endif
                            </td>
                            <td>
                                <strong class="text-primary">{{ $employee->employee_code }}</strong>
                            </td>
                            <td>
                                <div>{{ $employee->full_name_th }}</div>
                                @if($employee->nickname)
                                <small class="text-muted">({{ $employee->nickname }})</small>
                                @endif
                            </td>
                            <td>
                                @if($employee->department)
                                <span class="badge bg-info">{{ $employee->department->name }}</span>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($employee->branch)
                                <span class="badge bg-secondary">{{ $employee->branch->name }}</span>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $employee->email }}</td>
                            <td>
                                @php
                                $roleColors = [
                                    'super_admin' => 'danger',
                                    'it_admin' => 'warning',
                                    'hr' => 'info',
                                    'employee' => 'primary',
                                    'express' => 'success'
                                ];
                                $roleLabels = [
                                    'super_admin' => 'Super Admin',
                                    'it_admin' => 'IT Admin',
                                    'hr' => 'HR',
                                    'employee' => 'Employee',
                                    'express' => 'Express'
                                ];
                                @endphp
                                <span class="badge bg-{{ $roleColors[$employee->role] ?? 'secondary' }}">
                                    {{ $roleLabels[$employee->role] ?? $employee->role }}
                                </span>
                            </td>
                            <td>
                                @if(in_array(auth()->user()->role, ['super_admin', 'it_admin']))
                                <div class="form-check form-switch">
                                    <input class="form-check-input status-toggle" 
                                           type="checkbox" 
                                           data-employee-id="{{ $employee->id }}"
                                           {{ $employee->status === 'active' ? 'checked' : '' }}>
                                </div>
                                @else
                                <span class="badge bg-{{ $employee->status === 'active' ? 'success' : 'secondary' }}">
                                    {{ $employee->status === 'active' ? 'ใช้งาน' : 'ไม่ใช้งาน' }}
                                </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('employees.show', $employee) }}" 
                                       class="btn btn-outline-info" 
                                       title="ดูรายละเอียด">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @can('update', $employee)
                                    <a href="{{ route('employees.edit', $employee) }}" 
                                       class="btn btn-outline-warning" 
                                       title="แก้ไข">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    @endcan
                                    @can('delete', $employee)
                                    <button type="button" 
                                            class="btn btn-outline-danger btn-delete" 
                                            data-employee-id="{{ $employee->id }}"
                                            data-employee-name="{{ $employee->full_name_th }}"
                                            title="ลบ">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    แสดง {{ $employees->firstItem() ?? 0 }} - {{ $employees->lastItem() ?? 0 }} 
                    จากทั้งหมด {{ $employees->total() }} รายการ
                </div>
                <div>
                    {{ $employees->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/employees.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Status Toggle
    document.querySelectorAll('.status-toggle').forEach(toggle => {
        toggle.addEventListener('change', function() {
            const employeeId = this.dataset.employeeId;
            const newStatus = this.checked ? 'active' : 'inactive';
            
            fetch(`/employees/${employeeId}/status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ status: newStatus })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('success', data.message);
                } else {
                    this.checked = !this.checked;
                    showToast('error', data.message);
                }
            })
            .catch(error => {
                this.checked = !this.checked;
                showToast('error', 'เกิดข้อผิดพลาดในการอัปเดตสถานะ');
            });
        });
    });

    // Delete Button
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function() {
            const employeeId = this.dataset.employeeId;
            const employeeName = this.dataset.employeeName;
            
            if (confirm(`คุณต้องการลบพนักงาน "${employeeName}" หรือไม่?`)) {
                fetch(`/employees/${employeeId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast('success', data.message);
                        setTimeout(() => window.location.reload(), 1500);
                    } else {
                        showToast('error', data.message);
                    }
                })
                .catch(error => {
                    showToast('error', 'เกิดข้อผิดพลาดในการลบข้อมูล');
                });
            }
        });
    });
});

function showToast(type, message) {
    // Simple toast notification
    const toast = document.createElement('div');
    toast.className = `alert alert-${type === 'success' ? 'success' : 'danger'} position-fixed top-0 end-0 m-3`;
    toast.style.zIndex = '9999';
    toast.textContent = message;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.remove();
    }, 3000);
}
</script>
@endsection