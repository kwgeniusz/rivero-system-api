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
                                <th>transactionId</th>
                                <th>generalLedgerId</th>
                                <th>date</th>
                                <th>debit</th>
                                <th>credit</th>
                                <th>conversionRate</th>
                                <th>debitSecond</th>
                                <th>creditSecond</th>
                                <th>entityName</th>
                                <th>entityId</th>            
                               </tr>
                            </thead>
                           <tbody v-if="auxiliaryList.length > 0">      
                             <tr v-for="(auxiliary, index) in auxiliaryList" :key="index">
                                <td >{{index + 1}}</td>
                                <td class="text-left"> {{auxiliary.transactionId}}</td>
                                <td class="text-left"> {{auxiliary.generalLedgerId}}</td>
                                <td class="text-left"> {{auxiliary.date}}</td>
                                <td class="text-left"> {{auxiliary.debit}}</td>  
                                <td class="text-left"> {{auxiliary.credit}}</td>
                                <td class="text-left"> {{auxiliary.conversionRate}}</td>
                                <td class="text-left"> {{auxiliary.debitSecond}}</td>
                                <td class="text-left"> {{auxiliary.creditSecond}}</td>
                                <td class="text-left"> {{auxiliary.entityName}}</td>
                                <td class="text-left"> {{auxiliary.entityId}}</td>
                                <!-- <td> 
                                 <button @click="toggle(auxiliary.auxiliaryId)" :class="{ opened: opened.includes(auxiliary.auxiliaryId) }" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Informacion de otros contactos"><i class="fa fa-user" aria-hidden="true"></i></button>  
                                 <button @click="editData(index,auxiliary.auxiliaryId)" class="btn btn-sm btn-primary" title="Editar"><i class="fa fa-edit"></i></button>  
                                 <button @click="deleteData(index,auxiliary.auxiliaryId)" class="btn btn-sm btn-danger" title="Eliminar"><i class="fa fa-times-circle"></i></button> 
                                </td> -->
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
            // console.log(this.auxiliary)
        },
        data(){
            return{
                inputSearch: '',
            }
        },
        props: {
            auxiliaryList: { type: Array},
        },  
        computed: {
            // searchData: function () {
            //     return this.auxiliaryList.filter((client) => {

            //       if(client.companyName == null ) 
            //          client.companyName = 'No Info'
            //       if(client.clientName == null ) 
            //          client.clientName = 'No Info'
            //       if(client.clientAddress == null ) 
            //          client.clientAddress = 'No Info'
            //       if(client.businessPhone == null ) 
            //          client.businessPhone = 'No Info'
            //       if(client.mainEmail == null ) 
            //          client.mainEmail = 'No Info'
                  
            //       // return client.clientName.toLowerCase().includes(this.inputSearch.toLowerCase())
            //        return client.companyName.toLowerCase().includes(this.inputSearch.toLowerCase()) ||
            //               client.clientName.toLowerCase().includes(this.inputSearch.toLowerCase()) ||
            //               client.clientAddress.toLowerCase().includes(this.inputSearch.toLowerCase()) ||
            //               client.businessPhone.toLowerCase().includes(this.inputSearch.toLowerCase()) ||
            //               client.mainEmail.toLowerCase().includes(this.inputSearch.toLowerCase()) 
                  
            //     })
            // } //end of the function searchData
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
