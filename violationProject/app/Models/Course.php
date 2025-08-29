<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $table = 'courses';
    protected $primaryKey = 'course_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'course_name',
        'course_code',
    ];

    // Relationships
    public function students()
    {
        return $this->hasMany(Student::class, 'course_id', 'course_id');
    }

    public function violations()
    {
        return $this->hasMany(Violation::class, 'course_id', 'course_id');
    }
}
