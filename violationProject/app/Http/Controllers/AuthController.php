<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required|in:student,faculty',
        ]);

        $credentials = $request->only('email', 'password');
        $role = $request->role;

        if (Auth::guard($role)->attempt($credentials)) {
            $request->session()->regenerate();

            return $role === 'student'
                ? redirect()->route('student.violations.index')
                : redirect()->route('faculty.violations.index');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials for ' . $role . '.',
        ]);
    }

    public function logout(Request $request)
    {
        if (Auth::guard('student')->check()) {
            Auth::guard('student')->logout();
        } elseif (Auth::guard('faculty')->check()) {
            Auth::guard('faculty')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
