<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsStudent
{
    /**
     * Ensure authenticated user has Role = 'student'
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (!$user || ($user->Role ?? '') !== 'student') {
            abort(403, 'Unauthorized');
            // OR redirect: return redirect()->route('login.view');
        }

        return $next($request);
    }
}
