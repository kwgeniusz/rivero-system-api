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
      <!-- <a href="{{route('reports.contracts')}}" class="btn btn-danger btn-sm text-right">
                     <span class="fa fa-file-pdf" aria-hidden="true"></span> Imprimir contractes de la Corporacion
           </a> -->
        <!-- <div class="dropdown">
          <button  class="btn btn-info btn-sm" id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Opciones<span class="caret"></span>
          </button>
          <ul class="dropdown-menu" aria-labelledby="dLabel">
            <li><a v-if="$can('FE')" href="/contactTypes">¿Como nos Contacto?</a></li>
          </ul>
        </div> -->
           
    </div>

            <div class="col-xs-12">
                <div class="panel panel-default">          

                    <div class="table-responsive text-center">
                        <table class="table table-striped table-bordered text-center">
                            <thead>
                              <tr>
                                  <th>#</th>
                                  <th>NUMERO DE CONTRATO</th>
                                  <th>CLIENTE</th>   
                                  <th>DIRECCION / NOMBRE DEL PROYECTO</th>
                                  <th>DESCRIPCION</th>
                                  <th>USO</th>
                                  <th>TIPO</th>
                                  <th>FECHA DE CREACION</th>
                                  <th>CONVERTIDO POR </th>
                                  <th>ESTADO</th>          
                               </tr>
                            </thead>
                            <tbody v-if="searchData.length > 0">   
                             <tr v-for="(contract, index) in searchData" :key="contract.contractId">
                                <!-- <td >{{index + 1}}</td>
                                <td class="text-left"> 
                                  <modal-switch-contract 
                                     pref-url="/" 
                                     contract-id="contract.contractId"
                                     contract-number="contract.contractNumber">
                                  </modal-switch-contract>

                                   <comments-contract v-if="$can('BDE')" pref-url=""
                                    contract-id="contract.contractId"
                                     contract-number="contract.contractNumber">
                                     </comments-contract>

                                </td>
                                <td class="text-left"> 
                                    <modal-contract-details pref-url="/" 
                                    :contract-id="contract.contractId" 
                                    :contract-name="contract.contractName"
                                    :company-name="contract.companyName">
                                    </modal-contract-details>
                                </td>
                                <td class="text-left"> 
                                  {{contract.siteAddress}}
                                      <br> 
                                    @if(contract.projectName) 
                                     ( {{contract.projectName}} )
                                    @endif 
                               </td> 
                                <td class="text-left"> 
                                  <p v-for="(invoice,index) in contract.invoice" :key="otherContact.otherContactId">
                                    - {{invoice.projectDescription.projectDescriptionName}}<br>
                                  </p>
                               </td>  
                                 <td>{{contract.projectUse.projectUseName}}   </td>
                                 <td>{{contract.contractType}}   </td>
                                 <td>{{contract.contractDate}}   </td>
                                 <td>{{contract.user.fullName}}   </td>
                                  <td data-toggle="tooltip" data-placement="top" title="{{contract.contractStatusR[0].contStatusName}}"
                                    @if($contract.contractStatus == App\Contract::VACANT)
                                    style="background-color: #3c8ddc;color:white;" 
                                    @elseif($contract.contractStatus == App\Contract::STARTED)
                                     style="background-color: #2ab25b;color:white;" 
                                     @elseif($contract.contractStatus == App\Contract::READY_BUT_PENDING_PAYABLE)
                                     style="background-color: #cbb956;color:white;" 
                                    @elseif($contract.contractStatus == App\Contract::PROCESSING_PERMIT)
                                     style="background-color: #f39c12;color:white;" 
                                     @elseif($contract.contractStatus == App\Contract::WAITING_contract)
                                     style="background-color: red;color:white;"  
                                    @elseif($contract.contractStatus == App\Contract::DOWNLOADING_FILES)
                                     style="background-color: #666666; color:white;"    
                                    @elseif($contract.contractStatus == App\Contract::SENT_TO_OFFICE)
                                     style="background-color: #5dc1b9; color:white;"    
                                    @endif
                                    >
                                 </td> 
                                <td> 
                                 <button @click="editData(index,contract.contractId)" class="btn btn-sm btn-primary" title="Editar"><i class="fa fa-edit"></i></button>  
                                 <button @click="deleteData(index,contract.contractId)" class="btn btn-sm btn-danger" title="Eliminar"><i class="fa fa-times-circle"></i></button> 
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
            console.log(this.contractList)
        },
        data(){
            return{
                inputSearch: '',
                activeItem: 'home', //para los tags
                opened: [], //para el toogle
            }
        },
        props: {
            contractList: { type: Array},
        },  
        computed: {
            searchData: function () {
                return this.contractList.filter((contract) => {

                  // if(contract.companyName == null ) 
                  //    contract.companyName = 'No Info'
                  // if(contract.contractName == null ) 
                  //    contract.contractName = 'No Info'
                  // if(contract.contractAddress == null ) 
                  //    contract.contractAddress = 'No Info'
                  // if(contract.businessPhone == null ) 
                  //    contract.businessPhone = 'No Info'
                  // if(contract.mainEmail == null ) 
                  //    contract.mainEmail = 'No Info'
                  
                  // // return contract.contractName.toLowerCase().includes(this.inputSearch.toLowerCase())
                  //  return contract.companyName.toLowerCase().includes(this.inputSearch.toLowerCase()) ||
                  //         contract.contractName.toLowerCase().includes(this.inputSearch.toLowerCase()) ||
                  //         contract.contractAddress.toLowerCase().includes(this.inputSearch.toLowerCase()) ||
                  //         contract.businessPhone.toLowerCase().includes(this.inputSearch.toLowerCase()) ||
                  //         contract.mainEmail.toLowerCase().includes(this.inputSearch.toLowerCase()) 
                  
                })
            } //end of the function searchData
        },
       methods: {
         editData(index, id){
                this.$emit('editData', id)
        },
        toggle(id) {
         const index = this.opened.indexOf(id);
         if (index > -1) {
           this.opened.splice(index, 1)
         } else {
           this.opened.push(id)
         }
       }, 
       isActive (menuItem) {
        return this.activeItem === menuItem
       },
       setActive (menuItem) {
        this.activeItem = menuItem
       }

      } //end of methods
    }//end of vue instance

</script>
