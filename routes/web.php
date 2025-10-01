<?php

use Illuminate\Support\Facades\Route;
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
    return redirect('/login');
});

// Authentication Routes
Route::prefix('auth')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('auth.login');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// For compatibility
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('/logout', [LoginController::class, 'logout'])->name('auth.logout');

// Employee Dashboard Routes (requires authentication)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::put('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');
    Route::get('/change-password', [DashboardController::class, 'showChangePassword'])->name('password.change');
    Route::put('/change-password', [DashboardController::class, 'updatePassword'])->name('password.update');
});

// Admin Routes (requires admin privileges)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/system-info', [AdminController::class, 'systemInfo'])->name('system-info');
    Route::get('/activity-logs', [AdminController::class, 'activityLogs'])->name('activity-logs');
    
    // Employee Management (placeholder routes)
    Route::get('/employees', function() {
        return view('admin.employees.index');
    })->name('employees.index');
    
    // Department Management (placeholder routes)
    Route::get('/departments', function() {
        return view('admin.departments.index');
    })->name('departments.index');
    
    // Computer Management (placeholder routes)
    Route::get('/computers', function() {
        return view('admin.computers.index');
    })->name('computers.index');
    
    // User Management (placeholder routes)
    Route::get('/users', function() {
        return view('admin.users.index');
    })->name('users.index');
});
