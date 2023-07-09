<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class zone extends Model
{
    use HasFactory;

    protected $guarded = [];

    function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords( strtolower( $value ) );
    }

    function zone_content()
    {
        return $this->hasMany(zone_content::class);
    }

    function user()
    {
        return $this->belongsTo(User::class)->withDefault(['name'=>'']);
    }
}
