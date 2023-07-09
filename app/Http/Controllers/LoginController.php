<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    function login_page()
    {
        return view( view_page('login') );
    }

    public function login_user( Request $request )
    {
            $this->validate( $request, ['email' => 'required', 'password' => 'required' ]);
            $confirm_user = Auth::attempt(request(['email', 'password']), true );
            if (!$confirm_user): return redirect()->back()->withErrors('Invalid Login Details' ); endif;
            store_user_login();
            if( request()->return_url ) return redirect( request()->return_url );
            return redirect()->route('homepage'); 
    }
}
