<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware // ung middleware na to is para ma handle ung role based access
// example kung student lang dapat maka access sa student routes diba
{
    public function handle(Request $request, Closure $next, string $role) // yung role is galing sa route definition
    {
        if (!session()->has('user_role')) { 
            return redirect()->route('login')->withErrors([ // kung wala pang session ng role ibig sabihin hindi pa logged in
                'email' => 'Please log in first.'
            ]);
        }

        $sessionRole = strtolower(session('user_role'));
        $expectedRole = strtolower($role);

        if ($sessionRole === 'students') {
            $sessionRole = 'student';
        }
        if ($sessionRole === 'faculties') {
            $sessionRole = 'faculty';
        }

        if ($sessionRole !== $expectedRole) { // if magmismatch yung role sa session at sa expected role
            return redirect()->route('login')->withErrors([
                'email' => 'Unauthorized access for this role.'
            ]);
        }

        return $next($request);
    }
}
