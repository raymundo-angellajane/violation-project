<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\StudentAppeal;
use App\Models\Appeal;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentAppealController extends Controller
{
    public function index()
    {
        if (session('user_role') !== 'student') {
            return redirect()->route('login')->withErrors([
                'login' => 'You must be logged in as a student to view appeals.'
            ]);
        }

        $studentId = session('user_id');
        $student = Student::find($studentId);

        $appeals = StudentAppeal::with(['violation', 'appeal'])
            ->where('student_id', $studentId)
            ->get();

        return view('student.appeals.index', compact('appeals', 'student'));
    }

    public function create()
    {
        if (session('user_role') !== 'student') {
            return redirect()->route('login')->withErrors([
                'login' => 'You must be logged in as a student to submit an appeal.'
            ]);
        }

        $studentId = session('user_id');
        $student = Student::find($studentId);

        return view('student.appeals.create', compact('student'));
    }

    public function store(Request $request)
    {
        if (session('user_role') !== 'student') {
            return redirect()->route('login')->withErrors([
                'login' => 'You must be logged in as a student to submit an appeal.'
            ]);
        }

        $studentId = session('user_id');

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
            'student_id'   => $studentId,
            'violation_id' => $request->violation_id,
            'appeal_id'    => $appeal->appeal_id,
            'status'       => 'Pending',
        ]);

        return redirect()
            ->route('student.appeals.index')
            ->with('success', 'Appeal submitted successfully.');
    }
}
