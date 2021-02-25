<template>
       <div class="col-xs-11">
                <div class="panel panel-default">
                    <div class="table-responsive text-center">

                        <table class="table table-striped table-bordered text-center">
                            <thead>
                              <tr>
                                <th>#</th>
                                <th>FECHA</th>
                                <th>REFERENCIA EN BANCO O BENEFICIARIO</th>
                                <th >METODO DE PAGO</th>
                                <th>MOTIVO</th>
                                <th>EXPENSES</th>
                                <th>MONTO</th>
                                <th>DESTINO</th>
                                <th>RESPONSABLE</th>
                                <th>ACCIONES</th>
                               </tr>
                            </thead>
                            <tbody>
                             <template v-for="(transaction, index) in transactionList">       
                             <tr>
                                <td >{{index + 1}}</td>
                                <td class="text-left"> {{transaction.transactionDate}}</td>
                                <td class="text-left"> {{transaction.description}}</td>
                                <td class="text-left"> {{transaction.payment_method.payMethodName}} {{transaction.payMethodDetails}}</td>
                                <td class="text-left"> {{transaction.reason}}</td> 
                                <td class="text-left"> {{transaction.transaction_type.transactionTypeName}}</td>  
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
                                 <button @click="toggle(transaction.transactionId)" :class="{ opened: opened.includes(transaction.transactionId) }" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Ver Detalles"><i class="fa fa-user" aria-hidden="true"></i></button>  
                                     <div v-if="transaction.transactionable_id == null">
                                        <button @click="editTransaction(index,transaction.transactionId)" class="btn btn-sm btn-primary" title="Editar"><i class="fa fa-edit"></i></button>  
                                        <button @click="deleteTransaction(index,transaction.transactionId)" class="btn btn-sm btn-danger" title="Eliminar"><i class="fa fa-times-circle"></i></button> 
                                    </div>  
                                  </td>
                                </tr>

                         <tr v-if="opened.includes(transaction.transactionId)">
                            <td></td>
                            <td colspan="9">
                          
                             <div v-if="transaction.document">
                                <!-- previzualizar la imagen -->
                                 <img :src="raizUrl+transaction.document.docUrl" width="50%" height="50%">
                                 <!-- {{raizUrl+transaction.document.docUrl}} -->
                                <!-- descargar la imagen, -->
                          
                            </div>  
                        
                             <div v-if="transaction.payable != ''">
                                 <h3><b>Cuentas por Pagar Asociadas:</b></h3>
                                    <hr>
                                    <ul v-for="(payable,index) in transaction.payable" :key="payable.payableId">
                                        {{++index}}) <b>Direccion:</b> 
                                       {{payable.subcont_inv_detail.invoice.contract.propertyNumber}} 
                                       {{payable.subcont_inv_detail.invoice.contract.streetName}} 
                                       {{payable.subcont_inv_detail.invoice.contract.streetType}} 
                                       {{payable.subcont_inv_detail.invoice.contract.suiteNumber}} 
                                       {{payable.subcont_inv_detail.invoice.contract.city}} 
                                       {{payable.subcont_inv_detail.invoice.contract.state}} 
                                       {{payable.subcont_inv_detail.invoice.contract.zipCode}}
                                         <br>
                                        <b>Monto Pagado:</b> {{payable.pivot.amountPaid}} <br>
                                        <b>Motivo:</b> {{payable.pivot.reason}}<br>    
                                      </ul>
                                    <hr>
                            </div>  
                            </td>
                        </tr> 

                         </template>                 
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
        },
        props: {
            transactionList: {},
            // parents:{},
        },  
        data(){
            return{
                // editMode: -1,
                // num: 1,
                // parent:'',
                raizUrl: window.location.protocol+'//'+window.location.host+'/storage/',
                opened: [],
            }
        },
        methods: {
          toggle(id) {
         const index = this.opened.indexOf(id);
         if (index > -1) {
           this.opened.splice(index, 1)
         } else {
           this.opened.push(id)
         }
       },
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