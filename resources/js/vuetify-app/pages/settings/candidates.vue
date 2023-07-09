<template>
  <div> 
      <v-container fluid class="mt-3"> 
          
<v-snackbar v-model="snackbar" timeout="5000">
    {{ response_msg }}

    <template v-slot:action="{ attrs }">
      <v-btn color="red" text v-bind="attrs" @click="snackbar = false">  Close </v-btn>
    </template>
</v-snackbar>
      
  <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition">
    <template v-slot:activator="{ on, attrs }">
      <p v-if="current_user.permission.can_modify_all_admins" color="primary" dark v-bind="attrs" v-on="on"><v-icon>mdi-plus</v-icon>Add new </p>
    </template>

    <v-card>
      <v-toolbar dark color="green" > 
        <v-btn icon dark @click="dialog = false">
          <v-icon>mdi-close</v-icon>
        </v-btn>

      <v-toolbar-title>Add Candidate</v-toolbar-title>
        <v-spacer></v-spacer>
      </v-toolbar>

<v-card-text>

<form @submit.prevent="store_candidate_data" method="post" class="candidate_data py-5" enctype="multipart/form-data">
<input type="hidden" name="store_candidate" value="1"> 

<v-select 
  label="Election"
  name="election_id"
  placeholder="Select election"
  color="green"
  :items="app_data.all_elections"
  item-text="full_details"
  item-value="id"
  required>
</v-select>

<v-select 
  label="Election Type"
  name="type"
  placeholder="Select election"
  color="green"
  :items="app_data.election_types"
  item-text="name"
  item-value="slug"
  @change="selected_election_option"
  required>
</v-select>

<v-select
  v-if="selected_election == 'senatorial_zone'"
  label="Senatorial Zones"
  name="zone_id"
  placeholder="Senatorial District"
  color="green"
  :items="app_data.all_senatorial_zones"
  item-text="name"
  item-value="id"
  required>
</v-select>

<!-- <v-select
  v-if="selected_election == 'constituency'"
  label="Constituency"
  name="zone_id"
  placeholder="Constituency"
  color="green"
  :items="app_data.all_constituency"
  item-text="name"
  item-value="id"
  required>
</v-select> -->

<v-select
  label="Political party"
  name="political_party_id"
  placeholder="Political party..."
  color="green"
  :items="app_data.all_political_parties"
  item-text="name"
  item-value="id"
  required>
</v-select>

<v-text-field label="Main Candidate" name="name" color="green" placeholder="Main Candidate" required></v-text-field>
<v-text-field label="Deputy/Vice Candidate" name="deputy_name" color="green" placeholder="Deputy/Vice Candidate"></v-text-field>

<input type="hidden" name="hidden" value="1">
<v-btn v-if="is_processing" color="secondary" disabled outlined type="button"> Processing... </v-btn>
<v-btn v-else color="success" outlined type="submit"> Submit </v-btn>
<v-progress-circular v-if="is_processing" indeterminate color="green"></v-progress-circular>
</form>
     
</v-card-text>
     
    </v-card>
  </v-dialog>
  
          
<v-card>
              <v-card-title> All Candidates </v-card-title>
              <v-divider></v-divider>
              <v-card-text>

<section class="">

<v-list>
        <!-- <v-subheader> All Senatorial Dsistrict</v-subheader> -->
        <v-list-item v-for="(election_data, election) in app_data.all_candidates" :key="election">
          <v-list-item-content>
            <v-list-item-title> <h6 class="text-success">{{ election }} </h6> </v-list-item-title>
            <v-list-item-subtitle>
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>Party</th>
                      <th>Candidate</th>
                      <th>Deputy</th>
                      <th>Zone</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="candidate in election_data" :key="candidate.id">
                      <td>{{ candidate.political_party.short_name }}</td>
                      <td>{{ candidate.name }}</td>
                      <td>{{ candidate.deputy_name }}</td>
                      <td>{{ candidate.zone.name}}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
</v-list>

</section>

              </v-card-text>
          </v-card>

      </v-container>
  </div>
</template>

<script>
import { mapState } from "vuex";
import api from "../../../api";
  export default {
      data(){
          return{
              dialog:false, lga_id:'', snackbar: false, response_msg:'', 
              is_processing:false, selected_election:''
          }
      },

     computed: { ...mapState(['app_data', 'current_user']) },

     methods:{
          fetch_app_data_(){
            this.$store.dispatch("fetch_current_user");
              return this.$store.dispatch("fetch_app_data");
          },

          store_candidate_data(){
              this.is_processing = true;
              var data = $('.candidate_data').serialize();
                  api.store_app_data( data ) 
                     .then( response => {
                          this.is_processing = false;
                          this.snackbar = true;
                          if( response.data.error )return this.response_msg( response.data.error );
                          this.response_msg = response.data.success;
                          this.load_records();
                          this.dialog = false;
                     })
                     .catch( err => {
                      this.response_msg = "Network error !";
                      this.snackbar = true;
                      this.is_processing = false;
                     });
          },

          take_action(){
              setTimeout(() => {
                  $('.edit_data').on('click', (e) => {
                       var id_ = e.target.id;
                        console.log( id_ )
                  });

                  $('.delete_data').on('click', (e) => {
                      var id_ = e.target.id;
                      var data = {id: id_, remove_zone:'1'};
                      _user_confirmation((user_confirmed) => {
                          if(user_confirmed){
                              api.store_app_data( data )
                                 .then( response => {
                                    this.snackbar = true;
                                      if( response.data.error ) return this.response_msg = response.data.error;
                                      this.response_msg = response.data.success;
                                      this.load_records();
                                  });  
                          }
                      });
                       
                  });
              }, 2000);
          },

          selected_election_option($value){
            if( $value == "governorship_election" || $value == 'presidential_election'){
              return this.selected_election = '';
            }
            if( $value == 'senatorial_election'){
              this.selected_election = 'senatorial_zone';
            }
            else{
              this.selected_election = 'constituency';
            }
          },

          load_records(){
            this.fetch_app_data_(); 
          }
     },

     updated(){
         this.take_action();
     },

     mounted(){
        this.load_records(); 
     }
  }
</script>
