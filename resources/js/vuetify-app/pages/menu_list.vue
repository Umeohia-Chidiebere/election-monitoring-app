<template>
  <section>
    <v-list dense nav>


<!-- start -->
<section v-if="current_user.role.slug == 'super_admin'" >
      <v-list-item v-for="item in super_admin_lists" :key="item.title" :to="{name:item.url}" >
        <v-list-item-icon>
          <v-icon>{{ item.icon }}</v-icon>
        </v-list-item-icon>
        
        <v-list-item-content>
          <v-list-item-title>{{ item.title }}</v-list-item-title>
        </v-list-item-content>
      </v-list-item>

      <v-divider></v-divider>
</section>
<!-- ///end -->


<!-- start -->
<section v-if="current_user.role.slug == 'constituency_admin'">
      <v-list-item v-for="item in constituecy_admin_lists" :key="item.title" :to="{name:item.url}" >
        <v-list-item-icon>
          <v-icon>{{ item.icon }}</v-icon>
        </v-list-item-icon>
        
        <v-list-item-content>
          <v-list-item-title>{{ item.title }}</v-list-item-title>
        </v-list-item-content>
      </v-list-item>

      <v-divider></v-divider>
</section>
<!-- ///end -->


<!-- start -->
<section v-if="current_user.role.slug == 'ward_admin'">
      <v-list-item v-for="item in ward_admin_lists" :key="item.title" :to="{name:item.url}" >
        <v-list-item-icon>
          <v-icon>{{ item.icon }}</v-icon>
        </v-list-item-icon>
        
        <v-list-item-content>
          <v-list-item-title>{{ item.title }}</v-list-item-title>
        </v-list-item-content>
      </v-list-item>

      <v-divider></v-divider>
</section>
<!-- ///end -->


<!-- start -->
<section v-if="current_user.role.slug == 'senatorial_admin'">
      <v-list-item v-for="item in senatorial_admin_lists" :key="item.title" :to="{name:item.url}" >
        <v-list-item-icon>
          <v-icon>{{ item.icon }}</v-icon>
        </v-list-item-icon>
        
        <v-list-item-content>
          <v-list-item-title>{{ item.title }}</v-list-item-title>
        </v-list-item-content>
      </v-list-item>

      <v-divider></v-divider>
</section>
<!-- ///end -->

<!-- start -->
<section v-if="current_user.role.slug == 'lga_admin'">
      <v-list-item v-for="item in lga_admin_lists" :key="item.title" :to="{name:item.url}" >
        <v-list-item-icon>
          <v-icon>{{ item.icon }}</v-icon>
        </v-list-item-icon>
        
        <v-list-item-content>
          <v-list-item-title>{{ item.title }}</v-list-item-title>
        </v-list-item-content>
      </v-list-item>

      <v-divider></v-divider>
</section>
<!-- ///end -->

<!-- start -->
<section v-if="current_user.role.slug == 'user'">
      <v-list-item v-for="item in basic_user_lists" :key="item.title" :to="{name:item.url}" >
        <v-list-item-icon>
          <v-icon>{{ item.icon }}</v-icon>
        </v-list-item-icon>
        
        <v-list-item-content>
          <v-list-item-title>{{ item.title }}</v-list-item-title>
        </v-list-item-content>
      </v-list-item>

      <v-divider></v-divider>
</section>
<!-- ///end -->


<!-- start -->
      <!-- <v-list-item :href="logout_url" >
        <v-list-item-icon>
          <v-icon>mdi-logout</v-icon>
        </v-list-item-icon>
        
        <v-list-item-content>
          <v-list-item-title>Logout </v-list-item-title>
        </v-list-item-content>
      </v-list-item> -->
<!-- //end -->

<!-- start -->
<section >
      <v-list-item v-for="item in general_lists" :key="item.title" :to="{name:item.url}" >
        <v-list-item-icon>
          <v-icon>{{ item.icon }}</v-icon>
        </v-list-item-icon>
        
        <v-list-item-content>
          <v-list-item-title>{{ item.title }}</v-list-item-title>
        </v-list-item-content>
      </v-list-item>

      <v-divider></v-divider>
</section>
<!-- ///end -->


    </v-list>
</section>

</template>

<script>
import {  mapState } from "vuex";

export default {
  computed: { ...mapState([ "current_user"]) },

 data () {
  return {
    user: {},
    logout_url: route('logout'),
    general_lists: [
      { title: 'Incidence Reports', icon: 'mdi-newspaper', url: 'post_page' },
      { title: 'Notifications', icon: 'mdi-bell', url: 'notification_page' }
    ],
    super_admin_lists: [
      { title: 'Dashboard', icon: 'mdi-view-dashboard', url: 'homepage' },
      { title: 'Elections', icon: 'mdi-map-marker', url: 'elections_page' },
      // { title: 'Profile', icon: 'mdi-account', url: 'profile_page' },
      { title: 'Set-up', icon: 'mdi-cog', url: 'settings_page' },
      { title: 'All users', icon: 'mdi-account-multiple', url: 'users_page'},
      { title: 'Result Computation', icon: 'mdi-laptop', url: 'compute_result_page' },
    ],
    constituecy_admin_lists: [
    { title: 'Dashboard', icon: 'mdi-view-dashboard', url: 'homepage' },
      { title: 'Elections', icon: 'mdi-map-marker', url: 'elections_page' },
      // { title: 'Profile', icon: 'mdi-account', url: 'profile_page' },
      { title: 'Set-up', icon: 'mdi-cog', url: 'settings_page' },
      { title: 'All users', icon: 'mdi-account-multiple', url: 'users_page'},
      { title: 'Result Computation', icon: 'mdi-laptop', url: 'compute_result_page' },
    ],
    ward_admin_lists: [
    { title: 'Dashboard', icon: 'mdi-view-dashboard', url: 'homepage' },
      { title: 'Elections', icon: 'mdi-map-marker', url: 'elections_page' },
      // { title: 'Profile', icon: 'mdi-account', url: 'profile_page' },
      { title: 'Set-up', icon: 'mdi-cog', url: 'settings_page' },
      { title: 'All users', icon: 'mdi-account-multiple', url: 'users_page'},
      { title: 'Result Computation', icon: 'mdi-laptop', url: 'compute_result_page' },
    ],
    senatorial_admin_lists: [
    { title: 'Dashboard', icon: 'mdi-view-dashboard', url: 'homepage' },
      { title: 'Elections', icon: 'mdi-map-marker', url: 'elections_page' },
      // { title: 'Profile', icon: 'mdi-account', url: 'profile_page' },
      { title: 'Set-up', icon: 'mdi-cog', url: 'settings_page' },
      { title: 'All users', icon: 'mdi-account-multiple', url: 'users_page'},
      { title: 'Result Computation', icon: 'mdi-laptop', url: 'compute_result_page' },
    ],
    lga_admin_lists: [
    { title: 'Dashboard', icon: 'mdi-view-dashboard', url: 'homepage' },
      { title: 'Elections', icon: 'mdi-map-marker', url: 'elections_page' },
      // { title: 'Profile', icon: 'mdi-account', url: 'profile_page' },
      { title: 'Set-up', icon: 'mdi-cog', url: 'settings_page' },
      { title: 'All users', icon: 'mdi-account-multiple', url: 'users_page'},
      { title: 'Result Computation', icon: 'mdi-laptop', url: 'compute_result_page' },
    ],
    basic_user_lists: [
    
      { title: 'Profile', icon: 'mdi-account', url: 'profile_page' },
      { title: 'Result Computation', icon: 'mdi-laptop', url: 'compute_result_page' },
    ],
    right: null,
  }
},

mounted(){
    this.$store.dispatch("fetch_current_user");
  }
}
</script>
