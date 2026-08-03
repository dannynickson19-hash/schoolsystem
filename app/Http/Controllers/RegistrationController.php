<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    public function create()
    {
        return view('pages.registration');
    }

    // Handles saving the form data into MySQL
    public function store(Request $request)
    {
        // 1. Validate inputs
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'email'    => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // 2. Insert into the 'users' table
        User::create([
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 3. Redirect back with success message
        return redirect()->back()->with('success', 'Account registered successfully!');
    }
}
