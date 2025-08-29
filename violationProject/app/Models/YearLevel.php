<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YearLevel extends Model
{
    protected $primaryKey = 'year_level_id';
    protected $fillable = ['year_name'];

    public function students()
    {
        return $this->hasMany(Student::class, 'year_level_id', 'year_level_id');
    }
}
