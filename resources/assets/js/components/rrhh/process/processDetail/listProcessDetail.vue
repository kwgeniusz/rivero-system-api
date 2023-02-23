<template>

    <div class="col-md-8 col-md-offset-2">
        <!-- <div class="panel panel-default"> -->
            <!-- <div class="panel-heading"> -->
                <div class="row">
                    <div class="form-group col-md-2">
                        <h4>PROCESO: </h4>
                    </div>
                    <div class="form-group col-md-3">
                        <h4 for="companyId" class="form-group" >{{objProcessDetail.processName}}</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-2">
                        <h4>PAÍS: </h4>
                    </div>
                    <div class="form-group col-md-3">
                        <h4 for="companyId" class="form-group" >{{objProcessDetail.countryName}}</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-2">
                        <h4>EMPRESA: </h4>
                    </div>
                    <div class="form-group col-md-3">
                        <h4 for="companyId" class="form-group" >{{objProcessDetail.companyShortName}}</h4>
                    </div>
                </div>
                
            <!-- </div> -->

            <div class="table-responsive text-center">
                <table class="table table-striped table-bordered text-center">
                    <thead>
                        <tr>
                            <th>N.</th>
                            <th>CODIGO</th>
                            <th>NOMBRE</th>
                            <th>CANTIDAD</th>
                            <th>MONTO</th>
                            <th>PARAMETRO</th>
                            <th>ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody  v-if="this.objProcessDetailList.length > 0" >
    
                        <tr  v-for="(Process, index) in objProcessDetailList" :key="Process.hrpdId">
                            <td >{{index + 1}}</td>
                            <td class="form-inline">
                                <p class="text-left">
                                    {{Process.transactionTypeCode}}
                                </p>
                            </td>
                            <td class="form-inline">
                                <p class="text-left">
                                    {{Process.transactionTypeName}}
                                </p>
                            </td>
                            <td>
                                <p class="text-right">
                                    {{Process.quantity}}
                                </p>
                            </td>
                            <td>
                                <p class="text-right">
                                    {{Process.amount}}
                                </p>
                            </td>
                            <td>
                                <p v-if="Process.params > 0">
                                    {{Process.params | params}}
                                </p>
                                <p v-else >
                                    Sin Parametros
                                </p>
                            </td>
                            <td> 
                                <!-- <button v-on:click="detailRow(Process.hrpdId)" class="btn btn-sm btn-info"><i class=" 	glyphicon glyphicon-th-list"></i> </button>   -->
                                <button v-on:click="editDetailRow(index, Process.hrpdId)" class="btn btn-sm btn-primary" title="Editar"><i class="fa fa-edit"></i> </button>  
                                <button v-on:click="deleteDetailrow(index, Process.hrpdId)" class="btn btn-sm btn-danger" title="Eliminar"><i class="fa fa-times-circle"></i></button>  
                            </td>
                        </tr>
                    </tbody>
                    <tbody  v-else >
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
        <!-- </div> -->
    </div>
    
</template>

<script>
    export default {
        
        mounted() {
            // setTimeout(() => {
            axios.get(`process-detail/${this.objProcessDetail.hrprocessId}`).then( response => {
                this.objProcessDetailList = response.data.processDetail
                this.lengths = this.objProcessDetailList.length
                console.log(this.objProcessDetailList)
            })
            // },1000)
            
            
            console.log('Component mounted.')
        },
        data(){
            return{
                objProcessDetailList: {},
                lengths: '',
            }
            // lengths se utiliza para identificar si el objeto viene vacio y asi mostrar msj, si no hay datos
        },
        props: {
            namePanelList: {
                type: String,
                default: 'Name defauld',
            },
            objProcess:{},
            objProcessDetail:{},
        },
        methods: {
            editDetailRow(index, id){
                // console.log('objeto')
                // console.log(this.objProcessDetailList[index])
                // paso solamente el index para enviar al formulario el objeto del indice seleccionado,
                // de esta manera no tengo que buscar los datos en la DB nuevamente
            
                this.$emit("indexEditDetail",this.objProcessDetailList[index])
            },
            deleteDetailrow(index, id){
                // console.log('index ' + index)
                // console.log('id ' + id)
                // const indexIs = this.objProcessDetailList[index]
            

                // return
                if (confirm("Delete?") ){
                    axios.delete(`process-detail/${id}`).then(()=>{
                        this.objProcessDetailList.splice(index, 1)
                        // this.$emit("delDetailrow",[index,id])
                    })
                    .catch(function (error) {
                        alert("Error")
                        console.log(error);
                    });
                }
                
                // console.log('enviado')
            }
        },
        filters: {
            params: function (value) {
                if (value = 1 ) return 'Parametro hijos'
                
            }
        }
        
    }
</script>
