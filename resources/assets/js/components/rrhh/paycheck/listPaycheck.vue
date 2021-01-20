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
                            <th>Nombre</th>
                            <th>Documento de identidad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody v-if="objRecipt.length > 0">
    
                        <tr v-for="(Process, index) in objRecipt" :key="Process.hrprocessId">
                            <td >{{index + 1}}</td>
                            <td class="form-inline">
                                {{Process.staffCode}}
                            </td>
                            <td > 
                                {{Process.shortName}} 
                            </td>
                            <td>
                                {{Process.idDocument}}
                            </td>
                            <td> 
                                <button v-on:click="detailRow(index,Process.staffCode)" class="btn btn-sm btn-info" title="Ver Detalle"><i class="glyphicon glyphicon-th-list"></i> </button>  
                                <button v-on:click="editRow(index, Process.staffCode)" class="btn btn-sm btn-primary" title="Editar"><i class="fa fa-edit"></i> </button>  
                                <button v-on:click="deleterow(index, Process.staffCode)" class="btn btn-sm btn-danger" title="Eliminar"><i class="fa fa-times-circle"></i></button>  
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr>
                            <td v-if="this.lengths === 0" colspan="5">
                                No hay datos registrados
                            </td>
                            <td v-else colspan="5">
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
            
        },
        data(){
            return{
                objReciptStaff:{},
            }
        },
        props: {
            namePanelList: {
                type: String,
                default: 'Name defauld',
            },
            objRecipt:{},
            lengths:'',
        },
        methods: {
            detailRow(index,staffCode){
                axios.get(`history-receipt/${staffCode}`).then( response => {
                    this.objReciptStaff = response.data
                    const objEditProcessDetail = [this.objRecipt[index],this.objReciptStaff]
                    // console.log(objEditProcessDetail)
                    // debugger
                    this.$emit("processDetail", objEditProcessDetail)
                })
                // console.log(id)
            //   return
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
                // const indexIs = this.objRecipt[index]
            
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