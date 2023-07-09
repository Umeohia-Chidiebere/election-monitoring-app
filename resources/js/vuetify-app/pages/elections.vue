<template>
<div>
    <baseLayout page_title="Elections">
        <v-container fluid class="mt-3">

            <v-snackbar v-model="snackbar" timeout="5000">
                {{ response_msg }}

                <template v-slot:action="{ attrs }">
                    <v-btn color="red" text v-bind="attrs" @click="snackbar = false"> Close </v-btn>
                </template>
            </v-snackbar>

            <v-dialog v-model="dialog" fullscreen hide-overlay scrollable transition="dialog-bottom-transition">
                <template v-slot:activator="{ on, attrs }">
                    <p color="primary" dark v-bind="attrs" v-on="on">
                        <v-icon>mdi-plus</v-icon>Add new
                    </p>
                </template>

                <v-card>
                    <v-toolbar dark color="green">
                        <v-btn icon dark @click="dialog = false">
                            <v-icon>mdi-close</v-icon>
                        </v-btn>

                        <v-toolbar-title>Create Election</v-toolbar-title>
                        <v-spacer></v-spacer>

                    </v-toolbar>

                    <v-card-text>

                        <form @submit.prevent="store_data" method="post" class="election_data py-5" enctype="multipart/form-data">
                            <input type="hidden" name="store_election" value="1">
                            <v-select label="Election Type" name="election_type_id" placeholder="Election category" color="green" :items="app_data.election_types" item-text="name" item-value="id" required>
                            </v-select>
                            <!-- <v-select
    label="Political Party"
    name="political_party_id" 
    placeholder="Political party"
    color="green"
    :items="app_data.all_political_parties"
    item-text="short_name"
    item-value="id"
    required>
</v-select> -->
                            <v-select label="State" name="state_id" placeholder="State" color="green" :items="app_data.all_states" item-text="name" item-value="id" required>
                            </v-select>
                            <v-text-field type="number" label="Election year" name="year" color="green" placeholder="2023" value="2023" required></v-text-field>
                            <v-text-field type="number" label="Total Regsitered voters" name="total_registered_voters" color="green" placeholder="Total Regsitered voters" required></v-text-field>
                            <input type="hidden" name="start_date" :value="picker" required />
                            <div class="row">
                                <div class="col-md-6">
                                    <h6> Election Date </h6>
                                    <v-date-picker v-model="picker" label="Election date" color="green lighten-1"></v-date-picker>
                                </div>
                            </div>
                            <v-text-field label="Description" name="description" color="green" placeholder="Description"></v-text-field>
                            <input type="hidden" name="hidden" value="1">

                            <v-btn v-if="is_processing" color="secondary" disabled outlined type="button"> Processing... </v-btn>
                            <v-btn v-else color="success" outlined type="submit"> Create </v-btn>
                            <v-progress-circular v-if="is_processing" indeterminate color="green"></v-progress-circular>

                        </form>

                    </v-card-text>

                </v-card>
            </v-dialog>

            <v-card>
                <v-card-title> Elections({{ app_data.all_elections.length }}) </v-card-title>
                <v-divider></v-divider>
                <v-card-text>

                    <section class="table-responsive">
                        <table class="all_election_datatables table table-hover table-md">
                            <thead>
                                <tr>
                                    <th>Elections</th>
                                    <th>Date</th>
                                    <th>Registered_voters</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="election in app_data.all_elections" :key="election.id">
                                    <td>{{ election.full_details ?? '-'}}</td>
                                    <td>{{ election.start_date }}</td>
                                    <td>{{ number_format( election.total_registered_voters ) ?? '-' }}</td>
                                    <td>
                                        <a href="javascript:void(0)" @click="navigate_to_result_page(election)" class="text-decoration-none text-success"><i class="fa fa-eye"></i></a> &nbsp;
                                        <a href="javascript:void(0)" class="text-decoration-none text-danger delete_data"><i :id="election.id" class="fa fa-trash"></i> </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </section>

                </v-card-text>
            </v-card>

        </v-container>
    </baseLayout>
</div>
</template>

<script>
import { mapState } from "vuex";
import api from "../../api";
import baseLayout from "../layouts/base_layout.vue";
export default {
    components: {
        baseLayout
    },
    data() {
        return {
            dialog: false,
            lga_id: '',
            snackbar: false,
            response_msg: '',
            is_processing: false,
            picker: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10),
        }
    },

    computed: {
        ...mapState(['app_data'])
    },

    methods: {
        fetch_app_data_() {
            return this.$store.dispatch("fetch_app_data");
        },

        store_data() {
            this.is_processing = true;
            var data = $('.election_data').serialize();
            api.store_app_data(data)
                .then(response => {
                    this.is_processing = false;
                    this.snackbar = true;
                    if (response.data.error) return this.response_msg(response.data.error);
                    this.response_msg = response.data.success;
                    this.load_records();
                    this.dialog = false;
                })
                .catch(err => {
                    this.response_msg = "Network error !";
                    this.snackbar = true;
                    this.is_processing = false;
                });
        },

        take_action() {
            setTimeout(() => {
                $('.edit_data').on('click', (e) => {
                    var id_ = e.target.id;
                    console.log(id_)
                });

                $('.delete_data').on('click', (e) => {
                    var id_ = e.target.id;
                    var data = {
                        id: id_,
                        remove_election: '1'
                    };
                    _user_confirmation((user_confirmed) => {
                        if (user_confirmed) {
                            api.store_app_data(data)
                                .then(response => {
                                    this.snackbar = true;
                                    if (response.data.error) return this.response_msg = response.data.error;
                                    this.response_msg = response.data.success;
                                    this.load_records();
                                });
                        }
                    });

                });
            }, 2000);
        },

        load_records() {
            this.fetch_app_data_();
        },

        navigate_to_result_page($election = '') { 
            return this.$router.push({
                name: 'homepage',
                query: {
                    tab: $election.election_type.slug,
                }
            });
        }
    },

    updated() {
        this.take_action();
    },

    mounted() {
        this.load_records();
    }
}
</script>
