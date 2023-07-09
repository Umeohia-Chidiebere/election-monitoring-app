<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\election;
use App\Models\polling_unit;
use App\Models\temp_stat;
use App\Models\vote;
use Illuminate\Http\Request;

class VueController extends Controller
{
    function fetch_elections()
    {
        $all_elections = election::latest()->with('election_type', 'category', 'state')->get();
        $data['all_elections'] = $all_elections;
        $data['latest_election'] =  $this->active_election_data();  
        return json_response($data);
    }

    function active_election_data()
    {
        $election = election::latest();
        if( request()->has('filter')){
            $election = election::whereCode_number( request()->code )->first();
        }else{
            $election = $election->first();
        }
        if( ! $election ) return '';
        $state = all_states($election->state_id, true);
        $data['state'] = $state->name;
        $data['code_number'] = $election->code_number;
        $data['valid_votes'] = $election->valid_votes(); 
        $data['total_registered_voters'] = $election->total_registered_voters;
        $data['fullnames'] = $election->fullnames();
        $data['invalid_votes'] = $election->invalid_votes();
        $data['total_votes'] = $election->valid_votes() + $election->invalid_votes();
        $data['total_polling_units'] =  $election->group_votes()->count();
        
        $lg = [];
        $d = [];
        $results_in_pu = vote::whereElection_id( $election->id )
                              ->with('polling_unit')
                              ->get()
                              ->groupBy('polling_unit_id');
        //==Delete temp stats
        temp_stat::whereElection_id( $election->id )->delete();

        //fetch result by party
        foreach( all_political_parties() as $party ):
            $d[] = [ 'party' => $party->short_name,
                    'total_votes' => fetch_total_vote_records($election->id, $election->category->slug.'_id', $state, $party->id) ];
        endforeach;

        //fetch result by LGA
        foreach( all_lga($state) as $lga ):
            $invalid_v = election_total_votes($election->id, 'lga', $lga->id )->sum('invalid_votes');
            $valid = election_total_votes($election->id, 'lga', $lga->id )->sum('total');
            $total_v = $invalid_v + $valid ;

                  $lg[] = ['lga' => $lga->name,
                            'total_votes' => $total_v,
                            'valid_votes' => $valid,
                            'invalid_votes' => $invalid_v,
                            'apc_votes' => $this->lga_party_results($election->id, $lga->id, 'APC'),
                            'nnpp_votes' => $this->lga_party_results($election->id, $lga->id, 'NNPP'),
                            'lp_votes' =>$this->lga_party_results($election->id, $lga->id, 'LP'),
                            'pdp_votes' => $this->lga_party_results($election->id, $lga->id, 'PDP')
                        ];
        endforeach;

        foreach( $results_in_pu as $pu_id => $info ){
            foreach( $info as $record ){ 
                $coords = json_decode( $record->polling_unit->location_coordinates );
                $party_total_votes_ = fetch_total_vote_records($election->id, $election->category->slug.'_id', $state, $record->political_party_id, $pu_id);
                $values['polling_unit'] = polling_unit( $pu_id )->name;
                $values['polling_unit_id'] = $pu_id;
                $values['latitude'] = $coords->latitude;
                $values['longitude'] = $coords->longitude;
                $values['election_id'] = $election->id;
                $values['political_party_id'] = $record->political_party_id;
                $values['party_name'] = political_party( $record->political_party_id )->short_name;
                $values['invalid_votes'] = election_total_votes($election->id, 'polling_unit', $pu_id )->sum('invalid_votes');
                $values['valid_votes'] = election_total_votes($election->id, 'polling_unit', $pu_id )->sum('total');
                $values['total_votes'] = $values['invalid_votes'] + $values['valid_votes'];
                $values['party_total_votes'] = $party_total_votes_;
                $this->save_temp_data( $values );
            }
        }
        $data['result_by_party'] = $d;
        $data['result_by_lga'] = $lg;
        $data['result_by_polling_units'] = $this->fetch_temp_data( $election->id );;
        return $data;
    }

    function lga_party_results($election_id, $lga_id, $party_name )
    {
        $data = 0;
        foreach( all_political_parties() as $party ):
            if( $party->short_name == $party_name ){
                $data = floatval(election_total_votes($election_id, 'lga', $lga_id, $party->id )->sum('total') ) ;
            } 
        endforeach;
        return $data;
    }

    function save_temp_data( $values )
    {
        temp_stat::create( $values );
    }

    function fetch_temp_data( $election_id )
    {
        $records = [];
        $data = temp_stat::whereElection_id( $election_id )->get()->groupBy('polling_unit_id');
        foreach($data as $pu_id => $values){
            $records[] = ['polling_unit_name' => polling_unit( $pu_id )->name, 
                          'latitude' => $values[0]->latitude, 
                          "longitude" => $values[0]->longitude,
                          'invalid_votes' => $values[0]->invalid_votes,
                          'valid_votes' => $values[0]->valid_votes,
                          'total_votes' => $values[0]->total_votes,
                          'apc_votes' => election_total_votes($election_id, 'polling_unit', $pu_id, get_political_party_id('APC'))->sum('total'),
                          'pdp_votes' => election_total_votes($election_id, 'polling_unit', $pu_id, get_political_party_id('PDP'))->sum('total'),
                          'lp_votes' => election_total_votes($election_id, 'polling_unit', $pu_id, get_political_party_id('LP'))->sum('total'),
                          'nnpp_votes' => election_total_votes($election_id, 'polling_unit', $pu_id, get_political_party_id('NNPP'))->sum('total')
                        ];
        }
        return $records;
    }
}
