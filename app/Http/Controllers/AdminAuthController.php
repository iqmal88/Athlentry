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
        $data = $request->validate([
            'identifier' => 'required|string', // from view
            'password' => 'required|string',
            'remember' => 'nullable|boolean',
        ]);

        $matric = $data['identifier'];
        $user = \App\Models\User::where('MatricNo', $matric)->where('Role','admin')->first();

        if (! $user || ! \Hash::check($data['password'], $user->Password)) {
            return back()->withErrors(['identifier' => 'Invalid credentials'])->withInput();
        }

        \Auth::login($user, (bool)$request->boolean('remember'));
        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }
}
