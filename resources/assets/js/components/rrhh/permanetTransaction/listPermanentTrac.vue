<template>

    <div class="col-md-12">
        <div class="panel panel-default">
            <!-- <div class="panel-heading"><h4>{{namePanel}}</h4></div> -->

            <div class="table-responsive text-center">
                <table class="table table-striped table-bordered text-center">
                    <thead>
                        <tr>
                            <th>N</th>
                            <th>Cod.</th>
                            <th>Nombre</th>
                            <th>Compañia</th>
                            <th>Pais</th>
                            <th>Transaccion</th>
                            <th>Cantidad</th>
                            <th>Monto</th>
                            <th>Balance</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody v-if="objPermanentTrans.length > 0">
    
                        <tr v-for="(perTransact, index) in objPermanentTrans" :key="perTransact.hrpermanentTransactionId">
                            
                            <td >{{index + 1}}</td>
                            <td v-if="perTransact.blocked == 1 " class="form-inline" :style="addBlocked"> 
                                <p class="text-left">
                                    {{perTransact.staffCode}} 
                                
                                </p>
                            </td>
                            <td v-else class="form-inline">  
                                <p class="text-left">
                                    {{perTransact.staffCode}} 
                                
                                </p>
                            </td>
                            <td v-if="perTransact.blocked == 1" :style="addBlocked">
                                <p class="text-left">
                                    {{perTransact.shortName}}
                                </p>
                            </td>
                            <td v-else>
                                <p class="text-left">
                                    {{perTransact.shortName}}
                                </p>
                            </td>
                            <td>
                                <p class="text-left">
                                    {{perTransact.companyShortName}}
                                </p>
                            </td>
                            <td>
                                <p class="text-left">
                                    {{perTransact.countryName}}
                                </p>
                            </td>
                            <td>
                                <p class="text-left">
                                    {{perTransact.transactionTypeName}}
                                </p>
                            </td>
                            <td>
                                <p class="text-right">
                                    {{perTransact.quantity}}
                                </p>
                            </td>
                            <td>
                                <p class="text-right">
                                    {{perTransact.amount}}
                                </p>
                            </td>
                            <td>
                                <p class="text-right">
                                    {{perTransact.balance}}
                                </p>
                            </td>
                            
                            <td> 
                                <button v-on:click="edit(index, perTransact.hrpermanentTransactionId)" class="btn btn-sm btn-primary" title="Editar"><i class="fa fa-edit"></i></button>  
                                <button v-on:click="del(index,perTransact.hrpermanentTransactionId)" class="btn btn-sm btn-danger" title="Eliminar"><i class="fa fa-times-circle"></i></button>  
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr>
                            <td colspan="10">
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
            objPermanentTrans:{},
        },
        methods: {
            edit(index, id){
                // paso solamente el index para pasar al formulario el objeto del indice seleccionado,
                // de esta manera no tengo que buscar los datos en la DB nuevamente
                this.$emit("indexEdit",index)
                // console.log('enviado')
            },
            del(index,id){
                // console.log(index)
                // const indexIs = this.objPermanentTrans[index]
            
                if (confirm("Delete?") ){
                    axios.delete(`perm-trans/${id}`).then(()=>{

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
        computed: {
            addBlocked: function () {
                return { 
                    background: '#FFC5A5', 
                    
                    };  
            },
            
            
        },
    }
</script>