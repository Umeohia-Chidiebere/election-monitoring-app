<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class role extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function getCreatedAtAttribute($value)
    {
        return date('D, M d, Y , h:ia', strtotime($value) );
    }
}
