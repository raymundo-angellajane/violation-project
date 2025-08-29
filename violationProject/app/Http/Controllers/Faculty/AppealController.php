<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use App\Models\Appeal;
use Illuminate\Http\Request;

class AppealController extends Controller
{
    public function index()
    {
        $userId = session('user_id');
        $role   = session('user_role');

        if (!$userId || $role !== 'faculty') {
            return redirect()->route('login')->withErrors([
                'login' => 'You must be logged in as faculty to view appeals.'
            ]);
        }

        $appeals = Appeal::with('studentAppeals.student')->get();

        return view('faculty.appeals.index', [
            'appeals' => $appeals,
            'faculty' => session('user_name'),
        ]);
    }

    public function review($id)
    {
        $userId = session('user_id');
        $role   = session('user_role');

        if (!$userId || $role !== 'faculty') {
            return redirect()->route('login')->withErrors([
                'login' => 'You must be logged in as faculty to review appeals.'
            ]);
        }

        $appeal = Appeal::with('studentAppeals.student', 'studentAppeals.violation')
            ->findOrFail($id);

        return view('faculty.appeals.review', [
            'appeal'  => $appeal,
            'faculty' => session('user_name'),
        ]);
    }

    public function update(Request $request, $id)
    {
        $userId = session('user_id');
        $role   = session('user_role');

        if (!$userId || $role !== 'faculty') {
            return redirect()->route('login')->withErrors([
                'login' => 'You must be logged in as faculty to update appeals.'
            ]);
        }

        $request->validate([
            'status' => 'required|in:Approved,Rejected',
        ]);

        $appeal = Appeal::with('studentAppeals.violation')->findOrFail($id);

        foreach ($appeal->studentAppeals as $sa) {
            $sa->update([
                'status'       => $request->status,
                'reviewed_by'  => $userId,
                'reviewed_at'  => now(),
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
        $userId = session('user_id');
        $role   = session('user_role');

        if (!$userId || $role !== 'faculty') {
            return redirect()->route('login')->withErrors([
                'login' => 'You must be logged in as faculty to approve appeals.'
            ]);
        }

        $appeal = Appeal::with('studentAppeals.violation')->findOrFail($id);

        foreach ($appeal->studentAppeals as $sa) {
            $sa->update([
                'status'      => 'Approved',
                'reviewed_by' => $userId,
                'reviewed_at' => now(),
            ]);

            if ($sa->violation) {
                $sa->violation->update(['status' => 'Cleared']);
            }
        }

        $appeal->update(['status' => 'Approved']);

        return redirect()->back()->with('success', 'Appeal approved and violation cleared.');
    }
}

