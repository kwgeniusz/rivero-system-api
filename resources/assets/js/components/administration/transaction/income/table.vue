<template>
<div>

<div>
    <div class="col-xs-4">
     Total Transacciones: ${{totals.transactions}} <br>
     Manuales: ${{totals.manuales}} <br>
     Fee: ${{totals.fee}} <br>
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
         <div class="dropdown">
          <button  class="btn btn-info btn-sm" id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Opciones<span class="caret"></span>
          </button>
          <ul class="dropdown-menu" aria-labelledby="dLabel">
            <li><a href="#" @click="showModal=true"> Busqueda Avanzada</a></li>
          </ul>
        </div>
   </div>
</div>
 <br>
 <modal-advanced-search v-if="showModal" sign="+" @close="showModal = false" @filteredTransactions="changeTransactions"/>
   
   <div class="col-xs-12 text-center" v-if="datesToShow">
      <h2> Desde:{{datesToShow[0]| moment("MM/DD/YYYY")}} - Hasta:{{datesToShow[1]| moment("MM/DD/YYYY")}} </h2>
   </div> 
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
                                <th>REFERENCIA DE TRANSACCION</th>
                                 <th>METODO DE PAGO</th>
                                 <th>MONTO</th>
                                 <th>DESTINO</th>
                                 <th>RESPONSABLE</th>
                                 <th>ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody v-if="searchData.length > 0">
                             <tr  v-for="(transaction, index) in searchData" :key="transaction.transactionId">
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
                                <td class="text-left"> {{transaction.reference}}</td>  
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

    import ModalAdvancedSearch from '../ModalAdvancedSearch.vue'

    export default {
    mounted() {
            console.log('Component mounted.') 
            // console.log(this.transactionCodes)
            // console.log(this.transactionList)
        },
     data(){
            return{
                inputSearch: '',
            
                showModal: false,
                mutaTransaction: this.transactionList,
                datesToShow: ''
            }
        },
        props: {
            transactionList:  {  type: [Array], default: null},
            transactionCodes:  {  type: [Array], default: null},
        },  
      watch:{
         transactionList: function transactionList(data){
            this.mutaTransaction = data;
         }
       } ,
      components: {
         ModalAdvancedSearch,
       },        
         computed: {
            searchData: function () {
                return this.mutaTransaction.filter((transaction) => {
                  return transaction.description.toLowerCase().includes(this.inputSearch.toLowerCase()) ||
                         transaction.reason.toLowerCase().includes(this.inputSearch.toLowerCase()) ||
                         transaction.amount.toLowerCase().includes(this.inputSearch.toLowerCase()) ||
                         transaction.user.fullName.toLowerCase().includes(this.inputSearch.toLowerCase()) ||
                         transaction.payment_method.payMethodName.toLowerCase().includes(this.inputSearch.toLowerCase()) 
                })
            }, 
        totals: function (){
              var totalManual = 0;
              var totalTransaction = 0;
              var totalFee = 0;
              var netTotal = 0;

              var that = this; // Work around!
                 this.searchData.forEach(function(data){
                      if(data.transactionTypeId == that.transactionCodes[0].transactionTypeId) {
                         if(data.transactionable == null){
                          totalManual = parseFloat(totalManual) + parseFloat(data.amount);
                          }
                         else{
                          totalTransaction = parseFloat(totalTransaction) + parseFloat(data.amount);
                          }
                       }else if(data.transactionTypeId == that.transactionCodes[1].transactionTypeId) {
                          totalFee = parseFloat(totalFee) + parseFloat(data.amount);
                        }
                });
               netTotal = totalTransaction + totalManual + totalFee;

              return {
              'transactions': totalTransaction.toFixed(2),
              'manuales': totalManual.toFixed(2),
              'fee': totalFee.toFixed(2),
              'netTotal': netTotal.toFixed(2)}
         
                // return `Ingresos de Facturas ${suma.toFixed(2)}`;
            }  
        },
        methods: {
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
            changeTransactions(data,searched){
               this.mutaTransaction = data;
               this.datesToShow =  [searched.date1,searched.date2];
          }, 
        }
    }

</script>