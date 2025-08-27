<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Violation;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ViolationController extends Controller
{
    public function index()
    {
        $student = Auth::guard('student')->user();

        if (!$student) {
            return redirect()->route('login')->withErrors([
                'login' => 'You must be logged in as a student to view violations.'
            ]);
        }

        $violations = Violation::with(['course', 'student', 'studentAppeals.appeal', 'facultyReviewer'])
            ->where('student_id', $student->student_id)
            ->get();

        return view('student.violations', compact('violations', 'student'));
    }
}
