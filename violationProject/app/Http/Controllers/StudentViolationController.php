<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Violation;

class StudentViolationController extends Controller
{
    // Show all violations for the logged-in student
    public function index()
    {
        // Replace with Auth::user()->student_id later
        // $violations = ViolationStudent::where('student_id', 1)->get();

        // return view('student.violations', compact('violations'));
        $violations = Violation::all();
        return view('student.violations', compact('violations'));
    }
}
