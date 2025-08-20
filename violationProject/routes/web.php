<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViolationController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('violations', ViolationController::class)->except(['show']);


Route::get('/violations/export-pdf', [ViolationController::class, 'exportPdf'])
    ->name('violations.exportPdf');

