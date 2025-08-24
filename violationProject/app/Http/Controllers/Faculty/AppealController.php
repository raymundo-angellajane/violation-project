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

    public function updateStatus(Request $request, $id)
    {
        $appeal = Appeal::findOrFail($id);
        $appeal->update(['reviewed_at' => now()]);

        $appeal->studentAppeals()->update([
            'status' => $request->status,
            'reviewed_by' => auth()->id() // assuming faculty login
        ]);

        return redirect()->route('appeals.index')->with('success', 'Appeal reviewed successfully.');
    }
}
