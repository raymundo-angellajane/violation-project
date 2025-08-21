<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViolationStudent extends Model
{
    protected $fillable = ['student_id', 'date', 'status', 'details'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}