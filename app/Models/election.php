<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class election extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    
    public function getCreatedAtAttribute($value)
    {
        return date('D, M d, Y , h:ia', strtotime($value) );
    }

    public function getStartDateAttribute($value)
    {
        return date('M d, Y ', strtotime($value) );
    }

    function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords( strtolower( $value ) );
    }

    function election_type()
    {
        return $this->belongsTo(election_type::class)->withDefault(['name'=>'']);
    }

    function user()
    {
        return $this->belongsTo(User::class)->withDefault(['name'=>'']);
    }

    function state()
    {
        return $this->belongsTo(state::class)->withDefault(['name'=>'']);
    }

    function category()
    {
        return $this->belongsTo(category::class)->withDefault(['name'=>'']);
    }

    function event_reports()
    {
        return $this->hasMany(post::class);
    }

    function status_()
    {
        $status = "<span class='badge badge-warning'> Not started</span>";
        if( $this->status == 1) $status = "<span class='badge badge-success'> On-Going </span>";
        if( $this->status == 2) $status = "<span class='badge badge-danger'> Ended </span>";
        echo $status;
    }

    function all_votes()
    {
        return $this->hasMany(vote::class); 
    }

    function total_election_votes()
    {
        $valid_votes = $this->valid_votes();
        $invalid_votes = $this->invalid_votes();
        return number_format($valid_votes + $invalid_votes );
    }

    function invalid_votes()
    {
        return $this->all_votes->sum('invalid_votes');
    }

    function valid_votes()
    {
        return $this->all_votes->sum('total');
    }
    
    function group_votes($slug = "")
    {
        return $this->all_votes->groupBy( $slug );
    }
    
    function group_votes_by_ward()
    {
        return vote::whereElection_id($this->id)->where('ward_id', "!=", null)->groupBy('ward_id');
    }

    function group_votes_by_state() 
    {
        return vote::whereElection_id($this->id)
                    ->get()
                    ->groupBy('state');             
    }   

    function group_votes_by_party() 
    {
        return vote::groupBy('political_party_id')
                    ->selectRaw('sum(total) as total_votes, political_party_id as id')
                    ->whereElection_id($this->id)
                    ->get();               
    }

    function polling_unit_votes($pu_id = null)
    {
        return $this->hasOne(vote::class)->wherePolling_unit_id($pu_id);
    }

    function fullnames()
    {
        $name = $this->year. ' '. $this->state->name. ' '. $this->election_type->name;
        if( $this->description ) $name = $name. ' ('. $this->description.')';
        return $name;
    }
}
    