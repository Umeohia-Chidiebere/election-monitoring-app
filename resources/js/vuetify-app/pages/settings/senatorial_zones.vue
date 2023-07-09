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

        <v-toolbar-title>Add Senatorial Zone</v-toolbar-title>
          <v-spacer></v-spacer>
        </v-toolbar>

<v-card-text>

<form @submit.prevent="store_data" method="post" class="senatorial_zone_data py-5" enctype="multipart/form-data">
<input type="hidden" name="store_senatorial_zones" value="1"> 
<v-text-field label="Senatorial Zone" name="name" color="green" placeholder="Senatorial Zone" required></v-text-field>
<v-select 
    label="LGA"
    name="lga_id"
    placeholder="Select LGA"
    color="green"
    :items="app_data.all_lga"
    item-text="name"
    item-value="id"
    multiple
    required>
</v-select>

<v-select 
    label="Admin"
    name="user_id"
    placeholder="Select Admin"
    color="green"
    :items="app_data.all_admins.senatorial"
    item-text="name"
    item-value="id"
    required>
</v-select>


<input type="hidden" name="hidden" value="1">
<v-btn v-if="is_processing" color="secondary" disabled outlined type="button"> Processing... </v-btn>
<v-btn v-else color="success" outlined type="submit"> Submit </v-btn>
<v-progress-circular v-if="is_processing" indeterminate color="green"></v-progress-circular>
</form>
       
</v-card-text>
       
      </v-card>
    </v-dialog>
    
            
<v-card>
                <v-card-title> Senatorial District({{ app_data.all_senatorial_zones.length }}) </v-card-title>
                <v-divider></v-divider>
                <v-card-text>

<section class="">
 
  <v-list>
          <!-- <v-subheader> All Senatorial Dsistrict</v-subheader> -->
         
          <v-list-item v-for="zone in app_data.all_senatorial_zones" :key="zone.id">
            <v-list-item-content>
              <v-list-item-title> <h6  class="text-success"> {{ `${zone.name} - ${zone.state}`  }} 
                         <button v-if="current_user.role.slug == 'super_admin'"  class="delete_data pl-3"><i :id="zone.id" class="fa fa-trash text-danger"></i></button> </h6> </v-list-item-title>
              <v-list-item-subtitle>
                <div class="table-responsive">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>Polling units</th>
                        <th>Wards</th>
                        <th>LGA</th>
                        <th>Admin</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="data in zone.zone_content" :key="zone.id">
                        <td>{{ data.polling_unit }}</td>
                        <td>{{ data.ward }}</td>
                        <td>{{ data.lga }}</td>
                        <td>{{ zone.user.name }}</td>
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



        <!-- EDIT DATA -->
        <v-dialog v-model="edit_dialog" fullscreen hide-overlay transition="dialog-bottom-transition">
        <template v-slot:activator="{ on, attrs }">
            <p class="d-none edit_btn" color="primary" dark v-bind="attrs" v-on="on">
                <v-icon>mdi-plus</v-icon>Edit
            </p>
        </template>

        <v-card>
            <v-toolbar dark color="blue">
                <v-btn icon dark @click="edit_dialog = false">
                    <v-icon>mdi-close</v-icon>
                </v-btn>

                <v-toolbar-title>Edit</v-toolbar-title>
                <v-spacer></v-spacer>
            </v-toolbar>


            <v-card-text>
              <!-- edit info -->
              {{ this.edit_data  }}
              <!-- ///edit info -->
            </v-card-text>

        </v-card>
</v-dialog>

    </div>
</template>

<script>
import { mapState } from "vuex";
import api from "../../../api";
    export default {
        data(){
            return{
                edit_dialog:false, edit_data:{},
                dialog: false, lga_id:'', snackbar: false, 
                response_msg:'', is_processing:false
            }
        },

        computed: { ...mapState(['app_data', 'current_user']) },

       methods:{

            fetch_app_data_(){
              this.$store.dispatch("fetch_current_user");
                return this.$store.dispatch("fetch_app_data");
            },

            store_data(){
                this.is_processing = true;
                var data = $('.senatorial_zone_data').serialize();
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

