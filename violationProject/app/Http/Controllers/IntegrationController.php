<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Student;
use App\Models\Faculty;

class IntegrationController extends Controller
{
    /**
     * Show login form
     */
    public function showLoginForm()
    {
        return view('auth.login'); // make sure you have resources/views/auth/login.blade.php
    }

    /**
     * Handle login
     */
    public function loginUser(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required|in:student,faculty',
        ]);

        // Try faculty login
        if ($request->role === 'faculty') {
            if (Auth::guard('faculty')->attempt([
                'email' => $request->email,
                'password' => $request->password,
            ])) {
                $faculty = Auth::guard('faculty')->user();
                session([
                    'user_role' => 'faculty',
                    'user_id' => $faculty->faculty_id,
                ]);
                return redirect()->route('faculty.violations.index')
                                 ->with('success', 'Welcome Faculty!');
            }
        }

        // Try student login
        if ($request->role === 'student') {
            if (Auth::guard('student')->attempt([
                'email' => $request->email,
                'password' => $request->password,
            ])) {
                $student = Auth::guard('student')->user();
                session([
                    'user_role' => 'student',
                    'user_id' => $student->student_id,
                ]);
                return redirect()->route('student.violations.index')
                                 ->with('success', 'Welcome Student!');
            }
        }

        return back()->withErrors([
            'login' => 'Login failed. Please check your credentials.',
        ]);
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        if (Auth::guard('faculty')->check()) {
            Auth::guard('faculty')->logout();
        } elseif (Auth::guard('student')->check()) {
            Auth::guard('student')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out.');
    }
}
