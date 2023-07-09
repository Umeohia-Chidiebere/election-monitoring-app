<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class candidate extends Model
{
    use HasFactory;
    protected $guarded = [];

    function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords( strtolower( $value ) );
    }

    function setDeputyNameAttribute($value)
    {
        $this->attributes['deputy_name'] = ucwords( strtolower( $value ) );
    }

    function political_party()
    {
        return $this->belongsTo(political_party::class)->withDefault(['name'=>'']);
    }

    function election()
    {
        return $this->belongsTo(election::class)->withDefault(['name'=>'']);
    }

    function zone()
    {
        return $this->belongsTo(zone::class)->withDefault(['name'=>'']);
    }

}
