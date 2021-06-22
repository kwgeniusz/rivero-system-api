<template>
<div>

 <h3><b>CUENTAS POR COBRAR</b></h3>

<vue-tabs class="bg-info" type="pills"  centered @tab-change="handleTabChange">
    <v-tab title="CLIENTES" icon="ti-user">
            <receivables-from-clients/>
    </v-tab>

    <v-tab title="SOCIOS" icon="ti-settings">

    </v-tab>

    <v-tab title="EMPLEADOS" icon="ti-check">
       
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