<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\election;
use App\Models\post;
use App\Models\temp_stat;
use App\Models\vote;
use App\Models\ward;
use App\Models\zone;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VuetifyController extends Controller
{
    function fetch_app_data()
    {
        $pu_id = '';
        if( request()->type == 'all_lga') return $this->all_lga_datatables();
        if( request()->type == 'all_wards') return $this->all_ward_datatables();
        if( request()->type == 'all_users') return $this->all_users_datatables();
        if( request()->type == 'all_polling_units') return $this->all_polling_unit_datatables();
        if( request()->type == 'single_post') return $this->single_post();
        
        return
        [
            'all_admins' => all_admins(),
            'all_political_parties' => all_political_parties(),
            'all_lga' => all_lga( main_state()['name'] ),
            'all_states' => all_states( main_state()['id']),
            'all_senatorial_zones' => all_senatorial_zones( main_state()['name'] ),
            'all_constituency' => all_constituency( main_state()['name'] ),
            'all_polling_units' => all_polling_units( main_state()['name'] ),
            'all_wards' => all_wards(),
            'all_candidates' => all_election_candidates(),
            'all_elections' => all_elections(),
            'election_types' => election_category(),
            'all_users' => all_users(),
            'main_state' => main_state()['name'],
            'main_state_id' => main_state()['id'],
            'all_roles' => all_roles(),
            'all_notifications' => all_notifications(),
            'all_posts' => all_posts(),
            'my_polling_units' => my_polling_units(),
            'presidential_stats' => $this->presidential_stats(),
            'governorship_stats' => $this->governorship_stats(),
            'senatorial_stats' => $this->senatorial_stats(),
            'house_of_rep_stats' => $this->house_of_rep_stats(),
            'house_of_assembly_stats' => $this->house_of_assembly_stats(),
            'specific_elections' => specific_elections(),
            'report_category' => report_category()
        ];
    }

    function main_coordinates()
    {
        return ['latitude' => '12.9816', 'longitude' => '7.6223'];
    }

    function presidential_stats()
    {
        if( ! request()->has('presidential_stats')) return [];
        return $this->dashboard_stats();
    }

    function house_of_assembly_stats()
    {
        if( ! request()->has('house_of_assembly_stats')) return [];
        return $this->dashboard_stats();
    }

    function house_of_rep_stats()
    {
        if( ! request()->has('house_of_rep_stats')) return [];
        return $this->dashboard_stats();
    }

    function senatorial_stats()
    {
        if( ! request()->has('senatorial_stats')) return [];
        return $this->dashboard_stats();
    }

    function governorship_stats()
    {
        if( ! request()->has('governorship_stats')) return [];
        return $this->dashboard_stats();
    }

    function dashboard_stats()
    {
        if( ! request()->has('filter_election_result_stats')) return [];
        return [
            'election_data' => $this->election_data(),
            'party_total_votes' => $this->party_total_votes(),
            'party_lga_total_votes' => $this->party_lga_total_votes(),
            'party_pu_total_votes' => $this->party_pu_total_votes(),
            'party_state_total_votes' => $this->party_state_total_votes(),
            'party_zonal_total_votes' => $this->party_zonal_total_votes(),
            //'party_ward_total_votes' => $this->party_ward_total_votes(),
            'main_latitude' => $this->main_coordinates()['latitude'],
            'main_longitude' => $this->main_coordinates()['longitude'],
        ];
    }

    function active_election()
    {
        $election = election::whereElection_type_id( request()->election_type );
        if( $election_id = request()->election_id ){
            return $election->whereId( $election_id  )->first();
        }else{
            return $election->first();
        }
    }

    function election_data()
    {
        if( ! $election = $this->active_election() ) return error_msg('No Data Found...');
        $data['state'] = $election->state->name;
        $data['code_number'] = $election->code_number;
        $data['valid_votes'] = $election->valid_votes(); 
        $data['total_registered_voters'] = $election->total_registered_voters;
        $data['full_details'] = $election->full_details;
        $data['reported_total_events'] = $election->event_reports->count();
        $data['reported_events'] = post::with('user:id,name','polling_unit:id,name')
                                       ->whereElection_id( $election->id )
                                       ->whereType('post')
                                       ->get()
                                       ->take(3);
        $data['invalid_votes'] = $election->invalid_votes();
        $data['apc_total_votes'] = fetch_total_vote_records($election->id, '', 11);
        $data['pdp_total_votes'] = fetch_total_vote_records($election->id, '', 18);
        $data['lp_total_votes'] = fetch_total_vote_records($election->id, '', 15);
        $data['nnpp_total_votes'] = fetch_total_vote_records($election->id, '', 17);
        $data['total_votes'] = $election->valid_votes() + $election->invalid_votes();
        $data['other_party_votes'] = ($data['valid_votes'] ) - ($data['lp_total_votes'] + $data['nnpp_total_votes'] + $data['apc_total_votes'] + $data['pdp_total_votes']);
        $data['total_polling_units'] =  $election->group_votes('polling_unit_id')->count();
        return $data;
    }

    function party_total_votes()
    {
        if( ! $election = $this->active_election() ) return [];
        $data = [];
        foreach( all_political_parties() as $party ){
            $data[] = ['party' => $party->short_name, 
                       'total_votes' => fetch_total_vote_records($election->id,'', $party->id)
                    ];
        }
        return $data;
    }
    
    function party_zonal_total_votes()
    {
        if( ! request()->has('zonal_stats')) return [];
        if( ! $election = $this->active_election() ) return [];
        $data = [];
        $state =  main_state()['name'];
        if( $election->election_type->slug == 'senatorial_election'){
            $data = $this->get_zonal_election_result($election, $state, 'senatorial');
        }else{
            $data = $this->get_zonal_election_result($election, $state, 'constituency');
        }
        return $data;
    }

    function get_zonal_election_result($election, $state, $type)
    {
        $data = [];
        $zones = zone::whereType($type)->whereState($state)->get();
        $suffix = $type == 'senatorial' ? 'District' : '';
        foreach( $zones as $zone ){
            $data[ $zone->name.' '.$zone->type. ' '.$suffix ] = [
                'a' => fetch_total_vote_records($election->id,$state,5,'',$zone->id),
                'aa' => fetch_total_vote_records($election->id,$state,6,'',$zone->id),
                'adp' => fetch_total_vote_records($election->id,$state,7,'',$zone->id),
                'app' => fetch_total_vote_records($election->id,$state,8,'',$zone->id),
                'aac' => fetch_total_vote_records($election->id,$state,9,'',$zone->id),
                'adc' => fetch_total_vote_records($election->id,$state,10,'',$zone->id),
                'apc' => fetch_total_vote_records($election->id,$state,11,'',$zone->id),
                'apga' => fetch_total_vote_records($election->id,$state,12,'',$zone->id),
                'apm' => fetch_total_vote_records($election->id,$state,13,'',$zone->id),
                'bp' => fetch_total_vote_records($election->id,$state,14,'',$zone->id),
                'lp' => fetch_total_vote_records($election->id,$state,15,'',$zone->id),
                'nrm' => fetch_total_vote_records($election->id,$state,16,'',$zone->id),
                'nnpp' => fetch_total_vote_records($election->id,$state,17,'',$zone->id),
                'pdp' => fetch_total_vote_records($election->id,$state,18,'',$zone->id),
                'prp' => fetch_total_vote_records($election->id,$state,19,'',$zone->id),
                'sdp' => fetch_total_vote_records($election->id,$state,20,'',$zone->id),
                'ypp' => fetch_total_vote_records($election->id,$state,21,'',$zone->id),
                'zlp' => fetch_total_vote_records($election->id,$state,22,'',$zone->id)
            ];

        }
        return $data;
    }

    function party_lga_total_votes()
    {
        if( ! $election = $this->active_election() ) return [];
        $data = [];
        $state = '';
        if( request()->has('state')  ) $state = main_state()['name'];
            foreach( all_lga($state) as $lga ){
                $valid_votes = fetch_total_vote_records($election->id, $state, '', '', '',$lga->id);
                $invalid_votes = fetch_total_vote_records($election->id, $state, '', '', '',$lga->id, true);
                $total_votes = $valid_votes + $invalid_votes;
                $data[] = [
                       'valid_votes' => $valid_votes,
                       'invalid_votes' => $invalid_votes,
                       'lga_name' => $lga->name,
                       'total_votes' => $total_votes,
                       'apc_total_votes' => fetch_total_vote_records($election->id, $state, 11, '', '',$lga->id),
                       'lp_total_votes' => fetch_total_vote_records($election->id, $state, 15, '', '',$lga->id),
                       'pdp_total_votes' => fetch_total_vote_records($election->id, $state, 18, '', '',$lga->id),
                       'nnpp_total_votes' => fetch_total_vote_records($election->id, $state, 17, '', '',$lga->id),
                    ];
            }
        return $data;
    }

    function party_state_total_votes()
    {
        if( ! $election = $this->active_election() ) return [];
        $data = [];
            foreach( all_states() as $state ){
                $valid_votes = fetch_total_vote_records($election->id, $state->name);
                $invalid_votes = fetch_total_vote_records($election->id, $state->name, '', '', '','', true);
                $total_votes = $valid_votes + $invalid_votes;
                $data[] = [
                       'valid_votes' => $valid_votes,
                       'invalid_votes' => $invalid_votes,
                       'state_name' => $state->name,
                       'total_votes' => $total_votes,
                       'apc_total_votes' => fetch_total_vote_records($election->id, $state->name, 11),
                       'lp_total_votes' => fetch_total_vote_records($election->id, $state->name, 15),
                       'pdp_total_votes' => fetch_total_vote_records($election->id, $state->name, 18),
                       'nnpp_total_votes' => fetch_total_vote_records($election->id, $state->name, 17),
                    ];
            }
        return $data;
    }

    function party_pu_total_votes()
    {
        if( ! $election = $this->active_election() ) return [];
        $data = [];
        $state = '';
        if( request()->has('state')  ) $state = main_state()['name'];
        
            foreach( all_polling_units($state) as $pu ){
                $valid_votes = fetch_total_vote_records($election->id, $state, '', $pu->id);
                $invalid_votes = fetch_total_vote_records($election->id, $state, '', $pu->id,'','',true);
                $total_votes = $valid_votes + $invalid_votes;
                $data[] = [
                       'valid_votes' => $valid_votes,
                       'invalid_votes' => $invalid_votes,
                       'polling_unit' => $pu->name,
                       'total_votes' => $total_votes,
                       'reported_cases' => $this->reported_cases($pu->id)->count(),
                       'latitude' => $pu->latitude,
                       'longitude' => $pu->longitude,
                       'apc_total_votes' => fetch_total_vote_records($election->id, $state, 11, $pu->id),
                       'lp_total_votes' => fetch_total_vote_records($election->id, $state, 15, $pu->id),
                       'pdp_total_votes' => fetch_total_vote_records($election->id, $state, 18, $pu->id),
                       'nnpp_total_votes' => fetch_total_vote_records($election->id, $state, 17, $pu->id)
                    ];
            }
        return $data;
    }

    function party_ward_total_votes()
    {
        if( ! $election = $this->active_election() ) return [];
        $data = [];
        $state = '';
        if( request()->has('state')  ) $state =  main_state()['name'];
        
            foreach( all_wards($state) as $ward ){
                $data[] = [
                    'total_votes' => fetch_total_vote_records($election->id, $state, '', '','','',false, $ward->id),
                    'cancelled_votes' => fetch_total_vote_records($election->id, $state, '', '','','',true, $ward->id),
                    'ward' => $ward->name,
                    'apc_total_votes' => fetch_total_vote_records($election->id, $state, 11, '','','',false, $ward->id),
                    'lp_total_votes' => fetch_total_vote_records($election->id, $state, 15, '','','',false, $ward->id),
                    'pdp_total_votes' => fetch_total_vote_records($election->id, $state, 18, '','','',false, $ward->id),
                    'nnpp_total_votes' => fetch_total_vote_records($election->id, $state, 17, '','','',false, $ward->id),
                 ];
            }
        
        return $data;
    }

    function reported_cases($pu_id = '')
    {
        $posts = post::with('user:id,name','polling_unit:id,name')->latest()->whereType('post');
        if( $pu_id ) $posts = $posts->wherePolling_unit_id( $pu_id );
        return $posts->get(['id','code_number','content','user_id','polling_unit_id']);
    }

    function single_post()
    {
        return post::with(['comments'=> function($comment){
            return $comment->with('user:id,name');
        },
        'user','polling_unit'])->whereCode_number( request()->code_number )->first();
    }

    function all_lga_datatables()
    {
        return datatables()->of( all_lga( main_state()['name'] ) )->make( true );
    }

    function all_senatorial_zone_datatables()
    {
         return datatables()->of( all_senatorial_zones( main_state()['name'] ) )
                            //->only(['id', 'name','state','actions', 'data'])
                            ->addColumn('actions', function( $data ) {
                                return "<a class='delete_data text-danger' href='javascript:void(0)'><i id='$data->id' class='fa fa-trash'></i></a>";
                            })
                            ->addColumn('polling_units', function( $data ) {
                                return $data->map->polling_unit;
                            })
                            ->addColumn('wards', function( $data ) {
                                return $data->map->ward;
                            })
                            ->rawColumns(['actions'])
                            ->make( true );
    }

    function all_constituency_datatables()
    {
         return datatables()->of( all_constituency())
                            ->addColumn('actions', function( $data ) {
                                return "<a class='delete_data text-danger' href='javascript:void(0)'><i id='$data->id' class='fa fa-trash'></i></a>";
                            })
                            ->addColumn('data', function( $data ) {
                                return $data->zone_content;;
                            })
                            ->rawColumns(['actions'])
                            ->make( true );
    }

    function all_users_datatables()
    {
        return datatables()->of( all_users() )
                        //    ->only(['id', 'lga','name','admin','state','actions','username'])
                            ->addColumn('role', function( $data ) { 
                                return $data->role->name;
                            })
                            ->editColumn('name', function( $data ) {
                                return $data->fullnames();
                            })
                            ->addColumn('actions', function( $data ) {
                               if( ! current_user()->can_modify_all_admins() ) return "";
                                return "<a class='edit_user_data_btn text-info' href='javascript:void(0)'>
                                            <i id='$data' class='fa fa-edit'></i>
                                        </a> &nbsp;
                                        <a class='delete_data text-danger' href='javascript:void(0)'>
                                            <i id='$data->id' class='fa fa-trash'></i>
                                        </a>
                                        ";
                            })
                            ->rawColumns(['actions'])
                            ->make( true );
    }

    function all_ward_datatables()
    {
        return datatables()->of( all_wards() )
                        //    ->only(['id', 'lga','name','admin','state','actions','username'])
                            
                            ->addColumn('lga', function( $data ) {
                                return $data->lga->name;
                            })
                            ->addColumn('admin', function( $data ) { 
                                return $data->user->fullnames();
                            })
                            ->addColumn('state', function( $data ) {
                                return $data->lga->state;
                            })
                            ->addColumn('username', function( $data ) {
                                return $data->user->name;
                            })
                            ->addColumn('actions', function( $data ) {
                               if( ! current_user()->can_modify_all_admins() ) return "";
                                return "<a class='edit_ward_data_btn text-info' href='javascript:void(0)'>
                                            <i id='$data->id' class='fa fa-edit'></i>
                                        </a> &nbsp;
                                        <a class='delete_data text-danger' href='javascript:void(0)'>
                                            <i id='$data->id' class='fa fa-trash'></i>
                                        </a>
                                        ";
                            })
                            ->rawColumns(['actions'])
                            ->make( true );
    }

    function all_polling_unit_datatables()
    {
        return  datatables()->of( all_polling_units() )
                            ->only(['id','name','state','ward','lga','actions','admin'])
                            ->addColumn('lga', function($data) {
                                return $data->ward->lga->name;
                            })
                              ->addColumn('admin', function( $data ) { 
                                return $data->user->name;
                            })
                            ->addColumn('ward', function($data) {
                                return $data->ward->name;
                              })
                          
                            ->addColumn('actions', function($data) { 
                                if( ! current_user()->can_modify_users() ) return "";
                                return 
                                "
                                 <a class='edit_pu_data_btn text-info' href='javascript:void(0)'>
                                            <i id='$data->id' class='fa fa-edit'></i>
                                        </a> &nbsp;
                                        <a class='delete_data text-danger' href='javascript:void(0)'>
                                            <i id='$data->id' class='fa fa-trash'></i>
                                        </a>
                                ";
                              })
                            ->rawColumns(['actions'])
                            ->make( true );
    }
}
