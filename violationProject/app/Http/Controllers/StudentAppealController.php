<?php

namespace App\Http\Controllers;

use App\Models\StudentAppeal;
use Illuminate\Http\Request;

class StudentAppealController extends Controller
{
    // Submit appeal
    public function store(Request $request)
    {
        $request->validate([
            'violation_id' => 'required|exists:violations,violation_id',
            'appeal_text' => 'required|string|max:1000',
        ]);

        StudentAppeal::create([
            'student_id' => 1, // later replace with Auth::user()->student_id
            'violation_id' => $request->violation_id,
            'appeal_text' => $request->appeal_text,
            'status' => 'Pending',
        ]);

        return back()->with('success', 'Appeal submitted successfully!');
    }
}
