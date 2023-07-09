<template>
    <section >
     <nav-bar :page_title="page_title" />
         <v-main>  
                 <slot />
          </v-main>   
     <footer-nav-bar :page_title="page_title"/>
    </section>
  </template>
 
 <script>
 import footerNavBar from "./footer/index.vue";
 import navBar from "./navbar/index.vue";
 import sidebar from "./sidebar.vue";
 
 export default { 
     props: ['page_title'],
     components: { footerNavBar, navBar, sidebar},
     data(){
             return {}
         }
  }
 </script>
 