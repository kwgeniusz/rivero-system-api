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
                            <th>NOMBRE</th>
                            <th>CANTIDAD</th>
                            <th>MONTO</th>
                            <th>ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody  v-if="this.objProcessDetailList.length > 0" >
    
                        <tr  v-for="(Process, index) in objProcessDetailList" :key="Process.hrpdId">
                            <td >{{index + 1}}</td>
                            <td class="form-inline">
                                {{Process.transactionTypeName}}
                            </td>
                            <td>
                                {{Process.quantity}}
                            </td>
                            <td>
                                {{Process.amount}}
                            </td>
                            <td> 
                                <!-- <button v-on:click="detailRow(Process.hrpdId)" class="btn btn-sm btn-info"><i class=" 	glyphicon glyphicon-th-list"></i> </button>   -->
                                <button v-on:click="editDetailRow(index, Process.hrpdId)" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-edit"></i> </button>  
                                <button v-on:click="deleteDetailrow(index, Process.hrpdId)" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></button>  
                            </td>
                        </tr>
                    </tbody>
                    <tbody  v-else >
                        <tr>
                            <td colspan="5">
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
                // console.log(this.objProcessDetailList)
                // debugger
                // console.log('longitud: ' + this.objProcessDetailList.length)
            })
            // },1000)
            
            
            console.log('Component mounted.')
        },
        data(){
            return{
                objProcessDetailList: {}
            }
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
        }
    }
</script>
