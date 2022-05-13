<template>
<div>

   <div class="panel panel-default col-xs-12">

        <div class="panel-heading">
            <form class="form-inline">
               <div class="form-group">
                 <label for="exampleInputName2"><h4><b>PRESUPUESTOS: </b></h4></label>
                 <select v-model="entity" class="form-control" name="unit" id="unit">
                      <option value="budget">De Costo</option>
                      <option value="proposal">De Venta</option>
                 </select>
               </div>
             </form>
         </div>


        <div v-if="entity == 'budget'">
           <main-contract-budget/>
        </div>

        <div v-if="entity == 'proposals'">
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
             entity:'budget',
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