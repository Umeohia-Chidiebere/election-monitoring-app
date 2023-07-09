<template>
<section>
    <baseLayout page_title="View Report">

        <v-snackbar v-model="snackbar" timeout="5000">
            {{ response_msg }}

            <template v-slot:action="{ attrs }">
                <v-btn color="red" text v-bind="attrs" @click="snackbar = false"> Close </v-btn>
            </template>
        </v-snackbar>

        <v-container fluid>
            <skeletonLoader v-if="is_loading" />

            <v-card outlined v-else>
                
                <v-card-text>
                    <div class="row">
                        <div class="col-md-3"> Category: {{ post.category ?? '-'}} </div>
                        <div class="col-md-4"> Reported by: {{ post.user.name ?? '-'}} </div>
                        <div class="col-md-2"> P.U: {{ post.polling_unit.name ?? '-'}} </div>
                        <div class="col-md-3"> Date: {{ post.created_at ?? '-'}} </div>
                    </div>
                    <hr>

                    <p class="text_pre_line text-muted"> {{ post.content }} </p>
                    <div v-if="post.docs" class="row py-2 px-3">
                        <section class="col-md-6" v-for="media in post.docs" :key="media.file_name">
                            <mediaPlayer :file_name="media.file_name" :file_type="media.file_type" />
                        </section>
                    </div>

                    <section class="py-5" id="reply">
                        <h6> Responses({{ post.comments.length }})</h6>

                        <v-textarea v-model="comment_msg" append-outer-icon="mdi-send" clear-icon="mdi-close-circle" clearable label="Leave a response here..." rows="2" @click:append-outer="store_comment"></v-textarea>

                        <hr>

                        <v-timeline :reverse="reverse" dense outline shaped >
                            <v-timeline-item v-for="comment in post.comments" :key="comment.id">
                                <span slot="opposite" color='green'></span>
                                <v-card class="elevation-2">
                                    <v-card-subtitle>
                                        <h6> {{ comment.user.name ?? '-' }}</h6>
                                        <p><small> {{ comment.created_at }} . <a href="#reply"> Respond</a></small></p>
                                    </v-card-subtitle>
                                    <v-card-text class="text_pre_line">
                                        {{ comment.content }}
                                    </v-card-text>
                                </v-card>
                            </v-timeline-item>
                        </v-timeline>

                    </section>
                </v-card-text>
            </v-card>
        </v-container>

    </baseLayout>
</section>
</template>

<script>
import baseLayout from "../../layouts/base_layout.vue";
import api from "../../../api.js";
import skeletonLoader from '../../layouts/skeleton_loader.vue';
import mediaPlayer from "../../layouts/media_player.vue";

export default {
    components: {
        baseLayout,
        skeletonLoader,
        mediaPlayer
    },

    data() {
        return {
            post: {},
            is_loading: true,
            is_processing: false,
            snackbar: false,
            response_msg: '',
            comment_msg: ""
        }
    },

    methods: {
        view_post() {
            var code_number = this.$route.params.code_number;
            var data = {
                type: 'single_post',
                code_number: code_number
            };
            api.fetch_app_data(data)
                .then(response => {
                    this.is_loading = false;
                    this.post = response.data;
                })
                .catch(err => {
                    this.snackbar = true;
                    this.response_msg = "Network error !";
                    this.view_post();
                });
        },

        store_comment() {
            if( ! this.comment_msg ){
                this.response_msg = "Please, write something before submitting...";
                return this.snackbar = true;
            }
            var data = { store_post:1, content: this.comment_msg, post_id: this.post.id, type: 'comment'};
            api.store_app_data( data )
               .then( response => {
                if( response.data.error ){
                    this.response_msg = response.data.error;
                    return this.snackbar = true;
                }
                this.view_post();
               });
        }
    },

    mounted() {
        this.view_post();
    }
}
</script>
