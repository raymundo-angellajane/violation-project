<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViolationController;
use App\Http\Controllers\StudentController;
use Carbon\Carbon;
use App\Http\Controllers\AppealController;
use App\Http\Controllers\StudentViolationController;


Route::get('/', function () {
    return view('welcome');
});

Route::resource('violations', ViolationController::class)->except(['show']);

Route::get('/violations/export-pdf', [ViolationController::class, 'exportPdf'])
    ->name('violations.exportPdf');

Route::get('/student/violations', [StudentViolationController::class, 'index'])->name('student.violations');

Route::post('/student/appeal', [StudentViolationController::class, 'submitAppeal'])->name('student.appeal');
