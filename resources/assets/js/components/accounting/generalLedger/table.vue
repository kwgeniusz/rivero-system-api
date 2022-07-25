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
        <!-- <div class="dropdown">
          <button  class="btn btn-info btn-sm" id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Opciones<span class="caret"></span>
          </button>
          <ul class="dropdown-menu" aria-labelledby="dLabel">
            <li><a v-if="$can('FE')" href="/contactTypes">¿Como nos Contacto?</a></li>
          </ul>
        </div>
            -->
    </div>

            <div class="col-xs-12">
                <div class="panel panel-default">          
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="text-center">
                              <tr class="text-center">
                                <th>#</th>
                                <th>CUENTA PADRE</th>
                                <th>CODIGO DE CUENTA</th>
                                <th>NOMBRE DE CUENTA</th>
                                <th>CLASIFICACION</th>
                                <th>TIPO</th> 
                                <th>ACCIONES</th>            
                               </tr>
                            </thead>
                           <tbody v-if="searchData.length > 0">      
                             <tr v-for="(generalLedger, index) in searchData" :key="index">
                                <td >{{index + 1}}</td>
                                <td class="text-left"> {{generalLedger.parentAccountId}}</td>
                                <td class="text-left"> {{generalLedger.accountCode}}</td>
                                <td class="text-left"> {{generalLedger.accountName}}</td>
                                <td class="text-left"> {{generalLedger.account_classification.accountClassificationName}}</td>  
                                <td class="text-left"> {{generalLedger.account_type.accountTypeName}}</td>
                                <td> 
                                 <!-- <button @click="toggle(generalLedger.generalLedgerId)" :class="{ opened: opened.includes(generalLedger.generalLedgerId) }" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Informacion de otros contactos"><i class="fa fa-user" aria-hidden="true"></i></button>   -->
                                 <a v-if="generalLedger.account_type.accountTypeCode == 2" :href="`general-ledgers/${generalLedger.generalLedgerId}/auxiliaries`" class="btn btn-sm btn-info" title="Auxiliares"><i class="fa fa-book"></i></a> 
                                  
                                 <button @click="editData(index,generalLedger.generalLedgerId)" class="btn btn-sm btn-primary" title="Editar"><i class="fa fa-edit"></i></button>  
                                 <button @click="deleteData(index,generalLedger.generalLedgerId)" class="btn btn-sm btn-danger" title="Eliminar"><i class="fa fa-times-circle"></i></button> 
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
            // console.log(this.generalLedger)
        },
        data(){
            return{
                inputSearch: '',
            }
        },
        props: {
            generalLedgerList: { type: Array},
        },  
        computed: {
            searchData: function () {
                return this.generalLedgerList.filter((client) => {

                  if(client.companyName == null ) 
                     client.companyName = 'No Info'
                  if(client.clientName == null ) 
                     client.clientName = 'No Info'
                  if(client.clientAddress == null ) 
                     client.clientAddress = 'No Info'
                  if(client.businessPhone == null ) 
                     client.businessPhone = 'No Info'
                  if(client.mainEmail == null ) 
                     client.mainEmail = 'No Info'
                  
                  // return client.clientName.toLowerCase().includes(this.inputSearch.toLowerCase())
                   return client.companyName.toLowerCase().includes(this.inputSearch.toLowerCase()) ||
                          client.clientName.toLowerCase().includes(this.inputSearch.toLowerCase()) ||
                          client.clientAddress.toLowerCase().includes(this.inputSearch.toLowerCase()) ||
                          client.businessPhone.toLowerCase().includes(this.inputSearch.toLowerCase()) ||
                          client.mainEmail.toLowerCase().includes(this.inputSearch.toLowerCase()) 
                  
                })
            } //end of the function searchData
        },
       methods: {
         editData(index, id){
                this.$emit('editData', id)
            },
       deleteData(index, id){
                if (confirm(`Esta Seguro de Eliminar la Cuenta #${++index}?`) ){
                    axios.delete(`/accounting/general-ledgers/${id}`).then((response) => {
                           toastr.success(response.data.message);
                           this.$emit('showlist', 0)
                    })
                }    
            }, 
  
      } //end of methods
    }//end of vue instance

</script>
