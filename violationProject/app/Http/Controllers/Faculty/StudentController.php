<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('course')->get();
        return view('students.index', compact('students'));
    }

    public function create()
    {
        $courses = Course::all();
        return view('students.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_no' => 'required|unique:students',
            'first_name' => 'required',
            'last_name'  => 'required',
            'course_id'  => 'required|exists:courses,course_id',
            'year_level' => 'required',
            'email'      => 'required|unique:students|email',
            'contact_no' => 'required',
        ]);

        Student::create($request->all());

        return redirect()->route('students.index')->with('success', 'Student added successfully.');
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);
        $courses = Course::all();
        return view('students.edit', compact('student', 'courses'));
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $request->validate([
            'student_no' => 'required|unique:students,student_no,' . $student->student_id . ',student_id',
            'first_name' => 'required',
            'last_name'  => 'required',
            'course_id'  => 'required|exists:courses,course_id',
            'year_level' => 'required',
            'email'      => 'required|email|unique:students,email,' . $student->student_id . ',student_id',
            'contact_no' => 'required',
        ]);

        $student->update($request->all());

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy($id)
    {
        Student::findOrFail($id)->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }
}
