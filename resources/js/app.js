require('./bootstrap'); 

window.Vue = require('vue').default;
require('./helpers/app.js');
import VueRouter from "vue-router";
import routes from "./routes.js";
import store from "./vuex/store.js"; 
import vuetify from './vuetify.js';

Vue.use(VueRouter); 

new Vue({
//  mixins:[current_user_info],
  el: '#v-app', 
  store,
  vuetify,
  router: new VueRouter(routes),
  updated(){
      //select_2();
     this.close_modal();
     // $('.modal').modal({backdrop:'static',keyboard:false, show:false});`
      $('.modal').on('show.bs.modal', function(e) {
          window.location.hash = "modal";
      });
      $(window).on('hashchange', function (event) {
          if(window.location.hash != "#modal") {
              $('.modal').modal('hide'); 
          }
      });
  }, 

  methods:{
    close_modal(){
      $('.close').on('click', () => {   
        $('.modal').modal('hide');
      });
    }
  },

  mounted(){

  }

});
