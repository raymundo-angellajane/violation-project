<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Violation;
use Illuminate\Http\Request;

class ViolationController extends Controller
{
    public function index()
    {
        if (session('user_role') !== 'student') {
            return redirect()->route('login')->withErrors([
                'login' => 'You must be logged in as a student to view violations.'
            ]);
        }

        $violations = Violation::with(['course', 'student', 'studentAppeals.appeal', 'facultyReviewer'])
            ->whereHas('student', function($query) {
                $query->where('student_id', session('user_id'));
            })
            ->get();

        $studentName = session('user_name');

        return view('student.violations', compact('violations', 'studentName'));
    }
}
