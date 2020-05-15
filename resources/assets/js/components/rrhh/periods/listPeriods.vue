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
                            <th >Pais</th>
                            <th>Empresa</th>
                            <th>Año</th>
                            <th>Tipo de Nomina</th>
                            <th>Desde</th>
                            <th>Hasta</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
    
                        <tr v-for="(Periods, index) in objPeriods" :key="Periods.periodId">
                            <td >{{index + 1}}</td>
                            <td class="form-inline">
                                {{Periods.periodName}}
                            </td>
                            <td > 
                                
                                    {{Periods.countryName}} 
                               
                            </td>
                            <td>
                                {{Periods.companyShortName}}
                            </td>
                            <td>
                                {{Periods.year}}
                            </td>
                            <td>
                                {{Periods.payrollTypeName}} 
                            </td>
                            <td>
                                {{Periods.periodFrom}}
                            </td>
                            <td>
                                {{Periods.periodTo}}
                            </td>
                            
                            <td> 
                                <button v-on:click="editRow(index, Periods.periodId)" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-edit"></i> </button>  
                                <button v-on:click="deleterow(index, Periods.periodId)" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></button>  
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
            objPeriods:{},
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
        }
    }
</script>