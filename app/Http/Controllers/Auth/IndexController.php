<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    function dashboard()
    {
        return view( view_page('dashboard'));
    }
    
    function vue_homepage()
    {
        //if( current_user()->role->slug == 'super_admin') return redirect('/auth/profile');
        return view('vuetify_page.index');
    }

    function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
