<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminProfileController extends Controller
{
    /**
     * Display admin profile
     */
    public function view()
    {
        $admin = Auth::user();

        // Safety check (extra, tapi bagus untuk FYP)
        if (!$admin || $admin->Role !== 'admin') {
            abort(403, 'Unauthorized access');
        }

        return view('Profile.Admin.ProfileView', compact('admin'));
    }

    /**
     * Show edit admin profile form
     */
    public function edit()
    {
        $admin = Auth::user();

        if (!$admin || $admin->Role !== 'admin') {
            abort(403, 'Unauthorized access');
        }

        return view('Profile.Admin.EditProfile', compact('admin'));
    }

    /**
     * Update admin profile
     */
    public function update(Request $request)
    {
        $admin = Auth::user();

        if (!$admin || $admin->Role !== 'admin') {
            abort(403, 'Unauthorized access');
        }

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'nullable|email',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $admin->Name  = $request->name;
        $admin->Email = $request->email;

        // Update password only if admin enters new password
        if ($request->filled('password')) {
            $admin->Password = Hash::make($request->password);
        }

        $admin->save();

        return redirect()
            ->route('admin.profile.view')
            ->with('success', 'Admin profile updated successfully.');
    }
}
