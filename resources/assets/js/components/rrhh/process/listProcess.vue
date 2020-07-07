<template>

    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <!-- <div class="panel-heading"><h4>{{namePanelList}}</h4></div> -->

            <div class="table-responsive text-center">
                <table class="table table-striped table-bordered text-center">
                    <thead>
                        <tr>
                            <th>N.</th>
                            <th>Codigo</th>
                            <th>Nombre del Proceso</th>
                            <th>Pais</th>
                            <th>Empresa</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody v-if="objProcess.length > 0">
    
                        <tr v-for="(Process, index) in objProcess" :key="Process.hrprocessId">
                            <td >{{index + 1}}</td>
                            <td class="form-inline">
                                
                                    {{Process.processCode}}
                                
                            </td>
                            <td > 
                                <p class="text-left">
                                    {{Process.processName}}
                                </p> 
                            </td>
                            <td>
                                <p class="text-left">
                                    {{Process.countryName}}
                                </p>
                            </td>
                            <td>
                                <p class="text-left">
                                    {{Process.companyShortName}}
                                </p>
                            </td>
                            <td> 
                                <button v-on:click="detailRow(index, Process.hrprocessId)" class="btn btn-sm btn-info" title="Ver Detalle"><i class="glyphicon glyphicon-th-list"></i> </button>  
                                <button v-on:click="editRow(index, Process.hrprocessId)" class="btn btn-sm btn-primary" title="Editar"><i class="fa fa-edit"></i> </button>  
                                <button v-on:click="deleterow(index, Process.hrprocessId)" class="btn btn-sm btn-danger" title="Eliminar"><i class="fa fa-times-circle"></i></button>  
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr>
                            <td colspan="6">
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
            objProcess:{},
        },
        methods: {
            detailRow(index, id){
                
                const objEditProcessDetail = this.objProcess[index]
                // console.log(id)
              
                this.$emit("processDetail", objEditProcessDetail)
            },
            editRow(index, id){
                
                // paso solamente el index para enviar al formulario el objeto del indice seleccionado,
                // de esta manera no tengo que buscar los datos en la DB nuevamente
              
                this.$emit("indexEdit",index)
            },
            deleterow(index, id){
                // console.log('index ' + index)
                // console.log('id ' + id)
                // return
                // const indexIs = this.objProcess[index]
            
                if (confirm("Delete?") ){
                    axios.delete(`process/delete/${id}`).then((res)=>{
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