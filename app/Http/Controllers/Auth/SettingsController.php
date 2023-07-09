<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\candidate;
use App\Models\election;
use App\Models\lga;
use App\Models\political_party;
use App\Models\polling_unit;
use App\Models\post;
use App\Models\User;
use App\Models\vote;
use App\Models\ward;
use App\Models\zone;
use App\Models\zone_content;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    function index($slug)
    {
        if( request()->has('remove_wards')) return $this->remove_wards();
        if( request()->has('remove_polling_units')) return $this->remove_polling_units();
        return view( view_page($slug, 'setup'), compact('slug') );
    }
    
    function political_party_page()
    {
        if( request()->has('remove_party') ) return $this->remove_political_party();
        return view( view_page('political_parties', 'setup') );
    }

    function store()
    {
        if( request()->has('remove_wards')) return $this->remove_wards();
        if( request()->has('remove_polling_units')) return $this->remove_polling_units();
        if( request()->has('remove_zone')) return $this->delete_zone();
        if( request()->has('remove_candidate')) return $this->remove_candidate();
        if ( request()->has('remove_election')) return $this->remove_election();
        if ( request()->has('remove_user')) return $this->remove_user();
        if( request()->has('remove_post')) return $this->remove_post();

        if( request()->has('store_post')) return $this->store_post();
        if( request()->has('store_user')) return $this->store_user();
        if( request()->has('store_wards')) return $this->store_wards();
        if( request()->has('store_polling_units')) return $this->store_polling_units();
        if( request()->has('store_senatorial_zones')) return $this->store_senatorial_zones();
        if( request()->has('store_constituency')) return $this->store_constituency();
        if( request()->has('store_candidate')) return $this->store_candidate();
        if( request()->has('store_election')) return $this->store_election();
        if( request()->has('store_election_result')) return $this->store_election_result();

        if( request()->has('update_lga')) return $this->update_lga();
        if( request()->has('update_ward')) return $this->update_ward();
        if( request()->has('update_polling_unit')) return $this->update_polling_unit();
        if( request()->has('update_zone')) return $this->update_zone();
        if( request()->has('update_user')) return $this->update_user();
             
        if ( request()->has('start_election')) return $this->start_election();
        if ( request()->has('end_election')) return $this->end_election();
        
        return;
    }

    function update_lga()
    {
        $data = request()->all();
        $update = lga::whereId( request()->id )->update([
            'user_id' => $data['user_id']
        ]);
        return ! $update ? error_msg() : success_msg("updated successfully...");
    }

    function update_ward()
    {
        $data = request()->all();
        $update = ward::whereId( request()->id )->update([
            'user_id' => $data['user_id']
        ]);
        return ! $update ? error_msg() : success_msg("updated successfully...");
    }

    function update_user()
    {
        $data = request()->all();
        $update = User::whereId( request()->id )->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'role_id' => $data['role_id'],
        ]);
        return ! $update ? error_msg() : success_msg("updated successfully...");
    }

    function update_zone()
    {
        $data = request()->all();
        $update = zone::whereId( request()->id )->update( $data);
        return ! $update ? error_msg() : success_msg("updated successfully...");
    }

    function update_polling_unit()
    {
        $data = request()->all();
        $update = polling_unit::whereId( request()->id )->update( $data );
        return ! $update ? error_msg() : success_msg("updated successfully...");
    }

    function store_election_result()
    {
        $store = '';
        $data = request()->except('hidden', 'store_election_result', 'accredited_voters');
        if(!$data['polling_unit_id'] || ! $data['election_id'] || ! $data['political_party_id']){
            return error_msg("Please, all fields are required... ");
        }
        $data['user_id'] = current_user()->id;
        $data['lga_id'] = polling_unit( request()->polling_unit_id )->ward->lga->id;
        $data['ward_id'] = polling_unit( request()->polling_unit_id )->ward->id;
        $data['election'] = election( request()->election_id )->full_details;
        $data['polling_unit'] = polling_unit( request()->polling_unit_id )->name; 
        $zone = '';
        if( request()->has('accredited_voters')){
            polling_unit::whereId( $data['polling_unit_id'] )
                        ->update(['accredited_voters' => request()->accredited_voters]);
        }
        if( request()->has('zone_id') ){
            $zone =  zone( request()->zone_id );
            $zone = $zone->type == 'senatorial' ? $zone->name. ' senatorial zone' : $zone->name. ' '.$zone->type;
            $data['zone'] = $zone;
        }
        $record = vote::whereElection_id( request()->election_id )
                       ->wherePolling_unit_id( request()->polling_unit_id )
                       ->wherePolitical_party_id( request()->political_party_id )
                       ->whereWard_id( $data['ward_id'] )
                       ->whereZone_id( request()->zone_id );
        if( $record->exists() ){
            $store = $record->update( $data );
        }
        else{
            $store = vote::create( $data );
        }
        if( ! $store ) return error_msg();
        $msg = "submitted election result in Polling unit: "
              .polling_unit( request()->polling_unit_id )->name
              ." for ".$zone. ', '. election( request()->election_id )->full_details;
        notification($msg, 'election_result');
        return success_msg("Result uploaded successfully... ");
    }

    function remove_post()
    {
        $remove = post::whereId( request()->id )->delete();
        return ! $remove ? error_msg() : success_msg("Removed successfully...");
    }

    function store_post()
    {
       // return request()->all();
        $data = request()->except('_token','store_post');
        if( request()->type != 'comment' ) 
        {
            if( ! request()->polling_unit_id ) return error_msg("Please, select a Polling unit...");
            if( ! request()->category ) return error_msg("Please, select a category..");
            if( ! request()->election_id ) return error_msg("Please, select election...");
        }
        $data['ip_address'] = request()->ip();
        $data['ip_info'] = user_ip_address_info();
        $data['user_id'] = current_user()->id;
        $data['code_number'] = code_number();
        $data['type'] = request()->type ?? 'post';
        $data['docs'] = [];
        if( request()->docs){
            if( count( request()->docs ) > 4 ) return error_msg("You can't upload more that 4 files at once...");
            $docs = upload_multiple_files( request()->docs, post_folder() );
            if( $docs == 0) return error_msg("Invalid file format, please upload Image/Video only..."); 
            $data['docs'] =  $docs;
        }
        $data['docs'] = json_encode( $data['docs'] );
        $post = post::create( $data );
        if( request()->type == 'post'){
            $msg = "created a Report from Polling unit, ". $post->polling_unit->name;
            notification($msg);
        }
        
        return ! $post ? error_msg() : success_msg($post->code_number);
    }

    function store_user()
    {
        $data = request()->except('store_user','hidden');
        $data['code_number'] = uniqid();
        $data['password'] = rand(100000,999999);
        $data['ip_address'] = request()->ip();
        $data['ip_info'] = user_ip_address_info();
     
        $user = User::create( $data );
        if( ! $user ) return error_msg();
        send_registration_email($user, $data['password'] );
        return success_msg("Account created successfully...");
    }

    function remove_user()
    {
        $remove = User::whereId( request()->id )->delete();
        return ! $remove ? error_msg() : success_msg("User Removed successfully...");
    }

    function remove_election()
    {
        $id = request()->id;
        $remove = election::whereId($id)->delete();
        return ! $remove ? error_msg() : success_msg("Election removed successfully...");
    }

    function start_election()
    {
        $id = request()->id ?? [];
        $remove = election::whereIn('id', $id)->update(['status'=> 1]);
        return ! $remove ? error_msg() : success_msg("Election started successfully...");
    }

    function store_election()
    {
        $data = request()->except('_token','hidden','store_election');
        $data['user_id'] = current_user()->id;
        $data['code_number'] = uniqid();
        $data['full_details'] = $data['year']. ' '. all_states( request()->state_id, true)->name .' ' .election_types( request()->election_type_id )->name;
        //If election Type is Presidential or Governorship...let has_zones be zero else default to 1
        if( request()->election_type_id == 1 || request()->election_type_id == 2 ) $data['has_zones'] = 0;
        $store = election::create( $data );
        return ! $store ? error_msg() : success_msg('Election has been created successfully...');
    }

    function end_election()
    {
        $id = request()->id ?? [];
        $remove = election::whereIn('id', $id)->update(['status'=> 2]);
        return ! $remove ? error_msg() : success_msg("Election ended successfully...");
    }

    function remove_candidate()
    {
        $id = request()->id;
        $delete = candidate::whereId($id)->delete();
        return ! $delete ? error_msg() : success_msg("Candidate removed successfully...");
    }

    function store_candidate()
    {
        $data = request()->except('_token','store_candidate','hidden');
        $data['user_id'] = current_user()->id;
        $data['election'] = election( request()->election_id )->full_details;
        $store = candidate::create( $data );
        return ! $store ? error_msg() : success_msg('Candidate added successfully...');
    }

    function store_polling_units()
    {
        $data = explode(",", request()->name);
        foreach( $data as $record )
        {
            if( trim( $record ) ):
                if( ! $this->polling_unit_exists($record)){
                    polling_unit::create([
                        'ward_id' => request()->ward_id,
                        'name'=> $record,
                        'assignedBy_' => current_user()->id,
                        'user_id' => request()->user_id ?? current_user()->id,
                        'code' => uniqid(),
                        'lga_id' => ward( request()->ward_id )->lga->id,
                        'state' => ward( request()->ward_id )->lga->state,
                        'latitude' => request()->latitude,
                        'longitude' => request()->longitude
                    ]); 
                }
            endif;
        }
        return success_msg("P.U created successfully...");
    }

    function store_wards()
    {
        $data = explode(",", request()->name);
        foreach( $data as $record )
        {
            if( trim( $record ) ):
              if( ! $this->ward_exists( $record ) ){
                ward::create([
                    'lga_id' => request()->lga_id,
                    'name'=> $record,
                    'assignedBy_' => current_user()->id,
                    'user_id' => request()->user_id,
                    'state' => lga( request()->lga_id )->state,
                    'code' => uniqid()
                 ]);
              }
           endif;
        }
        return success_msg('Ward created successfully...');
    }

    function store_constituency()
    {
        $wards = explode(',', request()->ward_id );
        $zone_ = $this->zone_exists();
        if( $zone_ ) $this->delete_zone( $zone_->id );

        $zone = zone::create([
            'name' => request()->name,
            'type' => 'constituency',
            'state' => ward( $wards[0] )->lga->state,
            'user_id' => request()->user_id ?? current_user()->id
        ]);
        if( ! $zone ) return error_msg();

            foreach( $wards as $ward_id )
            {
                $polling_units = ward( $ward_id )->polling_units;
                foreach( $polling_units as $pu)
                {
                    zone_content::create([
                        'ward' => ward( $ward_id )->name,
                        'lga' => ward($ward_id)->lga->name,
                        'zone_id' => $zone->id,
                        'polling_unit' => $pu->name,
                        'polling_unit_id' => $pu->id
                    ]);
                }
            }
        return success_msg('Constituency added successfully !');
    }

    function store_senatorial_zones()
    {
        $lga_ids = explode(',', request()->lga_id );
        $zone_ = $this->zone_exists();
        if( $zone_ ) $this->delete_zone( $zone_->id );

        $zone = zone::create([
            'name' => request()->name,
            'type' => 'senatorial',
            'state' => lga( $lga_ids[0] )->state,
            'user_id' => request()->user_id ?? current_user()->id
        ]);
        if( ! $zone ) return error_msg();

        foreach( $lga_ids as $lga_id ){
            $wards = lga( $lga_id )->wards;
            foreach( $wards as $ward )
            {
                $polling_units = ward( $ward->id )->polling_units;
                foreach( $polling_units as $pu)
                {
                    zone_content::create([
                        'ward' => $ward->name,
                        'lga' => lga($lga_id)->name,
                        'zone_id' => $zone->id,
                        'polling_unit' => $pu->name,
                        'polling_unit_id' => $pu->id
                    ]);
                }
            }
        }
        return success_msg('Senatorial District added successfully !');
    }

    function zone_exists()
    {
        return zone::whereName( request()->name )->first();
    }

    function delete_zone()
    {
        $zone_id = request()->id;
        zone::whereId( $zone_id )->delete();
        zone_content::whereZone_id( $zone_id )->delete();
        return success_msg("Removed successfully... ");
    }

    function ward_exists($name = "")
    {
        return ward::whereLga_id( request()->lga_id )->whereName( $name )->exists();
    }

    function polling_unit_exists($name = "")
    {
        return polling_unit::whereWard_id( request()->ward_id )->whereName( $name )->exists();
    }

    function remove_wards()
    {
        $id = request()->id;
        $remove = ward::whereId($id)->delete();
        return ! $remove ? error_msg() : success_msg("Removed succesfully...");
    }

    function remove_polling_units()
    {
        $id = request()->id;
        $remove = polling_unit::whereId($id)->delete();
        return ! $remove ? error_msg() : success_msg("Removed succesfully...");
    }

    function remove_political_party()
    {
        $id = request()->id ?? [];
        $remove = political_party::whereIn('id', $id)->delete();
        return ! $remove ? error_msg() : success_msg("Removed succesfully...");
    }

    function validate_data()
    {
        return $this->validate( request(), ['name' => 'required', 'lga_id'=>'required']);
    }

    function store_political_party()
    {
        $data = request()->except('_token', 'img');
        $data['user_id'] = current_user()->id;
        $this->validate_political_party_data();
        if( request()->hasFile('img')){
            $data['logo'] = upload_file_(request()->file('img'), party_logo_folder());
        }
        if( request()->has('update') ) return $this->update_political_party( $data );
        $store = political_party::create( $data );
        return ! $store ? error_msg() : success_msg();
    }

    function update_political_party( $data = [])
    {
        if( $data ){
            $party = political_party::whereId( request()->id )->first();
            if(! $party ) return error_msg();
            if( request()->hasFile('img')){
                delete_file_from_folder(party_logo_folder(), $party->logo);
            }
            $update = $party->update($data);
            return ! $update ? error_msg() : success_msg();
        }
    }

    function validate_political_party_data()
    {
        return $this->validate( request(), [
            'name' => 'required',
            'short_name' => 'required',
            'img' => 'required|image'
        ]);
    }
}
