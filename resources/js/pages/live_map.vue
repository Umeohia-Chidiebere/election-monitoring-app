<template>
    <section>

        <div>
              <form action="?" class="post">
                <label for=""></label>
                <select @change="filter_election" class="form-control">
                    <option value="" id="election_options"> - Select Election - </option>
                    <option v-for="election in all_elections" :value="election.code_number" :key="election.id">
                        {{ election.year }} {{ election.state.name }} {{ election.election_type.name }}
                    </option>
                </select>
              </form>
              <br>       
            </div>

        <div class="card-body">

            <div :id="'map_'+latest_election.code_number"></div>

        </div>

    </section>
</template>

<script>
import { mapState } from "vuex";
// import api from "./../api.js"
export default {
    data(){
        return {}
    },

     computed: {
           ...mapState([ "latest_election", "all_elections" ]), 
     },

    methods:{
        async _fetch_elections() {
            var code_number = this.$route.query.code;
            var url_query = `code=${code_number}&filter=1&rec=1`;
            var query = '';
            if (code_number) query = url_query;
            // await api.fetch_elections( query ).then( response => {
            //       this.latest_election = response.data.latest_election;
            //       this.all_elections = response.data.all_elections;
            // })
            // .catch( err => { alert('Network error !')});
            await this.$store.dispatch("fetch_elections", query);
        },

        async filter_election(e) {
            var data = e.target.value;
            clearInterval(this.live_data() );
            this.$router.push({
                name: "map_page",
                query: {
                    code: data,
                    filter: 1
                }
            });
            await this._fetch_elections();
            this.show_map();
            window.location.reload();
        },

        show_map(){
            setTimeout(() => {
                var geo = {};
                var data_ = this.latest_election.result_by_polling_units;
                 data_.forEach((value) => {
                    if( value.latitude ) geo = {'latitude': value.latitude, 'longitude': value.longitude };
                 }); 
               const map = L.map("map_"+this.latest_election.code_number).setView([geo.latitude, geo.longitude], 5);

	 L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
	 	// attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
	 }).addTo(map);

	const LeafIcon = L.Icon.extend({
		options: {
			//shadowUrl: map_marker_shadow,
			iconSize:     [25, 50],
			//shadowSize:   [50, 64],
			iconAnchor:   [18, 80],
			shadowAnchor: [4, 62],
			popupAnchor:  [-3, -76]
		}
	});

	const map_location_icon = new LeafIcon({iconUrl: map_marker});
	//const redIcon = new LeafIcon({iconUrl: map_marker2 });
	//const orangeIcon = new LeafIcon({iconUrl: map_marker});

            data_.forEach((value) => {
                var $details = ` P.U: ${value.polling_unit_name}<hr>
                                 Valid votes: ${number_format(value.valid_votes)}<br>
                                 InValid votes: ${ number_format(value.invalid_votes) }<br>
                                 Total votes: ${number_format(value.total_votes)}<hr>
                                 APC votes: ${number_format(value.apc_votes)}<br>
                                 LP votes: ${number_format(value.lp_votes)}<br>
                                 NNPP votes: ${number_format(value.nnpp_votes)}<br>
                                 PDP votes: ${number_format(value.pdp_votes)}
                                `;
                    L.marker([value.latitude, value.longitude], {icon: map_location_icon})
                     .bindPopup($details).addTo(map);
                 }); 

            }, 3000);
        },

        live_data() {
            setInterval(() => {
                this._fetch_elections();
                this.show_map();
            }, 10000);
        },
        
    },

    mounted(){
        this._fetch_elections();
        this.show_map();
    }
}
</script>

<style scope>
.leaflet-container {
			height: 450px;
			width: cover;
		}

</style>
