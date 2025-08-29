<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Violation;
use App\Models\Student;
use App\Models\Course;
use Barryvdh\DomPDF\Facade\Pdf;

class ViolationController extends Controller
{
    // Show all violations
    public function index()
    {
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
            'student_id'      => 'nullable|exists:students,student_id',
            'student_no'      => 'nullable|string|max:50',
            'first_name'      => 'nullable|string|max:100',
            'last_name'       => 'nullable|string|max:100',
            'course_id'       => 'required|exists:courses,course_id',
            'year_level'      => 'nullable|string|max:20',
            'type'            => 'required|in:Minor,Major',
            'violation_date'  => 'required|date',
            'details'         => 'nullable|string',
            'penalty'         => 'required|string|max:255',
            'status'          => 'nullable|in:Pending,Disclosed',
        ]);

        // Case 1: Select existing student
        if ($validated['student_id']) {
            $student = Student::findOrFail($validated['student_id']);
        } 
        // Case 2: Manual entry (create or update student)
        else {
            $student = Student::firstOrCreate(
                ['student_no' => $validated['student_no']],
                [
                    'first_name' => $validated['first_name'],
                    'last_name'  => $validated['last_name'],
                    'course_id'  => $validated['course_id'],
                    'year_level' => $validated['year_level'],
                ]
            );
        }

        // Create violation
        Violation::create([
            'student_id'     => $student->student_id,
            'course_id'      => $validated['course_id'],
            'year_level'     => $student->year_level ?? $validated['year_level'] ?? 'N/A',
            'type'           => $validated['type'],
            'violation_date' => $validated['violation_date'],
            'details'        => $validated['details'] ?? null,
            'penalty'        => $validated['penalty'],
            'status'         => $validated['status'] ?? 'Pending',
        ]);

        return redirect()
            ->route('faculty.violations.index')
            ->with('success', 'Violation added successfully.');
    }

    // Edit form
    public function edit($id)
    {
        $violation = Violation::with(['student', 'course'])->findOrFail($id);
        $courses = Course::all();
        $students  = Student::all();
        return view('violations.edit', compact('violation', 'courses', 'students'));
    }

    // Update violation
    public function update(Request $request, $id)
    {
        $violation = Violation::findOrFail($id);

        $validated = $request->validate([
            'student_id'      => 'nullable|exists:students,student_id',
            'student_no'      => 'nullable|string|max:50',
            'first_name'      => 'nullable|string|max:100',
            'last_name'       => 'nullable|string|max:100',
            'course_id'       => 'required|exists:courses,course_id',
            'year_level'      => 'nullable|string|max:20',
            'type'            => 'required|in:Minor,Major',
            'violation_date'  => 'required|date',
            'details'         => 'nullable|string',
            'penalty'         => 'required|string|max:255',
            'status'          => 'nullable|in:Pending,Disclosed',
        ]);

        // Case 1: Existing student
        if ($validated['student_id']) {
            $student = Student::findOrFail($validated['student_id']);
        } 
        // Case 2: Manual entry
        else {
            $student = Student::firstOrCreate(
                ['student_no' => $validated['student_no']],
                [
                    'first_name' => $validated['first_name'],
                    'last_name'  => $validated['last_name'],
                    'course_id'  => $validated['course_id'],
                    'year_level' => $validated['year_level'],
                ]
            );
        }

        // Update violation
        $violation->update([
            'student_id'     => $student->student_id,
            'course_id'      => $validated['course_id'],
            'year_level'     => $student->year_level ?? $validated['year_level'] ?? 'N/A',
            'type'           => $validated['type'],
            'violation_date' => $validated['violation_date'],
            'details'        => $validated['details'] ?? null,
            'penalty'        => $validated['penalty'],
            'status'         => $validated['status'] ?? 'Pending',
        ]);

        return redirect()
            ->route('faculty.violations.index')
            ->with('success', 'Violation updated successfully.');
    }


    // Delete
    public function destroy($id)
    {
        Violation::findOrFail($id)->delete();
        return redirect()->route('faculty.violations.index')->with('success', 'Violation deleted successfully!');
    }

    // Export PDF
    public function exportPdf()
    {
        $violations = Violation::with(['student', 'course'])->get();

        $pdf = Pdf::loadView('violations.pdf', compact('violations'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('violations_report.pdf');
    }
}
