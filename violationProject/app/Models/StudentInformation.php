<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentInformation extends Model
{
     use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'course_year_level',
        'email',
        'contact_number',
    ];

     public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
