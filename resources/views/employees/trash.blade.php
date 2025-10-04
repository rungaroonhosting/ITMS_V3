@extends('layouts.app')

@section('title', 'ถังขยะพนักงาน')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/employees.css') }}">
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">
                <i class="bi bi-trash me-2"></i>ถังขยะพนักงาน
            </h2>
            <p class="text-muted mb-0">พนักงานที่ถูกลบชั่วคราว (สามารถกู้คืนได้)</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>กลับ
            </a>
            @if($trashedEmployees->count() > 0)
            <button type="button" class="btn btn-danger" onclick="emptyTrash()">
                <i class="bi bi-trash3 me-2"></i>ล้างถังขยะทั้งหมด
            </button>
            @endif
        </div>
    </div>

    <!-- Statistics -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-danger">
                    <i class="bi bi-trash"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-label">ในถังขยะ</div>
                    <div class="stat-value">{{ $stats['total_trashed'] ?? 0 }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-success">
                    <i class="bi bi-people"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-label">พนักงานที่ใช้งาน</div>
                    <div class="stat-value">{{ $stats['total_active'] ?? 0 }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-warning">
                    <i class="bi bi-images"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-label">มีรูปภาพ (ถังขยะ)</div>
                    <div class="stat-value">{{ $stats['with_photo'] ?? 0 }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-info">
                    <i class="bi bi-image"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-label">ไม่มีรูปภาพ (ถังขยะ)</div>
                    <div class="stat-value">{{ $stats['without_photo'] ?? 0 }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('employees.trash') }}">
                <div class="row g-3">
                    <div class="col-md-6">
                        <input type="text" name="search" class="form-control" 
                               placeholder="ค้นหารหัส, ชื่อ, อีเมล..." 
                               value="{{ request('search') }}">
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-search me-2"></i>ค้นหา
                            </button>
                            <a href="{{ route('employees.trash') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-counterclockwise me-2"></i>ล้างตัวกรอง
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Trashed Employees Table -->
    <div class="card">
        <div class="card-body">
            @if($trashedEmployees->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-inbox" style="font-size: 4rem; color: #dee2e6;"></i>
                <p class="text-muted mt-3 mb-0">ถังขยะว่างเปล่า</p>
            </div>
            @else
            <div class="alert alert-warning">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <strong>คำเตือน:</strong> การลบถาวรจะไม่สามารถกู้คืนได้ กรุณาตรวจสอบข้อมูลให้แน่ใจก่อนดำเนินการ
            </div>

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
                            <th>วันที่ลบ</th>
                            <th class="text-center" style="width: 150px;">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($trashedEmployees as $employee)
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
                                <strong class="text-danger">{{ $employee->employee_code }}</strong>
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
                                <small class="text-muted">
                                    {{ $employee->deleted_at->format('d/m/Y H:i') }}
                                    <br>
                                    ({{ $employee->deleted_at->diffForHumans() }})
                                </small>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <button type="button" 
                                            class="btn btn-outline-success btn-restore" 
                                            data-employee-id="{{ $employee->id }}"
                                            data-employee-name="{{ $employee->full_name_th }}"
                                            title="กู้คืน">
                                        <i class="bi bi-arrow-counterclockwise"></i>
                                    </button>
                                    <button type="button" 
                                            class="btn btn-outline-danger btn-force-delete" 
                                            data-employee-id="{{ $employee->id }}"
                                            data-employee-name="{{ $employee->full_name_th }}"
                                            title="ลบถาวร">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
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
                    แสดง {{ $trashedEmployees->firstItem() ?? 0 }} - {{ $trashedEmployees->lastItem() ?? 0 }} 
                    จากทั้งหมด {{ $trashedEmployees->total() }} รายการ
                </div>
                <div>
                    {{ $trashedEmployees->links() }}
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
    // Restore Button
    document.querySelectorAll('.btn-restore').forEach(btn => {
        btn.addEventListener('click', function() {
            const employeeId = this.dataset.employeeId;
            const employeeName = this.dataset.employeeName;
            
            if (confirm(`คุณต้องการกู้คืนพนักงาน "${employeeName}" หรือไม่?`)) {
                fetch(`/employees/${employeeId}/restore`, {
                    method: 'POST',
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
                    showToast('error', 'เกิดข้อผิดพลาดในการกู้คืนข้อมูล');
                });
            }
        });
    });

    // Force Delete Button
    document.querySelectorAll('.btn-force-delete').forEach(btn => {
        btn.addEventListener('click', function() {
            const employeeId = this.dataset.employeeId;
            const employeeName = this.dataset.employeeName;
            
            if (confirm(`⚠️ คำเตือน: คุณต้องการลบถาวรพนักงาน "${employeeName}" หรือไม่?\n\nการลบถาวรจะไม่สามารถกู้คืนได้!`)) {
                if (confirm('กรุณายืนยันอีกครั้ง: คุณแน่ใจหรือไม่ที่จะลบถาวร?')) {
                    fetch(`/employees/${employeeId}/force-delete`, {
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
            }
        });
    });
});

// Empty Trash
function emptyTrash() {
    if (confirm('⚠️ คำเตือนร้ายแรง: คุณต้องการล้างถังขยะทั้งหมดหรือไม่?\n\nการลบทั้งหมดจะไม่สามารถกู้คืนได้!')) {
        if (confirm('กรุณายืนยันอีกครั้ง: คุณแน่ใจหรือไม่ที่จะล้างถังขยะทั้งหมด?')) {
            if (confirm('ยืนยันครั้งสุดท้าย: พิมพ์ "DELETE" เพื่อยืนยัน')) {
                fetch('/employees/empty-trash', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast('success', data.message);
                        setTimeout(() => window.location.reload(), 2000);
                    } else {
                        showToast('error', data.message);
                    }
                })
                .catch(error => {
                    showToast('error', 'เกิดข้อผิดพลาดในการล้างถังขยะ');
                });
            }
        }
    }
}

function showToast(type, message) {
    const toast = document.createElement('div');
    toast.className = `alert alert-${type === 'success' ? 'success' : 'danger'} position-fixed top-0 end-0 m-3`;
    toast.style.zIndex = '9999';
    toast.innerHTML = `<i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>${message}`;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.remove();
    }, 3000);
}
</script>
@endsection