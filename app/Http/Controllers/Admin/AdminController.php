<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employee;
use App\Models\Computer;
use App\Models\Department;

class AdminController extends Controller
{
    public function dashboard()
    {
        // ตรวจสอบสิทธิ์
        if (!auth()->user()->hasAdminPrivileges()) {
            abort(403, 'Access denied. Admin privileges required.');
        }

        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('is_active', true)->count(),
            'total_employees' => Employee::count(),
            'active_employees' => Employee::where('is_active', true)->count(),
            'total_computers' => Computer::count(),
            'active_computers' => Computer::where('status', 'active')->count(),
            'total_departments' => Department::count(),
            'active_departments' => Department::where('is_active', true)->count(),
        ];

        $recent_users = User::with('employee')->latest()->take(5)->get();
        $recent_computers = Computer::with('assignedTo')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_users', 'recent_computers'));
    }
}