<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use App\Models\StudentAppeal;

class StudentAppealController extends Controller
{
    public function index()
    {
        $this->checkFaculty();
        $appeals = StudentAppeal::with(['student', 'violation', 'appeal'])->get();
        return view('student-appeals.index', compact('appeals'));
    }

    public function destroy($id)
    {
        $this->checkFaculty();
        StudentAppeal::findOrFail($id)->delete();
        return redirect()->route('student-appeals.index')->with('success', 'Student Appeal deleted successfully.');
    }

    private function checkFaculty()
    {
        if (!session('user_id') || session('user_role') !== 'faculty') {
            abort(403, 'Unauthorized: Faculty only.');
        }
    }
}

