<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'name' => 'required|string',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        // Create new user if login fails
        $user = User::create([
            'name' => $request->name, // Use username as name for simplicity
            'email' => $request->name."@gmail.com",
            'password' => Hash::make($request->password),
            'phone' => $request->password
        ]);

        // Log in the new user
        Auth::login($user);
        $request->session()->regenerate();
        return redirect()->intended('/');

        // Note: Removed error return since we create a new user instead
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
