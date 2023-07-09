<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
    */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
    */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    function can_modify_all_admins()
    {
        return $this->role->slug == 'super_admin' ? 1 : '';
    }

    function can_modify_lga_admin()
    {
        $status = '';
        if( $this->role->slug == 'super_admin') return $status = 1;
        if( $this->role->slug == 'senatorial_admin') return $status = 1;
        if( $this->role->slug == 'constituency_admin') return $status = 1;
        return $status;
    }

    function can_modify_ward_admin()
    {
        $status = '';
        if( $this->role->slug == 'super_admin') return $status = 1;
        if( $this->role->slug == 'senatorial_admin') return $status = 1;
        if( $this->role->slug == 'lga_admin') return $status = 1;
        if( $this->role->slug == 'constituency_admin') return $status = 1;
        return $status;
    }

    function can_modify_users()
    {
        $status = 1;
        if( $this->role->slug == 'user') return $status = '';
        return $status;
    }

    function username()
    {
        return '@'.explode('@', $this->email)[0];
    }

    function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords( strtolower( $value ) );
    }

    function fullnames()
    {
        return $this->name. ' ('.$this->username().')';
    }

    function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt( $value );
    }

    function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower( $value ) ;
    }

    function role()
    {
        return $this->belongsTo(role::class)->withDefault(['name'=>'']);
    }

    function lga()
    {
        return $this->belongsTo(lga::class)->withDefault(['name'=>'']);
    }

    function ward()
    {
        return ward::whereUser_id( $this->id )->get();
    }
    
    function is_admin()
    {
        $status = false;
        if( $this->is_super_admin() ) $status = true;
        if( $this->role->slug == "admin") $status = true;
        return $status;
    }

    function is_super_admin()
    {
        $status = false;
        if( $this->role->slug == "super_admin") $status = true;
        return $status;
    }

    function assigned_polling_units()
    {
        return polling_unit::whereUser_id( $this->id )->latest()->get();
    }

    function assigned_wards()
    {
        return ward::whereUser_id( $this->id )->latest()->get();
    }

    function get_election_votes($slug = "")
    {
        $votes = vote::whereUser_id( $this->id );
        if( $slug ){
            $slug = $slug."_id";
            $votes = $votes->where($slug, "!=", null);
        }
        return $votes->get()->groupBy('election_id');
    }
}
