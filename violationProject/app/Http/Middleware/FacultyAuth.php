<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class FacultyAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('token') || session('role') !== 'faculty') {
            return redirect()->route('faculty.login');
        }
        return $next($request);
    }
}
