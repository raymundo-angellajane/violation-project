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

    public function create() // form para mag-add ng student
    {
        $courses = Course::all();
        return view('students.create', compact('courses')); // para makuha yung courses sa dropdown
    }

    public function store(Request $request)
    {
        $request->validate([ // validation rules
            'student_no' => 'required|unique:students',
            'first_name' => 'required',
            'last_name'  => 'required',
            'course_id'  => 'required|exists:courses,course_id',
            'year_level' => 'required',
            'email'      => 'required|unique:students|email',
            'contact_no' => 'required',
        ]);

        Student::create($request->all()); // para ma-save sa database

        return redirect()->route('students.index')->with('success', 'Student added successfully.');
    }

    public function edit($id) // malamang form para mag-edit ng student
    {
        $student = Student::findOrFail($id);
        $courses = Course::all();
        return view('students.edit', compact('student', 'courses'));
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id); // para mahanap yung student

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

    public function destroy($id) // para mag-delete ng student
    {
        Student::findOrFail($id)->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }
}
