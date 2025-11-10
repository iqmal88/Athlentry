<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\StudentController; // if you have student dashboard
use Illuminate\Support\Facades\Route;

// Common login view (single page)
Route::get('/login', function () { return view('Login.LoginView'); })->name('login.view');

// Student auth (AuthController)
Route::post('/login/student', [AuthController::class, 'login'])->name('login.submit');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('student.register.view');
Route::post('/register', [AuthController::class, 'register'])->name('student.register.submit');

// Admin auth (AdminAuthController)
Route::post('/login/admin', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::get('/admin/login', function(){ return view('Login.LoginView'); })->name('admin.login.view'); // optional direct link

// Logout (shared)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected dashboards (example)
Route::middleware(['auth','is_admin'])->prefix('admin')->group(function(){
    Route::get('dashboard', [App\Http\Controllers\AdminDashboardController::class,'index'])->name('admin.dashboard');
});
Route::middleware(['auth','is_student'])->prefix('student')->group(function(){
    Route::get('dashboard', [App\Http\Controllers\StudentDashboardController::class,'index'])->name('student.dashboard');
});
