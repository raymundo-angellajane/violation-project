<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppealStudent extends Model
{
     use HasFactory;

    protected $fillable = [
        'student_appeals_id',
        'student_id',
        'violation_id',
        'appeals_id',
        'status',
        'reviewed_by',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
