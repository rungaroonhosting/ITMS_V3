<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employee;
use App\Models\Computer;
use App\Models\Department;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     */
    public function index()
    {
        $user = auth()->user();
        
        // Statistics for dashboard
        $stats = [
            'total_users' => User::count(),
            'total_employees' => Employee::count(),
            'total_computers' => Computer::count(),
            'total_departments' => Department::count(),
        ];

        // Recent activities (placeholder for now)
        $recent_activities = [];

        return view('dashboard.index', compact('stats', 'recent_activities'));
    }

    /**
     * Show user profile
     */
    public function profile()
    {
        $user = auth()->user();
        return view('dashboard.profile', compact('user'));
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
        ]);

        $user = auth()->user();
        $user->update($request->only('name', 'email'));

        return back()->with('success', 'ข้อมูลโปรไฟล์ถูกอัพเดทเรียบร้อยแล้ว');
    }

    /**
     * Show change password form
     */
    public function showChangePassword()
    {
        return view('dashboard.change-password');
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withErrors(['current_password' => 'รหัสผ่านปัจจุบันไม่ถูกต้อง']);
        }

        auth()->user()->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'เปลี่ยนรหัสผ่านเรียบร้อยแล้ว');
    }
}
