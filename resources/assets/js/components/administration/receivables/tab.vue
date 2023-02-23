<template>
<div>

   <div class="panel panel-default col-xs-12">

        <div class="panel-heading">
            <form class="form-inline">
               <div class="form-group">
                 <label for="exampleInputName2"><h4><b>CUENTAS POR COBRAR: </b></h4></label>
                 <select v-model="entity" class="form-control" name="unit" id="unit">
                      <option value="customers">Clientes</option>
                      <option value="partners">Socios</option>
                      <option value="employees">Empleados</option>
                 </select>
               </div>
             </form>
         </div>


        <div v-if="entity == 'customers'">
           <receivables-from-clients/>
        </div>

        <div v-if="entity == 'partners'">
            <!-- <receivables-from-clients/> --> 
        </div>

        <div v-if="entity == 'employees'">
            <!-- <receivables-from-clients/> -->
        </div>

    </div>

</div>
</template>

<script>
    export default {
        mounted() {

        },
        data() {
            return{
             entity:'customers',
            }
        },
     methods: {
    //    changeEntity(n){
    //             this.formStatus = 0
    //             axios.get('/receivables').then((response) => {
    //                 this.receivableList = response.data
    //                 // console.log(this.receivableList)
    //             })
    //         },  
        
     }
    }
</script>