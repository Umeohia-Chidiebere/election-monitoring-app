<template>
   <section>
        <baseLayout page_title="Profile">
          <v-container fluid class="py-5 px-5">

            <h5 class="text-center"> Hi, {{ current_user.name }} <br><small class="text-muted">{{ current_user.email }}</small> </h5>
          <section class="row py-5">
            <section class="col-md-2"></section>
            
            <div class="col-md-8 text-center">
             
              <section class="row">

                <!-- col -->
                <div class="col">
                  <v-card shaped elevation="3" class="cursor" @click="navigate_to_page('compute_result_page')">
                    <v-card-subtitle class="text-success">
                       <i class="fa fa-paper-plane fa-5x"></i> <br> Send result
                    </v-card-subtitle>
                  </v-card>
                </div>
                <!-- //col -->

                <!-- col -->
                <div class="col">
                  <v-card shaped elevation="3" class="cursor" @click="navigate_to_page('view_election_result_page')">
                    <v-card-subtitle class="text-success">
                       <i class="fa fa-laptop fa-5x"></i> <br> View Results
                    </v-card-subtitle>
                  </v-card>
                </div>
                <!-- //col -->

             </section>


         <section class="row">

           <!-- col -->
           <div class="col">
                  <v-card shaped elevation="3" class="cursor" @click="navigate_to_page('create_post_page')">
                    <v-card-subtitle class="text-success">
                       <i class="fa fa-edit fa-5x"></i> <br> Report Incidence
                    </v-card-subtitle>
                  </v-card>
                </div>
                <!-- //col -->


                <!-- col -->
                <div class="col">
                  <v-card shaped elevation="3" class="cursor" @click="navigate_to_page('post_page')">
                    <v-card-subtitle class="text-success">
                      <i class="fa fa-eye fa-5x"></i> <br> View Incidence
                    </v-card-subtitle>
                  </v-card>
                </div>
                <!-- //col -->

              </section>
              <!-- //row -->

            </div>

            <section class="col-md-2"></section>
          </section>

        
        </v-container>
   </baseLayout>


  <v-snackbar v-model="snackbar" timeout="5000">
      {{ response_msg }}

      <template v-slot:action="{ attrs }">
        <v-btn color="red" text v-bind="attrs" @click="snackbar = false"> Close </v-btn>
      </template>
  </v-snackbar>
    
   </section>
</template>

<script>
import {  mapState } from "vuex";
import baseLayout from "../layouts/base_layout.vue";
    export default {
        components: { baseLayout },
        data(){
            return { dialog:false, snackbar:false, response_msg:''}
        },
        computed: {  ...mapState(["current_user"]),  },
        methods:{
          navigate_to_page(link){
            this.$router.push({name: link});
          },
            
        },
        mounted(){
          this.$store.dispatch("fetch_current_user"); 
        }
    }
</script>
