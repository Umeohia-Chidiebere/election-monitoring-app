<template>
    <div> 
        <v-container fluid class="mt-3">
            <p class="cursor"><v-icon>mdi-plus</v-icon>Add LGA </p>
            <v-divider></v-divider>

            <v-card>
                <v-card-title> All LGA </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    
                    <v-menu transition="slide-x-transition">
      <template v-slot:activator="{ on, attrs }">
        <v-btn
          color="primary"
          class="ma-2"
          v-bind="attrs"
          v-on="on"
        >
          Slide X Transition
        </v-btn>
      </template>
      <v-list>
        <v-list-item
          v-for="n in 5"
          :key="n"
          link
        >
          <v-list-item-title v-text="'Item ' + n"></v-list-item-title>
        </v-list-item>
      </v-list>
    </v-menu>


  <v-card>
    <v-card-title>
      <v-text-field
        v-model="search"
        append-icon="mdi-magnify"
        label="Search"
        single-line
        hide-details
      ></v-text-field>
    </v-card-title>
    <v-data-table
      :headers="headers"
      :items="lga_lists"
      show-select
      :search="search"
    ></v-data-table>
  </v-card>


                </v-card-text>
            </v-card>

        </v-container>
    </div>
</template>

<script>
import { mapState } from "vuex";
    export default {
        data(){
            return{
                search: '',
                selected: [],
                headers: [
                    {
                        text: "LGA",
                        align: "start",
                        value: 'lga'
                    },
                    {
                        text: "State",
                        value: 'state'
                    },
                    {
                        text: "Country",
                        value: 'country'
                    },

                ],
                lga_lists: [
                    {
                        lga: "Awka south",
                        state: "Anambra state",
                        country: "Nigeria"
                    },
                    {
                        lga: "sururlere west",
                        state: "Lagos state",
                        country: "Ghana"
                    },
                ]
            }
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

