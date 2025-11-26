<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use App\Models\User;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('Login.Admin.AdminLoginView');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'identifier' => 'required|string',
            'password'   => 'required|string',
            'remember'   => 'nullable|boolean',
        ]);

        $matric = $data['identifier'];
        $throttleKey = Str::lower($matric).'|'.$request->ip();

        // Simple throttle: 5 attempts per minute
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->withErrors(['identifier' => "Too many attempts. Try again in {$seconds} seconds."])->withInput();
        }

        $user = User::where('MatricNo', $matric)->where('Role', 'admin')->first();

        if (! $user || ! Hash::check($data['password'], $user->Password)) {
            RateLimiter::hit($throttleKey, 60); // block for 60s after hitting max attempts
            return back()->withErrors(['identifier' => 'Invalid credentials'])->withInput();
        }

        // Successful login -> clear attempts
        RateLimiter::clear($throttleKey);

        Auth::login($user, (bool) $request->boolean('remember'));
        $request->session()->regenerate();

        return redirect()->intended(route('admin.announcements.index'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.view');
    }
}
