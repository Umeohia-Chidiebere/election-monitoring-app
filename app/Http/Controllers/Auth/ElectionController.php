<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\election;
use App\Models\vote;
use App\Models\polling_unit;
use Illuminate\Http\Request;

class ElectionController extends Controller
{
    function index()
    {
        if ( request()->has('remove_elections')) return $this->remove_elections();
        if ( request()->has('start_elections')) return $this->start_elections();
        if ( request()->has('end_elections')) return $this->end_elections();
        return view( view_page('elections') );
    }

    function compute_election_result_page()
    {
        return view( view_page('compute_election_result'));
    }

    function start_elections()
    {
        $id = request()->id ?? [];
        $remove = election::whereIn('id', $id)->update(['status'=> 1]);
        return ! $remove ? error_msg() : success_msg("Election started successfully...");
    }

    function end_elections()
    {
        $id = request()->id ?? [];
        $remove = election::whereIn('id', $id)->update(['status'=> 2]);
        return ! $remove ? error_msg() : success_msg("Election ended successfully...");
    }

    function store_election()
    {
        $data = request()->except('_token');
        $data['user_id'] = current_user()->id;
        $data['code_number'] = uniqid();
        $store = election::create( $data );
        return ! $store ? error_msg() : success_msg('Election has been created successfully...');
    }

    function store_election_result()
    {
        $store = '';
        $data = request()->except('_token', 'type_');
        $data['user_id'] = current_user()->id;
        $type = request()->type_;
        if( $type == 'polling_unit'){
            $data['ward_id'] = find_data( new polling_unit, request()->polling_unit_id )->ward->id;
            $data['lga_id'] = find_data( new polling_unit, request()->polling_unit_id )->ward->lga->id;
        }
        
        $type_id = request()->input($type.'_id');
        $data['state'] = get_nigeria_state($type, $type_id)->state;
        $record = vote::whereElection_id( request()->election_id )
                       ->wherePolling_unit_id( request()->polling_unit_id )
                       ->wherePolitical_party_id( request()->political_party_id )
                       ->whereWard_id( request()->ward_id );
        if( $record->exists() ){
            $store = $record->update(['total' => request()->total ]);
        }
        else{
            $store = vote::create( $data );
        }
        if( ! $store ) return error_msg();
        send_election_result_email();
        return success_msg("Result saved successfully...");
    }

    function view_election( $code_number )
    {
        $election = election::whereCode_number($code_number)->latest()->first();
        if( ! $election ) return error_msg("Election doesn't exist...");
        return view( view_page('view_election'), compact('election') );
    }

    function remove_elections()
    {
        $id = request()->id ?? [];
        $remove = election::whereIn('id', $id)->delete();
        return ! $remove ? error_msg() : success_msg("Election removed successfully...");
    }

}
