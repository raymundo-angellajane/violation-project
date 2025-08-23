<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Violation extends Model
{
    use HasFactory;

    protected $primaryKey = 'violation_id';
    protected $table = 'violations';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'violation_id',
        'student_no',
        'first_name',
        'last_name',
        'course_id',
        'year_level',
        'type',
        'violation_date',
        'penalty',
        'status',
        'reviewed_by'
    ];

    // Relationships
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_no', 'student_no');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by', 'id');
    }

    public function studentAppeals()
    {
        return $this->hasMany(StudentAppeal::class, 'violation_id', 'violation_id');
    }
}
