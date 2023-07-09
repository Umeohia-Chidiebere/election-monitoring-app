import user from "./user_permissions.js";

import home from "./pages/index.vue";
import live_map from "./pages/live_map.vue";
import profile from "./vuetify-app/pages/profile.vue";
import search from "./vuetify-app/pages/search.vue";
import menu from "./vuetify-app/pages/menu.vue";
import dashboard from "./vuetify-app/pages/dashboard/index.vue";
import users from "./vuetify-app/pages/users.vue";
import settings from "./vuetify-app/pages/settings/index.vue"; 
import posts from "./vuetify-app/pages/posts/index.vue";
import create_post from "./vuetify-app/pages/posts/create.vue";
import view_post from "./vuetify-app/pages/posts/view_post.vue"; 
import compute_result from "./vuetify-app/pages/compute_result/index.vue";
import elections from "./vuetify-app/pages/elections.vue";
import notifications from "./vuetify-app/pages/notifications.vue";
import view_election_results from "./vuetify-app/pages/view_election_results.vue";

import page_not_found from "./vuetify-app/pages/not_found.vue";  

export default {
    base:'auth',
    mode: 'history',
    //strict: true,
    
routes: [
    ///=== HOMEPAGE (Dashboard) ==///
    {
       path: '/', 
       component: dashboard, 
       name: 'homepage',
       async beforeEnter(to, from, next) { 
             change_page_title("Dashboard");
            // next();
             user.is_user(next());
      },                     
    },

    ///==Notifications ==//
    {
        path: '/notifications', 
        component: notifications,  
        name: 'notification_page',
        async beforeEnter(to, from, next) { 
            change_page_title("Notifications");
            next();
       }                   
     },

     ///==profile ==//
    {
        path: '/users', 
        component: users,  
        name: 'users_page',
        async beforeEnter(to, from, next) { 
            change_page_title("All users");
            next();
       }                     
     },

    ///== Posts  ==//
    {
        path: '/posts', 
        component: posts,  
        name: 'post_page',
        async beforeEnter(to, from, next) { 
            change_page_title("Reports");
            next();
       },                     
     },

    ///== view Posts  ==//
    {
        path: '/:code_number/view-post', 
        component: view_post,  
        name: 'view_post_page',
        async beforeEnter(to, from, next) { 
            change_page_title("View Reports");
            next();
       },                     
     },

     ///== create post  ==//
    {
        path: '/create-post', 
        component: create_post,  
        name: 'create_post_page',
        async beforeEnter(to, from, next) { 
            change_page_title("Create Report");
            next();
       },                     
     },

    ///== compute result ==//
    {
        path: '/compute-result', 
        component: compute_result,  
        name: 'compute_result_page',
        async beforeEnter(to, from, next) { 
            change_page_title("Compute Result");
            next();
       },                     
     },

    ///== Elections ==//
    {
        path: '/elections', 
        component: elections,  
        name: 'elections_page',
        async beforeEnter(to, from, next) { 
            change_page_title("Elections");
            next();
        },                     
     },

     {
        path: '/view-result', 
        component: view_election_results,  
        name: 'view_election_result_page',
        async beforeEnter(to, from, next) { 
            change_page_title("View Result");
            next();
        },                     
     },
     
    ///== Profile ==//
    {
        path: '/profile', 
        component: profile,  
        name: 'profile_page',
        async beforeEnter(to, from, next) { 
            change_page_title("Profile");
            next();
       },                     
     },

    ///==search page ==//
     {
        path: '/search', 
        component: search,  
        name: 'search_page',
        async beforeEnter(to, from, next) { 
            change_page_title("Search");
            next();
       },                     
     },
    ///settings page==//
     {
        path: '/set-up', 
        component: settings,  
        name: 'settings_page',
        async beforeEnter(to, from, next) { 
            change_page_title("General setup");
            next();
       },                     
     },

    ///=== LIVE MAP ==//
    {
        path: '/map', 
        component: live_map,  
        name: 'map_page',
        async beforeEnter(to, from, next) { 
            //change_page_title("Live Map ");
            next();
       },                     
    },

    ///=== show menu ==//
    {
        path: '/#', 
        component: menu,  
        name: 'menu_page',
        async beforeEnter(to, from, next) { 
            //change_page_title("Menu");
            next();
       },                     
    },

    ///===Not found ==//
    {
        path: '*', 
        component: page_not_found,  
        name: 'not_found_page',
        async beforeEnter(to, from, next) {
            change_page_title("Page Not Found"); 
            next();
       },                     
    },

   // //===ORGANIZATION/NGO SUPPORT ===///
   // {
   //     path: '/support/requests',  
   //     component: offer_support_page, 
   //     name: 'offer_support_page',
   //     async beforeEnter(to, from, next) {
   //         change_page_title("Offer Support");
   //         user_access.user_is_authenticated(next);
   //    },                     
   // },
]
}
