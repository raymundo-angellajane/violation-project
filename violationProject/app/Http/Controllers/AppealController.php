<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Violation;
use App\Models\Appeal;

class AppealController extends Controller
{
    // Show the appeal form
    public function create(Violation $violation)
    {
        return view('appeals.create', compact('violation'));
    }

    // Store the appeal
    public function store(Request $request)
    {
        $request->validate([
            'violation_id' => 'required|exists:violations,id',
            'message' => 'required|string|max:1000',
        ]);

        Appeal::create([
            'violation_id' => $request->violation_id,
            'student' => auth()->user()->name,
            'message' => $request->message,
            'status' => 'Pending',
        ]);

        return redirect()->route('student.violations')->with('success', 'Appeal submitted successfully!');
    }
}
