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

    protected $fillable = [
        'student_no',
        'first_name',
        'last_name',
        'course_id',
        'year_level_id',
        'email',
        'contact_no',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['password'] =
                (strlen($value) === 60 && preg_match('/^\$2y\$/', $value)) // tas ayan mga conditions to check if the password is already hashed
                    ? $value
                    : bcrypt($value); // yung bcrypt is laravel's built-in hashing function
        }
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'course_id');
    }

    public function violations()
    {
        return $this->hasMany(Violation::class, 'student_id', 'student_id');
    }

    public function studentAppeals()
    {
        return $this->hasMany(StudentAppeal::class, 'student_id', 'student_id');
    }

    public function yearLevel()
    {
        return $this->belongsTo(YearLevel::class, 'year_level_id', 'year_level_id');
    }

}