<template>
    <section>
    
        <v-list>
    
            <v-list-item v-for="(election_result, election_title) in app_data.my_polling_units.results" :key="election_title">
                <v-list-item-content>
                    <v-list-item-title>
                        <h6 class="text-success font-weight-bold"> {{ election_title  }} </h6>
                    </v-list-item-title>
    
                        <section v-for="(result_, zone) in election_result" :key="zone">
                           
                            <h6 class="pl-3 font-weight-bold text-warning" v-if="zone" > zone: {{ zone }}  </h6>

                            <div v-for="(result_data, pu) in result_" :key="pu">
                                <h6 class="pl-6 font-weight-bold text-info" v-if="pu">Polling unit: {{ pu }}</h6>
                        

                                <section> 
                            
                            <div class="table-responsive">
                  
                  <table class="table table-md table-hover">
                      <thead>
                          <tr>
                              <th>Party</th>
                              <th>Total votes</th>
                              <th>Cancelled votes</th>
                          </tr>
                      </thead>
                      <tbody>
                          <tr v-for="record in result_data" :key="record.id">
                              <td>{{ record.political_party.short_name }}</td>
                              <td>{{ number_format(record.total) }}</td>
                              <td>{{ number_format(record.invalid_votes) }}</td>       
                          </tr>

                      </tbody>
                  </table>
           

          </div>

                        </section>


                            </div>

                        </section>                      
                 
                 
                </v-list-item-content>
            </v-list-item>
        </v-list>
    
    
    </section>
    </template>

     
    <script> 
    import baseLayout from "../../layouts/base_layout.vue";
    import { mapState } from "vuex";
    
    export default {
        components: {
            baseLayout
        },
        data() {
            return {}
        },
    
        computed: {
            ...mapState(['app_data'])
        },
    
        methods: {
            fetch_app_data_() {
                return this.$store.dispatch("fetch_app_data");
            }
        },
    
        mounted() {
            this.fetch_app_data_();
        }
    }
    </script>
    