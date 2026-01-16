<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\GameInfoController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\ReportController;

/*
|--------------------------------------------------------------------------
| Authentication (Public)
|--------------------------------------------------------------------------
*/
Route::get('/', [AuthController::class, 'showLogin'])->name('login.view');

// Student Auth
Route::post('/login/student', [AuthController::class, 'login'])->name('login.submit');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('student.register.view');
Route::post('/register', [AuthController::class, 'register'])->name('student.register.submit');

// Admin Auth
Route::get('/admin/login', fn () => view('Login.LoginView'))->name('admin.login.view');
Route::post('/login/admin', [AdminAuthController::class, 'login'])->name('admin.login.submit');

// Forgot Password (Student)
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('login.forgot.view');
Route::post('/forgot-password/reset', [AuthController::class, 'resetPassword'])->name('student.password.reset');
Route::post('/forgot-password/send', [AuthController::class, 'sendResetMessage'])->name('login.forgot.send');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'is_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    /* Announcements */
    Route::get('announcements', [AnnouncementController::class, 'adminIndex'])->name('announcements.index');
    Route::get('announcements/create', [AnnouncementController::class, 'create'])->name('announcements.create');
    Route::post('announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
    Route::get('announcements/{announcement}', [AnnouncementController::class, 'showForAdmin'])->name('announcements.show');
    Route::get('announcements/{announcement}/edit', [AnnouncementController::class, 'edit'])->name('announcements.edit');
    Route::put('announcements/{announcement}', [AnnouncementController::class, 'update'])->name('announcements.update');
    Route::delete('announcements/{announcement}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');

    /* Events (Application Module) */
    Route::get('events', [ApplicationController::class, 'listEvents'])->name('events.list');
    Route::get('events/create', [ApplicationController::class, 'createEvent'])->name('events.create');
    Route::post('events', [ApplicationController::class, 'storeEvent'])->name('events.store');
    Route::get('events/{EventID}/edit', [ApplicationController::class, 'editEvent'])->name('events.edit');
    Route::post('events/{EventID}/update', [ApplicationController::class, 'updateEvent'])->name('events.update');

    /* Applications */
    Route::get('applications/{ApplicationID}', [ApplicationController::class, 'showApplication'])->name('applications.show');
    Route::put('applications/{ApplicationID}/select', [ApplicationController::class, 'selectApplicant'])->name('applications.select');

    /* Game Applicants */
    Route::get('games/{GameID}/applicants', [ApplicationController::class, 'viewApplicantsByGame'])->name('games.applicants');

    /*
    |--------------------------------------------------------------------------
    | Selection Module
    |--------------------------------------------------------------------------
    */
    Route::get('selection',[ApplicationController::class, 'selectionIndex'])->name('selection.index');
    Route::put('selection/{ApplicationID}',[ApplicationController::class, 'updateSelection'])->name('selection.update');

    /* Game Info */
    Route::get('gameinfo', [GameInfoController::class, 'index'])->name('gameinfo.index');
    Route::get('gameinfo/{GameID}', [GameInfoController::class, 'show'])->name('gameinfo.show');
    Route::get('gameinfo/{GameID}/edit', [GameInfoController::class, 'edit'])->name('gameinfo.edit');
    Route::post('gameinfo/{GameID}/update', [GameInfoController::class, 'update'])->name('gameinfo.update');
    Route::delete('gameinfo/{GameID}', [GameInfoController::class, 'destroy'])->name('gameinfo.destroy');

    /* Admin Profile */
    Route::get('profile', [AdminProfileController::class, 'view'])->name('profile.view');
    Route::get('profile/edit', [AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [AdminProfileController::class, 'update'])->name('profile.update');

    //report
    Route::get('reports',[ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/export/applicants/csv', [ReportController::class, 'exportApplicantsCSV'])->name('reports.export.applicants.csv');
    Route::get('reports/export/selected/csv', [ReportController::class, 'exportSelectedCSV'])->name('reports.export.selected.csv');
    Route::get('reports/export/selected/pdf',[ReportController::class, 'exportSelectedPDF'])->name('reports.export.selected.pdf');

});

/*
|--------------------------------------------------------------------------
| Student Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'is_student'])
    ->prefix('student')
    ->name('student.')
    ->group(function () {
    
    //PROFILE
    Route::get('/student/profile', [UserController::class, 'showProfile'])->name('profile.show');
    Route::get('/student/profile/edit', [UserController::class, 'editProfile'])->name('profile.edit');
    Route::post('/student/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::post('/student/profile/password', [UserController::class, 'changePassword'])->name('profile.password');

    //ANNOUNCEMENT
    Route::get('announcements', [AnnouncementController::class, 'studentIndex'])->name('announcements.index');
    Route::get('announcements/{announcement}', [AnnouncementController::class, 'showForStudent'])->name('announcements.show');

    //APPLICATION
    Route::get('applications',[ApplicationController::class, 'studentApplicationIndex'])->name('application.index');
    Route::post('applications/submit/{GameID}',[ApplicationController::class, 'submitApplication'])->name('application.submit');
    Route::get('events/{EventID}', [ApplicationController::class, 'studentEventShow'])->name('events.show');
    
    //GAMEINFO
    Route::get('/game-info',[GameInfoController::class, 'studentIndex'])->name('gameinfo.index');
    Route::get('/game-info/{GameID}',[GameInfoController::class, 'studentShow'])->name('gameinfo.show');

    //STATUS
    Route::get('applications/status',[ApplicationController::class, 'studentApplicationsStatus'])->name('applications.status');
});
