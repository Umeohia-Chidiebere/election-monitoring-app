<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\candidate;
use Illuminate\Http\Request;

class CandidatesController extends Controller
{
    function index()
    {
        if( request()->has('remove_candidate')) return $this->delete_candidate();
        return view( view_page('candidates'));
    }

    function delete_candidate()
    {
        $id = request()->id;
        $delete = candidate::whereIn( 'id', $id)->delete();
        return ! $delete ? error_msg() : success_msg();
    }

    function store_candidate()
    {
        $data = request()->except('_token');
        $data['user_id'] = current_user()->id;
        $store = candidate::create( $data );
        return ! $store ? error_msg() : success_msg(); 
    }
}
