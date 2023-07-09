<template>
<section>
    <div>
        <form action="?" class="post">
            <label for="" :id="latest_election.code_number" class="code_number_"></label>
            <select @change="filter_election" class="form-control">
                <option value="" id="election_options"> - Select Election - </option>
                <option v-for="election in all_elections" :value="election.code_number" :key="election.id">
                    {{ election.year }} {{ election.state.name }} {{ election.election_type.name }}
                </option>
            </select>
        </form>
        <br>

    </div>

    <h4 class="text-center"> {{ latest_election.fullnames }} </h4><hr>
    <section class="row">
   
                        <div class="col-md-4">
                            <div class="card mb-3 widget-content">
                                <div class="widget-content-outer">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left">
                                            <div class="widget-heading"> Total Polling units with votes: </div>
                                            <div class="widget-subheading"> Total Polling units </div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-info"> {{ number_format(latest_election.total_polling_units) }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card mb-3 widget-content">
                                <div class="widget-content-outer">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left">
                                            <div class="widget-heading"> Total Accredited Voters: </div>
                                            <div class="widget-subheading"> Accredited voters </div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-info"> {{ number_format(latest_election.total_registered_voters) }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card mb-3 widget-content">
                                <div class="widget-content-outer">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left">
                                            <div class="widget-heading"> Total Remaining voters: </div>
                                            <div class="widget-subheading"> Remaining voters </div> 
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-info"> {{ number_format( parseFloat(latest_election.total_registered_voters) -  parseFloat(latest_election.total_votes) ) }}  </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card mb-3 widget-content">
                                <div class="widget-content-outer">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left">
                                            <div class="widget-heading"> Total votes casted: </div>
                                            <div class="widget-subheading"> Votes casted: </div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-info"> {{ number_format(latest_election.total_votes) }} </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card mb-3 widget-content">
                                <div class="widget-content-outer">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left">
                                            <div class="widget-heading"> Total Valid votes: </div>
                                            <div class="widget-subheading"> Total valid votes: </div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-info"> {{ number_format(latest_election.valid_votes) }} </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card mb-3 widget-content">
                                <div class="widget-content-outer">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left">
                                            <div class="widget-heading"> Total InValid votes: </div>
                                            <div class="widget-subheading"> Total invalid votes: </div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-info"> {{ number_format(latest_election.invalid_votes) }} </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

    </section>

<!-- Graph record by party -->
<section class="row">
    <section class="col-md-6">
        <div class="card mb-3" >
        <section class="card-header text-center">{{ latest_election.fullnames }} </section>
        <section class="card-body">
            <div class="graph_1_section" :id="'chartContainer_'+latest_election.code_number"></div>
        </section>
    </div>
    </section><!-- //div -->

    <section class="col-md-6">  
        <div class="card mb-3" >
        <section class="card-header text-center"> Election Result stats </section>
        <section class="card-body">
            <div class="graph_1_section" :id="'chartContainer_2_'+latest_election.code_number"></div>
        </section>
    </div>
    </section><!-- //div -->
</section>

    <!-- LGA Graph result -->
    <div class="card mb-3">
        <section class="card-header text-center"> Total votes in Local Government </section>
        <section class="card-body">
            <div class="graph_2_section" :id="'chartContainer_3_'+latest_election.code_number"></div>
        </section>
    </div>

     <!-- Voters stats -->
     <div class="card" >
        <section class="card-header text-center"> Stats of Voters </section>
        <section class="card-body">
            <div class="graph_3_section" :id="'chartContainer_4_'+latest_election.code_number"></div>
        </section>
    </div>

    <!-- //Polling unit result table -->
    <div class="row">
        <section class="col-md-4 mt-2" v-for="(records, index) in latest_election.result_by_polling_units" :key="records.polling_unit_name">
            
        <div class="card">
        <section class="card-header text-center">p.u: {{ records.polling_unit_name }} </section>
        <section class="card-body" >
            <p>Valid votes: <b> {{ number_format( records.valid_votes ) }} </b> 
             . Invalid votes: <b> {{ number_format( records.invalid_votes ) }} </b> 
             . Total Votes: <b> {{ number_format( records.total_votes ) }} </b> </p>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th> s/n</th>
                            <th> Party </th>
                            <th> Total Votes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ ++index }}</td>
                            <td> APC </td>
                            <td>{{ number_format( records.apc_votes ) }}</td>
                        </tr>
                        <tr>
                            <td>{{ ++index }}</td>
                            <td> LP </td>
                            <td>{{ number_format( records.lp_votes ) }}</td>
                        </tr>
                        <tr>
                            <td>{{ ++index }}</td>
                            <td> NNPP</td>
                            <td>{{ number_format( records.nnpp_votes ) }}</td>
                        </tr>
                        <tr>
                            <td>{{ ++index }}</td>
                            <td> PDP </td>
                            <td>{{ number_format( records.pdp_votes ) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
         </section>
        </div>

        </section>
    </div>
    
</section>
</template>

<script>
import api from "./../api.js"
// import {  mapState } from "vuex";

export default {
    data() {
        return {
            latest_election: {} , all_elections: []
        }
    },

    // computed: {
    //     ...mapState(["latest_election", "all_elections"]),
    // },

    methods: {
        async _fetch_elections() {
            var code_number = this.$route.query.code;
            var url_query = `code=${code_number}&filter=1&rec=1`;
            var query = '';
            if (code_number) query = url_query;
            await api.fetch_elections( query ).then( response => {
                this.latest_election = response.data.latest_election;
                this.all_elections = response.data.all_elections;
            })
            .catch( err => { alert('Network error !')});
            //await this.$store.dispatch("fetch_elections", query);
        },

        async filter_election(e) {
            var data = e.target.value;
            clearInterval(this.live_data() );
            this.$router.push({
                name: "homepage",
                query: {
                    code: data,
                    filter: 1
                }
            });
            await this._fetch_elections();
            this.show_data_graph();
            //window.location.reload();
        },

        async graph_result_by_party(data_, code_number = ''){
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
            horizontal: true,
            dataLabels: {
              position: 'bottom'
            },
          }
        },
        colors: ['#33b2df', '#546E7A', '#d4526e', '#13d8aa', '#A5978B', '#2b908f', '#f9a3a4', '#90ee7e',
          '#f48024', '#69d2e7'
        ],
        dataLabels: {
          enabled: true,
          textAnchor: 'start',
          style: {
            colors: ['#fff']
          },
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
            text: this.latest_election.fullnames,
            align: 'center',
            floating: true
        },
        subtitle: {
            text: '',
            align: 'center',
        },
        tooltip: {
          theme: 'dark',
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

        var chart = new ApexCharts(document.querySelector("#chartContainer_"+code_number), options);
        chart.render();

        },

        async graph_result_by_party_pie_chart(data_, code_number = ''){
            var data_y = [];
                var data_x = [];
                for(var i = 0; i < data_.length; i++ ){
                    data_y.push( data_[i]['total_votes'] );
                    data_x.push( data_[i]['party'] );
                }
                var options = {
          series: data_y,
          chart: {
             animations: {
            enabled: false
          },
          width: 400,
          type: 'pie',
        },
        labels: data_x,
        responsive: [{
          breakpoint: 480,
          options: {
            chart: {
                 animations: {
            enabled: false
          },
              width: 300
            },
            legend: {
              position: 'bottom'
            }
          }
        }]
        };

        var chart = new ApexCharts(document.querySelector("#chartContainer_2_"+code_number), options);
        chart.render();

        },

        async graph_result_by_lga(data_, code_number = ''){
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
                    $apc_votes.push( data_[i]['apc_votes'] );
                    $lp_votes.push( data_[i]['lp_votes'] );
                    $pdp_votes.push( data_[i]['pdp_votes'] );
                    $nnpp_votes.push( data_[i]['nnpp_votes'] );
                    $lga.push( data_[i]['lga'] );
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
          height: 700
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
          width: 1,
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
        var chart = new ApexCharts( document.querySelector("#chartContainer_3_"+code_number), options);
        chart.render();

        },

        async graph_result_of_voters(data_, code_number = ''){
            var options = {
          series: data_,
          chart: {
             animations: {
            enabled: false
          },
          width: 400,
          type: 'pie',
        },
        labels: ['Accredited voters', 'Valid Votes', 'Invalid votes'],
        responsive: [{
          breakpoint: 480,
          options: {
            chart: {
                 animations: {
            enabled: false
          },
              width: 300
            },
            legend: {
              position: 'bottom'
            }
          }
        }]
        };

        var chart = new ApexCharts(document.querySelector("#chartContainer_4_"+code_number), options);
        chart.render();
        },

        show_data_graph() {
            setTimeout(() => {
                var code_number = $('.code_number_').attr('id'); 
                var election = this.latest_election;
                var data_1 = election.result_by_party;
                var data_2 = election.result_by_lga;
                var data_3 = [election.total_registered_voters, election.valid_votes, election.invalid_votes];
                this.graph_result_by_party_pie_chart(data_1, code_number);
                this.graph_result_by_party(data_1, code_number);
                this.graph_result_by_lga(data_2, code_number);
                this.graph_result_of_voters(data_3, code_number);
                //end setTimeout
                this.live_data();
            }, 2500);

        },

        live_data() {
            return;
            setInterval(() => {
                this._fetch_elections();
                this.show_data_graph();
            }, 10000);
        },

    },

    mounted() {
        this._fetch_elections();
        this.show_data_graph();
    }
}
</script>
