<template>
    <div> 
        <v-container fluid class="mt-3">
        
            <v-card>
                <v-card-title> All Political Parties({{ app_data.all_political_parties.length }}) </v-card-title>
                <v-divider></v-divider>
                <v-card-text>

<section class="">

    <div class="row">
        <div class="col-md-4" v-for="party in app_data.all_political_parties" :key="party.id">
            <center>
                <img class="img-thumbnail" :src="party_logo_folder+party.logo" style="max-height: 200px; max-width:200px;"/>
                <h6 class="py-2"> {{ `${party.short_name} - ${party.name}` }} </h6>
            </center>
            
        </div>
    </div>

</section>
                </v-card-text>
            </v-card>

        </v-container>
    </div>
</template>

<script>
import { mapState } from "vuex";
// import skeletonLoader from '../../layouts/skeleton_loader.vue';
    export default {
      // components: {skeletonLoader},
        data(){
            return{}
        },

        computed: {
        ...mapState(['app_data'])
       },

       methods:{
            fetch_app_data_(){
                return this.$store.dispatch("fetch_app_data");
            }
       },

       mounted(){
          this.fetch_app_data_();
       }
    }
</script>

