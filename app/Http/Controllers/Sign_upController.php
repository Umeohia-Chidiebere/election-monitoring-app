<?php

namespace App\Http\Controllers;

use App\Models\organization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Sign_upController extends Controller
{
    function organization_registration_page()
    {
        return view( view_page('o_sign_up'));
    }

    function user_registration_page()
    {
        return view( view_page('u_sign_up'));
    }

    function sign_up()
    {
        $data = request()->except('_token','state_id', 'register_organization', 'organization_name', 'organization_description');
        $data['code_number'] = uniqid();
        $data['password'] = request()->password ?? rand(100000,999999);
        $data['ip_address'] = request()->ip();
        $data['ip_info'] = user_ip_address_info();
        $data['role_id'] = request()->role_id ?? 1;
        $user = $this->register_user($data);
        if( ! $user ) return error_msg();
        send_registration_email($user, $data['password'] );
        if( request()->has('register_organization'))
        {
            $this->validate_user_data();
            $this->register_user_organization($user);
        }
        return success_msg("Account created successfully...");
    }
    
    function register_user_organization($user)
    {
        $organization = organization::create([
            'user_id' => $user->id,
            'state_id' => request()->state_id,
            'name' => request()->organization_name,
            'description' => request()->organization_description,
            'code_number' => uniqid()
        ]);
        if( ! $organization ) return error_msg();
        Auth::login($user, true);
        return redirect()->route('dashboard');
    }

    function register_user($data)
    {
        $this->validate( request(), ['email' => 'required|email|unique:users']);
        return User::create( $data );
    }

    function store_organization($data)
    {
        return organization::create( $data );
    }

    function validate_user_data()
    {
        return 
        $this->validate( request(), [
            'name' => 'required',
            'organization_name' => 'required',
            'state_id'=> 'required',
            'phone_number' => 'required',
            'password' => 'required|min:5',
        ]);
    }

}

