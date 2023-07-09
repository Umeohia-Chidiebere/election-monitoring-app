<template>
    <div>
        
<img v-if="file_type == 'image'" :src="`${post_folder}${file_name}`" class=" img-thumbnail" style="width:100%; max-height:300px;"/>

<video v-else-if="file_type == 'video'" :poster="app_logo" controls name="media" class=" img-thumbnail" style="width:100%; max-height:300px;"> 
    <source :src="`${post_folder}${file_name}`" type="video/mp4">
    Your broswer doesn't support this video... 
</video>

<video v-else-if="file_type == 'audio'" :poster="app_logo" controls name="media" class=" img-thumbnail" style="width:100%; max-height:300px;"> 
    <source :src="`${post_folder}${file_name}`" type="audio/mp3">
    Your broswer doesn't support this audio... 
</video>

    </div>
</template>

<script>
    export default {
        data(){
            return {}
        },
        props: ['file_type', 'file_name'],
    }
</script>