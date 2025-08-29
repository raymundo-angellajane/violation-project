<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAppeal extends Model // ito ung model for student appeals na magre-relate sa student, violation, appeal, at faculty reviewer
{
    use HasFactory;

    protected $table = 'student_appeals';
    protected $primaryKey = 'student_appeal_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'student_appeal_id',
        'student_id',
        'violation_id',
        'appeal_id',
        'status',
        'reviewed_by',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    public function violation()
    {
        return $this->belongsTo(Violation::class, 'violation_id', 'violation_id');
    }

    public function appeal()
    {
        return $this->belongsTo(Appeal::class, 'appeal_id', 'appeal_id');
    }

    public function facultyReviewer()
    {
        return $this->belongsTo(Faculty::class, 'reviewed_by', 'faculty_id');
    }
}
