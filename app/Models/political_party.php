<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class political_party extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords( strtolower( $value ) );
    }

    function setShortNameAttribute($value)
    {
        $this->attributes['short_name'] = strtoupper( $value );
    }

    function setMottoAttribute($value)
    {
        $this->attributes['motto'] = ucfirst( strtolower( $value ) );
    }

    function fullnames()
    {
        return $this->short_name.' - '.$this->name;
    }
}
