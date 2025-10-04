<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\EmployeeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Landing page - redirect to login
Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
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

        $status = Password::sendResetLink($request->only('email'));

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

/*
|--------------------------------------------------------------------------
| Logout Routes
|--------------------------------------------------------------------------
*/
Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::post('/auth/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('auth.logout');

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Main Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile Management
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::put('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');
    
    // Password Change
    Route::get('/change-password', [DashboardController::class, 'showChangePassword'])->name('password.change');
    Route::put('/change-password', [DashboardController::class, 'updatePassword'])->name('password.update.own');
});

/*
|--------------------------------------------------------------------------
| Employee Management Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    
    // ⚠️ IMPORTANT: Custom routes must come BEFORE resource routes
    
    // Trash Management (must be before resource routes)
    Route::get('employees/trash/index', [EmployeeController::class, 'trash'])
        ->name('employees.trash');
    Route::post('employees/{id}/restore', [EmployeeController::class, 'restore'])
        ->name('employees.restore');
    Route::delete('employees/{id}/force-delete', [EmployeeController::class, 'forceDelete'])
        ->name('employees.force-delete');
    Route::delete('employees/trash/empty', [EmployeeController::class, 'emptyTrash'])
        ->name('employees.trash.empty');
    
    // Bulk Operations (must be before resource routes)
    Route::post('employees/bulk/status', [EmployeeController::class, 'bulkUpdateStatus'])
        ->name('employees.bulk.status');
    Route::post('employees/bulk/department', [EmployeeController::class, 'bulkUpdateDepartment'])
        ->name('employees.bulk.department');
    Route::post('employees/bulk/email', [EmployeeController::class, 'bulkSendEmail'])
        ->name('employees.bulk.email');
    Route::post('employees/bulk/export', [EmployeeController::class, 'bulkExportSelected'])
        ->name('employees.bulk.export');
    Route::post('employees/bulk/trash', [EmployeeController::class, 'bulkMoveToTrash'])
        ->name('employees.bulk.trash');
    Route::post('employees/bulk/permanent-delete', [EmployeeController::class, 'bulkPermanentDelete'])
        ->name('employees.bulk.permanent-delete');
    
    // Photo Management - Mass Operations (must be before resource routes)
    Route::post('employees/photos/mass-upload', [EmployeeController::class, 'massPhotoUpload'])
        ->name('employees.photos.mass-upload');
    Route::post('employees/photos/compress', [EmployeeController::class, 'compressAllPhotos'])
        ->name('employees.photos.compress');
    Route::get('employees/photos/report', [EmployeeController::class, 'exportPhotoReport'])
        ->name('employees.photos.report');
    Route::post('employees/photos/backup', [EmployeeController::class, 'photoBackup'])
        ->name('employees.photos.backup');
    
    // Employee CRUD Routes (resource)
    Route::resource('employees', EmployeeController::class);
    
    // Employee Status Update (Toggle)
    Route::patch('employees/{employee}/status', [EmployeeController::class, 'updateStatus'])
        ->name('employees.update-status');
    
    // Employee Photo Management (Individual)
    Route::post('employees/{employee}/photo', [EmployeeController::class, 'uploadPhoto'])
        ->name('employees.upload-photo');
    Route::delete('employees/{employee}/photo', [EmployeeController::class, 'deletePhoto'])
        ->name('employees.delete-photo');
    Route::get('employees/{employee}/photo/info', [EmployeeController::class, 'getPhotoInfo'])
        ->name('employees.photo-info');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');
    
    // System Information
    Route::get('/system-info', [AdminController::class, 'systemInfo'])->name('system-info');
    
    // Activity Logs
    Route::get('/activity-logs', [AdminController::class, 'activityLogs'])->name('activity-logs');
    
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