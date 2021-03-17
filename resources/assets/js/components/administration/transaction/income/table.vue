<template>
       <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="table-responsive text-center">

                        <table class="table table-striped table-bordered text-center">
                            <thead class="bg-success">
                              <tr>
                                 <th>#</th>
                                 <th>FECHA</th>
                                 <th>DESCRIPCION</th>
                                 <th>FACTURA</th>
                                 <th>MOTIVO</th>
                                 <th>METODO DE PAGO</th>
                                 <th>MONTO</th>
                                 <th>DESTINO</th>
                                 <th>RESPONSABLE</th>
                                 <th>ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody>  
                             <tr  v-for="(transaction, index) in transactionList" :key="transaction.transactionId">
                                <td >{{index + 1}}</td>
                                <td class="text-left"> 
                                    {{transaction.transactionDate | moment("MM/DD/YYYY hh:mm A")}}
                                    {{transaction.transactionDateLocal}}
                                    </td>
                                <td class="text-left"> {{transaction.description}} <br>
                                 <!-- <p v-if="transaction.transactionable != null">
                                    {{transaction.transactionable.contract.siteAddress}}
                                    </p> -->
                                
                                </td>
                                <td class="text-left"> 
                                    <p v-if="transaction.transactionable  != null"> 
                                    {{transaction.transactionable.invId}}
                                    </p> 
                                </td>
                                <td class="text-left"> {{transaction.reason}}</td>  
                                <td class="text-left"> {{transaction.payment_method.payMethodName}} {{transaction.payMethodDetails}}</td>           
                               <td class="text-left"> {{transaction.amount}}</td>   
                                 <td class="text-left"> 
                                   <p v-if="transaction.cashboxId == null" class="text-left"> 
                                    {{transaction.account.bank.bankName}}<br> {{transaction.account.accountCodeId}} 
                                    </p>
                                     <p v-else class="text-left"> 
                                       CASHBOX
                                     </p>                                          
                                </td>    
                               <td class="text-left">{{transaction.user.fullName}}</td>
                                  <td> 
                                     <div v-if="transaction.transactionable_id == null">
                                        <button @click="editTransaction(index,transaction.transactionId)" class="btn btn-sm btn-primary" title="Editar"><i class="fa fa-edit"></i></button>  
                                        <button @click="deleteTransaction(index,transaction.transactionId)" class="btn btn-sm btn-danger" title="Eliminar"><i class="fa fa-times-circle"></i></button> 
                                    </div>  
                                  </td>
                                </tr>
                     
                        </tbody>
                     </table>

                    </div>
                </div>
            </div>
        
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.') 
            // console.log(this.transactionList)
        },
        props: {
            transactionList: {},
        },  
        data(){
            return{
               
            }
        },
        methods: {
            editTransaction(index, id){
                // console.log('index: '+index + ' id: '+ id)
                this.$emit('editData', id)
            },
            deleteTransaction(index, id){
                if (confirm(`Esta Seguro de Eliminar la Transaccion #${++index}?`) ){
                    axios.delete(`-/delete/${id}`).then((response) => {
                           toastr.success(response.data.message);
                           this.$emit('showlist', 0)
                    })
                }    
            }, 
        }
    }

</script>