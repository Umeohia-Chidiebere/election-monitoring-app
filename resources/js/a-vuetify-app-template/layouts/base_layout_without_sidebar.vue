<template>
    <section>
     <nav-bar />
         <slot />
     <footer-nav-bar />
    </section>
  </template>
 
  <script>
 import footerNavBar from "./footer/index.vue";
 import navBar from "./navbar/index.vue";
 
 export default { 
     components: { footerNavBar, navBar },
     data(){
             return {}
         }
  }
 </script> 