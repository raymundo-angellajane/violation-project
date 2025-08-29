<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    use HasFactory;

    protected $table = 'students';
    protected $primaryKey = 'student_id';
    public $incrementing = true;
    protected $keyType = 'int';

    /**
     * Fillable fields for mass assignment.
     * Password is optional because login is handled externally.
     */
    protected $fillable = [
        'student_no',
        'first_name',
        'last_name',
        'course_id',
        'year_level',
        'email',
        'contact_no',
        'password',
    ];

    /**
     * Hidden fields in serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Year levels enum
     */
    public const YEAR_LEVELS = [
        '1st Year',
        '2nd Year',
        '3rd Year',
        '4th Year',
    ];

    /**
     * Only hash password if provided (optional).
     */
    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['password'] =
                (strlen($value) === 60 && preg_match('/^\$2y\$/', $value))
                    ? $value
                    : bcrypt($value); 
        }
    }

    /** Relationships */

    // Student belongs to a course
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'course_id');
    }

    // Student has many violations
    public function violations()
    {
        return $this->hasMany(Violation::class, 'student_id', 'student_id');
    }

    // Student has many appeals
    public function studentAppeals()
    {
        return $this->hasMany(StudentAppeal::class, 'student_id', 'student_id');
    }
}
