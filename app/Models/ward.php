<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ward extends Model
{
    use HasFactory;
    protected $guarded = [];
    //public $timestamps = false;
    
    public function getCreatedAtAttribute($value)
    {
        return date('D, M d, Y , h:ia', strtotime($value) );
    }

    function lga()
    {
        return $this->belongsTo(lga::class)->withDefault(['name' => '']);
    }

    function polling_units()
    {
        return $this->hasMany(polling_unit::class);
    }

    function assigned_by()
    {
        return $this->belongsTo(User::class, 'assignedBy_')->withDefault(['name' => '']);
    }

    function user()
    {
        return $this->belongsTo(User::class)->withDefault(['name' => '']);
    }

    function get_state()
    {
        return $this->lga;
    }

    function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords( strtolower( $value ) );
    }

    function fullnames()
    {
        return $this->name. ' ('.$this->lga->name.', '. $this->lga->state.')';
    }
}
