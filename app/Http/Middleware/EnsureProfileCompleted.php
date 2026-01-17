<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureProfileCompleted
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user || $user->Role !== 'student') {
            return $next($request);
        }

        // If they try to access a route inside the 'profileCompleted' group but haven't finished...
        if (!$user->ProfileCompleted) {
            // If it's a POST request (submitting a form), stop them with an error
            if ($request->isMethod('post')) {
                return back()->with('error', 'You must complete your profile before you can apply for games!');
            }

            // If it's a GET request (trying to view application pages), redirect to profile
            return redirect()->route('student.profile.edit')
                ->with('warning', 'Please complete your profile to unlock this feature.');
        }

        return $next($request);
    }
}
