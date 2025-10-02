<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Landing page - redirect to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('auth.login');
    
    // Password Reset - Request Form
    Route::get('/forgot-password', function () {
        return view('auth.reset-password');
    })->name('password.request');
    
    // Password Reset - Send Email
    Route::post('/forgot-password', function (Request $request) {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.exists' => 'ไม่พบอีเมลนี้ในระบบ'
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                    ? redirect()->route('password.sent')->with('email', $request->email)
                    : back()->withErrors(['email' => 'ไม่สามารถส่งลิงก์รีเซ็ตรหัสผ่านได้ กรุณาลองใหม่อีกครั้ง']);
    })->name('password.email');
    
    // Password Reset - Success Page
    Route::get('/password-sent', function () {
        return view('auth.reset-password-sent');
    })->name('password.sent');
    
    // Password Reset - Form (from email link)
    Route::get('/reset-password/{token}', function ($token) {
        return view('auth.reset-password-form', ['token' => $token]);
    })->name('password.reset');
    
    // Password Reset - Update Password
    Route::post('/reset-password', function (Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ], [
            'password.min' => 'รหัสผ่านต้องมีอย่างน้อย 8 ตัวอักษร',
            'password.confirmed' => 'รหัสผ่านไม่ตรงกัน'
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password)
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', 'รีเซ็ตรหัสผ่านสำเร็จ กรุณาเข้าสู่ระบบด้วยรหัสผ่านใหม่')
                    : back()->withErrors(['email' => 'ไม่สามารถรีเซ็ตรหัสผ่านได้ ลิงก์อาจหมดอายุแล้ว']);
    })->name('password.update');
});

// Logout Routes (requires authentication)
Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::post('/auth/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('auth.logout');

// Employee Dashboard Routes (requires authentication)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::put('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');
    Route::get('/change-password', [DashboardController::class, 'showChangePassword'])->name('password.change');
    Route::put('/change-password', [DashboardController::class, 'updatePassword'])->name('password.update.own');
});

// Admin Routes (requires authentication)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/system-info', [AdminController::class, 'systemInfo'])->name('system-info');
    Route::get('/activity-logs', [AdminController::class, 'activityLogs'])->name('activity-logs');
    
    // Employee Management (placeholder)
    Route::get('/employees', function() {
        return view('admin.employees.index');
    })->name('employees.index');
    
    // Department Management (placeholder)
    Route::get('/departments', function() {
        return view('admin.departments.index');
    })->name('departments.index');
    
    // Computer Management (placeholder)
    Route::get('/computers', function() {
        return view('admin.computers.index');
    })->name('computers.index');
    
    // User Management (placeholder)
    Route::get('/users', function() {
        return view('admin.users.index');
    })->name('users.index');
});