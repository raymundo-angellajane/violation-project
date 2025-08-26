<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // make this blade later
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        // Try faculty login
        if (Auth::guard('faculty')->attempt($credentials)) {
            return redirect()->route('faculty.violations.index');
        }

        // Try student login
        if (Auth::guard('student')->attempt($credentials)) {
            return redirect()->route('student.violations.index');
        }

        return back()->withErrors([
            'email' => 'Login failed. Please check your credentials.',
        ]);
    }

    public function logout(Request $request)
    {
        if (Auth::guard('faculty')->check()) {
            Auth::guard('faculty')->logout();
        } elseif (Auth::guard('student')->check()) {
            Auth::guard('student')->logout();
        }

        return redirect()->route('login');
    }
}
