<?php

namespace App\Http\Controllers;

use App\Models\password_reset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Forgot_passwordController extends Controller
{
    function forgot_password_page()
    {
        return view( view_page('forgot_password') );
    }
    
    function send_password_reset_email()
    {
        $email = request()->email;
        $user = User::whereEmail( $email )->first();
        if( ! $user ) return error_msg("Invalid Email Account !");
        $token = code_number().random_strings(70);
        password_reset::create([
            'email' => $email,
            'token' => $token
        ]);
        send_password_reset_email($user, $token);   
        return success_msg("A Mail has been sent to ". $email );
    }

    function confirm_password_reset_token()
    {
        Auth::logout();
        $user = User::whereEmail( request()->email )->first();
        if( ! $user ) return $this->error_msg("Invalid User ID !");
        if( ! request()->token || ! request()->email ) return $this->error_msg("Invalid Link !");
        if( $this->password_reset_token_has_expired() ) return $this->error_msg("Invalid confirmation token !");
        $new_password = rand(100000,999999);
        $user->update(['password' => $new_password]);
        Auth::login( $user, true );
        store_user_login();
        return redirect()->route('dashboard')->withSuccess("Success ! Your New Default Password  is ( ". $new_password. ' )');
    }

    function password_reset_token_has_expired()
    {
       $data = password_reset::whereEmail( request()->email )->latest()->first();
       if( ! $data ) return false;
       $incoming_token = request()->token;
       return ( $data->token != $incoming_token ) ? true : false;
    }

    function confirm_user_email_verification_link()
    {
        Auth::logout();
        $token = request()->token;
        $user_id = request()->uid;

        if( $user_id && $token && $user_id ){
            $user = find_user($user_id);
            if( ! $user ) return redirect()->route('login')->withErrors('Invalid Link');;
            if( $user->email_verification_link != $token ) return redirect()->route('login')->withErrors('Invalid Link');
            $user->update(['email_is_verified' => 1 ]);
            Auth::login($user, true);
            return redirect()->route('dashboard')->withSuccess('Your Email has been Confirmed successfully !');
        }
        else{
            return redirect()->route('login')->withErrors('Invalid Link');
        }
    }
}
