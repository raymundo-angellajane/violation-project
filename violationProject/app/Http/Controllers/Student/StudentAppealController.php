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
        $userId = session('user_id');
        $role   = session('user_role');

        if (!$userId || $role !== 'student') {
            return redirect()->route('login')->withErrors([
                'login' => 'You must be logged in as a student to view appeals.'
            ]);
        }

        $appeals = StudentAppeal::with(['violation', 'appeal'])
            ->where('student_id', $userId)
            ->get();

        return view('student.violations.index', compact('appeals'));
    }

    public function create()
    {
        $userId = session('user_id');
        $role   = session('user_role');

        if (!$userId || $role !== 'student') {
            return redirect()->route('login')->withErrors([
                'login' => 'You must be logged in as a student to submit an appeal.'
            ]);
        }

        return view('student.appeals.create');
    }

    public function store(Request $request)
    {
        $userId = session('user_id');
        $role   = session('user_role');

        if (!$userId || $role !== 'student') {
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
            'student_id'   => $userId,
            'violation_id' => $request->violation_id,
            'appeal_id'    => $appeal->appeal_id,
            'status'       => 'Pending',
        ]);

        return redirect()
            ->route('student.appeals.index')
            ->with('success', 'Appeal submitted successfully.');
    }
}
