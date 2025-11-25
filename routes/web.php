<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\GameInfoController;
use App\Http\Controllers\EventController;

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

Route::middleware(['auth','is_admin'])->prefix('admin')->name('admin.')->group(function () {
    //announcement
    Route::get('announcements', [AnnouncementController::class, 'adminIndex'])->name('announcements.index');
    Route::get('announcements/create', [AnnouncementController::class, 'create'])->name('announcements.create');
    Route::post('announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
    Route::get('announcements/{announcement}', [AnnouncementController::class, 'showForAdmin'])->name('announcements.show');
    Route::get('announcements/{announcement}/edit', [AnnouncementController::class, 'edit'])->name('announcements.edit');
    Route::put('announcements/{announcement}', [AnnouncementController::class, 'update'])->name('announcements.update');
    Route::delete('announcements/{announcement}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');
    // events
    Route::get('events', [EventController::class,'adminIndex'])->name('events.index');
    Route::get('events/create', [EventController::class,'create'])->name('events.create');
    Route::post('events', [EventController::class,'store'])->name('events.store');
    Route::get('events/{event}', [EventController::class,'showForAdmin'])->name('events.show');
    Route::get('events/{event}/edit', [EventController::class,'edit'])->name('events.edit');
    Route::put('events/{event}', [EventController::class,'update'])->name('events.update');
    Route::delete('events/{event}', [EventController::class,'destroy'])->name('events.destroy');

    // games
    Route::get('games', [GameInfoController::class,'adminIndex'])->name('games.index');
    Route::get('games/create', [GameInfoController::class,'create'])->name('games.create');
    Route::post('games', [GameInfoController::class,'store'])->name('games.store');
    Route::get('games/{game}', [GameInfoController::class,'showForAdmin'])->name('games.show');
    Route::get('games/{game}/edit', [GameInfoController::class,'edit'])->name('games.edit');
    Route::put('games/{game}', [GameInfoController::class,'update'])->name('games.update');
    Route::delete('games/{game}', [GameInfoController::class,'destroy'])->name('games.destroy');

    // applications (admin)
    Route::get('applications', [ApplicationController::class,'adminIndex'])->name('applications.index');
    Route::get('games/{game}/applications', [ApplicationController::class,'showForAdmin'])->name('games.applications');
    Route::get('applications/{application}', [ApplicationController::class,'showForAdminSingle'])->name('applications.show');
    Route::patch('applications/{application}', [ApplicationController::class,'update'])->name('applications.update');
    Route::delete('applications/{application}', [ApplicationController::class,'destroy'])->name('applications.destroy');
});


Route::middleware(['auth','is_student'])->prefix('student')->group(function () {
    Route::get('announcements', [AnnouncementController::class, 'studentIndex'])
        ->name('student.announcements.index');
});

