<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class polling_unit extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function getCreatedAtAttribute($value)
    {
        return date('D, M d, Y , h:ia', strtotime($value) );
    }

    function ward()
    {
        return $this->belongsTo(ward::class)->withDefault(['name' => '']);
    }

    function lga()
    {
        return $this->ward->lga;
    }

    function get_state()
    {
        return $this->ward->lga;
    }

    function assigned_by()
    {
        return $this->belongsTo(User::class, 'assignedBy_')->withDefault(['name' => '']);
    }

    function user()
    {
        return $this->belongsTo(User::class)->withDefault(['name' => '']);
    }

    function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords( strtolower( $value ) );
    }

    function fullnames()
    {
        return $this->name.' ('.$this->ward->name.', '.$this->ward->lga->name.', '. $this->ward->lga->state.')';
    }
}