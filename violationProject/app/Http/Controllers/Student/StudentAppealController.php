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
        //$studentId = Auth::user()->student_id;

        $studentId = 1; 

        $appeals = StudentAppeal::with(['violation', 'appeal'])
                        ->where('student_id', $studentId)
                        ->get();

        return view('student.appeals.index', compact('appeals'));
    }

    public function create()
    {
        //$studentId = Auth::user()->student_id;

        $studentId = 1; 

        return view('student.appeals.create');
    }

    public function store(Request $request)
    {
        //$studentId = Auth::user()->student_id;

        $studentId = 1; 

        $request->validate([
            'violation_id' => 'required|exists:violations,violation_id',
            'appeal_text'  => 'required',
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

        return redirect()->route('student.appeals.index')->with('success', 'Appeal submitted successfully.');
    }
}
