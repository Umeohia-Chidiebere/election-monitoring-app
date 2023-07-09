<template>
  <section>
    <v-list dense nav>
<section >
      <v-list-item v-for="item in general_lists" :key="item.title" :to="{name:item.url}" link>
        <v-list-item-icon>
          <v-icon style="color:green;">{{ item.icon }}</v-icon>
        </v-list-item-icon>
        
        <v-list-item-content>
          <v-list-item-title>{{ item.title }}</v-list-item-title>
        </v-list-item-content>
      </v-list-item>

      <v-divider class="py-2"></v-divider>
    </section>

      <v-list-item v-for="item in general_admin_lists" :key="item.title" link>
        <v-list-item-icon>
          <v-icon style="color:green;">{{ item.icon }}</v-icon>
        </v-list-item-icon>
        
        <v-list-item-content>
          <v-list-item-title>{{ item.title }}</v-list-item-title>
        </v-list-item-content>
      </v-list-item>

      <v-list-item :href="logout_url" link>
        <v-list-item-icon>
          <v-icon style="color:green;">mdi-logout</v-icon>
        </v-list-item-icon>
        
        <v-list-item-content>
          <v-list-item-title>Logout</v-list-item-title>
        </v-list-item-content>
      </v-list-item>

      

    </v-list>
  </section>

</template>

<script>
import {  mapState } from "vuex";
import routes from "../../routes";
export default {
  computed: {
           ...mapState([ "current_user"]), 
     },

data () {
  return {
    user: {},
    logout_url: route('logout'),
    general_lists: [
      { title: 'Dashboard', icon: 'mdi-view-dashboard', url: 'homepage' },
      { title: 'Profile', icon: 'mdi-account', url: 'profile_page' },
      { title: 'Settings', icon: 'mdi-cog', url: 'settings_page' },
    ],
    general_admin_lists: [
      { title: 'Dashboard', icon: 'mdi-view-dashboard' },
      { title: 'Photos', icon: 'mdi-image' },
      { title: 'About', icon: 'mdi-help-box' },
      { title: 'Profile', icon: 'mdi-account-multiple' },
      { title: 'Senatorial', icon: 'mdi-account-multiple' },
      { title: 'Constituency', icon: 'mdi-account-multiple' },
    ],
    state_admin_lists: [
      { title: 'Dashboard', icon: 'mdi-view-dashboard' },
      { title: 'Photos', icon: 'mdi-image' },
    ],
    ward_admin_lists: [
      { title: 'Dashboard', icon: 'mdi-view-dashboard' },
      { title: 'Photos', icon: 'mdi-image' },
    ],
    zonal_admin_lists: [
      { title: 'Dashboard', icon: 'mdi-view-dashboard' },
      { title: 'Photos', icon: 'mdi-image' },
    ],
    lga_admin_lists: [
      { title: 'Dashboard', icon: 'mdi-view-dashboard' },
      { title: 'Photos', icon: 'mdi-image' },
    ],
    user_lists: [
      { title: 'Dashboard', icon: 'mdi-view-dashboard' },
      { title: 'Photos', icon: 'mdi-image' },
    ],
    right: null,
  }
},

mounted(){
    this.$store.dispatch("fetch_current_user");
}
}
</script>
