<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
{
    $request->validate([
        'username' => 'required',
        'password' => 'required'
    ]);

    $user = User::where('username', $request->username)->first();

    if ($user && Hash::check($request->password, $user->password)) {
        Auth::login($user);

        return redirect()->route('dashboard');
    }

    return back()->with('error', 'Invalid username or password');
}
}
