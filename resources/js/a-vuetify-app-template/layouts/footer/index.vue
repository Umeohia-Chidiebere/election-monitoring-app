<template>
    <v-footer id='d-block d-sm-none' app>
      
        <v-bottom-navigation 
        grow  
        absolute
        hide-on-scroll
        scroll-target="#hide-bottom-nav-on-scroll"> 

              <v-btn :to="{name: 'menu_page'}" >
                <span> Menu</span>
          
                <v-icon>mdi-menu</v-icon>
              </v-btn> 

              <v-btn :to="{name: 'homepage'}" >
                <span>Dashboard</span>
          
                <v-icon>mdi-view-dashboard</v-icon>
              </v-btn>

              <v-btn :to="{name: 'profile_page'}" >
                <span> Profile </span>
          
                <v-icon>mdi-account</v-icon>
              </v-btn>        
          
              <v-btn :to="{name: 'settings_page'}" >
                <span>Settings</span>
          
                <v-icon>mdi-cog</v-icon>
              </v-btn>
                   
            </v-bottom-navigation>

        </v-footer>
</template>

<script>
    export default {
      data(){
        return{}
      },

      methods:{
          check_network_status(){
      
           }
      }
    }
</script>
