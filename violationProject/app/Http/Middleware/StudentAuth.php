<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class StudentAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('token') || session('role') !== 'student') {
            return redirect()->route('student.login');
        }
        return $next($request);
    }
}
