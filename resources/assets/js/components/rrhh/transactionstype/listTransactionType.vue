<template>

    <div class="col-md-12">
        <div class="panel panel-default">
            <!-- <div class="panel-heading"><h4>{{namePanelList}}</h4></div> -->

            <div class="table-responsive text-center">
                <table class="table table-striped table-bordered text-center">
                    <thead>
                        <tr>
                            <th>N.</th>
                            <th>Pais</th>
                            <th>Empresa</th>
                            <th>Codigo</th>
                            <th>Tipo de transaccion</th>
                            <th>Salario base</th>
                            <th>Trans. de ingreso</th>
                            <th>Trans. con saldo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
    
                        <tr v-for="(hrTansType, index) in objHrTansType" :key="hrTansType.hrtransactionTypeId">
                            <td >{{index + 1}}</td>

                            <td class="form-inline">  
                        
                                {{hrTansType.countryName}} 
                            </td>
                            <td>
                                {{hrTansType.companyName}}
                            </td>
                            <td>
                                {{hrTansType.transactionTypeCode}}
                            </td>
                            <td>
                                {{hrTansType.transactionTypeName}} 
                            </td>
                            <td>
                                <p v-if="hrTansType.salaryBased === 0">No</p>
                                <p v-else>Si</p>
                                
                            </td>
                            <td>
                                <p v-if="hrTansType.isIncome === 0">No</p>
                                <p v-else>Si</p>
                            
                            </td>
                            <td>
                                <p v-if="hrTansType.hasBalance === 0">No</p>
                                <p v-else>Si</p>
                            </td>
                            
                            <td> 
                                <button v-on:click="editRow(index, hrTansType.hrtransactionTypeId)" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-edit"></i> </button>  
                                <button v-on:click="deleterow(index, hrTansType.hrtransactionTypeId)" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></button>  
                            </td>
                        </tr>
                    </tbody>
                </table> 
            </div><!-- table-responsive text-center -->
        </div>
    </div>
        
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        data(){
            return{

            }
        },
        props: {
            namePanelList: {
                type: String,
                default: 'Name defauld',
            },
            objHrTansType:{},
        },
        methods: {
            editRow(index, id){
                
                // paso solamente el index para enviar al formulario el objeto del indice seleccionado,
                // de esta manera no tengo que buscar los datos en la DB nuevamente
              
                this.$emit("indexEdit",index)
            },
            deleterow(index, id){
                // console.log('index ' + index)
                // console.log(id)
                // return
                const indexIs = this.objHrTansType[index]
            
                if (confirm("Delete?") ){
                    axios.delete(`transactionstypes/delete/${id}`).then(()=>{

                        this.$emit("delrow",[index,id])
                    })
                    .catch(function (error) {
                        alert("Error")
                        console.log(error);
                    });
                }
                
                // console.log('enviado')
            }
        }
    }
</script>