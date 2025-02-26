<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // Show the list of profiles
    public function index()
    {
        $users = User::all(); // Assuming you have a Profile model
        return view('dashboard.user.index', compact('users'));
    }

    // Show the form to create a new profile
    public function create()
    {
        return view('profile.create');
    }

    // Store a newly created profile
    public function store(Request $request)
    {
        // Store profile logic here
    }

    // Show the details of a single profile
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('dashboard.user.show', compact('user'));
    }

    // Show the form to edit an existing profile
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('dashboard.user.edit', compact('user'));
    }

    // Update an existing profile
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'old_password' => 'required|string|min:6', // Validate old password input
            'password' => 'nullable|string|min:6|confirmed', // Validate new password if provided
        ]);

        // Check if the old password entered matches the current user's password
        $user = Auth::user();
        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'The provided old password does not match our records.']);
        }

        // Update the user's profile
        $user->name = $request->name;
        $user->email = $request->email;

        // Update password if a new one is provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('profile.index')->with('success', 'Profile updated successfully!');
    }

    // Delete a profile
    public function destroy($id)
    {
        // Delete profile logic here
    }
}

