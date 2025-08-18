<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Violation extends Model
{
    protected $fillable = [
        'student_no',
        'name',
        'course',
        'year_level',
        'type',
        'details',
        'date',
        'penalty',
        'status'
    ];
}
