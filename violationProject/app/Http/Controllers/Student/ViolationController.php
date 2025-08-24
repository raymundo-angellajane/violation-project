<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Violation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ViolationController extends Controller
{
    public function index()
    {
         // Temporary for testing
        $studentId = 1;

        //$studentId = Auth::user()->student_id; 
        $violations = Violation::with(['course', 'student', 'studentAppeals.appeal','facultyReviewer'])
                            ->where('student_id', $studentId)
                            ->get();

        $student = \App\Models\Student::find($studentId);

        return view('student.violations', compact('violations', 'student'));
    }
}