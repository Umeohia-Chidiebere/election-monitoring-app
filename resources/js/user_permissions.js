import api from './api';
let fetch_data = api.fetch_user_info();
let homepage = route('homepage') ;
export default{
    mixins: [],
    is_user(next){
      fetch_data.then( response => {
        return (response.data.role.slug != "user") ? next() : window.location.href = '/auth/profile';
      });
    },

    is_authenticated(next){
      fetch_data.then( response => {
              if( response ) return next();
              return window.location = homepage;
            })
            .catch( err => {
              return window.location = homepage;
            });
    },

    is_general_admin(next){
      fetch_data.then( response => {
        return (response.data.role.slug == "general_admin") ? next() : window.location = homepage;
      });
    },

    is_super_admin(next){
      fetch_data.then( response => {
        return (response.data.role.slug == "super_admin") ? next() : window.location = homepage;
      });
    }, 

    is_state_admin(next){
      fetch_data.then( response => {
        return (response.data.role.slug == "state_admin") ? next() : window.location = homepage;
      });
    }, 

    is_zonal_admin(next){
      fetch_data.then( response => {
        return (response.data.role.slug == "zonal_admin") ? next() : window.location = homepage;
      });
    }, 

    is_lga_admin(next){
      fetch_data.then( response => {
        return (response.data.role.slug == "lga_admin") ? next() : window.location = homepage;
      });
    }, 
    
    is_ward_admin(next){
      fetch_data.then( response => {
        return (response.data.role.slug == "ward_admin") ? next() : window.location = homepage;
      });
    }
}
