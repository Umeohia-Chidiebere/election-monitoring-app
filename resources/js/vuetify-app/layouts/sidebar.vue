<template>
    <v-navigation-drawer app>

      <v-list>
          <v-list-item class="px-1">
            <v-list-item-avatar>
              <v-img :src="app_logo"></v-img>
              <!-- <v-icon> fas fa-user-circle </v-icon> -->
            </v-list-item-avatar>
          </v-list-item>

          <v-list-item link>
            <v-list-item-content>
              <v-list-item-title class="text-h6">
              {{ current_user.name }}
              </v-list-item-title>
              <v-list-item-subtitle>{{ current_user.email }}</v-list-item-subtitle>
              <v-list-item-subtitle>{{ current_user.username }}</v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
        </v-list>

        <v-divider></v-divider>

        <menuList />
      </v-navigation-drawer>
    
</template>
 
 <script>
 import {  mapState } from "vuex";
 import menuList from "../pages/menu_list.vue";
  export default {
    components: { menuList},
    computed: {  ...mapState([ "current_user"]),  },
     mounted(){
      this.$store.dispatch("fetch_current_user");
     }
  }
</script>
 