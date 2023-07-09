<template>
    <div>
        <skeletonLoader  v-if="is_loading"/>
        
        <v-container v-else fluid style="background: darkgreen;"> 


<div class="row" style="background-color: whitesmoke;">
    <section class="col-md-6">
        <h4 class="text-success font-weight-bold text-center"> {{ app_data.governorship_stats.election_data.full_details }}</h4>
    </section>

    <section class="col-md-6">
        
<v-select
  label="Select Election"
  v-model="selected_election"
  placeholder="Select election"
  :items="app_data.specific_elections.governorship"
  item-text="full_details"
  item-value="id"
  @change="filter_election_result"
  color="green"
  required>
</v-select>

    </section>
</div>


<section class="row">

<!-- shiow Live-map -->
    <div class="col-md-8">
          
        <v-card  elevation="5">
            <div :key="component_key" id="governorship_election_map" style="z-index:0; max-height:350px;"></div>
        </v-card>

    </div>
<!-- ///end live-map -->


    <div class="col-md-4">
        
        <section class="row" :key="component_key">

            <div class="col-md-6">
                <v-card shaped elevation="2">
                    <v-card-subtitle> 
                        <p class="float-right font-weight-bold text-success"> {{ number_format(app_data.governorship_stats.election_data.apc_total_votes) }} </p>
                        <h6> APC votes </h6>
                    </v-card-subtitle>
                </v-card>
            </div>

            <div class="col-md-6">
                <v-card shaped elevation="2">
                    <v-card-subtitle> 
                        <p class="float-right font-weight-bold text-warning"> {{ number_format(app_data.governorship_stats.election_data.pdp_total_votes) }} </p>
                        <h6>PDP votes</h6>   
                    </v-card-subtitle>
                </v-card>
            </div>

            <div class="col-md-6">
                <v-card shaped elevation="2">
                    <v-card-subtitle> 
                        <p class="float-right font-weight-bold text-success"> {{ number_format(app_data.governorship_stats.election_data.lp_total_votes) }} </p>
                        <h6>LP votes</h6>   
                    </v-card-subtitle>
                </v-card>
            </div>

            <div class="col-md-6">
                <v-card shaped elevation="2">
                    <v-card-subtitle> 
                        <p class="float-right font-weight-bold text-info"> {{ number_format(app_data.governorship_stats.election_data.nnpp_total_votes) }} </p>
                        <h6>NNPP votes</h6>   
                    </v-card-subtitle>
                </v-card>
            </div>

            <div class="col-md-6">
                <v-card shaped elevation="2">
                    <v-card-subtitle> 
                        <p class="float-right font-weight-bold text-primary"> {{ number_format(app_data.governorship_stats.election_data.other_party_votes) }} </p>
                        <h6>Other party votes</h6>   
                    </v-card-subtitle>
                </v-card>
            </div>

            <div class="col-md-6">
                <v-card shaped elevation="2">
                    <v-card-subtitle> 
                        <p class="float-right font-weight-bold text-success"> {{ number_format(app_data.governorship_stats.election_data.valid_votes) }} </p>
                        <h6>Valid votes</h6>   
                    </v-card-subtitle>
                </v-card>
            </div>

            <div class="col-md-6">
                <v-card shaped elevation="2">
                    <v-card-subtitle> 
                        <p class="float-right font-weight-bold text-danger">{{ number_format(app_data.governorship_stats.election_data.invalid_votes) }} </p>
                        <h6>Cancelled votes </h6>   
                    </v-card-subtitle>
                </v-card>
            </div>

            <div class="col-md-6">
                <v-card shaped elevation="2">
                    <v-card-subtitle> 
                        <p class="float-right font-weight-bold text-primary"> {{ number_format(app_data.governorship_stats.election_data.total_votes) }} </p>
                        <h6>Total votes</h6>   
                    </v-card-subtitle>
                </v-card>
            </div>

            <div class="col-md-6">
                <v-card shaped elevation="2">
                    <v-card-subtitle> 
                        <p class="float-right font-weight-bold text-primary"> {{ number_format(app_data.governorship_stats.election_data.total_registered_voters) }} </p>
                        <h6>Registered voters</h6>   
                    </v-card-subtitle>
                </v-card>
            </div>

            <div class="col-md-6">
                <v-card shaped elevation="2">
                    <v-card-subtitle> 
                        <p class="float-right font-weight-bold text-primary"> {{ number_format(app_data.governorship_stats.election_data.total_polling_units) }} </p>
                        <h6>Polling unit with votes</h6>   
                    </v-card-subtitle>
                </v-card>
            </div>


            <div class="col-md-12">
                <v-card shaped elevation="2">
                    <v-card-subtitle> 
                        <p class="float-right font-weight-bold text-secondary"> {{ number_format(app_data.governorship_stats.election_data.reported_total_events) }} </p>
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
<div class="row">

    
<div class="col-md-7">
        <!-- LGA Graph result -->
    <v-card>
        <v-card-subtitle class="font-weight-bold"> Party Total Votes </v-card-subtitle>
        <v-card-text>
            <div id="party_result_graph" :key="component_key"></div>
        </v-card-text>
    </v-card>

</div>
<!-- //col -->

    <div class="col-md-5">
        <!-- LGA Graph result -->
    <v-card>
        <v-card-subtitle class="font-weight-bold"> Total votes in Local Government </v-card-subtitle>
        <v-card-text>
            <div id="lga_graph" :key="component_key"></div>
        </v-card-text>
    </v-card>

</div>
<!-- //col -->


</div>
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
             
        async graph_result_by_party(){
                setTimeout(() => {
                    
                    var data_ = this.app_data.governorship_stats.party_total_votes;
                var data_y = [];
                var data_x = [];
                for(var i = 0; i < data_.length; i++ ){
                    data_y.push( data_[i]['total_votes'] );
                    data_x.push( data_[i]['party'] );
                }
               // return console.log( data_y );
                
               var options = {
          series: [{
          data: data_y
        }],
          chart: {
          type: 'bar',
          height: 400
        },
        plotOptions: {
          bar: {
            barHeight: '100%',
            //distributed: true,
            horizontal: false,
            dataLabels: {
              position: 'bottom'
            },
          }
        },
        colors: ['#33b2df', '#546E7A', '#d4526e', '#13d8aa', '#A5978B', '#2b908f', '#f9a3a4', '#90ee7e',
          '#f48024', '#69d2e7'
        ],
        dataLabels: {
          enabled: false,
          
          formatter: function (val, opt) {
            return opt.w.globals.labels[opt.dataPointIndex] + ":  " + val
          },
          offsetX: 0,
          dropShadow: {
            enabled: true
          }
        },
        stroke: {
          width: 1,
          colors: ['#fff']
        },
        xaxis: {
          categories: data_x,
        },
        yaxis: {
          labels: {
            show: false
          }
        },
        title: {
            text: '',
            align: 'center',
            floating: true
        },
        subtitle: {
            text: '',
            align: 'center',
        },
        tooltip: {
          theme: 'light',
          x: {
            show: true
          },
          y: {
            title: {
              formatter: function () {
                return ''
              }
            }
          }
        }
        };

        var chart = new ApexCharts(document.querySelector("#party_result_graph"), options);
        chart.render();

                }, 5000);
        },


        async graph_result_by_lga(){
                setTimeout(() => {
                    
                    var data_ = this.app_data.governorship_stats.party_lga_total_votes;
                var $total_votes = [],
                    $invalid_votes = [],
                    $valid_votes = [],
                    $apc_votes = [],
                    $pdp_votes = [],
                    $nnpp_votes = [],
                    $lp_votes= [],
                    $lga = [];
                for(var i = 0; i < data_.length; i++ ){  
                    $total_votes.push( data_[i]['total_votes'] );
                    $invalid_votes.push( data_[i]['invalid_votes'] );
                    $valid_votes.push( data_[i]['valid_votes'] );
                    $apc_votes.push( data_[i]['apc_total_votes'] );
                    $lp_votes.push( data_[i]['lp_total_votes'] );
                    $pdp_votes.push( data_[i]['pdp_total_votes'] );
                    $nnpp_votes.push( data_[i]['nnpp_total_votes'] );
                    $lga.push( data_[i]['lga_name'] );
                }
            
                var options = {
          series: [
          { name:"Total votes", data: $total_votes },
          { name:"Valid votes", data: $valid_votes },
           { name:"Invalid votes", data: $invalid_votes },
           { name: 'APC', data: $apc_votes },
           { name: 'PDP', data: $pdp_votes },
           { name: 'NNPP', data: $nnpp_votes },
           { name: 'LP', data: $lp_votes },
          ],
          chart: {
             animations: {
            enabled: false
          },

          type: 'bar',
          height: 600
        },

        // ued for shared bars (Double data)
        tooltip: {
           shared: true,
           intersect: false
         },

        plotOptions: {
          bar: {
            borderRadius: 5,
            horizontal: true,
            position: 'top',
            barHeight: '150px',
            distributed: true
          }
        },

        stroke: {
          show: true,
          width: 2,
          colors: ['#fff']
        },

        dataLabels: {
          enabled: false,
          offsetX: -6,
          style: {
            fontSize: '14px',
            colors: ['#fff']
          }
        },

        xaxis: {
          categories: $lga,
        }
        };
        var chart = new ApexCharts( document.querySelector("#lga_graph"), options);
        chart.render();

                }, 5000);
        },


         async show_map(){
            setTimeout(() => {

                var data_ = this.app_data.governorship_stats.party_pu_total_votes;
                 
               const map = L.map("governorship_election_map").setView([this.app_data.governorship_stats.main_latitude, this.app_data.governorship_stats.main_longitude], 8);

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
                data ? data : data = {filter_election_result_stats:1, governorship_stats:1, state:1, election_type: 2, election_id};
                this.$store.dispatch("fetch_app_data", data);    
                this.graph_result_by_lga();
                this.graph_result_by_party();
                this.show_map();
                this.is_loading = false;
                
                 setTimeout(() => {
                     this.load_records();
                  }, 40000);
            },

            filter_election_result(){   
                var $election_id = this.selected_election;
                var data = {filter_election_result_stats:1,governorship_stats:1, state:1, election_type: 2, election_id: $election_id };
                    this.load_records( data );
            },

            
        },

        mounted(){
            this.load_records();
        }
    }
</script>
