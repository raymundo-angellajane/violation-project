<?php

namespace App\Http\Controllers;

use App\Models\Violation;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ViolationController extends Controller
{
    public function index()
    {
        $violations = Violation::latest()->get();
        return view('violation-entry', compact('violations'));
    }

    public function show($id)
    {
        $violation = Violation::findOrFail($id);
        return view('violations.index', compact('violation'));
    }


    public function create()
    {
        return view('violations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_no' => 'required',
            'name'       => 'required',
            'course'     => 'required',
            'year_level' => 'required',
            'type'       => 'required',
            'date'       => 'required|date',
            'penalty'    => 'required',
            'status'     => 'required'
        ]);

        Violation::create($request->all());

        return redirect()->route('violations.index')
                         ->with('success', 'Violation added successfully.');
    }

    public function edit(Violation $violation)
    {
        return view('violations.edit', compact('violation'));
    }

    public function update(Request $request, Violation $violation)
    {
        $request->validate([
            'student_no' => 'required',
            'name'       => 'required',
            'course'     => 'required',
            'year_level' => 'required',
            'type'       => 'required',
            'date'       => 'required|date',
            'penalty'    => 'required',
            'status'     => 'required'
        ]);

        $violation->update($request->all());

        return redirect()->route('violations.index')
                         ->with('success', 'Violation updated successfully.');
    }

    
    public function destroy(Violation $violation)
    {
        $violation->delete();
        return redirect()->route('violations.index')
                         ->with('success', 'Violation deleted successfully.');
    }

    public function exportPdf()
    {
        $violations = Violation::all(); // fetch from DB
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('violations.pdf', compact('violations'));
        return $pdf->download('violations_report.pdf');
    }
}
