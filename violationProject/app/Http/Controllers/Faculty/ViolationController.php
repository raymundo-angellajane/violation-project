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
    // to show ano yung laman ng violations table
    public function index()
    {
        $violations = Violation::with(['studentAppeals.appeal', 'student', 'course'])->get();
        return view('violations.violation-entry', compact('violations'));
    }

    public function create() // para ka mag add ng violation
    {
        $students = Student::all();
        $courses = Course::all();
        return view('violations.create', compact('students', 'courses'));
    }

    public function store(Request $request) // para ma save yung violation
    {
        $validated = $request->validate([
            'student_id'      => 'nullable|exists:students,student_id', // pipili ka kung existing student or manual entry
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

        if ($validated['student_id']) { // para to check kung existing student ba
            $student = Student::findOrFail($validated['student_id']);
        } 
        else { // kung manual entry naman
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

        Violation::create([ // para mag create ng violation
            'student_id'     => $student->student_id,
            'course_id'      => $validated['course_id'],
            'year_level'     => $student->year_level ?? $validated['year_level'] ?? 'N/A', // kung wala sa student table yung year level, gagamitin yung galing sa form, kung wala din dun, 'N/A' na lang
            'type'           => $validated['type'],
            'violation_date' => $validated['violation_date'],
            'details'        => $validated['details'] ?? null,
            'penalty'        => $validated['penalty'],
            'status'         => $validated['status'] ?? 'Pending',
        ]);

        return redirect() // para mag redirect sa index page
            ->route('faculty.violations.index')
            ->with('success', 'Violation added successfully.');
    }

    public function edit($id) // edit yan
    {
        $violation = Violation::with(['student', 'course'])->findOrFail($id);
        $courses = Course::all();
        $students  = Student::all();
        return view('violations.edit', compact('violation', 'courses', 'students'));
    }

    public function update(Request $request, $id) // update ka ning violation
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

        if ($validated['student_id']) {// ito ulit magccheck kung existing student ba
            $student = Student::findOrFail($validated['student_id']);
        } 
        else { // o kung manual mo nilagay
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

    public function destroy($id) // basta pag destroy, delete na
    {
        Violation::findOrFail($id)->delete();
        return redirect()->route('faculty.violations.index')->with('success', 'Violation deleted successfully!');
    }

    public function exportPdf() // para ma export sa pdf
    {
        $violations = Violation::with(['student', 'course'])->get();

        $pdf = Pdf::loadView('violations.pdf', compact('violations'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('violations_report.pdf'); // para ma download
    }
}
