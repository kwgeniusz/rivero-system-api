<template>

    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <!-- <div class="panel-heading"><h4>{{namePanel}}</h4></div> -->

            <div class="table-responsive text-center">
                <table class="table table-striped table-bordered text-center">
                    <thead>
                        <tr>
                            <th>N</th>
                            <th>Nombre del tipo de nomina</th>
                            <th>Descripcion del tipo de nomina</th>
                            <th>Pais</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody v-if="objPayRollType.length > 0">
    
                        <tr v-for="(payrollType, index) in objPayRollType" :key="payrollType.payrollTypeId">
                            
                            <td >{{index + 1}}</td>
                            <td class="form-inline">  
                                <p class="text-left">
                                    {{payrollType.payrollTypeName}} 
                                
                                </p>
                            </td>
                            <td>
                                <p class="text-left">
                                    {{payrollType.payrollTypeDescription}}
                                </p>
                            </td>
                            <td>
                                <p class="text-left">
                                    {{payrollType.countryName}}
                                </p>
                            </td>
                            
                            <td> 
                                <button v-on:click="editPayrollType(index, payrollType.payrollTypeId)" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></button>  
                                <button v-on:click="deletePayrollType(index,payrollType.payrollTypeId)" class="btn btn-sm btn-danger"><i class="fa fa-times-circle"></i></button>  
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr>
                            <td colspan="5">
                                <loading></loading>
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
            namePanel: {
                type: String,
                default: 'Listado tipo de Nomina',
            },
            objPayRollType:{},
        },
        methods: {
            editPayrollType(index, id){
                // paso solamente el index para pasar al formulario el objeto del indice seleccionado,
                // de esta manera no tengo que buscar los datos en la DB nuevamente
                this.$emit("indexEdit",index)
                // console.log('enviado')
            },
            deletePayrollType(index,id){
                // console.log(index)
                // const indexIs = this.objPayRollType[index]
            
                if (confirm("Delete?") ){
                    axios.delete(`payrolltypes/delete/${id}`).then(()=>{

                        this.$emit("delPayrollType",[index,id])
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