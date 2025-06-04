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
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'password' => 'required|string',
            'is_admin' => 'nullable'
        ]);

        $query = User::where('name', $request->name)
            ->where('phone', $request->phone);

        // If "is_admin" checkbox is present, filter users with is_admin = 1
        if ($request->has('is_admin')) {
            $query->where('is_admin', 1);
        }

        $user = $query->first();

        if ($user) {
            Auth::login($user);
            $request->session()->regenerate();

            return redirect()->intended($user->is_admin ? '/orders' : '/');
        }

        // Create a new user only if "is_admin" is not requested
        if (!$request->has('is_admin')) {
            $user = User::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => uniqid() . '@example.com',
                'password' => Hash::make($request->password),
            ]);

            Auth::login($user);
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        // Admin login attempted but not found
        return back()->withErrors([
            'login' => 'Invalid admin credentials.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
