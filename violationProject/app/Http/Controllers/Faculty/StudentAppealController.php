<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use App\Models\StudentAppeal;

class StudentAppealController extends Controller // controller to para sa student appeals
{
    public function index() // magli-list ng student appeals
    {
        $this->checkFaculty(); // again, para ma-check kung faculty ang user

        $appeals = StudentAppeal::with(['student', 'violation', 'appeal'])->get();

        return view('student-appeals.index', compact('appeals'));
    }

    public function destroy($id) // magde-delete ng student appeal
    {
        $this->checkFaculty();

        StudentAppeal::findOrFail($id)->delete();

        return redirect()->route('student-appeals.index')
                         ->with('success', 'Student Appeal deleted successfully.');
    }

    private function checkFaculty() 
    {
        if (!session('user_id') || session('user_role') !== 'faculty') {
            abort(403, 'Unauthorized: Faculty only.'); // 403 error kung hindi faculty
        }
    }
}
