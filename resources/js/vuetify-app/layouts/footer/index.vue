<template>
    <v-footer class='d-block d-lg-none py-6' app>

<v-snackbar v-model="snackbar" timeout="5000">
  {{ response_msg }}
      <template v-slot:action="{ attrs }">
        <v-btn color="red" text v-bind="attrs" @click="snackbar = false"> Close </v-btn>
      </template>
</v-snackbar>

        <v-bottom-navigation 
        grow  
        absolute
        hide-on-scroll> 

              <v-btn :to="{name: 'menu_page'}" >
                <span> Menu</span>
          
                <v-icon>mdi-menu</v-icon>
              </v-btn> 

              <v-btn :to="{name: 'profile_page'}" >
                <span>Profile</span>
          
                <v-icon>mdi-account</v-icon>
              </v-btn>

              <v-btn :to="{name: 'post_page'}" >
                <span> Reports </span>
          
                <v-icon>mdi-newspaper</v-icon>
              </v-btn>        
          
              <v-btn :to="{name: 'notification_page'}" >
                <span>Notifications</span>
          
                <v-icon>mdi-cog</v-icon>
              </v-btn>
                   
            </v-bottom-navigation>

        </v-footer>
</template>

<script>
    export default { 
      props:['page_title'],
        data(){
          return {
            snackbar:false, response_msg:""
          }
        },

        methods:{
          updated_network_status(event){
            if(navigator.onLine) {
              this.response_msg = "You are back Online...";
            }else{
              this.response_msg = "Please, check your Network connection...";
            }
            this.snackbar = true;
          },

          store_comment(){
            alert('comment ')
          }
        },

        mounted(){
            window.addEventListener('online', this.updated_network_status );
            window.addEventListener('offline', this.updated_network_status );
        }
    }
</script>
