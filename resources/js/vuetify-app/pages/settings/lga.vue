<template>
<div>
    <v-container fluid class="mt-3">

        <v-card>
            <v-card-title> All LGA({{ app_data.all_lga.length }}) </v-card-title>
            <v-divider></v-divider>
            <v-card-text>

                <section class="table-responsive">
                    <table class="all_lga_datatables table table-hover table-md">
                        <thead>
                            <tr>
                                <th>LGA</th>
                                <th>Admins</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="data in app_data.all_lga" :key="data.id">
                                <td>{{ data.name }}</td>
                                <td>{{ data.user.name }}</td>
                                <td><a @click="edit_user( data )" href="javascript:void(0)"><i class="fa fa-edit text-info"></i></a> </td>
                            </tr>
                        </tbody>
                    </table>
                </section>
            </v-card-text>
        </v-card>

    </v-container>

    <v-snackbar v-model="snackbar" timeout="5000">
        {{ response_msg }}

        <template v-slot:action="{ attrs }">
            <v-btn color="red" text v-bind="attrs" @click="snackbar = false"> Close </v-btn>
        </template>
    </v-snackbar>

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

                <form class="py-5 update_lga_data" method="post" @submit.prevent="update_data">
                  <input type="hidden" name="id" :value="edit_data.id">
                  <input type="hidden" name="update_lga" value="1">
                    <section class="row">
                        <div class="col-md-12">
                            <v-text-field placeholder="Lga name" label="LGA" name="name" required :value="edit_data.name"></v-text-field>
                        </div>
                        <!-- //col -->

                        <div class="col-md-12">
                            <v-select label="Admin" name="user_id" placeholder="Admin" color="green" 
                                      :items="app_data.all_admins.lga" item-text="name" item-value="id" required>
                            </v-select>
                            <p class="text-muted">Admin: {{ edit_data.user.name  }}</p>
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
import {
    mapState
} from "vuex";
import api from "../../../api";
// import skeletonLoader from '../../layouts/skeleton_loader.vue';
export default {
    // components: {skeletonLoader},
    data() {
        return {
            edit_data: {user:{}},
            edit_dialog: false,
            snackbar: false,
            response_msg: ''
        }
    },

    computed: {
        ...mapState(['app_data', 'current_user'])
    },

    methods: {
        fetch_app_data_() {
            this.$store.dispatch("fetch_current_user"); 
            return this.$store.dispatch("fetch_app_data");
        },

        edit_user($data) {
            $('.lga_edit_btn').click();
            this.edit_data = $data;
        },
        update_data(){
          var data = $('.update_lga_data').serialize();
              api.store_app_data( data )
                 .then( response => {
                  this.snackbar = true;
                  if( response.data.error ) return this.response_msg = response.data.error;
                  this.response_msg = response.data.success;
                  this.fetch_app_data_();
                 })
                 .catch( err => {
                  this.response_msg = "Network error !";
                  this.snackbar = true;
                 });
        }
    },

    mounted() {
        this.fetch_app_data_();
    }
}
</script>
