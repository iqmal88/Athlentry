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
        $request->validate([
            'MatricNo' => 'required',
            'Password' => 'required',
        ]);

        $user = User::where('MatricNo', $request->MatricNo)->first();

        if ($user && Hash::check($request->Password, $user->Password)) {
            Session::put('user', $user);
            return redirect()->route('dashboard'); // Change to your dashboard route
        }

        return back()->with('error', 'Invalid Matric No or Password.');
    }

    // Show registration view
    public function showRegister()
    {
        return view('Register.RegisterView');
    }

    // Handle registration
    public function register(Request $request)
    {
        $request->validate([
            'Name' => 'required|string|max:255',
            'Email' => 'required|email|unique:User,Email',
            'MatricNo' => 'required|string|max:50|unique:User,MatricNo',
            'PhoneNumber' => 'required|string|max:20',
            'Password' => 'required|min:6',
        ]);

        $user = new User();
        $user->Name = $request->Name;
        $user->Email = $request->Email;
        $user->MatricNo = $request->MatricNo;
        $user->PhoneNumber = $request->PhoneNumber;
        $user->Password = Hash::make($request->Password);
        $user->MedicalHistory = $request->MedicalHistory;
        $user->save();

        return redirect()->route('login.view')->with('success', 'Registration successful! Please login.');
    }

    // Handle logout
    public function logout()
    {
        Session::forget('user');
        return redirect()->route('login.view');
    }
}
