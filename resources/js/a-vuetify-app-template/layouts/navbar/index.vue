<template>
   <v-app-bar color="white" dark app>
              
    <v-toolbar color="white" flat>
          <v-btn icon light>
            <v-icon @click="go_back" color="grey darken-2">
              mdi-arrow-left
            </v-icon>
          </v-btn>

          <v-toolbar-title class="grey--text text--darken-4">
           {{ page_title }}
          </v-toolbar-title>

          <v-spacer></v-spacer>

          <v-btn
            icon
            light
            :to="{name:'search_page'}"
          >
            <v-icon color="grey darken-2">
              mdi-magnify
            </v-icon>
          </v-btn>
        </v-toolbar>

   </v-app-bar>
</template>

<script>
 
    export default {
        props: ['page_title'],
        data(){
            return {}
        },
        methods:{
            go_back(){
                return window.history.back();
            }
        }
    }
</script>
