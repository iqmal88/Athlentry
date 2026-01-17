<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    // Show login view
    public function showLogin()
    {
        return view('Login.LoginView');
    }

    /**
     * Handle login with Profile Completion Check
     */
    public function login(Request $request)
    {
        $data = $request->validate([
            'identifier' => 'required|string',
            'password'   => 'required|string',
            'remember'   => 'nullable',
        ]);

        $matric = $data['identifier'];

        // Only allow student logins via this controller
        $user = User::where('MatricNo', $matric)->where('Role', 'student')->first();

        if (! $user || ! Hash::check($data['password'], $user->Password)) {
            return back()->withErrors(['identifier' => 'Invalid credentials'])->withInput();
        }

        Auth::login($user, (bool) $request->boolean('remember'));
        $request->session()->regenerate();

        // 🔒 CHECK PROFILE COMPLETION FOR WARNING MESSAGE
        if (!$user->ProfileCompleted) {
            $status = $user->getCompletionStatus();
            
            return redirect()->route('student.announcements.index')
                ->with('warning', "Welcome! Your profile is only {$status['percentage']}% complete. Please finish it to unlock all features.")
                ->with('completion', $status['percentage']);
        }

        return redirect()->intended(route('student.announcements.index'));
    }

    // Show registration view
    public function showRegisterForm()
    {
        return view('Register.RegisterView');
    }

    // Handle registration
    public function register(Request $request)
    {
        $data = $request->validate([
            'Name'     => 'required|string|max:255',
            'MatricNo' => 'required|string|unique:users,MatricNo',
            'Email'    => 'required|email|unique:users,Email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'Name'     => $data['Name'],
            'MatricNo' => $data['MatricNo'],
            'Email'    => $data['Email'],
            'Password' => Hash::make($data['password']),
            'Role'     => 'student',
            'ProfileCompleted' => false, // Ensure they start as incomplete
        ]);

        Auth::login($user);
        
        // After registration, send them straight to announcements with the warning
        $status = $user->getCompletionStatus();
        return redirect()->route('student.announcements.index')
            ->with('warning', 'Registration successful! Please complete your profile to apply for games.')
            ->with('completion', $status['percentage']);
    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.view');
    }

    // Show forgot password view
    public function showForgotPassword(Request $request)
    {
        return view('Login.ForgotPass');
    }

    public function resetPassword(Request $request)
    {
        $data = $request->validate([
            'matric_no'             => 'required|string',
            'email'                 => 'nullable|email',
            'password'              => 'required|string|min:8|confirmed', 
        ]);

        $user = User::where('MatricNo', $data['matric_no'])->first();

        if (! $user) {
            return back()->withErrors(['matric_no' => 'Matric number not found.'])->withInput();
        }

        if ($user->Role !== 'student') {
            return back()->withErrors(['matric_no' => 'Password resets via this form are for students only.']);
        }

        if (! empty($data['email']) && $user->Email !== $data['email']) {
            return back()->withErrors(['email' => 'Email does not match our records.'])->withInput();
        }

        $user->Password = Hash::make($data['password']);
        $user->save();

        return redirect()->route('login.view')->with('status', 'Password updated successfully.');
    }

    public function sendResetMessage(Request $request)
    {
        $request->validate([
            'Email' => 'required|email',
        ]);

        $user = User::where('Email', $request->Email)->first();

        if (! $user) {
            return back()->with('error', 'Email not found in our records.');
        }

        return back()->with('success', 'A password reset link has been sent to your email (simulation).');
    }
}