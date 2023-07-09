<template>
    <section>
     <baseLayout page_title="Dashboard">

  <v-card
    class="mx-auto"
  >
    <v-toolbar
      :color="selection.length ? 'grey darken-4' : 'deep-purple accent-4'"
      dark
    >
      <v-app-bar-nav-icon v-if="!selection.length"></v-app-bar-nav-icon>
      <v-btn
        v-else
        icon
        @click="selection = []"
      >
        <v-icon>mdi-close</v-icon>
      </v-btn>

      <v-toolbar-title>
        {{ selection.length ? `${selection.length} selected` : 'Dashboard' }}
      </v-toolbar-title>

      <v-spacer></v-spacer>

      <v-scale-transition>
        <v-btn
          v-if="selection.length"
          key="export"
          icon
        >
          <v-icon>mdi-export-variant</v-icon>
        </v-btn>
      </v-scale-transition>
      <v-scale-transition>
        <v-btn
          v-if="selection.length"
          key="delete"
          icon
        >
          <v-icon>mdi-delete</v-icon>
        </v-btn>
      </v-scale-transition>

      <v-btn icon>
        <v-icon>mdi-dots-vertical</v-icon>
      </v-btn>
    </v-toolbar>

    <v-card-text>
      <v-select
        v-model="selection"
        :items="items"
        
        label="Select an option"
      ></v-select>
    </v-card-text>
  </v-card>
     
    </baseLayout>
    </section>
 </template>
 
 
 <script>
 import baseLayout from "../layouts/base_layout.vue";
 import baseLayoutWithoutSidebar from "../layouts/base_layout_without_sidebar.vue";
     export default {
         components: { baseLayout, baseLayoutWithoutSidebar },
         data(){
             return {
                selection: [],
                items: ['Foo', 'Bar', 'Fizz', 'Buzz'],
             }
         },

         methods:{
         }
     }
 </script>
 