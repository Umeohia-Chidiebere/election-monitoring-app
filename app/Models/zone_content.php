<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class zone_content extends Model
{
    use HasFactory;
    protected $guarded = [];

    function user()
    {
        return $this->belongsTo(User::class)->withDefault(['name'=>'']);
    }

    function polling_units()
    {
        return $this->polling_unit;
    }
}
