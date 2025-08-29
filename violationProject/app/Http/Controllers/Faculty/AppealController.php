<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use App\Models\Appeal;
use Illuminate\Http\Request;

class AppealController extends Controller
{
    public function index()
    {
        $this->checkFaculty();

        $appeals = Appeal::with('studentAppeals.student')->get();

        return view('faculty.appeals.index', [
            'appeals' => $appeals,
            'faculty' => session('user_name'),
        ]);
    }

    public function review($id)
    {
        $this->checkFaculty();

        $appeal = Appeal::with('studentAppeals.student', 'studentAppeals.violation')
            ->findOrFail($id);

        return view('faculty.appeals.review', [
            'appeal'  => $appeal,
            'faculty' => session('user_name'),
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->checkFaculty();

        $request->validate([
            'status' => 'required|in:Approved,Rejected',
        ]);

        $appeal = Appeal::with('studentAppeals.violation')->findOrFail($id);

        foreach ($appeal->studentAppeals as $sa) {
            $sa->update([
                'status'      => $request->status,
                'reviewed_by' => session('user_id'), // FAC-xxxx
                'reviewed_at' => now(),
            ]);

            if ($sa->violation) {
                $sa->violation->update([
                    'status' => $request->status === 'Approved' ? 'Cleared' : 'Disclosed',
                ]);
            }
        }

        return redirect()->route('faculty.appeals.index')
            ->with('success', 'Appeal reviewed successfully.');
    }

    public function approve($id)
    {
        $this->checkFaculty();

        $appeal = Appeal::with('studentAppeals.violation')->findOrFail($id);

        foreach ($appeal->studentAppeals as $sa) {
            $sa->update([
                'status'      => 'Approved',
                'reviewed_by' => session('user_id'), // FAC-xxxx
                'reviewed_at' => now(),
            ]);

            if ($sa->violation) {
                $sa->violation->update(['status' => 'Cleared']);
            }
        }

        $appeal->update(['status' => 'Approved']);

        return redirect()->back()->with('success', 'Appeal approved and violation cleared.');
    }

    private function checkFaculty()
    {
        if (!session('user_id') || session('user_role') !== 'faculty') {
            return redirect()->route('login')->withErrors([
                'login' => 'You must be logged in as faculty.',
            ]);
        }
    }
}
