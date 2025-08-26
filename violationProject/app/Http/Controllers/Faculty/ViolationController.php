<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\IntegrationController;
use App\Models\Violation;
use App\Models\Student;
use App\Models\Course;
use Barryvdh\DomPDF\Facade\Pdf;

class ViolationController extends Controller
{
    // Show all violations
    public function index()
    {
        // join students and courses for cleaner display
        $violations = Violation::with(['studentAppeals.appeal', 'student', 'course'])->get();
        return view('violations.violation-entry', compact('violations'));
    }

    // Show create form
    public function create()
    {
        $students = Student::all();
        $courses = Course::all();
        return view('violations.create', compact('students', 'courses'));
    }

    // Store new violation
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_no'     => 'required|string',
            'first_name'     => 'required|string',
            'last_name'      => 'required|string',
            'course_id'      => 'required|exists:courses,course_id',
            'year_level'     => 'required|string',
            'type'           => 'required|string',
            'violation_date' => 'required|date',
            'details'        => 'nullable|string',
            'penalty'        => 'required|string',
            'status'         => 'required|string',
        ]);

        //  Create or find student
        $student = Student::firstOrCreate(
            ['student_no' => $validated['student_no']],
            [
                'first_name' => $validated['first_name'],
                'last_name'  => $validated['last_name'],
                'course_id'  => $validated['course_id'],
                'year_level' => $validated['year_level'],
                'email'      => strtolower($validated['student_no']).'@school.test',
                'contact_no' => 'N/A',
            ]
        );

        //  Create violation
        Violation::create([
            'student_id'     => $student->student_id,
            'course_id'      => $validated['course_id'],
            'year_level'     => $validated['year_level'],
            'type'           => $validated['type'],
            'details'        => $validated['details'],
            'violation_date' => $validated['violation_date'],
            'penalty'        => $validated['penalty'],
            'status'         => $validated['status'],
            'reviewed_by'    => null,
        ]);

        return redirect()->route('faculty.violations.index')->with('success', 'Violation added successfully!');

    }

    // Show edit form
    public function edit($id)
    {
        $violation = Violation::with(['student', 'course'])->findOrFail($id);
        $courses = Course::all();
        return view('violations.edit', compact('violation', 'courses'));
    }

    // Update violation
    public function update(Request $request, $id)
    {
        $violation = Violation::findOrFail($id);

        // Prevent changes to status if it's already Cleared
        if ($violation->status === 'Cleared') {
            return redirect()->route('faculty.violations.index')
                            ->with('error', 'This violation is locked because the appeal was approved.');
        }

        $validated = $request->validate([
            'student_no'     => 'required|string',
            'first_name'     => 'required|string',
            'last_name'      => 'required|string',
            'course_id'      => 'required|exists:courses,course_id',
            'year_level'     => 'required|string',
            'type'           => 'required|string',
            'violation_date' => 'required|date',
            'details'        => 'nullable|string',
            'penalty'        => 'required|string',
            'status'         => 'required|string',
        ]);

        $student = $violation->student;

        $student->update([
            'student_no' => $validated['student_no'],
            'first_name' => $validated['first_name'],
            'last_name'  => $validated['last_name'],
            'course_id'  => $validated['course_id'],
            'year_level' => $validated['year_level'],
        ]);

        $violation->update([
            'course_id'      => $validated['course_id'],
            'year_level'     => $validated['year_level'],
            'type'           => $validated['type'],
            'details'        => $validated['details'],
            'violation_date' => $validated['violation_date'],
            'penalty'        => $validated['penalty'],
            'status'         => $validated['status'],
        ]);

        return redirect()->route('faculty.violations.index')
                        ->with('success', 'Violation updated successfully!');
    }

    // Delete violation
    public function destroy($id)
    {
        Violation::findOrFail($id)->delete();
        return redirect()->route('faculty.violations.index')->with('success', 'Violation deleted successfully!');
    }

    public function exportPdf()
    {
        $violations = \App\Models\Violation::with(['student', 'course'])->get();

        $pdf = Pdf::loadView('violations.pdf', compact('violations'))
                ->setPaper('a4', 'landscape');

        return $pdf->download('violations_report.pdf');
    }
}
