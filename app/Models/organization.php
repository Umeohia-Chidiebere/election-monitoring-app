<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class organization extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function getCreatedAtAttribute($value)
    {
        return date('D, M d, Y , h:ia', strtotime($value) );
    }

    function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords( strtolower( $value ) );
    }

    function state()
    {
        return $this->belongsTo(state::class)->withDefault(['name'=>'']);
    }
}
