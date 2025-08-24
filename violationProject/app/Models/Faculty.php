<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;

    protected $table = 'faculties';
    protected $primaryKey = 'faculty_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'faculty_id',
        'first_name',
        'last_name',
        'email',
    ];

    // Relationships
    public function reviewedViolations()
    {
        return $this->hasMany(Violation::class, 'reviewed_by', 'faculty_id');
    }

    public function reviewedAppeals()
    {
        return $this->hasMany(StudentAppeal::class, 'reviewed_by', 'faculty_id');
    }
}
