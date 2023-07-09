<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    function index()
    {
        if( request()->has('delete')) return $this->delete_post();
        return view( view_page('posts') );
    }

    function delete_post()
    {
        $delete = post::whereCode_number( request()->id )->delete();
        return ! $delete ? error_msg() : redirect()->back();
    }

    function store()
    {
        $data = request()->except('_token');
        $data['ip_address'] = request()->ip();
        $data['ip_info'] = user_ip_address_info();
        $data['user_id'] = current_user()->id;
        $data['code_number'] = code_number();
        if( request()->docs){
            if( count( request()->docs  ) > 6 ) return error_msg("You can't upload more that 6 files at a time...");
            $docs = upload_multiple_files( request()->docs, post_folder() );
            $data['docs'] = json_encode( $docs );
        }
        $store = post::create( $data );
        return ! $store ? error_msg() : redirect()->route('posts_page');
    }
}
