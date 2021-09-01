<template>
  <div >

    <div class="col-xs-4">
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
        <div class="dropdown">
          <button  class="btn btn-info btn-sm" id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Opciones<span class="caret"></span>
          </button>
          <ul class="dropdown-menu" aria-labelledby="dLabel">
            <li><a v-if="$can('FE')" @click="balanceUpdate" href="#">Actualizar Asientos Contables</a></li>
          </ul>
        </div>           
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
                                <th>ACCIONES</th>            
                               </tr>
                            </thead>
                           <tbody v-if="searchData.length > 0">      
                             <tr v-for="(header, index) in searchData" :key="index">
                                <td >{{index + 1}}</td>
                                <td class="text-left"> {{header.entryNumber}}</td>
                                <td class="text-left"> {{header.entryDate | moment("MM/DD/YYYY ")}}</td>  
                                <td class="text-left"> {{header.entryDescription}}</td>
                                <td class="text-left"> - {{header.totalDebit}}</td>
                                <td class="text-left"> + {{header.totalCredit}}</td>
                                <td> 
                                 <!-- <button @click="toggle(header.headerId)" :class="{ opened: opened.includes(header.headerId) }" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Informacion de otros contactos"><i class="fa fa-user" aria-hidden="true"></i></button>   -->
                                 <button class="btn btn-sm btn-warning" title="Validar"><i class="fa fa-clipboard-check"></i></button> 
                                  |
                                 <button @click="editData(index,header.headerId)" class="btn btn-sm btn-primary" title="Editar"><i class="fa fa-edit"></i></button>  
                                 <button @click="deleteData(index,header.headerId)" class="btn btn-sm btn-danger" title="Eliminar"><i class="fa fa-times-circle"></i></button> 
              
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
    export default {
        mounted() {
            console.log('Component mounted.') 
            // console.log(this.transaction)
        },
        data(){
            return{
                inputSearch: '',
            }
        },
        props: {
            headerList: { type: Array},
        },  
        computed: {
            searchData: function () {
                return this.headerList.filter((transaction) => {

                  if(transaction.companyName == null ) 
                     transaction.companyName = 'No Info'
                  if(transaction.transactionName == null ) 
                     transaction.transactionName = 'No Info'
                  if(transaction.transactionAddress == null ) 
                     transaction.transactionAddress = 'No Info'
                  if(transaction.businessPhone == null ) 
                     transaction.businessPhone = 'No Info'
                  if(transaction.mainEmail == null ) 
                     transaction.mainEmail = 'No Info'
                  
                  // return transaction.transactionName.toLowerCase().includes(this.inputSearch.toLowerCase())
                   return transaction.companyName.toLowerCase().includes(this.inputSearch.toLowerCase()) ||
                          transaction.transactionName.toLowerCase().includes(this.inputSearch.toLowerCase()) ||
                          transaction.transactionAddress.toLowerCase().includes(this.inputSearch.toLowerCase()) ||
                          transaction.businessPhone.toLowerCase().includes(this.inputSearch.toLowerCase()) ||
                          transaction.mainEmail.toLowerCase().includes(this.inputSearch.toLowerCase()) 
                  
                })
            } //end of the function searchData
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
                    axios.get(`/accounting/transacciones/actualizarSaldos`).then((response) => {
                           toastr.success(response.data.message);
                          console.log(response)
                           this.$emit('showlist', 0)
                    })
                // }    
            },   
  
      } //end of methods
    }//end of vue instance

</script>
