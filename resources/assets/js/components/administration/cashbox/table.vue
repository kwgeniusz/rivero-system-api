<template>
<div>

<div>
    <div class="col-xs-4">
     <!-- Total Transacciones: ${{totals.transactions}} <br>
     Manuales: ${{totals.manuales}} <br>
     Fee: ${{totals.fee}} <br>
     Total: ${{totals.netTotal}} <br> -->
    </div>   

    <div class="col-xs-4">
      <ul class="list-group">
        <li class="list-group-item">
            <input type="text" placeholder="Buscar" class="form-control" v-model="inputSearch">
        </li>
       </ul>
    </div> 
   <div class="col-xs-4">

       <div class="btn-group"> 
         <div class="dropdown">
          <button  class="btn btn-info btn-sm" id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Opciones<span class="caret"></span>
          </button>
          <ul class="dropdown-menu" aria-labelledby="dLabel">
            <li><a href="#" @click="showModal=true"> Busqueda Avanzada</a></li>
          </ul>
        </div>
    </div>

       <div  class="btn-group"> 
        <div v-if="!loading" class="dropdown">
         <button  class="btn btn-warning btn-sm dropdown-toggle" id="drop2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Exportar<span class="caret"></span>
          </button>
          <ul class="dropdown-menu" aria-labelledby="drop2">
            <li><a href="#" @click="printPDF()"> PDF</a></li>
            <!-- <li><a href="#"> EXCEL</a></li> -->
          </ul>
      </div>  
       <div v-else>
         <loading/><br>
           DESCARGANDO...
      </div>
     </div>  

   </div>
</div>

 <br>
  <!-- <modal-advanced-search v-if="showModal" 
   sign="+" 
  @close="showModal = false" 
  @filteredTransactions="changeTransactions"/>
    -->

   <div class="col-xs-12 text-center" v-if="datesToShow.date1">
      <h2> Desde: {{datesToShow.date1| moment("MM/DD/YYYY")}} - Hasta:{{datesToShow.date2 | moment("MM/DD/YYYY")}} </h2>
   </div> 
   <div class="col-xs-12 text-center" v-if="datesToShow.year">
      <h2> Año: {{datesToShow.year}}</h2>
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
                                <th>MONTO</th>
                                <th>D/C</th>
                                <th>SALDO</th>
                                <th>RESPONSABLE</th>
                                <th>ACCIONES</th> 
                                </tr>
                            </thead>
                            <tbody v-if="searchData.length > 0">
                             <tr  v-for="(transaction, index) in searchData" :key="transaction.transactionId">
                                 <td>{{index + 1}}</td>
                                 <td>{{transaction.transactionDate | moment("MM/DD/YYYY hh:mm A")}}</td>
                                 <td>{{$transaction.description}} <br> {{$transaction.reason}}</td>
                                 <td>{{$transaction.amount}}</td>
                                 <td>{{$transaction.sign}}</td>
                                 <td>{{$transaction.balance}}</td>
                                 <td>{{$transaction.user.fullName}}</td>
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

    // import ModalAdvancedSearch from '../ModalAdvancedSearch.vue'

    export default {
    mounted() {
            console.log('Component mounted.') 
        },
     data(){
            return{
                inputSearch: '',
            
                showModal: false,
                mutaTransaction: this.transactionList,
                datesToShow:  {                    
                     date1: '',
                     date2: '',
                     year:  ''
                     },
                loading: false

            }
        },
        props: {
            transactionList:  {  type: [Array], default: null},
            transactionYear:  {  type: [String], default: null},
            transactionCodes:  {  type: [Array], default: null},
        },  
      watch:{
         transactionList: function transactionList(data){
            this.mutaTransaction = data;
            this.datesToShow.year = this.transactionYear;
         }
       } ,       
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
          //  totals: function (){
          //     var totalManual = 0;
          //     var totalTransaction = 0;
          //     var totalFee = 0;
          //     var netTotal = 0;

          //     var that = this; // Work around!
          //        this.searchData.forEach(function(data){
          //             if(data.transactionTypeId == that.transactionCodes[0].transactionTypeId) {
          //                if(data.transactionable == null){
          //                 totalManual = parseFloat(totalManual) + parseFloat(data.amount);
          //                 }
          //                else{
          //                 totalTransaction = parseFloat(totalTransaction) + parseFloat(data.amount);
          //                 }
          //              }else if(data.transactionTypeId == that.transactionCodes[1].transactionTypeId) {
          //                 totalFee = parseFloat(totalFee) + parseFloat(data.amount);
          //               }
          //       });
          //      netTotal = totalTransaction + totalManual + totalFee;

          //     return {
          //     'transactions': totalTransaction.toFixed(2),
          //     'manuales': totalManual.toFixed(2),
          //     'fee': totalFee.toFixed(2),
          //     'netTotal': netTotal.toFixed(2)}
         
          //       // return `Ingresos de Facturas ${suma.toFixed(2)}`;
          //   }  
        },
        components: {
         ModalAdvancedSearch,
       },   
        methods: {
          editTransaction(index, id){
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
               this.datesToShow =  searched;
          }, 
          printPDF(){
            this.loading = true;

           axios.post('/reports/incomes',{transactions: this.mutaTransaction, dateRange: this.datesToShow},{
            responseType: 'blob',
            onDownloadProgress: (progressEvent) => {
               console.log(progressEvent.total)
               this.percentCompleted = Math.round((progressEvent.loaded * 100) );
              // console.log(percentCompleted)
              }
             }).then((response) => {
                  this.loading = false; 
                  
                  const url  = window.URL.createObjectURL(new Blob([response.data]));
                  const link = document.createElement('a');
                  link.href = url;
                  link.setAttribute('download', 'Incomes.pdf'); //or any other extension
                  document.body.appendChild(link);
                  link.click();
            }).catch((error)=>{
                  alert(error)
                  this.loading = false; 
            })
         }  //end of printPDF 
      }//end of methods
    }

</script>