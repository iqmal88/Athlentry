<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('Login.Admin.AdminLoginView');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'matric_no' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('MatricNo', $credentials['matric_no'])->first();

        if (! $user) {
            return back()->withErrors(['matric_no' => 'No account found with that Matric Number.'])->withInput();
        }

        if ($user->Role !== 'admin') {
            return back()->withErrors(['matric_no' => 'You are not authorized to access admin panel.'])->withInput();
        }

        if (! Hash::check($credentials['password'], $user->Password)) {
            return back()->withErrors(['password' => 'Invalid password'])->withInput();
        }

        Auth::login($user);
        return redirect()->route('admin.dashboard');
    }
}
