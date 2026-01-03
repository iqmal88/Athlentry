<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Show logged-in student profile
     */
    public function showProfile()
    {
        $user = Auth::user(); // 🔥 AUTH ONLY

        return view('Profile.Student.AthleteProfile', compact('user'));
    }

    /**
     * Show edit profile page
     */
    public function editProfile()
    {
        $user = Auth::user();

        return view('Profile.Student.AthleteEditProfile', compact('user'));
    }

    /**
     * Update student profile (email, phone, medical history)
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'Email'           => 'required|email',
            'PhoneNumber'     => 'required|string|max:20',
            'MedicalHistory'  => 'nullable|string',
            'Password'        => 'nullable|min:6',
        ]);

        $user = Auth::user();

        $user->Email          = $request->Email;
        $user->PhoneNumber    = $request->PhoneNumber;
        $user->MedicalHistory = $request->MedicalHistory;

        // Optional password update
        if ($request->filled('Password')) {
            $user->Password = Hash::make($request->Password);
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully!');
    }

    /**
     * Change password (with current password verification)
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password'      => 'required',
            'new_password'          => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        // Check current password
        if (!Hash::check($request->current_password, $user->Password)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        $user->Password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password updated successfully!');
    }
}
