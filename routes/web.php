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
    // EVENT (in Application module)
    Route::get('/admin/events', [ApplicationController::class, 'listEvents'])->name('events.list');
    Route::get('/admin/events/create', [ApplicationController::class, 'createEvent'])->name('events.create');
    Route::post('/admin/events/store', [ApplicationController::class, 'storeEvent'])->name('events.store');
    Route::get('/admin/events/{EventID}/edit', [ApplicationController::class, 'editEvent'])->name('events.edit');
    Route::post('/admin/events/{EventID}/update', [ApplicationController::class, 'updateEvent'])->name('events.update');

    // APPLICATION
    Route::get('/admin/applications', [ApplicationController::class, 'listApplications'])->name('applications.list');
    Route::get('/admin/applications/{ApplicationID}', [ApplicationController::class, 'showApplication'])->name('applications.show');
    Route::post('/admin/applications/{ApplicationID}/status', [ApplicationController::class, 'updateStatus'])->name('applications.status');
    // Show applicants for a game
    Route::get('/admin/games/{GameID}/applicants', [ApplicationController::class, 'viewApplicantsByGame'])->name('games.applicants');
    // Mark an application as selected (admin action)
    Route::post('/admin/applications/{ApplicationID}/select', [ApplicationController::class, 'selectApplicant'])->name('applications.select');

    // list games grouped by event
    Route::get('/gameinfo', [GameInfoController::class, 'index'])->name('gameinfo.index');
    // show game details
    Route::get('/gameinfo/{GameID}', [GameInfoController::class, 'show'])->name('gameinfo.show');
    // edit / update / destroy
    Route::get('/gameinfo/{GameID}/edit', [GameInfoController::class, 'edit'])->name('gameinfo.edit');
    Route::post('/gameinfo/{GameID}/update', [GameInfoController::class, 'update'])->name('gameinfo.update');
    Route::delete('/gameinfo/{GameID}', [GameInfoController::class, 'destroy'])->name('gameinfo.destroy');

});
Route::middleware(['auth','is_student'])->prefix('student')->group(function () {
    Route::get('announcements', [AnnouncementController::class, 'studentIndex'])->name('student.announcements.index');
    Route::get('announcements/{announcement}', [AnnouncementController::class, 'showForStudent'])->name('student.announcements.show');
});