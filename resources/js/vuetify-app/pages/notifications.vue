<template>
    <section>
     <v-container fluid>
        <baseLayout page_title="Notifications">
        
            <v-card>
                <v-card-text>

                    
      <section v-for="notification in app_data.all_notifications" :key="notification.id">
    
           <h6>{{ `${notification.user.name} ${notification.content}` }}</h6>
            <p class="text-muted"><small> {{ notification.created_at }} </small></p>
            <hr>
      </section>

<!-- ///end -->
                </v-card-text>
            </v-card>
 
        </baseLayout>
     </v-container>
     
    </section>
 </template>
 
 
 <script>
import {  mapState } from "vuex";
import baseLayout from "../layouts/base_layout.vue";
    export default {
         computed: {  ...mapState([ "app_data"]),  },
         components: { baseLayout },
         data(){
             return {}
         },

         mounted(){
            this.$store.dispatch("fetch_app_data");
         }
     }
 </script>
 