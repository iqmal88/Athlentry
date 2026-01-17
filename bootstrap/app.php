<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use App\Http\Middleware\EnsureProfileCompleted;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsStudent;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

    // --- YOUR ROLE MIDDLEWARE ALIASES ---
        $middleware->alias([
            'is_admin'   => \App\Http\Middleware\IsAdmin::class,
            'is_student' => \App\Http\Middleware\IsStudent::class,

            // If your routes use camelCase names, register them too:
            'isAdmin'   => \App\Http\Middleware\IsAdmin::class,
            'isStudent' => \App\Http\Middleware\IsStudent::class,
            'profileCompleted' => \App\Http\Middleware\EnsureProfileCompleted::class,
    ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
