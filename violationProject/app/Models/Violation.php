<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Violation extends Model
{
    use HasFactory;

    protected $table = 'violations';
    protected $primaryKey = 'violation_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'violation_id',
        'student_no',
        'details',
        'status',
        'penalty',
        'type',
        'violation_date',
        'reviewed_by',
    ];

    // Relationships
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_no', 'student_no');
    }

    public function reviewer()
    {
        return $this->belongsTo(Reviewer::class, 'reviewed_by', 'reviewer_id');
    }

    public function studentAppeals()
    {
        return $this->hasMany(StudentAppeal::class, 'violation_id', 'violation_id');
    }
}
