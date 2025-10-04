<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Branch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // สถิติพื้นฐาน
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('is_active', 1)->count(),
            'total_employees' => Employee::count(),
            'active_employees' => Employee::whereNull('deleted_at')->count(),
            'total_departments' => Department::count(),
            'total_branches' => Branch::count(),
        ];
        
        // พนักงานตามแผนก
        $employeesByDepartment = Employee::select('department_id', DB::raw('count(*) as total'))
            ->whereNull('deleted_at')
            ->groupBy('department_id')
            ->with('department')
            ->get()
            ->map(function($item) {
                return [
                    'department' => $item->department->name ?? 'ไม่ระบุแผนก',
                    'total' => $item->total
                ];
            });
        
        // พนักงานตามสาขา
        $employeesByBranch = Employee::select('branch_id', DB::raw('count(*) as total'))
            ->whereNull('deleted_at')
            ->groupBy('branch_id')
            ->with('branch')
            ->get()
            ->map(function($item) {
                return [
                    'branch' => $item->branch->name ?? 'ไม่ระบุสาขา',
                    'total' => $item->total
                ];
            });
        
        // กิจกรรมล่าสุด
        $recentActivities = [
            [
                'icon' => 'fa-user-plus',
                'color' => 'success',
                'title' => 'เพิ่มพนักงานใหม่',
                'description' => 'เพิ่มข้อมูลพนักงานเข้าสู่ระบบ',
                'time' => '2 ชั่วโมงที่แล้ว'
            ],
            [
                'icon' => 'fa-edit',
                'color' => 'info',
                'title' => 'แก้ไขข้อมูลพนักงาน',
                'description' => 'อัปเดตข้อมูลส่วนตัว',
                'time' => '5 ชั่วโมงที่แล้ว'
            ],
            [
                'icon' => 'fa-building',
                'color' => 'warning',
                'title' => 'เพิ่มแผนกใหม่',
                'description' => 'สร้างแผนกการตลาด',
                'time' => '1 วันที่แล้ว'
            ]
        ];
        
        return view('dashboard', compact(
            'user',
            'stats',
            'employeesByDepartment',
            'employeesByBranch',
            'recentActivities'
        ));
    }
    
    public function adminDashboard()
    {
        return $this->index();
    }
}