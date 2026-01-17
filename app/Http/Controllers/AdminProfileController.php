<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminProfileController extends Controller
{
    public function view()
    {
        $admin = Auth::user();
        if (!$admin || $admin->Role !== 'admin') {
            abort(403);
        }
        return view('Profile.Admin.ProfileView', compact('admin'));
    }

    public function edit()
    {
        $admin = Auth::user();
        return view('Profile.Admin.EditProfile', compact('admin'));
    }

    public function update(Request $request)
    {
        $admin = Auth::user();

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,Email,' . $admin->UserID . ',UserID',
            'phone'    => 'nullable|string|max:20',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $admin->Name = $request->name;
        $admin->Email = $request->email;
        $admin->PhoneNumber = $request->phone; // Map phone input to PhoneNumber column

        if ($request->filled('password')) {
            $admin->Password = Hash::make($request->password);
        }

        $admin->save();

        return redirect()->route('admin.profile.view')->with('success', 'Profile updated successfully.');
    }
}