<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViolationStudent extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'type',
        'details',
        'date',
        'penalty',
        'appeal',
        'status',
        'reviewed_by',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
