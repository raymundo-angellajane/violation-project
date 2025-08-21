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

Route::get('/appeals/create/{violation}', [AppealController::class, 'create'])->name('appeals.create');

Route::post('/appeals/store', [AppealController::class, 'store'])->name('appeals.store');

Route::get('/student/violations', [StudentViolationController::class, 'index'])->name('student.violations');
