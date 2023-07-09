<template>
    <section>
     <baseLayout page_title="Menu">
        <menuList />
    </baseLayout>
    </section>
 </template>
 
 <script>
 import baseLayout from "../layouts/base_layout.vue";
 import menuList from "../pages/menu_list.vue";
     export default {
         components: { baseLayout, menuList},
         data(){
             return {}
         }
     }
 </script>
 