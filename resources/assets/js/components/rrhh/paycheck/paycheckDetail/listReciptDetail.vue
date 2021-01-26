<template>

    <div class="col-md-8 col-md-offset-2">
         <div class="panel panel-default"> 
            <div class="panel-heading">
                <div class="row">
                    <div class="form-group col-md-12">
                        <h4>RECIBOS DE PAGOS DE: <b> {{objReciptDetail[0].shortName}} </b></h4>
                        <h4> DOCUMENTO DE IDENTIDAD: <b> {{objReciptDetail[0].idDocument}}</b> </h4>
                    </div>
                </div>
                </div>
            </div>
            <div class="panel panel-default"> 
                <div class="panel-heading">
                    <div class="table-responsive text-center">
                        <table class="table table-striped table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>N.</th>
                                    <th>AÑO</th>
                                    <th>PERIODO</th>
                                    <th>MONTO</th>
                                    <!-- <th>DEDUCCIONES</th> -->
                                    <th>ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody  v-if="this.objReciptDetail.length > 0" >
            
                                <tr  v-for="(Process, index) in objReciptDetail[1]" :key="Process.index">
                                    <td >{{index + 1}}</td>
                                    <td class="form-inline">
                                        {{Process.year}}
                                    </td>
                                    <td>
                                        {{Process.payrollName}}
                                    </td>
                                    <td>
                                        {{Process.amount}}
                                    </td>
                                    <!-- <td>
                                        {{Process.amount}}
                                    </td> -->
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
                </div>
            </div>
    </div>
    
</template>

<script>
    export default {
        
        mounted() {
            // setTimeout(() => {
            // axios.get(`process-detail/${this.objReciptDetail.hrprocessId}`).then( response => {
            //     this.objProcessDetailList = response.data.processDetail
            //     this.lengths = this.objProcessDetailList.length
                
            // })
            // },1000)
            
            
            console.log(this.objReciptDetail)
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
            objReciptDetail:{},
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
        }
    }
</script>
