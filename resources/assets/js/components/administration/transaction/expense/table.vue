<template>
   <div>

<div>
    <div class="col-xs-4">
      Subcontratistas: ${{totals.subcontractors}} <br>
      Manuales: ${{totals.manuales}} <br>
      Total: ${{totals.netTotal}} <br>
    </div>   

    <div class="col-xs-4">
      <ul class="list-group">
        <li class="list-group-item">
            <input type="text" placeholder="Buscar" class="form-control" v-model="inputSearch">
        </li>
       </ul>
    </div> 
   <div class="col-xs-4">
    </div>
    
</div>
       <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="table-responsive text-center">
                        <table class="table table-striped table-bordered text-center">
                            <thead class="bg-danger">
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
                     <tbody v-if="searchData.length > 0">       
                      <template v-for="(transaction, index) in searchData">      
                              <tr :key="index">
                                <td >{{index + 1}}</td>
                                <td class="text-left"> {{transaction.transactionDate | moment("MM/DD/YYYY hh:mm A")}}</td>
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
                                 <button @click="toggle(transaction.transactionId)" :class="{ opened: opened.includes(transaction.transactionId) }" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Ver Detalles"><i class="fa fa-angle-double-down" aria-hidden="true"></i></button>  
                                     <div v-if="transaction.transactionable_id == null">
                                        <button @click="editTransaction(index,transaction.transactionId)" class="btn btn-sm btn-primary" title="Editar"><i class="fa fa-edit"></i></button>  
                                        <button @click="deleteTransaction(index,transaction.transactionId)" class="btn btn-sm btn-danger" title="Eliminar"><i class="fa fa-times-circle"></i></button> 
                                    </div>  
                                </td>
                         </tr>
                         <tr v-if="opened.includes(transaction.transactionId)" >
                            <td></td>
                            <td colspan="9">
                             <div v-if="transaction.document">
                                <!-- previzualizar la imagen -->
                                 <img :src="raizUrl+transaction.document.docUrl" width="50%" height="50%">
                                <!-- descargar la imagen -->
                             </div>  
                             <div v-else-if="transaction.payable">
                                 <h3><b>Cuentas por Pagar Asociadas:</b></h3>
                                <div class="col-xs-9 col-xs-offset-2">
                                    <div class="panel panel-default">          
                                        <div class="table-responsive text-center">
                                           <table class="table table-striped table-bordered text-center ">
                                           <thead>
                                             <tr class="bg-success">
                                              <th>#</th>
                                              <th>DIRECCION</th>
                                              <th>MONTO</th>
                                              <th>MOTIVO</th>                
                                            </tr>
                                         </thead>
                                       <tbody>
                                             <tr v-for="(payable,index) in transaction.payable" :key="payable.payableId">
                                                 <td>{{++index}} </td>
                                                 <td> {{payable.subcont_inv_detail.invoice.contract.siteAddress}} </td>
                                                 <td>{{payable.pivot.amountPaid}} </td>
                                                 <td>{{payable.pivot.reason}} </td>
                                            </tr>
                                     </tbody>
                                    </table>
                                   </div>
                               </div>
                           </div>
              
                        </div>
                      </td>
                    </tr> 

                         </template> 
                         </tbody>
                         
                         <tbody v-else>
                           <tr>
                             <td colspan="12">
                                 <loading></loading>
                             </td>
                          </tr>
                         </tbody>                  
                     </table>

                    </div>
                </div>

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
                inputSearch: '',
                raizUrl: window.location.protocol+'//'+window.location.host+'/storage/',
                opened: [],
            }
        },
        props: {
            transactionList: {},
            // parents:{},
        },  
     computed: {
            searchData: function () {
                return this.transactionList.filter((transaction) => {
                  return transaction.description.toLowerCase().includes(this.inputSearch.toLowerCase()) ||
                         transaction.reason.toLowerCase().includes(this.inputSearch.toLowerCase()) ||
                         transaction.amount.toLowerCase().includes(this.inputSearch.toLowerCase()) ||
                         transaction.user.fullName.toLowerCase().includes(this.inputSearch.toLowerCase()) ||
                         transaction.payment_method.payMethodName.toLowerCase().includes(this.inputSearch.toLowerCase()) 
                })
            }, 
        totals: function (){
              var totalManual = 0;
              var totalSubcontractor = 0;
              var netTotal = 0;

              var that = this; // Work around!

                 this.searchData.forEach(function(data){
                     if(data.transactionable == null){
                         totalManual = parseFloat(totalManual) + parseFloat(data.amount);
                      }else{
                        totalSubcontractor = parseFloat(totalSubcontractor) + parseFloat(data.amount);
                      }
                       
                });
               netTotal =  totalManual + totalSubcontractor;

              return {
              'subcontractors': totalSubcontractor.toFixed(2),
              'manuales': totalManual.toFixed(2),
              'netTotal': netTotal.toFixed(2)

              }
         
                // return `Ingresos de Facturas ${suma.toFixed(2)}`;
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
                     axios.delete(`/transactions/${id}`).then((response) => {
                           toastr.success(response.data.message);
                           this.$emit('showlist', 0)
                    })
                }    
            }, 
        }
    }

</script>