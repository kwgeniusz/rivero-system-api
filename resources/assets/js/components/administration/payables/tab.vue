<template>
<div>

   <h3><b>CUENTAS POR PAGAR</b></h3>

    <vue-tabs class="bg-info" type="pills" centered @tab-change="handleTabChange">

    <v-tab title="SUBCONTRATISTAS" icon="ti-user">
            <main-subcontractor/>
    </v-tab>

    <v-tab title="SOCIOS" icon="ti-settings">
            <!-- <main-subcontractor/> -->
    </v-tab>

    <v-tab title="CLIENTES" icon="ti-check">
            <!-- <main-subcontractor/> -->
    </v-tab>

    <v-tab title="EMPLEADOS" icon="ti-check">
      <div class="panel panel-default">
           <div class="panel-body">
             <!-- <main-subcontractor/> -->
          </div>
        </div>
    </v-tab>
</vue-tabs>

 </div>         
</template>

<script>
    export default {
        mounted() {

        },
        data() {
            return{
             
            }
        },
     methods: {

        
     }
    }
</script>