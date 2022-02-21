<template>
  <div >

    <div class="col-xs-4">
         GENERAR ASIENTOS TEMPORALES
    </div>   

    <div class="col-xs-4">
      <ul class="list-group">
        <li class="list-group-item">
            <input type="text" placeholder="Buscar" class="form-control" v-model="inputSearch">
        </li>
       </ul>
    </div> 

   <div class="col-xs-4">
      <!-- <a href="{{route('reports.clients')}}" class="btn btn-danger btn-sm text-right">
                     <span class="fa fa-file-pdf" aria-hidden="true"></span> Imprimir Clientes de la Corporacion
           </a> -->
      <div class="btn-group">     
        <!-- <div class="dropdown">
          <button  class="btn btn-info btn-sm" id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Opciones<span class="caret"></span>
          </button>
          <ul class="dropdown-menu" aria-labelledby="dLabel">
            <li><a v-if="$can('FE')" @click="$refs.modalConfirmation.open()" href="#">Actualizar Asientos Contables</a></li>
          </ul>
        </div>     -->
        </div>   

      <!-- <div  class="btn-group"> 
         <button @click="showModalPrint=true" class="btn btn-success btn-sm">
            Filtrar
          </button>
    </div>    -->

      <div  class="btn-group"> 
        <div v-if="!loading" class="dropdown">
         <button  class="btn btn-warning btn-sm dropdown-toggle" id="drop2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Imprimir<span class="caret"></span>
          </button>
          <ul class="dropdown-menu" aria-labelledby="drop2">
            <li><a href="#"  @click="showModalPrint1=true">Por Rango de Fecha (PDF)</a></li>
            <li><a href="#"  @click="showModalPrint2=true"> Reporte de Libro Mayor (PDF)</a></li>
            <!-- <li><a href="#"> EXCEL</a></li> -->
          </ul>
      </div>  
       <div v-else>
         <loading/><br>
           DESCARGANDO...
      </div>
    </div>  

     
   </div>



<sweet-modal ref="modalConfirmation" >
	<b>Esta seguro de Actualizar los asientos contables? </b>
 <br><br>
	<button type="button" class="btn btn-success" @click="balanceUpdate">Confirmar</button>
	<!-- <button type="button" class="btn btn-danger"  @click="$ref.modalConfirmation.open()">Cancelar</button> -->
</sweet-modal>

  <modal-print-entries  v-if="showModalPrint1" @close="showModalPrint1 = false" />
  <modal-print-general-ledger v-if="showModalPrint2" @close="showModalPrint2 = false" />
   
   <!-- {{datesToShow}} -->
   <div class="col-xs-12 text-center" v-if="datesToShow.date1">
      <h2> Desde: {{datesToShow.date1| moment("MM/DD/YYYY")}} - Hasta:{{datesToShow.date2 | moment("MM/DD/YYYY")}} </h2>
   </div> 
   <div class="col-xs-12 text-center" v-if="datesToShow.year">
      <h2> Año: {{datesToShow.year}}</h2>
   </div>

            <div class="col-xs-12">
                <div class="panel panel-default">          
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="text-center">
                              <tr class="text-center">
                                <th>#</th>
                                <th>NUMERO DE ASIENTO</th>
                                <th>FECHA</th>
                                <th>DESCRIPCION</th>
                                <th>TOTAL DEBITO</th>
                                <th>TOTAL CREDITO</th>
                                <th>ACTUALIZADO?</th>
                                <th>ACCIONES</th>            
                               </tr>
                            </thead>
                           <tbody v-if="searchData.length > 0">      
                             <tr v-for="(header, index) in searchData" :key="index">
                                <td >{{index + 1}}</td>
                                <td class="text-left"> {{header.entryNumber}}</td>
                                <td class="text-left"> {{header.entryDate | moment("MM/DD/YYYY ")}}</td>  
                                <td class="text-left"> {{header.entryDescription}}</td>
                                <td class="text-left"> {{header.totalDebit}}</td>
                                <td class="text-left"> {{header.totalCredit}}</td>
                                <td class="text-left">{{header.entryUpdated}}</td>
                                <td > 
                                 <!-- <button @click="toggle(header.headerId)" :class="{ opened: opened.includes(header.headerId) }" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Informacion de otros contactos"><i class="fa fa-user" aria-hidden="true"></i></button>   -->
                                 <!-- <button v-if="header.validation == 0" @click="validateHeader(index,header.headerId)" class="btn btn-sm btn-info" title="Validar"><i class="fa fa-clipboard-check"></i></button>  -->
                                  |
                                 <!-- <button  @click="editData(index,header.headerId)" class="btn btn-sm btn-primary" title="Editar"><i class="fa fa-edit"></i></button>   -->
                                 <button v-if="header.entryUpdated == 0" @click="deleteData(index,header.headerId)" class="btn btn-sm btn-danger" title="Eliminar"><i class="fa fa-times-circle"></i></button> 
              
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

 import ModalPrintEntries from '../ModalPrintEntries.vue'
 import ModalPrintGeneralLedger from '../ModalPrintGeneralLedger.vue'

    export default {
        mounted() {
            console.log('Component mounted.') 
            // console.log(this.transaction)
        },
        data(){
            return{
                inputSearch: '',
            
                showModalPrint1: false,
                showModalPrint2: false,

                mutaHeaderList: this.headerList,
                datesToShow:  {                    
                     date1: '',
                     date2: '',
                     year:  ''
                     },
                loading: false
            }
        },
        props: {
            headerList:   {  type: [Array], default: null},
            headerYear:   {  type: [Number], default: null},
            // headerCodes:  {  type: [Array], default: null},
        },  
      watch:{
         headerList: function headerList(data){
            this.mutaHeaderlist = data;
            this.datesToShow.year = this.headerYear;
         }
       },    
        computed: {
            searchData: function () {
                return this.headerList.filter((header) => {

                  if(header.entryDate == null ) 
                     header.entryDate = 'No Info'
                  if(header.entryDescription == null ) 
                     header.entryDescription = 'No Info'

                   return header.entryDescription.toLowerCase().includes(this.inputSearch.toLowerCase()) 
                          // transaction.transactionName.toLowerCase().includes(this.inputSearch.toLowerCase()) ||
                })
            } //end of the function searchData
        },
       components: {
         ModalPrintEntries,
         ModalPrintGeneralLedger,
       },       
       methods: {
         editData(index, id){
                this.$emit('editData', id)
            },
         deleteData(index, id){
                if (confirm(`Esta Seguro de Eliminar la Transaccion #${++index}?`) ){
                    axios.delete(`/accounting/transactions/${id}`).then((response) => {
                           toastr.success(response.data.message);
                           this.$emit('showlist', 0)
                    })
                }    
            }, 
          balanceUpdate(){
                // if (confirm(`Esta Seguro de Actualizar Todas las Transacciones?`) ){
                    axios.get(`/accounting/transacciones-encabezado/actualizarSaldos`).then((response) => {
                           toastr.success(response.data.message);
                          console.log(response)
                           this.$emit('showlist', 0)
                    })
                // }    
            },   
          validateHeader(index, id){
               if (confirm("Desea Validar este Encabezado con sus Asientos?") ){
                axios.get(`/accounting/transacciones-encabezado/${id}/validar`).then((res)=>{
                    toastr.success(response.data.message);


                    this.$emit('showlist', 0)
                })
                .catch(function (error) {
                    alert("Error")
                    console.log(error);
                });
            } //end of confirmation
          },
          changeHeaders(data,searched){
               this.mutaHeaderlist = data;
               this.datesToShow =  searched;
          }, 
          printGeneralLedger(){
            this.loading = true;

           axios.post('/accounting/reports/acc-general-ledger',{data: this.mutaHeaderlist, dateRange: this.datesToShow},{
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
                  link.setAttribute('download', 'General Ledger.pdf'); //or any other extension
                  document.body.appendChild(link);
                  link.click();
            }).catch((error)=>{
                  alert(error)
                  this.loading = false; 
            })
         }  //end of printPDF 

      } //end of methods
    }//end of vue instance

</script>
