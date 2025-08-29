<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index() // magli-list ng courses
    {
        $courses = Course::all();
        return view('courses.index', compact('courses')); // magre-return ng view na may listahan ng courses
    }

    public function create() // magdi-display ng form para mag-add ng new course
    {
        return view('courses.create');
    }

    public function store(Request $request) // magse-save ng new course
    {
        $request->validate([
            'course_name' => 'required',
            'course_code' => 'required|unique:courses',
        ]);

        Course::create($request->all());

        return redirect()->route('courses.index')->with('success', 'Course added successfully.');
    }

    public function edit($id) // magdi-display ng form para mag-edit ng existing course
    {
        $course = Course::findOrFail($id);
        return view('courses.edit', compact('course'));
    }

    public function update(Request $request, $id) // magse-save ng changes sa existing course
    {
        $course = Course::findOrFail($id);

        $request->validate([
            'course_name' => 'required',
            'course_code' => 'required|unique:courses,course_code,' . $course->course_id . ',course_id',
        ]);

        $course->update($request->all()); 

        return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
    }

    public function destroy($id) // magde-delete ng course
    {
        Course::findOrFail($id)->delete();
        return redirect()->route('courses.index')->with('success', 'Course deleted successfully.');
    }
}
