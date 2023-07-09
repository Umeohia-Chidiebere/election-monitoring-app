<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    function view_users_page()
    {
        return view( view_page('users') );
    }

    function update_users()
    {
        if( request()->has('remove_users') ) return $this->remove_users();
        $data = request()->except('_token');
        $update = User::whereId(request()->id)->update($data);
        return ! $update ? error_msg(): success_msg("User info updated successfully...");
    }
}
