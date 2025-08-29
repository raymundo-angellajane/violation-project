<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Violation;
use Illuminate\Http\Request;
use App\Models\Student;

class ViolationController extends Controller
{
    public function index()
    {
        // Check session for student role
        if (session('user_role') !== 'student') {
            return redirect()->route('login')->withErrors([
                'login' => 'You must be logged in as a student to view violations.'
            ]);
        }

        $studentId = session('user_id');
        $student = Student::find($studentId); // Optional: only if you need full student model

        $violations = Violation::with(['course', 'student', 'studentAppeals.appeal', 'facultyReviewer'])
            ->where('student_id', $studentId)
            ->get();

        return view('student.violations', [
            'violations' => $violations,
            'student' => $student
        ]);
    }
}
