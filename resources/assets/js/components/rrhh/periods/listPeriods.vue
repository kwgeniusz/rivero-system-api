<template>

    <div class="col-md-12">
        <div class="panel panel-default">
            <!-- <div class="panel-heading"><h4>{{namePanelList}}</h4></div> -->

            <div class="table-responsive text-center">
                <table class="table table-striped table-bordered text-center">
                    <thead>
                        <tr>
                            <th>N.</th>
                            <th>Nombre del periodo</th>
                            <th>Pais</th>
                            <th>Empresa</th>
                            <th>Año</th>
                            <th>Tipo de Nomina</th>
                            <th>Desde</th>
                            <th>Hasta</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody v-if="objPeriods.length > 0">
    
                        <tr v-for="(Periods, index) in objPeriods" :key="Periods.periodId">
                            <td >{{index + 1}}</td>
                            <td class="form-inline">
                                <p class="text-left">
                                    {{Periods.periodName}}
                                </p>
                            </td>
                            <td > 
                                <p class="text-left">
                                    {{Periods.countryName}} 
                                </p>
                            </td>
                            <td>
                                <p class="text-left">
                                    {{Periods.companyShortName}}
                                </p>
                            </td>
                            <td>
                                {{Periods.year}}
                            </td>
                            <td>
                                <p class="text-left">
                                    {{Periods.payrollTypeName}} 
                                </p>
                            </td>
                            <td>
                                {{Periods.periodFrom}}
                            </td>
                            <td>
                                {{Periods.periodTo}}
                            </td>
                            
                            <td> 
                                <button v-on:click="editRow(index, Periods.periodId)" class="btn btn-sm btn-primary" title="Editar"><i class="fa fa-edit"></i> </button>  
                                <button v-on:click="deleterow(index, Periods.periodId)" class="btn btn-sm btn-danger" title="Eliminar"><i class="fa fa-times-circle"></i></button>  
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr>
                            <td colspan="9">
                                <div v-if="showLoading === true">
                                    <loading></loading>
                                </div>
                                <div v-else>
                                    No hay registros para la empresa seleccionada
                                </div>
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
            
        },
        data(){
            return{
                showLoading: true,
            }
        },
        props: {
            namePanelList: {
                type: String,
                default: 'Name defauld',
            },
            objPeriods:{},
            vacio: {
                type: Number,
                default: 0,
            },
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
                const indexIs = this.objPeriods[index]
            
                if (confirm("Delete?") ){
                    axios.delete(`periods/delete/${id}`).then(()=>{

                        this.$emit("delrow",[index,id])
                    })
                    .catch(function (error) {
                        alert("Error")
                        console.log(error);
                    });
                }
                
                // console.log('enviado')
            }
        },
        watch: {
            vacio: function(val){
                // console.log(val)
                if (val === 1) {
                    this.showLoading = false
                }
            }
        }
    }
</script>
<style>
    td{
        padding: 4px 0 0 2px !important;
    }
</style>