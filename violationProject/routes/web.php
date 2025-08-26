<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IntegrationController;
use App\Http\Controllers\Faculty\AppealController as FacultyAppealController;
use App\Http\Controllers\Faculty\CourseController as FacultyCourseController;
use App\Http\Controllers\Faculty\StudentAppealController as FacultyStudentAppealController;
use App\Http\Controllers\Faculty\StudentController as FacultyStudentController;
use App\Http\Controllers\Faculty\ViolationController as FacultyViolationController;
use App\Http\Controllers\Student\StudentAppealController as StudentAppealController;
use App\Http\Controllers\Student\ViolationController as StudentViolationController;

// ==================== AUTH ROUTES ==================== //
Route::get('/', [IntegrationController::class, 'showLoginForm'])->name('login');
Route::post('login', [IntegrationController::class, 'loginUser'])->name('login.submit');
Route::post('logout', [IntegrationController::class, 'logout'])->name('logout');

// ==================== STUDENT ROUTES ==================== //
Route::prefix('student')
    ->name('student.')
    ->middleware(['role:student'])
    ->group(function () {
        Route::get('violations', [StudentViolationController::class, 'index'])->name('violations.index');
        Route::get('appeals', [StudentAppealController::class, 'index'])->name('appeals.index');
        Route::post('appeals', [StudentAppealController::class, 'store'])->name('appeals.store');
    });

// ==================== FACULTY ROUTES ==================== //
Route::prefix('faculty')
    ->name('faculty.')
    ->middleware(['role:faculty'])
    ->group(function () {
        Route::get('violations/export-pdf', [FacultyViolationController::class, 'exportPdf'])->name('violations.exportPdf');
        Route::resource('students', FacultyStudentController::class);
        Route::resource('courses', FacultyCourseController::class);
        Route::resource('violations', FacultyViolationController::class);
        Route::resource('appeals', FacultyAppealController::class);
        Route::resource('student-appeals', FacultyStudentAppealController::class);
        Route::get('appeals/{id}/review', [FacultyAppealController::class, 'review'])->name('appeals.review');
    });

// ==================== FALLBACK ROUTE ==================== //
Route::fallback(fn () => redirect()->route('login'));
