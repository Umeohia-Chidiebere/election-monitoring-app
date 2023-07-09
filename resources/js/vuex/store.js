import Vue from "vue";
import Vuex from "vuex";
import api from '../api'; 

Vue.use(Vuex); 

export default new Vuex.Store({
    state:{
        all_elections:[], latest_election: {}, current_user:{}, app_data: {}
    },

    mutations:{
        set_elections: (state, {election_data} ) => {
            state.all_elections = election_data.all_elections;
            state.latest_election = election_data.latest_election;
        },

        set_user_info: ( state, {user_info}) => {
            state.current_user = user_info;
        },

        set_app_data: ( state, {app_data}) => {
            state.app_data = app_data;
        }
      
    }, 

    actions:{ 
        fetch_elections: ( {commit}, $data = '') => {
                 api.fetch_elections( $data )
                    .then( response => {
                        if( response.data.error ) return; //alert_error_msg( response.data.error );
                        commit('set_elections', {election_data: response.data });
                     })
                    .catch( err => { 
                       // return alert_network_error();
                     });
        },

        fetch_app_data: ( {commit}, $data = '') => {
                api.fetch_app_data( $data )
                    .then( response => {
                        if( response.data.error ) return; //alert_error_msg( response.data.error );
                        commit('set_app_data', {app_data: response.data });
                     })
                    .catch( err => { 
                       // return alert_network_error();
                     });
        },

        fetch_current_user: ( {commit} ) => {
            api.fetch_user_info()
               .then( response => {
                   if( response.data.error ) return; //alert_error_msg( response.data.error );
                   commit('set_user_info', {user_info: response.data });
                })
               .catch( err => { 
                  // return alert_network_error();
                });
   } 
    }
});

