<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class post extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    function comments()
    {
        return $this->hasMany( comment::class)->latest();
    }

    function polling_unit()
    {
        return $this->belongsTo( polling_unit::class)->withDefault(['name'=>'']);
    }
    
    public function getCreatedAtAttribute($value)
    {
        return date('D, M d, Y , h:ia', strtotime($value) );
    }

    public function getDocsAttribute($value)
    {
        return json_decode( $value );
    }

    public function getIpInfoAttribute($value)
    {
        return json_decode( $value );
    }

    function user()
    {
        return $this->belongsTo(User::class)->withDefault(['name'=>'']);
    }

}
