<?php

namespace App\Http\Controllers;

use App\Models\Violation;
use Illuminate\Http\Request;

class FacultyViolationController extends Controller
{
    // List of violations
    public function index()
    {
        $violations = Violation::all();
        return view('faculty.violations.index', compact('violations'));
    }

    // Single violation details
    public function show($id)
    {
        $violation = Violation::findOrFail($id);
        return view('faculty.violations.show', compact('violation'));
    }
}
