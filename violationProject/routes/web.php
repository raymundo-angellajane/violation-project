<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViolationController;
use App\Http\Controllers\AppealController;
use App\Http\Controllers\FacultyViolationController;
use App\Http\Controllers\StudentAppealController;
use App\Http\Controllers\StudentViolationController;

// Wala to, homepage lang
Route::get('/', function () {
    return view('welcome');
});

// Faculty side
Route::resource('violations', ViolationController::class)->except(['show']);
Route::resource('appeals', AppealController::class);
Route::get('/violations/export-pdf', [ViolationController::class, 'exportPdf'])->name('violations.exportPdf');

Route::prefix('faculty')->group(function () {
    Route::get('/violations', [FacultyViolationController::class, 'index'])->name('faculty.violations.index');
    Route::get('/violations/{id}', [FacultyViolationController::class, 'show'])->name('faculty.violations.show');
});

// Student side
Route::get('/student/violations', [StudentViolationController::class, 'index'])->name('student.violations');
Route::post('/student/appeal', [StudentAppealController::class, 'store'])->name('student.appeal');

// Faculty reviewing appeals
Route::get('/faculty/appeals', [AppealController::class, 'index'])->name('faculty.appeals');
Route::post('/faculty/appeals/{id}/review', [AppealController::class, 'review'])->name('faculty.appeals.review');
