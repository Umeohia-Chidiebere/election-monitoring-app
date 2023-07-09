<template>
    <section>

     <baseLayout page_title="Election result computation">
  
    <v-card>
      <v-tabs v-model="tab" background-color="whitesmoke" color="success" light>
  
        <v-tab id="by_pu_link">
          Result in P.U 
        </v-tab>

        <v-tab v-if="current_user.permission.can_modify_users" id="by_ward_link">
          Result in wards 
        </v-tab>

        <v-tab id="view_result_link">
         View Results
        </v-tab> 
  
        <v-tab v-if="current_user.permission.can_modify_users" id="by_zone_link">
         Result in zones
        </v-tab> 
  
  
      </v-tabs>
   
      <v-tabs-items v-model="tab"> 
       
        <v-tab-item>
          <by_polling_unit />
        </v-tab-item>

        <v-tab-item v-if="current_user.permission.can_modify_users">
          <by_ward />
        </v-tab-item>

        <v-tab-item>
          <view_result />
        </v-tab-item>        
  
        <v-tab-item v-if="current_user.permission.can_modify_users">
          <by_zone />
        </v-tab-item>
        
  
      </v-tabs-items>
  
    </v-card>

  
    <v-snackbar v-model="snackbar" timeout="5000">
        {{ response_msg }}
  
        <template v-slot:action="{ attrs }">
          <v-btn color="red" text v-bind="attrs" @click="snackbar = false">  Close </v-btn>
        </template>
  </v-snackbar>


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
  
  
    </baseLayout>
    </section>
  </template> 
  
  <script>
  import {  mapState } from "vuex";
  import baseLayout from "../../layouts/base_layout.vue";
  import by_ward from "./by_ward.vue";
  import by_polling_unit from "./by_polling_unit.vue";
  import by_zone from "./by_zone.vue";
  import view_result from "./view_result.vue";

  export default {
         components: { baseLayout, by_ward, by_zone, view_result, by_polling_unit },
         data(){
             return {
              tab: null, dialog:false, response_msg:'', snackbar: false
             }
         },
         computed: {  ...mapState(["current_user"]),  },
         methods:{
            auto_navigate_to_tab(){
              setTimeout(() => {
                var tab = this.$route.query.tab;
                $(`#${tab}_link`).click();
              }, 1000);
            },

            get_coords(){
              this.response_msg = "Updating your location Coordinates...";
              this.snackbar = true;
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

          show_coordinates(position) {
            localStorage.setItem("latitude", position.coords.latitude);
            localStorage.setItem("longitude", position.coords.longitude);
            //console.log( position )
            this.dialog = false;
          },

          enable_location() {
              if (navigator.geolocation) {
                 navigator.geolocation.getCurrentPosition(this.show_coordinates);
              } 
              else { 
                  this.response_msg = "GeoLocation is not supported by this device.";
                  this.snackbar = true;
              }
          },


         },
  
         mounted(){
            this.auto_navigate_to_tab();
            this.check_location_access_status();
            this.$store.dispatch("fetch_current_user"); 
         }
     }
  </script>
  