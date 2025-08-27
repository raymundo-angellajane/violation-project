<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\StudentAppeal;
use App\Models\Appeal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentAppealController extends Controller
{
    public function index()
    {
        $student = Auth::guard('student')->user();

        if (!$student) {
            return redirect()->route('login')->withErrors([
                'login' => 'You must be logged in as a student to view appeals.'
            ]);
        }

        $appeals = StudentAppeal::with(['violation', 'appeal'])
            ->where('student_id', $student->student_id)
            ->get();

        return view('student.appeals.index', compact('appeals', 'student'));
    }

    public function create()
    {
        $student = Auth::guard('student')->user();

        if (!$student) {
            return redirect()->route('login')->withErrors([
                'login' => 'You must be logged in as a student to submit an appeal.'
            ]);
        }

        return view('student.appeals.create', compact('student'));
    }

    public function store(Request $request)
    {
        $student = Auth::guard('student')->user();

        if (!$student) {
            return redirect()->route('login')->withErrors([
                'login' => 'You must be logged in as a student to submit an appeal.'
            ]);
        }

        $request->validate([
            'violation_id' => 'required|exists:violations,violation_id',
            'appeal_text'  => 'required|string',
        ]);

        $appeal = Appeal::create([
            'appeal_id'   => uniqid('APL-'),
            'appeal_text' => $request->appeal_text,
        ]);

        StudentAppeal::create([
            'student_appeal_id' => uniqid('SAP-'),
            'student_id'   => $student->student_id,
            'violation_id' => $request->violation_id,
            'appeal_id'    => $appeal->appeal_id,
            'status'       => 'Pending',
        ]);

        return redirect()
            ->route('student.appeals.index')
            ->with('success', 'Appeal submitted successfully.');
    }
}
