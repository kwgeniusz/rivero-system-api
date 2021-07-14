<template>
<div>
<!-- {{this.mutaTransaction[0]}} -->
  <div class="col-xs-12">
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

    <div class="btn-group"> 
        <div class="dropdown">
          <button  class="btn btn-info btn-sm dropdown-toggle" id="drop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Opciones<span class="caret"></span>
          </button>
          <ul class="dropdown-menu" aria-labelledby="drop1">
            <li><a v-if="$can('FE')" href="/transaction-types/-/index">Lista de Tipos de Expenses</a></li>
            <li><a v-if="companyId == 8" href="/cost-categories"> Categoria de Costos </a></li>
            <li><a href="#" @click="showModal=true"> Busqueda Avanzada</a></li>
          </ul>
        </div>
    </div>

   <div v-if="datesToShow" class="btn-group"> 
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

   <modal-advanced-search v-if="showModal" sign="-" @close="showModal = false" @filteredTransactions="changeTransactions"/>
   
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
                            <thead class="bg-danger">
                              <tr>
                                <th>#</th>
                                <th>FECHA</th>
                                <th>REFERENCIA EN BANCO O BENEFICIARIO</th>
                                <th >METODO DE PAGO</th>
                                <th>MOTIVO</th>
                                <th>REFERENCIA DE TRANSACCION</th>
                                <th>EXPENSES</th>
                                <th>MONTO</th>
                                <th>DESTINO</th>
                                <th v-if="companyId == 8">CATEGORIA DE COSTOS</th>
                                <th>RESPONSABLE</th>
                                <th>ESTADO</th>
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
                                <td class="text-left"> {{transaction.reference}}</td> 
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
                               <td class="text-left" v-if="companyId == 8">
                                 <div v-if="transaction.cost_category != null">
                                 ({{transaction.cost_category.costCategoryCode}} - {{transaction.cost_category.categoryName}})<br>
                                 ({{transaction.cost_subcategory.costCategoryCode}} - {{transaction.cost_category.categoryName}})<br>
                                 ({{transaction.cost_subcategory_detail.costCategoryCode}} - {{transaction.cost_category.categoryName}})
                                 </div>
                               </td>
                               <td class="text-left">{{transaction.user.fullName}}</td>
                               <td class="text-left">{{transaction.status}}</td>
                                  <td> 
                                 <button @click="toggle(transaction.transactionId)" :class="{ opened: opened.includes(transaction.transactionId) }" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Ver Detalles"><i class="fa fa-angle-double-down" aria-hidden="true"></i></button>  
                                     <div v-if="transaction.transactionable_id == null || transaction.transactionable_id != null && transaction.contractId ">
                                        <button @click="editTransaction(index,transaction.transactionId)" class="btn btn-sm btn-primary" title="Editar"><i class="fa fa-edit"></i></button>  
                                        <button @click="deleteTransaction(index,transaction.transactionId)" class="btn btn-sm btn-danger" title="Eliminar"><i class="fa fa-times-circle"></i></button> 
                                    </div>  
                                </td>
                         </tr>
                         <!-- style="background:blue"  -->
                         <tr v-if="opened.includes(transaction.transactionId)" >
                            <td></td>
                            <td style="background:#c6e8f4" colspan="10">
                             <div v-if="transaction.document">
                                <!-- previzualizar la imagen -->
                                 <iframe v-if="transaction.document.mimeType == 'pdf'" :src="raizUrl+transaction.document.docUrl" frameborder="0" width="100%" height="700px"></iframe>
                                 <img v-else :src="raizUrl+transaction.document.docUrl" width="50%" height="50%">
                                <!-- descargar la imagen -->
                             </div>  
                             <div v-else-if="transaction.payable != ''">
                                 <h3><b>Cuentas por Pagar Asociadas:</b></h3>
                                <div class="col-xs-9 col-xs-offset-2">
                                    <div class="panel panel-default">          
                                        <div class="table-responsive text-center">
                                           <table class="table table-striped table-bordered text-center ">
                                           <thead>
                                             <tr class="bg-success">
                                              <th>#</th>
                                              <th># FACTURA</th>
                                              <th>DIRECCION</th>
                                              <th>MONTO</th>
                                              <th>MOTIVO</th>                
                                            </tr>
                                         </thead>
                                       <tbody>
                                             <tr v-for="(payable,index) in transaction.payable" :key="payable.payableId">
                                                 <td>{{++index}} </td>
                                                 <td>{{payable.subcont_inv_detail.invoice.invId}} </td>
                                                 <td>{{payable.subcont_inv_detail.invoice.contract.siteAddress}} </td>
                                                 <td>{{payable.pivot.amountPaid}} </td>
                                                 <td>{{payable.pivot.reason}} </td>
                                            </tr>
                                     </tbody>
                                    </table>
                                   </div>
                               </div>
                           </div>
                        </div>
                         <div v-else>
                           EMPTY
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

    import ModalAdvancedSearch from '../ModalAdvancedSearch.vue'

    export default {
      mounted() {
            console.log('Component mounted.') 
        },
      data(){
            return{
                companyId: window.globalCompanyId,
                inputSearch: '',
                raizUrl: window.location.protocol+'//'+window.location.host+'/storage/',
                opened: [],
                
                showModal: false,
                mutaTransaction: this.transactionList,
                datesToShow:  {                    
                     date1: '',
                     date2: '',
                     year:  ''
                     },
                loading: false,
                percentCompleted:0,
            }
        },
      props: {
         transactionList: { type: Array},
         transactionYear: { type: String},
        }, 
      watch:{
         transactionList: function transactionList(data){
            this.mutaTransaction = data;
            this.datesToShow.year = this.transactionYear;
         },
         percentCompleted: function percentCompleted(data){
           console.log(data)
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
                         transaction.user.fullName.toLowerCase().includes(this.inputSearch.toLowerCase()) 
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
              this.datesToShow =  searched;
          },
         toggle(id) {
           const index = this.opened.indexOf(id);
           if (index > -1) {
            this.opened.splice(index, 1)
           } else {
            this.opened.push(id)
           }
         },
         printPDF(){
            this.loading = true;

           axios.post('/reports/expenses',{transactions: this.mutaTransaction, dateRange: this.datesToShow},{
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
                  link.setAttribute('download', 'Expenses.pdf'); //or any other extension
                  document.body.appendChild(link);
                  link.click();
            }).catch((error)=>{
                  alert(error)
                  this.loading = false; 
            })
         }  //end of printPDF
      }//end of methods
    } //end of export

</script>