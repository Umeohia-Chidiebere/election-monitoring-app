<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lga extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function getCreatedAtAttribute($value)
    {
        return date('D, M d, Y , h:ia', strtotime($value) );
    }

    function fullnames()
    {
        return $this->name.' - '.$this->state;
    }

    function wards()
    {
        return $this->hasMany(ward::class);
    }
    function user()
    {
        return $this->belongsTo(User::class)->withDefault(['name'=>'']);
    }
}
