<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comment extends Model
{
    use HasFactory;
    protected $table = "posts";
    protected $guarded = [];

    function post()
    {
        return $this->belongsTo(post::class)->withDefault(['name'=>'']);
    }

    function user()
    {
        return $this->belongsTo(User::class)->withDefault(['name'=>'']);
    }

    function getCreatedAtAttribute($value)
    {
        return date('D, M d, Y h:ia', strtotime($value) );
    }
}
