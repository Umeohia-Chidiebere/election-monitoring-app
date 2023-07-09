import axios from 'axios';

export default {
    async fetch_elections($data = ''){  
        return axios.get( route('fetch_elections', $data ) );
    },
    async fetch_user_info($data = ''){
        return axios.get( route('fetch_user_info', $data ) );
    },

    async fetch_app_data($data = ''){  
        return axios.get( route('fetch_app_data', $data ) );
    },

    async store_app_data( $data = ''){
        return axios.post( route('store_app_data'), $data );
    },
}
