<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Violation extends Model
{
    use HasFactory;

    protected $table = 'violations';
    protected $primaryKey = 'violation_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'student_id',
        'course_id',
        'year_level',
        'type',
        'details',
        'violation_date',
        'penalty',
        'status',
        'reviewed_by'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    public function facultyReviewer()
    {
        return $this->belongsTo(Faculty::class, 'reviewed_by', 'faculty_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'course_id');
    }

    public function studentAppeals()
    {
        return $this->hasMany(StudentAppeal::class, 'violation_id', 'violation_id');
    }

    public function getFormattedIdAttribute() // ito naman is ginawa para sa formatted violation ID
    // example: VIO-0001
    {
        return 'VIO-' . str_pad($this->violation_id, 4, '0', STR_PAD_LEFT);
    }
}
