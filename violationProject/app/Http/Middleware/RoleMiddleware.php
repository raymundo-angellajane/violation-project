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
        // Check if session exists
        if (!session()->has('user_role')) {
            return redirect()->route('login')->withErrors([
                'email' => 'Please log in first.'
            ]);
        }

        // Check if role matches
        if (session('user_role') !== $role) {
            return redirect()->route('login')->withErrors([
                'email' => 'Unauthorized access for this role.'
            ]);
        }

        return $next($request);
    }
}
