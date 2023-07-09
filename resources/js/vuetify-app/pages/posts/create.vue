<template>
<section>
    <baseLayout page_title="Create a report">
        <v-container fluid class="mt-3">
           
            <v-snackbar v-model="snackbar" timeout="5000">
                {{ response_msg }}

                <template v-slot:action="{ attrs }">
                    <v-btn color="red" text v-bind="attrs" @click="snackbar = false"> Close </v-btn>
                </template>
            </v-snackbar>

            <v-card>
                <v-card-text>

                   <center>

                    <form action="" @submit.prevent="store_post" method="post" class="store_post_data" enctype="multipart/form-data">
                        <input type="hidden" name="store_post" value="1">
                        <v-select 
    label="Select Election"
    name="election_id" 
    placeholder="Select Election"
    color="green"
    :items="app_data.all_elections"
    item-text="full_details"
    item-value="id"
    required>
</v-select>


<v-select 
    label="Report Category"
    name="category" 
    placeholder="Select Category"
    color="green"
    :items="app_data.report_category"
    required>
</v-select>

<v-select 
    label="Polling unit"
    name="polling_unit_id" 
    placeholder="Polling unit"
    color="green"
    :items="app_data.all_polling_units"
    item-text="name"
    item-value="id"
    required>
</v-select>

                        <v-textarea
                        required
          solo
          name="content"
          label="What is happening?"
          hint="Report live event in your polling unit"
        ></v-textarea>
        
<v-file-input
  counter
  multiple
  show-size
  truncate-length="4"
  label="Attach files"
  accept=""
  name="docs[]">
</v-file-input>

<v-btn v-if="is_processing" color="secondary" disabled outlined type="button"> Processing... </v-btn>
<v-btn v-else color="success" outlined type="submit"> Report now </v-btn>
<v-progress-circular v-if="is_processing" indeterminate color="green"></v-progress-circular>

                    </form>
                   </center>
                </v-card-text>
            </v-card>

        </v-container>

    </baseLayout>

</section>
</template>

<script>
import baseLayout from "../../layouts/base_layout.vue";
import {mapState} from "vuex";
import api from '../../../api.js';
export default {
    computed: { ...mapState(['app_data']) },
    components: {
        baseLayout
    },
    data() {
        return { snackbar:false, response_msg:'', is_processing:false}
    },
    methods:{
        store_post(){
              this.is_processing = true;
              var data = new FormData( document.querySelector('.store_post_data')); //$('.store_post_data').serialize();
                  api.store_app_data( data )
                     .then( response => {
                          this.is_processing = false;
                          this.snackbar = true;
                          if( response.data.error ){
                              return this.response_msg = response.data.error;
                          }
                          //== this.response_msg = response.data.success;
                          this.$router.push({name:"view_post_page", params:{code_number:response.data.success}});
                     });
          },
    },

    mounted(){
        this.$store.dispatch("fetch_app_data");
    }
}
</script>
