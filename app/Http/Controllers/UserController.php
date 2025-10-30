<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class UserController extends Controller
{
    // Show the user profile
    public function showProfile()
    {
        $user = Session::get('user');

        if (!$user) {
            return redirect()->route('login.view')->with('error', 'Please log in first.');
        }

        // Refresh user data from DB
        $user = User::find($user->UserID);

        return view('Profile.FMProfile', compact('user'));
    }

    // Update user profile
    public function updateProfile(Request $request)
{
    $request->validate([
        'Email' => 'required|email',
        'PhoneNumber' => 'required|string|max:20',
        'MedicalHistory' => 'nullable|string',
        'Password' => 'nullable|min:6', // optional password validation
    ]);

    $user = Session::get('user');

    if (!$user) {
        return redirect()->route('login.view')->with('error', 'Session expired. Please log in again.');
    }

    $dbUser = User::find($user->UserID);

    // Update editable fields
    $dbUser->Email = $request->Email;
    $dbUser->PhoneNumber = $request->PhoneNumber;
    $dbUser->MedicalHistory = $request->MedicalHistory;

    // Update password only if provided
    if ($request->filled('Password')) {
        $dbUser->Password = \Illuminate\Support\Facades\Hash::make($request->Password);
    }

    $dbUser->save();

    // Update session data
    Session::put('user', $dbUser);

    return back()->with('success', 'Profile updated successfully!');
}

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed', // must match new_password_confirmation
        ]);

        $user = Session::get('user');
        if (!$user) {
            return redirect()->route('login.view')->with('error', 'Please log in again.');
        }

        $dbUser = \App\Models\User::find($user->UserID);

        // Check if current password is correct
        if (!\Illuminate\Support\Facades\Hash::check($request->current_password, $dbUser->Password)) {
            return back()->with('error', 'Your current password is incorrect.');
        }

        // Update to new password
        $dbUser->Password = \Illuminate\Support\Facades\Hash::make($request->new_password);
        $dbUser->save();

        // Update session
        Session::put('user', $dbUser);

        return back()->with('success', 'Password updated successfully!');
    }

    public function editProfile()
    {
        $user = Session::get('user');

        if (!$user) {
            return redirect()->route('login.view')->with('error', 'Please log in first.');
        }

        $user = User::find($user->UserID);

        return view('Profile.EditFmProfile', compact('user'));
    }


}
