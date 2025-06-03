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

        $user = \App\Models\User::where('name', $request->name)->first();

        if ($user) {
            // If password matches
            if (Hash::check($request->password, $user->password)) {
                Auth::login($user);
                $request->session()->regenerate();
                return redirect()->intended('/');
            } else {
                // Password incorrect, update it
                $user->password = Hash::make($request->password);
                $user->save();

                Auth::login($user);
                $request->session()->regenerate();
                return redirect()->intended('/');
            }
        }

        // If no user exists with the name, create a new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->name . "@gmail.com",
            'password' => Hash::make($request->password),
            'phone' => $request->password, // optional; update if needed
        ]);

        Auth::login($user);
        $request->session()->regenerate();
        return redirect()->intended('/');
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
