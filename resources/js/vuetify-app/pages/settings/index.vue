<template>
  <section>
   <baseLayout page_title="Set-up">

  <v-card>
    <v-tabs v-model="tab" background-color="whitesmoke" color="success" light>
      
      <v-tab id="lga_link">
        LGA
      </v-tab>

      <v-tab id="wards_link">
        Wards
      </v-tab>

      <v-tab id="polling_units_link">
        Polling units
      </v-tab>

      <v-tab id="senatorial_zones_link">
       Senatorial Zones
      </v-tab> 

      <v-tab id="constituency_link">
       Constituency
      </v-tab> 

      <v-tab id="candidates_link">
       Candidates
      </v-tab> 

      <v-tab id="political_party_link">
       Political parties
      </v-tab> 

    </v-tabs>
 
    <v-tabs-items v-model="tab">
     
      <v-tab-item>
        <lga />
      </v-tab-item>

      <v-tab-item>
        <wards />
      </v-tab-item>

      <v-tab-item> 
          <polling_units />
      </v-tab-item>

      <v-tab-item>
       <senatorial_zones/>
      </v-tab-item>

      <v-tab-item>
        <constituency/>
      </v-tab-item>

      <v-tab-item>
        <candidates />
      </v-tab-item>

      <v-tab-item>
        <political_parties/>
      </v-tab-item>

    </v-tabs-items>

  </v-card>


  <v-row justify="center">
    <v-dialog
      v-model="dialog"
      persistent
      max-width="300"
    >
      <v-card>
        <v-card-title class="text-h6">
          Grant Location Access
        </v-card-title>
        <v-card-text>
          For better use of this software, we need you to give access to Location service
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn :to="{name:'homepage'}"
            color="blue darken-1"
            outlined
            @click="dialog = false"
          >
            Home
          </v-btn>

          <v-btn
            color="green darken-1"
            outlined
            @click="enable_location"
          >
            Enable Location
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>

  <v-snackbar v-model="snackbar" timeout="20000">
      {{ response_msg }}

      <template v-slot:action="{ attrs }">
        <v-btn color="red" text v-bind="attrs" @click="snackbar = false">  Close </v-btn>
      </template>
</v-snackbar>

  </baseLayout>
  </section>
</template>

<script>
import baseLayout from "../../layouts/base_layout.vue";
import lga from "./lga.vue";
import wards from "./wards.vue";
import constituency from "./constituency.vue";
import political_parties from "./political_parties.vue";
import polling_units from "./polling_units.vue";
import senatorial_zones from "./senatorial_zones.vue";
import candidates from "./candidates.vue";

export default {
       components: { baseLayout, lga, wards, constituency, political_parties, polling_units, senatorial_zones, candidates},
       data(){
           return {
            tab: null, dialog:false, response_msg:'', snackbar: false
           }
       },

       methods:{
        enable_location() {
              if (navigator.geolocation) {
                 navigator.geolocation.getCurrentPosition(this.show_coordinates);
              } 
              else { 
                  this.response_msg = "GeoLocation is not supported by this device.";
                  this.snackbar = true;
              }
          },
    
          show_coordinates(position) {
            localStorage.setItem("latitude", position.coords.latitude);
            localStorage.setItem("longitude", position.coords.longitude);
            //console.log( position )
            this.dialog = false;
          },
        
          check_location_access_status(){
            this.dialog = true;
            navigator.permissions.query({name:'geolocation'}).then( (result) => {
              // Will return ['granted', 'prompt', 'denied']

              if( result.state === "denied"){
                 this.response_msg = "Location access is denied, please go to your settings and manually Grant location access !";
                 this.snackbar = true;
                 this.dialog = true;
                 return;
              }
              else if( ! localStorage.getItem('latitude') ){
                this.response_msg = "It seems your Location is turned off, please enable Location !";
                this.snackbar = true;
                this.dialog = true;
                return;
              }
              else if( result.state === "granted"){
                 this.dialog = false;
                 this.enable_location();
               }
               
            });
          },

          auto_navigate_to_tab(){
            setTimeout(() => {
              var tab = this.$route.query.tab;
              $(`#${tab}_link`).click();
            }, 1000);
          }
        
       },

       mounted(){
          //this.check_location_access_status();
          this.auto_navigate_to_tab();
       }
   }
</script>

30107
