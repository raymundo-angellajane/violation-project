<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ViolationStudent;

class StudentViolationController extends Controller
{
    // Show all violations for the logged-in student
    public function index()
    {
        // Replace with Auth::user()->student_id later
        $violations = ViolationStudent::where('student_id', 1)->get();

        return view('student.violations', compact('violations'));
    }

    // Submit appeal
    public function submitAppeal(Request $request)
    {
        $request->validate([
            'violation_id' => 'required|exists:violation_students,id',
            'appeal' => 'required|string|max:1000',
        ]);

        $violation = ViolationStudent::findOrFail($request->violation_id);

        if ($violation->appeal) {
            return back()->with('error', 'Appeal already submitted.');
        }

        $violation->update([
            'appeal' => $request->appeal,
            'status' => 'pending',
            'reviewed_by' => null,
        ]);

        return back()->with('success', 'Appeal submitted successfully.');
    }
}
