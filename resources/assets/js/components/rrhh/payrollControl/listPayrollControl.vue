<template>

    <div class="col-md-12">
        <div class="panel panel-default">
            <!-- <div class="panel-heading"><h4>{{namePanelList}}</h4></div> -->

            <div class="table-responsive text-center">
                <table class="table table-striped table-bordered text-center">
                    <thead>
                        <tr>
                            <th>N.</th>
                            <th>PAIS</th>
                            <th>EMPRESA</th>
                            <th>TIPO DE NOMINA</th>
                            <th>AÑO</th>
                            <th>PEROÍDO</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody v-if="objPayrollCOntrol.length > 0">
    
                        <tr v-for="(payrollcontro, index) in objPayrollCOntrol" :key="payrollcontro.hrpayrollControlId">
                            <td >{{index + 1}}</td>
                            <td class="form-inline">
                                <p class="text-left">
                                    {{payrollcontro.countryName}}
                                </p>
                            </td>
                            <td > 
                                <p class="text-left">
                                    {{payrollcontro.companyName}} 
                                </p>
                            </td>
                            <td>
                                <p class="text-left">
                                    {{payrollcontro.payrollTypeName}}
                                </p>
                            </td>
                            <td>
                                {{payrollcontro.year}}
                            </td>
                            <td>
                                <p class="text-left">
                                    {{payrollcontro.payrollName}} 
                                </p>
                            </td>
                            <td> 
                                <button v-on:click="editRow(index, payrollcontro.hrpayrollControlId)" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-edit"></i> Procesar</button>  
                                <button v-on:click="deleterow(index, payrollcontro.hrpayrollControlId)" class="btn btn-sm btn-danger"><i class="fa fa-times-circle"></i> Eliminar</button>  
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr>
                            <td colspan="9">
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
            namePanelList: {
                type: String,
                default: 'Name defauld',
            },
            objPayrollCOntrol:{},
        },
        methods: {
            editRow(index, id){
                
                // paso solamente el index para enviar al formulario el objeto del indice seleccionado,
                // de esta manera no tengo que buscar los datos en la DB nuevamente
              
                this.$emit("indexEdit",index)
            },
            deleterow(index, id){
                // console.log('index ' + index)
                // console.log('id ' + id)
                // return
                const indexIs = this.objPayrollCOntrol[index]
            
                if (confirm("Delete?") ){
                    axios.delete(`payrollcontrol/${id}`).then((res)=>{
                        // console.log(res)
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
<style>
    /* td{
        padding: 4px 0 0 2px !important;
    } */
</style>