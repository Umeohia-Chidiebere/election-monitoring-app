<template>
    <div> 
  <v-container fluid class="mt-3">
    
    <baseLayout page_title="All users"> 
            
  <v-snackbar v-model="snackbar" timeout="5000">
      {{ response_msg }}

      <template v-slot:action="{ attrs }">
        <v-btn color="red" text v-bind="attrs" @click="snackbar = false"> Close </v-btn>
      </template>
  </v-snackbar>
        
    <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition">
      <template v-slot:activator="{ on, attrs }">
        <p v-if="current_user.permission.can_modify_users" color="primary" dark v-bind="attrs" v-on="on"><v-icon>mdi-plus</v-icon>Add new </p>
      </template>
  
      <v-card>
        <v-toolbar dark color="green"> 
          <v-btn icon dark @click="dialog = false">
            <v-icon>mdi-close</v-icon>
          </v-btn>
  
        <v-toolbar-title>Add user</v-toolbar-title>
          <v-spacer></v-spacer>
        </v-toolbar>
  
  <v-card-text>
  
  <form @submit.prevent="store_data" method="post" class="user_data_ py-5" enctype="multipart/form-data">
  <input type="hidden" name="store_user" value="1">

  <v-text-field label="Name" name="name" color="green" placeholder="Surname first..." required></v-text-field>
  <v-text-field label="E-mail" name="email" color="green" placeholder="Email..." required></v-text-field>
  <v-text-field label="Phone Number" name="phone_number" color="green" placeholder="Phone number..." required></v-text-field>

  <v-select
  v-if="current_user.permission.can_modify_all_admins"
    label="Role"
    name="role_id"
    placeholder="Role"
    color="green"
    :items="app_data.all_roles"
    item-text="name"
    item-value="id"
    required>
  </v-select>

  <!-- <v-select
    label="LGA"
    name="lga_id"
    placeholder="LGA"
    color="green"
    :items="app_data.all_lga"
    item-text="name"
    item-value="id"
    required>
  </v-select> -->
  
  <input type="hidden" name="hidden" value="1">
  <v-btn v-if="is_processing" color="secondary" disabled outlined type="button"> Processing... </v-btn>
  <v-btn v-else color="success" outlined type="submit"> Submit </v-btn>
  <v-progress-circular v-if="is_processing" indeterminate color="green"></v-progress-circular>
  </form>
       
  </v-card-text>
       
      </v-card>
    </v-dialog>
            
  <v-card>
                <v-card-title> All users({{ app_data.all_users.length }}) </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
  
                <div class="table-responsive">
                  <table class="table table-hover table-md all_users_datatables">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th></th>
                      </tr>
                    </thead>
                  </table>
                </div>
  
              </v-card-text>
            </v-card>

          </baseLayout>

        </v-container>


        <v-dialog v-model="edit_dialog" fullscreen hide-overlay transition="dialog-bottom-transition">
        <template v-slot:activator="{ on, attrs }">
            <p class="d-none lga_edit_btn" color="primary" dark v-bind="attrs" v-on="on">
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
                <form class="py-5 update_user_data" method="post" @submit.prevent="update_data">
                  <input type="hidden" name="id" :value="edit_u_data.id">
                  <input type="hidden" name="update_user" value="1">
                    <section class="row">
                        <div class="col-md-12">
                            <v-text-field placeholder="Name" label="Name" name="name" required :value="edit_u_data.name"></v-text-field>
                            <p class="text-muted">{{ edit_u_data.name }}</p>
                        </div>
                        <!-- //col -->

                        <div class="col-md-12">
                            <v-text-field type="email" placeholder="Email" label="Email" name="email" required :value="edit_u_data.email"></v-text-field>
                        </div>
                        <!-- //col -->

                        <div class="col-md-12">
                            <v-text-field placeholder="phone_number" label="Phone Number" name="phone_number" required :value="edit_u_data.phone_number"></v-text-field>
                        </div>
                        <!-- //col -->

                        <div v-if="current_user.permission.can_modify_users" class="col-md-12">
                            <v-select label="Role" name="role_id" placeholder="Role" color="green" 
                                      :items="app_data.all_roles" item-text="name" item-value="id" required>
                            </v-select>
                            <p class="text-muted"> Current Role: {{ edit_u_data.role ? edit_u_data.role.name : '-' }}</p>
                        </div>

                        <div class="col-md-12">
                          <v-btn color="blue" outlined type="submit">Update</v-btn> 
                        </div>

                        <!-- //col -->
 
                    </section>
                    <!-- //row-->

                </form>
                <!-- ///edit info -->
            </v-card-text>

        </v-card>
    </v-dialog>


    </div>
  </template>
  
<script>
import baseLayout from "../layouts/base_layout.vue";
import { mapState } from "vuex";
import api from "../../api";

    export default {
      components: { baseLayout },
        data(){
            return {
                dialog: false, lga_id:'', snackbar: false, response_msg:'', 
                is_processing:false, selected_election:'', edit_dialog:false, edit_u_data:{}
            }
        },
  
        computed: { ...mapState(['app_data', 'current_user']) },

        methods:{
            async fetch_app_data_(){
              this.$store.dispatch("fetch_current_user");
                return this.$store.dispatch("fetch_app_data");
            },

            store_data(){
                this.is_processing = true;
                var data = $('.user_data_').serialize();
                    api.store_app_data( data )
                       .then( response => {
                            this.is_processing = false;
                            this.snackbar = true;
                            if( response.data.error ) return this.response_msg( response.data.error );
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

            async fetch_data(){
              setTimeout(() => {
                
                var url = route('fetch_app_data',{type:'all_users'} );
                  $('.all_users_datatables').DataTable({
                     destroy:true,
                     order:[[0, 'asc']],
                     responsive:true,
                     pageLength:50,
                     processing:true, 
                     serverSide:true,
                     lengthMenu: [[50, 100, 200, 500, -1], [50, 100, 200, 500, 'All']],
                     ajax: url,
                     columns: [
                        {data: 'name', name: 'name' , className:''},
                        {data: 'email', name: 'email' , className:''},
                        {data: 'phone_number', name: 'phone_number' , className:''},
                        {data: 'role', name: 'role' , className:''},
                        {data: 'actions', name: 'actions' , className:''}
                     ],

                    drawCallback: function(){
                     
                    }
                    
                  });

              }, 1000);
            },

            update_data(){
              var data = $('.update_user_data').serialize();
              api.store_app_data( data )
                 .then( response => {
                  this.snackbar = true;
                  if( response.data.error ) return this.response_msg = response.data.error;
                  this.response_msg = response.data.success;
                  this.load_records();
                 });
            },

            take_action(){ 
                setTimeout(() => {
                    $('.edit_user_data_btn').on('click', (e) => {
                         var data = e.target.id;
                             this.edit_u_data.name = data;
                             this.edit_dialog = true;
                    });
  
                    $('.delete_data').on('click', (e) => {
                        var id_ = e.target.id;
                        var data = {id: id_, remove_user:'1'};
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
                }, 1000);
            },
  
            load_records(){
              this.fetch_data();
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
