<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class Faculty extends Authenticatable
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
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Automatically hash password
    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['password'] =
                (strlen($value) === 60 && preg_match('/^\$2y\$/', $value))
                    ? $value
                    : Hash::make($value);
        }
    }

    /** Relationships */
    public function reviewedViolations()
    {
        return $this->hasMany(Violation::class, 'reviewed_by', 'faculty_id');
    }

    public function reviewedAppeals()
    {
        return $this->hasMany(StudentAppeal::class, 'reviewed_by', 'faculty_id');
    }

    public function getAuthIdentifierName()
    {
        return 'email';
    }
}
