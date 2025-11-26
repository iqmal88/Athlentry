<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
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
        'password' => 'required|string',
        'remember' => 'nullable|boolean',
        ]);

        $matric = $data['identifier'];
        $user = \App\Models\User::where('MatricNo', $matric)->where('Role','student')->first();

        if (! $user || ! \Hash::check($data['password'], $user->Password)) {
            return back()->withErrors(['identifier' => 'Invalid credentials'])->withInput();
        }

        \Auth::login($user, (bool)$request->boolean('remember'));
        $request->session()->regenerate();

        return redirect()->intended(route('student.announcements.index'));
    }


    // Show registration view
    public function showRegisterForm(){ 
        
        return view('Register.RegisterView'); 
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'Name' => 'required|string|max:255',
            'MatricNo' => 'required|string|unique:users,MatricNo',
            'Email' => 'required|email|unique:users,Email',
            'Password' => 'required|string|min:8|confirmed',
        ]);

        $user = \App\Models\User::create([
            'Name' => $data['Name'],
            'MatricNo' => $data['MatricNo'],
            'Email' => $data['Email'],
            'Password' => \Hash::make($data['Password']),
            'Role' => 'student',
        ]);

        \Auth::login($user);
        return redirect()->route('Login.LoginView');
    }


    // Handle logout
    public function logout()
    {
        Session::forget('user');
        return redirect()->route('login.view');
    }

    // Show forgot password view
    public function showForgotPassword()
    {
        return view('Login.ForgotPass');
    }

    // Handle forgot password request
    public function sendResetMessage(Request $request)
    {
        $request->validate([
        'Email' => 'required|email',
        ]);

        $user = User::where('Email', $request->Email)->first();

        if (!$user) {
            return back()->with('error', 'Email not found in our records.');
            }

        // For now, just simulate message sent
        // Later you can add actual email sending logic
        return back()->with('success', 'A password reset link has been sent to your email (simulation).');
    }

}
