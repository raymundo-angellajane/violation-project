<?php

namespace App\Http\Controllers;

use App\Models\StudentAppeal;
use Illuminate\Http\Request;

class AppealController extends Controller
{
    public function index()
    {
        $appeals = StudentAppeal::with('violation')->get();
        return view('faculty.appeals.index', compact('appeals'));
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Approved,Pending,Declined,Disclosed',
        ]);

        $appeal = StudentAppeal::findOrFail($id);
        $appeal->update([
            'status' => $request->status,
            'reviewed_by' => 1, 
        ]);

        return back()->with('success', 'Appeal reviewed successfully!');
    }
}
