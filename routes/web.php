<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;


Route::get('/', function () {
    return view('welcome');
});

//Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login.view');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

//Register
Route::get('/register', [AuthController::class, 'showRegister'])->name('register.view');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

//Logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Forgot Password Routes
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgotpass.view');
Route::post('/forgot-password', [AuthController::class, 'sendResetMessage'])->name('forgotpass.post');

//Profile
Route::get('/profile', [UserController::class, 'showProfile'])->name('profile.view');
Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('profile.edit');
Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');


// Example dashboard redirect after login
Route::get('/dashboard', function () {
    return view('dashboard'); // create dashboard.blade.php later
})->name('dashboard')->middleware('web');