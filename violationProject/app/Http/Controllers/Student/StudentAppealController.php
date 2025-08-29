<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\StudentAppeal;
use App\Models\Appeal;
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

        $appeals = StudentAppeal::with(['violation', 'appeal'])
            ->where('student_id', session('user_id'))
            ->get();

        $studentName = session('user_name');

        return view('student.appeals.index', compact('appeals', 'studentName'));
    }

    public function create()
    {
        if (session('user_role') !== 'student') {
            return redirect()->route('login')->withErrors([
                'login' => 'You must be logged in as a student to submit an appeal.'
            ]);
        }

        $studentName = session('user_name');

        return view('student.appeals.create', compact('studentName'));
    }

    public function store(Request $request)
    {
        if (session('user_role') !== 'student') {
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
            'student_id'   => session('user_id'),
            'violation_id' => $request->violation_id,
            'appeal_id'    => $appeal->appeal_id,
            'status'       => 'Pending',
        ]);

        return redirect()
            ->route('student.appeals.index')
            ->with('success', 'Appeal submitted successfully.');
    }
}
