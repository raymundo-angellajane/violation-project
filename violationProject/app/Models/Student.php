<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';
    protected $primaryKey = 'student_no';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'student_id',
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
        return $this->hasMany(Violation::class, 'student_no', 'student_no');
    }

    public function appeals()
    {
        return $this->hasMany(StudentAppeal::class, 'student_no', 'student_no');
    }
}
