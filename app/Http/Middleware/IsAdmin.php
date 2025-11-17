<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    /**
     * Ensure authenticated user has Role = 'admin'
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (!$user || ($user->Role ?? '') !== 'admin') {
            // Option A: abort with 403
            abort(403, 'Unauthorized');

            // Option B: redirect to student home instead (uncomment if preferred)
            // return redirect()->route('home')->with('error', 'Access denied.');
        }

        return $next($request);
    }
}
