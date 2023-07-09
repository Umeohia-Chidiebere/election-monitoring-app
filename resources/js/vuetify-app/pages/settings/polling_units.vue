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
        <p v-if="current_user.permission.can_modify_users" color="primary" dark v-bind="attrs" v-on="on"><v-icon>mdi-plus</v-icon>Add new </p>
      </template>

      <v-card>
        <v-toolbar dark color="green" >
          <v-btn icon dark @click="dialog = false">
            <v-icon>mdi-close</v-icon>
          </v-btn>

          <v-toolbar-title>New Polling unit</v-toolbar-title>
          <v-spacer></v-spacer>
          
        </v-toolbar>

<v-card-text>

<form @submit.prevent="store_data" method="post" class="polling_unit_data py-5" enctype="multipart/form-data">
<input type="hidden" name="store_polling_units" value="1">
<input type="hidden" name="latitude" :value="coords.latitude">
<input type="hidden" name="longitude" :value="coords.longitude">
<v-text-field label="Polling unit" name="name" color="green" placeholder="Separate each P.U with a comma (,)" required></v-text-field>
<v-select 
    label="Ward"
    name="ward_id" 
    placeholder="Ward name"
    color="green"
    :items="app_data.all_wards"
    item-text="name"
    item-value="id"
    required>
</v-select>

<v-select 
    label="Polling unit Agent"
    name="user_id" 
    placeholder="Admin"
    color="green"
    :items="app_data.all_admins.user"
    item-text="name"
    item-value="id"
    required>
</v-select>

<input type="hidden" name="hidden" value="1">
<v-btn v-if="is_processing" color="secondary" disabled outlined type="button"> Processing... </v-btn>
<v-btn v-else color="success" outlined type="submit"> Create </v-btn>
<v-progress-circular v-if="is_processing" indeterminate color="green"></v-progress-circular>
</form>
       
</v-card-text>
       
      </v-card>
    </v-dialog>
    
            
<v-card>
                <v-card-title> Polling units({{ app_data.all_polling_units.length }}) </v-card-title>
                <v-divider></v-divider>
                <v-card-text>

<section class="table-responsive">
  <table class="all_pu_datatables table table-hover" >
  <thead>
    <tr>
      <th>Polling unit</th>
      <th>Ward</th>
      <th>LGA</th>
      <th>Admin</th>
      <th></th>
    </tr>
  </thead>
</table>
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
                dialog: false, lga_id:'', snackbar: false, 
                response_msg:'', coords: {}, is_processing:false,
                edit_data:{}, edit_dialog:false
            }
        },

        computed: { ...mapState(['app_data', 'current_user']) },

       methods:{

        fetch_data(){
              $( function() {
                
                  //var qumery = "type=all_lga&1",;
                  var url = route('fetch_app_data',{type:'all_polling_units'} );
                  $('.all_pu_datatables').DataTable({
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
                        {data: 'ward', name: 'ward' , className:''},
                        {data: 'lga', name: 'lga' , className:''},
                        {data: 'admin', name: 'admin' , className:''},
                        {data: 'actions', name: 'actions' , className:''}
                     ],

                    drawCallback: function(){
                     
                    }
                    
                  });
              });
            },

            fetch_app_data_(){
                  this.$store.dispatch("fetch_current_user");
                return this.$store.dispatch("fetch_app_data");
            },

            store_data(){
                this.is_processing = true;
                var data = $('.polling_unit_data').serialize();
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
                        var data = {id: id_, remove_polling_units:'1'};
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
              this.fetch_data();
              this.fetch_app_data_(); 
            }
       },

       updated(){
           this.take_action();
       },

       mounted(){     
          this.coords.latitude = localStorage.getItem('latitude');
          this.coords.longitude = localStorage.getItem('longitude');
          this.load_records();
       }
    }
</script>

