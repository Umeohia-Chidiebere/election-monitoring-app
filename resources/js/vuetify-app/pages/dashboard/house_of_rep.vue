<template>
    <div>
        <skeletonLoader  v-if="is_loading"/>
        
        <v-container v-else fluid > 


<div class="row">
    <section class="col-md-6">
        <h4 class="text-success font-weight-bold text-center"> {{ app_data.house_of_rep_stats.election_data.full_details }}</h4>
    </section>

    <section class="col-md-6">
        
<v-select 
  label="Select Election"
  v-model="selected_election"
  placeholder="Select election"
  color="green"
  :items="app_data.specific_elections.house_of_rep"
  item-text="full_details"
  item-value="id"
  @change="filter_election_result"
  required>
</v-select>

    </section>
</div>


<section class="row">

<!-- shiow Live-map -->
    <div class="col-md-8">
          
        <v-card  elevation="5">
            <div :key="component_key" id="house_of_rep_election_map" style="z-index:0; max-height:350px;"></div>
        </v-card>

        <v-card elevation="5">
            <v-card-title class="text-left"> Situation Reports </v-card-title>

            <div class="table-responsive">
                <table class="table table-md table-hover">
                    <tbody>
                        <tr class="cursor" v-for="post in app_data.house_of_rep_stats.election_data.reported_events" :key="post.id" @click="navigate_to_post(post.code_number)">
                            <td>
                                <p> {{ post.user.name }} <small class="text-muted"> .  {{ post.created_at }} (Polling unit: {{ post.polling_unit.name }}) </small> |
                                    <span class="text-muted text-xs"> {{ $short_text(post.content, 100) }} 
                                   </span> 
                                </p>  
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </v-card>

    </div>
<!-- ///end live-map -->



    <div class="col-md-4">
        
        <section class="row" :key="component_key">

            <div class="col-md-6">
                <v-card shaped elevation="2">
                    <v-card-subtitle> 
                        <p class="float-right font-weight-bold text-success"> {{ number_format(app_data.house_of_rep_stats.election_data.apc_total_votes) }} </p>
                        <h6> APC votes </h6>   
                    </v-card-subtitle>
                </v-card>
            </div>

            <div class="col-md-6">
                <v-card shaped elevation="2">
                    <v-card-subtitle> 
                        <p class="float-right font-weight-bold text-warning"> {{ number_format(app_data.house_of_rep_stats.election_data.pdp_total_votes) }} </p>
                        <h6>PDP votes</h6>   
                    </v-card-subtitle>
                </v-card>
            </div>

            <div class="col-md-6">
                <v-card shaped elevation="2">
                    <v-card-subtitle> 
                        <p class="float-right font-weight-bold text-success"> {{ number_format(app_data.house_of_rep_stats.election_data.lp_total_votes) }} </p>
                        <h6>LP votes</h6>   
                    </v-card-subtitle>
                </v-card>
            </div>

            <div class="col-md-6">
                <v-card shaped elevation="2">
                    <v-card-subtitle> 
                        <p class="float-right font-weight-bold text-info"> {{ number_format(app_data.house_of_rep_stats.election_data.nnpp_total_votes) }} </p>
                        <h6>NNPP votes</h6>   
                    </v-card-subtitle>
                </v-card>
            </div>

            <div class="col-md-6">
                <v-card shaped elevation="2">
                    <v-card-subtitle> 
                        <p class="float-right font-weight-bold text-primary"> {{ number_format(app_data.house_of_rep_stats.election_data.other_party_votes) }} </p>
                        <h6>Other party votes</h6>   
                    </v-card-subtitle>
                </v-card>
            </div>

            <div class="col-md-6">
                <v-card shaped elevation="2">
                    <v-card-subtitle> 
                        <p class="float-right font-weight-bold text-success"> {{ number_format(app_data.house_of_rep_stats.election_data.valid_votes) }} </p>
                        <h6>Valid votes</h6>   
                    </v-card-subtitle>
                </v-card>
            </div>

            <div class="col-md-6">
                <v-card shaped elevation="2">
                    <v-card-subtitle> 
                        <p class="float-right font-weight-bold text-danger">{{ number_format(app_data.house_of_rep_stats.election_data.invalid_votes) }} </p>
                        <h6>Cancelled votes </h6>   
                    </v-card-subtitle>
                </v-card>
            </div>

            <div class="col-md-6">
                <v-card shaped elevation="2">
                    <v-card-subtitle> 
                        <p class="float-right font-weight-bold text-primary"> {{ number_format(app_data.house_of_rep_stats.election_data.total_votes) }} </p>
                        <h6>Total votes</h6>   
                    </v-card-subtitle>
                </v-card>
            </div>

            <div class="col-md-6">
                <v-card shaped elevation="2">
                    <v-card-subtitle> 
                        <p class="float-right font-weight-bold text-primary"> {{ number_format(app_data.house_of_rep_stats.election_data.total_registered_voters) }} </p>
                        <h6>Registered voters</h6>   
                    </v-card-subtitle>
                </v-card>
            </div>

            <div class="col-md-6">
                <v-card shaped elevation="2">
                    <v-card-subtitle> 
                        <p class="float-right font-weight-bold text-primary"> {{ number_format(app_data.house_of_rep_stats.election_data.total_polling_units) }} </p>
                        <h6>Polling unit with votes</h6>   
                    </v-card-subtitle>
                </v-card>
            </div>


            <div class="col-md-12">
                <v-card shaped elevation="2">
                    <v-card-subtitle> 
                        <p class="float-right font-weight-bold text-secondary"> {{ number_format(app_data.house_of_rep_stats.election_data.reported_total_events) }} </p>
                        <h6>Reported cases </h6>   
                    </v-card-subtitle>
                </v-card>
            </div>
            
        </section>

    </div>

</section>
<!-- //end row -->


<!-- row -->
<!-- show graph -->
<section class="row">
    
<div class="col-md-4" v-for="(result, title) in app_data.house_of_rep_stats.party_zonal_total_votes" :key="title">
        <!-- LGA Graph result -->
    <v-card :key="component_key">
        <v-card-subtitle class="table-capitalized font-weight-bold"> {{ title }} </v-card-subtitle>
        <v-card-text>
            <div>
                <section class="table-responsive">
                    <table class="table table-md table-hover text-uppercase"> 
                        <thead>
                            <tr>
                                <th>PARTY</th>
                                <th>TOTAL VOTES</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>a</td>
                                <td>{{ result.a }}</td>
                            </tr>
                            <tr>
                                <td>aa</td>
                                <td>{{ result.aa }}</td>
                            </tr>
                            <tr>
                                <td>aac</td>
                                <td>{{ result.aac }}</td>
                            </tr>
                            <tr>
                                <td>adc</td>
                                <td>{{ result.adc }}</td>
                            </tr>
                            <tr>
                                <td>adp</td>
                                <td>{{ result.adp }}</td>
                            </tr>
                            <tr>
                                <td>apc</td>
                                <td>{{ result.apc }}</td>
                            </tr>
                            <tr>
                                <td>apga</td>
                                <td>{{ result.apga }}</td>
                            </tr>
                            <tr>
                                <td>apm</td>
                                <td>{{ result.apm }}</td>
                            </tr>
                            <tr>
                                <td>app</td>
                                <td>{{ result.app }}</td>
                            </tr>
                            <tr>
                                <td>bp</td>
                                <td>{{ result.bp }}</td>
                            </tr>
                            <tr>
                                <td>lp</td>
                                <td>{{ result.lp }}</td>
                            </tr>
                            <tr>
                                <td>nnpp</td>
                                <td>{{ result.nnpp }}</td>
                            </tr>
                            <tr>
                                <td>nrm</td>
                                <td>{{ result.nrm }}</td>
                            </tr>
                            <tr>
                                <td>pdp</td>
                                <td>{{ result.pdp }}</td>
                            </tr>
                            <tr>
                                <td>prp</td>
                                <td>{{ result.prp }}</td>
                            </tr>
                            <tr>
                                <td>sdp</td>
                                <td>{{ result.sdp }}</td>
                            </tr>
                            <tr>
                                <td>ypp</td>
                                <td>{{ result.ypp }}</td>
                            </tr>
                            <tr>
                                <td>zlp</td>
                                <td>{{ result.zlp }}</td>
                            </tr>
                            
                        </tbody>
                    </table>
                </section>
            </div>
        </v-card-text>
    </v-card>

</div>
<!-- //col -->

</section>
<!-- //row -->


        </v-container>
    </div>
</template>

<script>
import { mapState } from 'vuex';
import skeletonLoader from '../../layouts/skeleton_loader.vue';

    export default {
        components: { skeletonLoader,},
        data(){
            return { selected_election:'', is_loading:true, component_key:1
                }
        },

        computed:{
            ...mapState(['app_data']),
        },

        methods:{
            
        async show_map(){
            setTimeout(() => {

                var data_ = this.app_data.house_of_rep_stats.party_pu_total_votes;
                 
               const map = L.map("house_of_rep_election_map").setView([this.app_data.house_of_rep_stats.main_latitude, this.app_data.house_of_rep_stats.main_longitude], 8);

	 var osm = L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
	 	// attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
	 });//.addTo(map);
     map.addLayer(osm);

	const LeafIcon = L.Icon.extend({
		options: {
			//shadowUrl: map_marker_shadow,
			iconSize:     [25, 50],
			//shadowSize:   [50, 64],
			iconAnchor:   [18, 80],
			shadowAnchor: [4, 62],
			popupAnchor:  [-3, -76]
		}
	});

	const map_location_icon = new LeafIcon({iconUrl: map_marker});
	//const redIcon = new LeafIcon({iconUrl: map_marker2 });
	//const orangeIcon = new LeafIcon({iconUrl: map_marker});

            data_.forEach((value) => {
                var $details = ` P.U: ${value.polling_unit}<hr>
                                 Valid votes: <span class='text-success'> ${number_format(value.valid_votes)}</span><br>
                                 InValid votes: <span class='text-danger'> ${ number_format(value.invalid_votes) } </span><br>
                                 Total votes: <span class='text-primary'> ${number_format(value.total_votes)} </span><br>
                                 Reported cases: <span class='text-info'> ${number_format(value.reported_cases)} </span> <br>
                                 <hr>
                                 APC votes: ${number_format(value.apc_total_votes)}<br>
                                 LP votes: ${number_format(value.lp_total_votes)}<br>
                                 NNPP votes: ${number_format(value.nnpp_total_votes)}<br>
                                 PDP votes: ${number_format(value.pdp_total_votes)}
                                `;
                    L.marker([value.latitude, value.longitude], {icon: map_location_icon})
                     .bindPopup($details).addTo(map);
                 }); 

            }, 5000);
        },

        navigate_to_post( $code_number = ''){
            this.$router.push({name:"view_post_page", params:{code_number:$code_number }});
        },

        load_records( data = ''){
                this.component_key+= 1;
                var election_id = this.selected_election;
                data ? data : data = {filter_election_result_stats:1, zonal_stats:1,house_of_rep_stats:1, state:1, election_type: 4, election_id};
                this.$store.dispatch("fetch_app_data", data); 
                this.show_map();
                this.is_loading = false;
                
                 setTimeout(() => {
                     this.load_records();
                  }, 40000);
            },

            filter_election_result(){   
                var $election_id = this.selected_election;
                var data = {filter_election_result_stats:1,zonal_stats:1,house_of_rep_stats:1, state:1, election_type: 4, election_id: $election_id };
                    this.load_records( data );
            },
            
        },

        mounted(){
            this.load_records();
        }
    }
</script>
