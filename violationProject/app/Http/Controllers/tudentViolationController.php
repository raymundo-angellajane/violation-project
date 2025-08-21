<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\ViolationStudent;

class StudentViolationController extends Controller
{
    public function index(Request $request)
    {
        // For demo: we assume student_id=1 (replace with Auth::user()->student_id if you have login)
        $student = Student::findOrFail(1);

        $status = $request->input('status'); // filter by status
        $violations = $student->violations()
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->orderBy('date', 'desc')
            ->get();

        return view('students.violations', compact('student', 'violations', 'status'));
    }
}