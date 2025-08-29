<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appeal extends Model // ito naman ung model na magrerepresent sa appeals table
{
    use HasFactory;

    protected $table = 'appeals';
    protected $primaryKey = 'appeal_id'; // primary key ng table
    public $incrementing = false; 
    protected $keyType = 'string';

    protected $fillable = [ // mga fields na pwedeng i-mass assign
        'appeal_id',
        'appeal_text',
        'status',       
        'reviewed_at',
    ];

    public function studentAppeals() // dito natin makukuha ung mga student appeals na related sa appeal na to
    {
        return $this->hasMany(StudentAppeal::class, 'appeal_id', 'appeal_id');
    }
}

