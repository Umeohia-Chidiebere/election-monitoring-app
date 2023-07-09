<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vote extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function getCreatedAtAttribute($value)
    {
        return date('D, M d, Y , h:ia', strtotime($value) );
    }

    function user()
    {
        return $this->belongsTo(User::class)->withDefault(['name' => '']);
    }

    function lga()
    {
        return $this->belongsTo(lga::class)->withDefault(['name' => '']);
    }

    function election()
    {
        return $this->belongsTo(election::class)->withDefault(['name' => '']);
    }
    
    function state()
    {
        return $this->belongsTo(state::class)->withDefault(['name' => '']);
    }

    function political_party()
    {
        return $this->belongsTo(political_party::class)->withDefault(['name' => '']);
    }

    function polling_unit()
    {
        return $this->belongsTo(polling_unit::class)->withDefault(['name' => '']);
    }

    function ward()
    {
        return $this->belongsTo(ward::class)->withDefault(['name' => '']);
    }
}
