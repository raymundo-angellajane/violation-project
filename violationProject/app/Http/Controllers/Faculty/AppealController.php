<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use App\Models\Appeal;
use Illuminate\Http\Request;

class AppealController extends Controller
{
    public function index()
    {
        $appeals = Appeal::with('studentAppeals.student')->get();
        return view('appeals.index', compact('appeals'));
    }

    public function review($id)
    {
        $appeal = Appeal::with('studentAppeals.student')->findOrFail($id);
        return view('appeals.review', compact('appeal'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Approved,Rejected',
        ]);

        $appeal = Appeal::with('studentAppeals.violation')->findOrFail($id);

        foreach ($appeal->studentAppeals as $sa) {
            $sa->update([
                'status' => $request->status,
                'reviewed_by' => auth()->id(),
                'reviewed_at' => now(),
            ]);

            if ($request->status === 'Approved') {
                $sa->violation->update(['status' => 'Cleared']);
            } else {
                $sa->violation->update(['status' => 'Disclosed']);
            }
        }

        return redirect()->route('faculty.appeals.index')
            ->with('success', 'Appeal reviewed successfully.');
    }
}
