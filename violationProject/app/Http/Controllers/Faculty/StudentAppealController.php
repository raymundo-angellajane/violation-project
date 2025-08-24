<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use App\Models\StudentAppeal;
use Illuminate\Http\Request;

class StudentAppealController extends Controller
{
    public function index()
    {
        $appeals = StudentAppeal::with(['student', 'violation', 'appeal'])->get();
        return view('student-appeals.index', compact('appeals'));
    }

    public function destroy($id)
    {
        StudentAppeal::findOrFail($id)->delete();
        return redirect()->route('student-appeals.index')->with('success', 'Student Appeal deleted successfully.');
    }
}
