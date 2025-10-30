<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

// Example dashboard redirect after login
Route::get('/dashboard', function () {
    return view('dashboard'); // create dashboard.blade.php later
})->name('dashboard')->middleware('web');