<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';
    protected $primaryKey = 'student_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'student_no',
        'first_name',
        'last_name',
        'course_id',
        'year_level',
        'email',
        'contact_no',
    ];

    // Relationships
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'course_id');
    }

    public function violations()
    {
        return $this->hasMany(Violation::class, 'student_id', 'student_id');
    }

    public function studentAppeals()
    {
        return $this->hasMany(StudentAppeal::class, 'student_id', 'student_id');
    }
}
