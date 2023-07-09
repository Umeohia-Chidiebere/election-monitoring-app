<template>
   <v-app-bar color="green" dark app>
              
    <v-toolbar color="green" flat>
          <v-btn icon light v-if="page_title != 'Election Live Report'">
            <v-icon @click="go_back" color="white darken-2">
              mdi-arrow-left
            </v-icon>
          </v-btn>

          <v-toolbar-title class="white--text text--darken-4 ">
           {{ page_title }}
          </v-toolbar-title>

          <v-spacer></v-spacer>
          

    <v-menu top :offset-x="offset">
      <template v-slot:activator="{ on, attrs }">
       
        <v-btn icon light v-bind="attrs" v-on="on"> 
          <v-icon color="white darken-2">mdi-dots-vertical</v-icon>
        </v-btn>

      </template>

      <v-list>
        <v-list-item v-for="(item, index) in items" :key="index" :to="{name:item.url}">
          <v-list-item-title ><v-icon>{{ item.icon }}</v-icon> {{ item.title }}</v-list-item-title>
        </v-list-item>
        <v-list-item :href="logout">
          <v-list-item-title><v-icon>mdi-logout</v-icon> Logout</v-list-item-title>
        </v-list-item>
      </v-list>
    </v-menu>

        </v-toolbar>

   </v-app-bar>
</template>

<script>
 
    export default {
        props: ['page_title'],
        data(){
            return {
                logout: route('logout'),
                items: [
                        { title: 'Create Report', icon:"mdi-plus", url:'create_post_page' },
                        // { title: 'Elections', icon:"mdi-map-marker", url:'elections_page' },
                        { title: 'Profile', icon:"mdi-account", url:'profile_page' },
                        { title: 'Notifications', icon:"mdi-bell", url:'notification_page' },
                      ],
                offset: true,
            }
        },
        methods:{
            go_back(){
                return window.history.back();
            }
        }
    }
</script>
