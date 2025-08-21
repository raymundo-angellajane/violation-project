<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model {
    use HasFactory;

    protected $fillable = ['student_no', 'name', 'course', 'year_level'];

    public function violations() {
        return $this->hasMany(ViolationStudent::class);
    }
}