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

    // Handle login
    public function login(Request $request)
    {
        $data = $request->validate([
            'identifier' => 'required|string',
            'password'   => 'required|string',
            'remember'   => 'nullable|boolean',
        ]);

        $matric = $data['identifier'];

        // Only allow student logins via this controller
        $user = User::where('MatricNo', $matric)->where('Role', 'student')->first();

        if (! $user || ! Hash::check($data['password'], $user->Password)) {
            return back()->withErrors(['identifier' => 'Invalid credentials'])->withInput();
        }

        Auth::login($user, (bool) $request->boolean('remember'));
        $request->session()->regenerate();

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
        ]);

        Auth::login($user);
        return redirect()->route('login.view');
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
        // Optionally pass role query param to the view for UX (e.g. ?role=admin)
        return view('Login.ForgotPass');
    }

    /**
     * Handle the actual reset request from the ForgotPass form.
     * This endpoint updates the password immediately for the given matric_no,
     * ONLY if the matric record exists and Role === 'student'.
     *
     * IMPORTANT: This is a direct reset flow (form supplies new password).
     * If you prefer token/email-based reset, adapt this to generate a token and send email instead.
     */
    public function resetPassword(Request $request)
    {
        $data = $request->validate([
            'matric_no'             => 'required|string',
            'email'                 => 'nullable|email',
            'password'              => 'required|string|min:8|confirmed', // expects password_confirmation
        ]);

        // Find user by MatricNo
        $user = User::where('MatricNo', $data['matric_no'])->first();

        if (! $user) {
            return back()->withErrors(['matric_no' => 'Matric number not found.'])->withInput();
        }

        // Enforce server-side: only students may reset here
        if ($user->Role !== 'student') {
            return back()->withErrors(['matric_no' => 'Password resets via this form are for students only. Please contact system administrator for admin accounts.']);
        }

        // Optional: if email provided, match it for added safety
        if (! empty($data['email']) && $user->Email !== $data['email']) {
            return back()->withErrors(['email' => 'Email does not match our records for this matric number.'])->withInput();
        }

        // Update the password securely
        $user->Password = Hash::make($data['password']);
        $user->save();

        // Optionally: log the user in automatically after reset
        // Auth::login($user);

        return redirect()->route('login.view')->with('status', 'Password updated successfully. You may now sign in with your new password.');
    }

    // Handle forgot-password "send reset" message (simulation)
    public function sendResetMessage(Request $request)
    {
        $request->validate([
            'Email' => 'required|email',
        ]);

        $user = User::where('Email', $request->Email)->first();

        if (! $user) {
            return back()->with('error', 'Email not found in our records.');
        }

        // For now, just simulate message sent
        // Later you can add actual email sending logic (e.g. Notification::send / Mail::to(...)->send(...))
        return back()->with('success', 'A password reset link has been sent to your email (simulation).');
    }
}
