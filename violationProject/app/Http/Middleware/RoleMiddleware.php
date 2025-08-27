<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        // Check if session has a user role
        if (!session()->has('user_role')) {
            return redirect()->route('login')->withErrors([
                'email' => 'Please log in first.'
            ]);
        }

        $sessionRole = strtolower(session('user_role'));
        $expectedRole = strtolower($role);

        // Normalize common variants
        if ($sessionRole === 'students') {
            $sessionRole = 'student';
        }
        if ($sessionRole === 'faculties') {
            $sessionRole = 'faculty';
        }

        // Role mismatch
        if ($sessionRole !== $expectedRole) {
            return redirect()->route('login')->withErrors([
                'email' => 'Unauthorized access for this role.'
            ]);
        }

        return $next($request);
    }
}
