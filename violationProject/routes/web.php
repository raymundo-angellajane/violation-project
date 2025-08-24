<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Faculty\AppealController as FacultyAppealController;
use App\Http\Controllers\Faculty\CourseController as FacultyCourseController;
use App\Http\Controllers\Faculty\StudentAppealController as FacultyStudentAppealController;
use App\Http\Controllers\Faculty\StudentController as FacultyStudentController;
use App\Http\Controllers\Faculty\ViolationController as FacultyViolationController;

use App\Http\Controllers\Student\StudentAppealController as StudentAppealController;
use App\Http\Controllers\Student\ViolationController as StudentViolationController;

Route::prefix('faculty')->name('faculty.')->group(function () {
    Route::get('violations/export-pdf', [FacultyViolationController::class, 'exportPdf'])
         ->name('violations.exportPdf');
    Route::resource('students', FacultyStudentController::class);
    Route::resource('courses', FacultyCourseController::class);
    Route::resource('violations', FacultyViolationController::class);
    Route::resource('appeals', FacultyAppealController::class);
    Route::resource('student-appeals', FacultyStudentAppealController::class);

    Route::put('/faculty/appeals/{violation}', [FacultyAppealController::class, 'update'])
    ->name('faculty.appeals.update');
});


Route::prefix('student')->name('student.')->group(function () {

    // View all violations
    Route::get('violations', [StudentViolationController::class, 'index'])
         ->name('violations.index');

    // View appeals
    Route::get('appeals', [StudentAppealController::class, 'index'])
         ->name('appeals.index');

    // Submit a new appeal
    Route::post('appeals', [StudentAppealController::class, 'store'])
         ->name('appeals.store');

});
