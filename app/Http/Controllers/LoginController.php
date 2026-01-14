<?php

namespace App\Http\Controllers;

use App\Models\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    //

    public function login(Request $request)
    {
        // Handle login logic
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if(Auth::guard('login')->attempt($validated)) {
            $request->session()->regenerate();
            return redirect()->route('chatView');
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function signup(Request $request)
    {
        // Handle signup logic
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:logins,email',
            'password' => 'required|string|min:4|confirmed',
        ]);

        $user = Login::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::guard('login')->login($user);
        return redirect()->route('chatView');
    }

    // Logout function
    public function logout(Request $request)
    {
        Auth::guard('login')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
