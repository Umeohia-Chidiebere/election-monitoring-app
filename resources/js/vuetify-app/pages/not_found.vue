<template>
    <section>
      <v-container fluid>
     <baseLayout page_title="Page Not found">    
  <v-card :loading="loading" class="mx-auto">
    <template slot="progress">
      <v-progress-linear
        color="deep-purple"
        height="10"
        indeterminate
      ></v-progress-linear>
    </template>

    <v-img height="400px" :src="page_not_found_img"></v-img>
<!-- 
    <v-card-text align="center"> <b>  OOPS ! PAGE NOT FOUND</b> </v-card-text> -->
    <v-divider class="mx-4"></v-divider>


    <v-card-actions>
      <v-btn
        color="green lighten-2"
        text
        :to="{name: 'homepage'}"
      >
        Go to Homepage
      </v-btn>
    </v-card-actions>
  </v-card>


    </baseLayout>
  </v-container>
    </section>
 </template>
 
 <script> 
 import baseLayout from "../layouts/base_layout.vue";
     export default {
         components: { baseLayout},
         data(){
             return {}
         },
         mounted(){
          
         }
     }
 </script>
 