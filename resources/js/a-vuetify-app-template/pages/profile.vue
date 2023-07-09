<template>
   <section>
    <v-container fluid>
        <baseLayout page_title="Profile">
       <p class=""> chidi profile without sidebar</p>

   </baseLayout>
    </v-container>
    
   </section>
</template>


<script>
import baseLayout from "../layouts/base_layout.vue";
import baseLayoutWithoutSidebar from "../layouts/base_layout_without_sidebar.vue";
    export default {
        components: { baseLayout, baseLayoutWithoutSidebar },
        data(){
            return {}
        }
    }
</script>
