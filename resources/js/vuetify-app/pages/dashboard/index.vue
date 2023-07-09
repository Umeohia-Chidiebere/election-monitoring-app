<template>
    <section>
     <baseLayout page_title="Election Live Report">   

      <v-card>

        <v-tabs v-model="tab" background-color="green" color="white" dark>
  
  <v-tab id="governorship_election">
    Governorship Election
  </v-tab>

  <v-tab id="presidential_election">
   Presidential Election
  </v-tab> 

  <v-tab id="senatorial_election">
   Senatorial Election
  </v-tab>

  <v-tab id="house_of_rep_election">
   House of Rep
  </v-tab> 

  <v-tab id="house_of_assembly_election">
   House of Assembly
  </v-tab> 

</v-tabs>

<v-tabs-items v-model="tab">
 
  <v-tab-item>
    <governorship :key="component_key" />
  </v-tab-item>

  <v-tab-item>
    <presidential :key="component_key" />
  </v-tab-item>

  <v-tab-item>
    <senatorial :key="component_key" />
  </v-tab-item>

  <v-tab-item>
    <house_of_rep :key="component_key" />
  </v-tab-item>

  <v-tab-item>
    <house_of_assembly :key="component_key" />
  </v-tab-item>

</v-tabs-items>

      </v-card>

    <v-snackbar v-model="snackbar" timeout="5000">
        {{ response_msg }}
  
        <template v-slot:action="{ attrs }">
          <v-btn color="red" text v-bind="attrs" @click="snackbar = false">  Close </v-btn>
        </template>
  </v-snackbar>
  
    </baseLayout>
    </section>
  </template> 
  
  <script>
  import baseLayout from "../../layouts/base_layout_without_sidebar.vue";
  import governorship from "./governorship.vue";
  import presidential from "./presidential.vue";
  import senatorial from "./senatorial.vue";
  import house_of_rep from "./house_of_rep.vue";
  import house_of_assembly from "./house_of_assembly.vue";

  export default {
         components: { baseLayout, governorship, presidential, senatorial, house_of_rep, house_of_assembly },
         data(){
             return {
              tab: null, dialog:false, response_msg:'', snackbar: false, component_key:1             
            }
         },
  
         methods:{
            auto_navigate_to_tab(){
              setTimeout(() => {
                var tab = this.$route.query.tab;
                $(`#${tab}`).click();
              }, 1000);
            },
          
         },
  
         mounted(){
            this.auto_navigate_to_tab();
         }
     }
  </script>
  