<?php

use App\Models\candidate;
use App\Models\role;
use App\Models\category;
use App\Models\election;
use App\Models\election_type;
use App\Models\lga;
use App\Models\notification;
use App\Models\political_party;
use App\Models\organization;
use App\Models\polling_unit;
use App\Models\post;
use App\Models\state;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;  
use App\Models\User;
use App\Models\user_login;
use App\Models\vote;
use App\Models\ward;
use App\Models\zone;
use Illuminate\Support\Facades\Http;

require('file_uploads.php');
require('mail_config.php');
require('send_emails.php');

    function password_corresponds( $value, $hashed_value )
    {
       return Hash::check($value, $hashed_value);
    }

    function report_category()
    {
        return [
            'INEC Official Arrived',
            'Accreditation Started',
            'Accreditation Ended',
            'Election Started',
            'Election Ended',
            'Result Counting Started',
            'Result is Announced',
            'BVAS/Network',
            'Cancellation of Results',
            'Fighting/Crisis',
            'Winning',
            'Other Party Agents',
            'About Election',
            'INEC Staff'
        ];
    }

    function all_admins()
    {
        if( current_user()->role->slug == 'user') return [];
        return [
            'ward' => User::whereRole_id(5)->get(),
            'user' => User::whereRole_id(2)->get(),
            'super_admin' => User::whereRole_id(1)->get(),
            'senatorial' => User::whereRole_id(4)->get(),
            'lga' => User::whereRole_id(3)->get(),
            'constituency' => User::whereRole_id(6)->get(),
        ];
    }

    function current_party()
    {
        return political_party::latest()->whereStatus(1)->first();
    }

    function all_political_parties()
    {
        return political_party::orderBy('name')->get();
    }

    function main_party()
    {
        return "APC";
    }

    function main_state()
    {
        return ["id" => 4, "name" => "Katsina"];
    }

    function app_name()
    {
        return "Election Monitoring App";
    }

    function official_phone_number()
    {
        return "+2348106928318";
    }
    
    function election($id)
    {
        return election::whereId($id)->first();
    }

    function zone( $zone_id = '')
    {
        return zone::whereId( $zone_id )->first();
    }

    function get_record($type, $id)
    {
        if( $type ){
            return vote::where($type.'_id',$id)->first();
        }
    }

    function fetch_total_vote_records($election_id, $state = '', $party_id = '', $polling_unit_id = '', $zone_id = '', $lga_id = "", $cancelled_votes = false, $ward_id = '')
    {
        $data = vote::whereElection_id($election_id);
        if( $state ) $data = $data->whereState($state);
        if( $party_id ) $data = $data->wherePolitical_party_id($party_id);
        if( $lga_id ) $data = $data->whereLga_id($lga_id); 
        if( $zone_id ) $data = $data->whereZone_id($lga_id);                   
        if( $polling_unit_id ) $data = $data->wherePolling_unit_id( $polling_unit_id );
        if( $ward_id ) $data = $data->whereWard_id( $ward_id );
        if( $cancelled_votes ) return $data->sum('invalid_votes');
        return $data->sum('total');
    }

    function get_nigeria_state($type, $id)
    {
        if( $type == "polling_unit") $data = polling_unit::whereId($id)->first()->get_state();
        if( $type == "ward") $data =  ward::whereId($id)->first()->get_state();
        return $data;
    }

    function political_party($id)
    {
        return political_party::whereId($id)->first();
    }

    function find_user( $user_id )
    {
        return User::whereId( $user_id )->first();
    }

    function query_model($model, $user_id, $is_deleted = 0)
    {
        return $model->whereUser_id( $user_id )->whereIs_deleted( $is_deleted )->latest();
    }

    function find_data($model, $id)
    {
        return $model->whereId($id)->first();
    }

    function store_user_login()
    {
        $login = user_login::create([
            'user_id' => current_user()->id,
            'ip_info' => user_ip_address_info(),
            "ip_address" => request()->ip(),
            "device_details" => user_device_details()
        ]);
        send_login_email(current_user(), $login);
    }

    function election_types( $id = '')
    {
        $data = election_type::orderBy('name');
        if( $id ) return $data->whereId( $id )->first();
        return $data->get();
    }

    function election_total_votes($election_id, $category = '', $query_id = '', $party_id = '')
    {
        $data = vote::whereElection_id($election_id);
        if( $category ) $data = $data->where($category.'_id', $query_id);
        if( $party_id ) $data = $data->wherePolitical_party_id( $party_id );
        return $data;
    }

    function get_political_party_id( $party_short_name = '')
    {
        $q = strtoupper( $party_short_name );
        $data = political_party::whereShort_name( $q )->first();
        return $data ? $data->id : '';
    }

    function all_election_candidates()
    {
        return candidate::with("zone","political_party","election")->latest()->get()->groupBy('election');
    }

    function short_name( $content, $max_number = 15 )
    {
        return ( strlen( $content ) > $max_number ) ? substr( $content, 0, ($max_number - 1) ).'...' : $content ;
    }

    function acronym( $word = "")
    {
        $text = "";
        $words = explode(" ", trim($word) );
        try{      
             foreach( $words as $word ){
               $text .= $word[0];
            }
        }
        catch(Exception $err){
            //
        }
        return $text;
    }

    function organization()
    {
        return organization::latest()->first();
    }

    function random_strings($length = 40)
    {
        return time().'_'.Str::random($length).'_'.uniqid('');
    }

    function code_number()
    {
        return uniqid().'_'.time();
    }

    function all_roles()
    {
        return role::orderBy('name')->get();
    }

    function all_categories()
    {
        return category::orderBy('name')->get();
    }

    function all_notifications()
    {
        $notifications = notification::with('user')->latest();
        if( current_user()->role->slug == 'user') $notifications = $notifications->whereUser_id( current_user()->id );
        return $notifications->get()->take(100);
    }

    function all_posts()
    {
        $posts = post::with('comments', 'user:id,name','polling_unit:id,name')->whereType('post')->latest();
        if( request()->filter_post )
        {
            if( $pu_id = request()->polling_unit_id ) $posts = $posts->wherePolling_unit_id( $pu_id );
            if( $election_id = request()->election_id ) $posts = $posts->whereElection_id( $election_id );
            if( $category = request()->category ) $posts = $posts->wherecategory( $category );
        }
        return $posts->get()->take( 100 );
    }

    function my_polling_units()
    {
        $pu = polling_unit::whereUser_id( current_user()->id )
                          ->orWhereIn('ward_id', current_user()->ward()->pluck('id') )
                          ->get();
        $wards = ward::with('polling_units')->whereUser_id( current_user()->id )->get();
        $zones = zone::with('zone_content')->whereUser_id( current_user()->id )->get();

       
        $election_results = vote::with('political_party')
                                ->whereUser_id( current_user()->id )
                                ->orWhereIn('ward_id', current_user()->ward()->pluck('id') )
                                ->get()
                                ->groupBy(['election', 'zone', 'polling_unit']);
        return ['wards' => $wards, 'zones' => $zones, 'results' => $election_results, 'polling_units' =>$pu ];
    }

    function specific_elections()
    {
        $general = election::whereIn('election_type_id', [1,2])->get();
        $presidential = election::whereElection_type_id(1)->get();
        $governorship = election::whereElection_type_id(2)->get();
        $zonal = election::whereIn('election_type_id', [3,4,5])->get();
        $senatorial = election::whereElection_type_id(3)->get();
        $house_of_rep = election::whereElection_type_id(4)->get();
        $house_of_assembly = election::whereElection_type_id(5)->get();
        return [
            'zonal' => $zonal,
            'general' => $general,
            'presidential' => $presidential,
            'governorship' => $governorship,
            'senatorial' => $senatorial,
            'house_of_rep' => $house_of_rep,
            'house_of_assembly' => $house_of_assembly,
            'all' => election::latest()->get()
        ];
    }

    function single_post( $code_number = '')
    {
        return post::whereCode_number( $code_number )->first();
    }

    function polling_unit( $pu_id = '')
    {
        return polling_unit::whereId( $pu_id )->first();
    }

    function all_states( $state_id = '', $find_single = false)
    {
        $state = state::orderBy('name');
        if( $state_id) $state = $state->whereId( $state_id );
        if ( $state_id && $find_single ) return $state->first();
        return $state->get();
    }

    function all_senatorial_zones( $state = '')
    {
        $data = zone::with('zone_content','user:id,name')->whereType('senatorial')->latest();
        if( $state ){
            $record = $data->whereState( $state );
            if( $record->exists() ) $data = $record;
        }
        return $data->get();
    }

    function all_constituency( $state = '')
    {
        $data = zone::with('zone_content','user:id,name')->whereType('constituency')->latest();
        if( $state ){
            $record = $data->whereState( $state );
            if( $record->exists() ) $data = $record;
        }
        return $data->get();
    }

    function all_lga( $state = '')
    {
        $data = lga::with('user')->orderBy('name');
        if( $state ){
             $record = $data->whereState( $state );
             if( $record->exists() ) $data = $record;
        }
        return $data->get();
    }

    function all_elections()
    {
        return election::with('election_type','state')->latest()->get();
    }

    function all_active_elections()
    {
        return election::whereStatus(1)->latest()->get();
    }

    function election_category()
    {
        return election_type::orderBy('name')->get();
    }

    function all_users()
    {
        return User::with('role')->latest()->get();
    }

    function all_wards($state = '')
    {
          $data = ward::latest();
          if( $state ){
              $record = $data->whereState( $state );
              if( $record->exists() ) $data = $record;
           }
        return $data->with('user')->get();
    }

    function lga($id = '')
    {
        return lga::whereId( $id )->first();
    }

    function ward($id = '')
    {
        return ward::whereId( $id )->first();
    }

    function all_polling_units($state = '')
    {
        $data = polling_unit::latest();
        if( $state ){
            $record = $data->whereState( $state );
            if( $record->exists() ) $data = $record;
        }
        return $data->get();
    }

    function current_user()
    {
        return auth()->user();
    }

    function notification($content = '', $type = 'post')
    {
        notification::create([
            'user_id' => current_user()->id,
            'content' => $content,
            'type' => $type
        ]);
    }

    function json_response($data = [])
    {
        return response()->json($data);
    }

    function slug( $text = '', $seperator = '-')
    {
        return Str::slug( $text, $seperator );
    }

    function view_page( $page, $folder = '' )
    {
        $dir = "pages/";
        return ( $folder ) ? $dir.$folder.'/'.$page : $dir.'/'.$page;
    }

    function error_msg($msg='Failed, an error Occured...')
    {
        return response()->json(['error' => $msg ]);
    }

    function success_msg($msg = 'Success...')
    {
        return response()->json(['success' => $msg ]);
    }

    function error_msg_($msg='Failed, an error Occured...')
    {
        return back()->withErrors( $msg );
    }

    function success_msg_($msg = 'Success...')
    {
        return back()->withSuccess( $msg );
    }

    function user_device_details()
    {
        return '';
    }

    function event_reports()
    {
        return post::latest()->whereType('post')->simplePaginate(15);
    }

    function event_reports_count()
    {
        return post::whereType('post')->count();
    }

    function user_ip_info($data = '')
    {
        return $data ? json_decode( $data ) : json_decode( user_ip_address_info() );
    }

    function user_ip_address_info()
    { 
      $ip_info = '';
      try{
      $api_key = "2d9a7d6c0c9144dbaf7135717221002";
      $request_uri = 'http://api.weatherapi.com/v1/ip.json';
      $ip_address = request()->ip();
      $url = $request_uri."?key=".$api_key."&q=".$ip_address;
      $data = Http::get($url);
      $data = $data->object();
      $ip_info = json_encode([
          'state' => $data->region,
          'ip_address' => $ip_address,
          'country_code' => $data->country_code,
          'continent' => $data->continent_name,
          'city' => $data->city,
          'timezone' => $data->tz_id,
          'longitude' => $data->lon,
          'latitude' => $data->lat,
          'currency' => '',
          'country' => $data->country_name
        ]);
      }
      catch(Exception $err ){
          //return 'error '.$err;
          //$ip_info = [];
      }
      return $ip_info;
    }
