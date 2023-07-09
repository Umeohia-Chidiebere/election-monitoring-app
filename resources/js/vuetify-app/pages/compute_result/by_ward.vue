<template>
<section>

    <v-list>

        <v-list-item v-for="ward in app_data.my_polling_units.wards" :key="ward.id">
            <v-list-item-content>
                <v-list-item-title>
                    <h6 class="text-success"> {{ `${ward.name} - ${ward.state}`  }} </h6>
                    <p><v-btn @click="update_my_location" color="green" outlined><v-icon>mdi-map-marker</v-icon> My Location</v-btn> </p>
                </v-list-item-title>
                <v-list-item-subtitle>

                    <div class="table-responsive">
                        <form @submit.prevent="store_election_result(ward.id)"  :class="'store_election_result_data_'+ward.id" method="post">
                          <input type="hidden" name="store_election_result" value="1">
                          <input type="hidden" name="ward_id" :value="ward.id"/>
                          <input type="hidden" name="state" :value="ward.state"/>
                            <table class="table table-md">
                                <thead>
                                    <tr>
                                        <th>Polling units</th>
                                        <th>Election</th>
                                        <th>Party</th>
                                        <th>Valid votes</th>
                                        <th>Invalid votes</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <v-select label="Select Polling unit" name="polling_unit_id" placeholder="Select Polling unit" color="green" :items="ward.polling_units" item-text="name" item-value="id" required>
                                            </v-select>

                                        </td>
                                        <td>
                                            <v-select label="Select Election" name="election_id" placeholder="Select election" color="green" :items="app_data.specific_elections.general" item-text="full_details" item-value="id" required>
                                            </v-select>
                                        </td>

                                        <td>
                                            <v-select label="Select Party" name="political_party_id" placeholder="Select party" color="green" :items="app_data.all_political_parties" item-text="short_name" item-value="id" required>
                                            </v-select>
                                        </td>

                                        <td>
                                            <v-text-field type="number" required placeholder="0.00" name="total"></v-text-field>
                                        </td>

                                        <td>
                                            <v-text-field type="number" required placeholder="0.00" value='0' name="invalid_votes"></v-text-field>
                                        </td>

                                        <td>
                                          <v-btn type="submit" class="text-success" outline>Upload</v-btn>
                                        </td>

                                    </tr>

                                </tbody>
                            </table>
                        </form>

                    </div>
                </v-list-item-subtitle>
            </v-list-item-content>
        </v-list-item>
    </v-list>


    <v-snackbar v-model="snackbar" timeout="5000">
      {{ response_msg }}

      <template v-slot:action="{ attrs }">
        <v-btn color="red" text v-bind="attrs" @click="snackbar = false">  Close </v-btn>
      </template>
</v-snackbar>

</section>
</template>

 
<script>
import baseLayout from "../../layouts/base_layout.vue";
import {
    mapState
} from "vuex";
import api from "../../../api";

export default {
    components: {
        baseLayout
    },
    data() {
        return {
            snackbar: false,
            response_msg: '',
            is_processing: false
        }
    },

    computed: {
        ...mapState(['app_data'])
    },

    methods: {
        fetch_app_data_() {
            return this.$store.dispatch("fetch_app_data");
        },

        store_election_result(ward_id = '') {
          var data = $(`.store_election_result_data_${ward_id}`).serialize();
              api.store_app_data( data )
                 .then( response => {
                    this.snackbar = true;
                    if( response.data.error ) return this.response_msg = response.data.error;
                      this.response_msg = response.data.success;
                      this.fetch_app_data_();
                 });
        },

        update_my_location(){
            this.response_msg = 'Gps Location updated...';
            this.snackbar = true;
        }
    },

    mounted() {
        this.fetch_app_data_();
    }
}
</script>
