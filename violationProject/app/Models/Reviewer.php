<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reviewer extends Model
{
    use HasFactory;

    protected $table = 'reviewers';
    protected $primaryKey = 'reviewer_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'reviewer_id',
        'faculty_id',
    ];

    // Relationships
    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id', 'faculty_id');
    }

    public function studentAppeals()
    {
        return $this->hasMany(StudentAppeal::class, 'reviewed_by', 'reviewer_id');
    }

    public function violations()
    {
        return $this->hasMany(Violation::class, 'reviewed_by', 'reviewer_id');
    }
}
