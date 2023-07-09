<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    function election_categories()
    {
        return $this->hasMany(election_category::class)
                    ->latest('updated_at')
                    ->whereIs_deleted(0);
    }
    
    public function getCreatedAtAttribute($value)
    {
        return date('D, M d, Y, h:ia', strtotime($value) );
    }
}
