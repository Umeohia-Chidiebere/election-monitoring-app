<template>
<section>

    <baseLayout page_title="Reports">

        <section class="row pt-3">
            <div class="col-md-3">
                <a @click="create_post" class="btn text-muted text-decoration-none">
                    <v-icon>mdi-plus</v-icon> Create Report
                </a>
            </div>

            <div class="col-md-3">
                <v-select label="Filter by Election" v-model="filter_record.election_id" placeholder="Election" color="green" :items="app_data.all_elections" item-text="full_details" item-value="id" @change="filter_posts" required>
                </v-select>
            </div>

            <div class="col-md-3">
                <v-select label="Filter by Polling unit" v-model="filter_record.polling_unit_id" placeholder="Polling unit" color="green" :items="app_data.all_polling_units" item-text="name" item-value="id" @change="filter_posts" required>
                </v-select>
            </div>
            <div class="col-md-3">
                <v-select label="Filter by Category" v-model="filter_record.category" placeholder="Category" color="green" :items="app_data.report_category" @change="filter_posts" required>
                </v-select>
            </div>
           
        </section>

        <skeletonLoader v-if="is_loading" />

        <section v-else>

            <div class="row">
                <section class="col-md-2"></section>

                <section class="col-md-8">
                    <v-card v-for="post in app_data.all_posts" :key="post.id" class="mx-auto my-3" :to="{name:'view_post_page', params:{code_number:post.code_number}}">
                        <template slot="progress">
                            <v-progress-linear color="deep-purple" height="10" indeterminate></v-progress-linear>
                        </template>

                        <section v-if="post.docs.length">
                            <mediaPlayer :file_type="post.docs[0].file_type" :file_name="post.docs[0].file_name" />
                        </section>

                        <v-card-subtitle>
                            <h6><i class="fa fa-user-circle"></i> {{ post.user.name }} . <small class="text-muted">{{ post.created_at }}</small></h6>
                            <small> <b>Category: </b> {{ post.category ?? '-'}}</small> | 
                            <small> <b>Polling unit: </b> {{ post.polling_unit.name ?? '-'}}</small>
                        </v-card-subtitle>

                        <v-card-text>
                            {{ $short_text(post.content, 200) }}
                        </v-card-text>

                        <hr>

                        <v-card-text>
                            <v-chip-group active-class="deep-green accent-4" column>
                                <v-chip>{{ post.comments.length }} Responses</v-chip>

                                <v-chip>{{ post.docs.length }} Attached files</v-chip>
                            </v-chip-group>
                        </v-card-text>

                    </v-card>
                </section>

                <section class="col-md-2"></section>
            </div>

        </section>

    </baseLayout>

</section>
</template>

<script>
import baseLayout from "../../layouts/base_layout.vue";
import skeletonLoader from "../../layouts/skeleton_loader.vue";
import {
    mapState
} from "vuex";
import mediaPlayer from "../../layouts/media_player.vue";

export default {
    components: {
        baseLayout,
        skeletonLoader,
        mediaPlayer
    },
    data() {
        return {
            is_loading: true,
            filter_record: {
                polling_unit_id: '',
                election_id: '',
                category:''
            }
        }
    },
    computed: {
        ...mapState(['app_data'])
    },

    methods: {
        create_post() {
            return this.$router.push({
                name: 'create_post_page'
            });
        },

        filter_posts() {
            this.is_loading = true;
            var data = {
                filter_post: 1,
                polling_unit_id: this.filter_record.polling_unit_id,
                election_id: this.filter_record.election_id,
                category: this.filter_record.category,
            };
            this.fetch_app_data_(data);
        },

        fetch_app_data_(data = '') {
            this.$store.dispatch("fetch_app_data", data);
            this.is_loading = false; 
        }
    },

    mounted() {
        this.fetch_app_data_();
    }
}
</script>
