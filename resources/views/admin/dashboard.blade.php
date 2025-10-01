@extends('layouts.app')

@section('title', 'แดชบอร์ดผู้ดูแล - ITMS')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 fw-bold">แดชบอร์ดผู้ดูแลระบบ</h1>
            <p class="text-muted">ภาพรวมการจัดการระบบ IT</p>
        </div>
    </div>

    <!-- Admin Statistics -->
    <div class="row mb-4">
        @foreach([
            ['label' => 'ผู้ใช้งาน', 'count' => $stats['total_users'] ?? 0, 'active' => $stats['active_users'] ?? 0, 'icon' => 'users', 'color' => 'primary'],
            ['label' => 'พนักงาน', 'count' => $stats['total_employees'] ?? 0, 'active' => $stats['active_employees'] ?? 0, 'icon' => 'user-tie', 'color' => 'success'],
            ['label' => 'ครุภัณฑ์', 'count' => $stats['total_computers'] ?? 0, 'active' => $stats['active_computers'] ?? 0, 'icon' => 'desktop', 'color' => 'info'],
            ['label' => 'แผนก', 'count' => $stats['total_departments'] ?? 0, 'active' => $stats['active_departments'] ?? 0, 'icon' => 'building', 'color' => 'warning']
        ] as $stat)
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="text-{{ $stat['color'] }} text-uppercase fw-bold small">{{ $stat['label'] }}</h6>
                            <span class="h2 fw-bold">{{ $stat['count'] }}</span>
                            <span class="text-muted">/ {{ $stat['active'] }} ใช้งาน</span>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-{{ $stat['icon'] }} fa-2x text-{{ $stat['color'] }}"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Content placeholder -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <h4>แดชบอร์ดผู้ดูแล</h4>
                    <p class="text-muted">ส่วนนี้จะพัฒนาต่อไปเพื่อแสดงกราฟและรายงาน</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
