<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     */
    protected $middleware = [
        // ...
    ];

    /**
     * The application's route middleware groups.
     */
    protected $middlewareGroups = [
        'web' => [
            // ...
        ],

        'api' => [
            // ...
        ],
    ];

    /**
     * The application's route middleware.
     */
    protected $routeMiddleware = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,

        'is_admin'  => \App\Http\Middleware\IsAdmin::class,
        'is_student'=> \App\Http\Middleware\IsStudent::class,   
        'profileCompleted' => \App\Http\Middleware\EnsureProfileCompleted::class,
        
    ];
}
