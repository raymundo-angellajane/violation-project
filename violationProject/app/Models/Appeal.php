<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appeal extends Model
{
    use HasFactory;

    protected $table = 'appeals';
    protected $primaryKey = 'appeal_id';
    public $incrementing = false; // since it's string-based
    protected $keyType = 'string';

    protected $fillable = [
        'appeal_id',
        'appeal_text',
        'reviewed_at',
    ];

    // Relationships
    public function studentAppeals()
    {
        return $this->hasMany(StudentAppeal::class, 'appeal_id', 'appeal_id');
    }
}
