<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    function index()
    {
        return view( view_page('profile'));
    }

    function user_info()
    {
        $user = current_user();
        if( $user_id = request()->user_id ){
            $user = User::whereId( $user_id )->first();
        }
        return [
            'fullnames' => $user->fullnames(),
            'name'=> $user->name,
            'username' => $user->username(),
            'email' => $user->email,
            'role' => ['name' => $user->role->name, 'slug' => $user->role->slug ],
            'phone_number' => $user->phone_number,
            'lga' => $user->lga,
            'permission' => [
                'can_modify_ward_admin' => $user->can_modify_ward_admin(),
                'can_modify_all_admins' => $user->can_modify_all_admins(),
                'can_modify_users' => $user->can_modify_users(),
                'can_modify_lga_admin' => $user->can_modify_lga_admin()
            ]
        ];
    }

    
}
