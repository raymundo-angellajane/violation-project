<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // para to sa login form
    }

    public function login(Request $request) // ito yung nag ha-handle ng login
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password'); // kukuha ng email at password

        // faculty login
        if (Auth::guard('faculty')->attempt($credentials)) {
            return redirect()->route('faculty.violations.index');
        }

        // student login
        if (Auth::guard('student')->attempt($credentials)) {
            return redirect()->route('student.violations.index');
        }

        return back()->withErrors([ // pag mali ang credentials, magrereturn to sa login form
            'email' => 'Login failed. Please check your credentials.',
        ]);
    }

    public function logout(Request $request) // ito yung nag ha-handle ng logout
    {
        if (Auth::guard('faculty')->check()) { // check kung faculty ang naka-login
            Auth::guard('faculty')->logout(); // logout ng faculty
        } elseif (Auth::guard('student')->check()) { //magccheck kung student ang naka-login
            Auth::guard('student')->logout(); // logout ng student
        }

        return redirect()->route('login'); // pag logout, ire-redirect sa login page
    }
}
