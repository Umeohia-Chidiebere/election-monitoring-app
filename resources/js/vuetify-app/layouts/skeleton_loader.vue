<template>
    <div>
        <v-skeleton-loader
           v-bind="attrs"
           type="card-avatar, article, actions"
         ></v-skeleton-loader>
 
         <v-skeleton-loader
           v-bind="attrs"
           type="date-picker"
         ></v-skeleton-loader>
    </div>
</template>

<script>
    export default {
        
    }
</script>