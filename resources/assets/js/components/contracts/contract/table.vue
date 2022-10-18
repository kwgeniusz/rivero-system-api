<template>
   <div>
    <div class="col-xs-4">

    </div>   

    <div class="col-xs-4">
      <ul class="list-group">
        <li class="list-group-item">
            <input type="text" placeholder="Buscar" class="form-control" v-model="inputSearch">
        </li>
       </ul>
    </div> 
<!-- <button v-popover:foo>Toggle popover</button> -->
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
                                  <!-- <th>USO</th> -->
                                  <!-- <th>TIPO</th> -->
                                  <th>CONVERTIDO POR </th>
                                  <th>ESTADO</th>
                                  <th>ALERTA</th>
                                  <th>FECHA DE CREACION</th>
                                  <!-- <th data-toggle="tooltip" data-placement="top" title="DIAS DE TRABAJO ESTIMADO">D.T.E </th> -->
                                  <!-- <th data-toggle="tooltip" data-placement="top" title="HORAS DE TRABAJO ESTIMADO">H.T.E</th> -->
                                  <!-- <th data-toggle="tooltip" data-placement="top" title="DIAS CONSECUTIVOS TRANSCURRIDOS">D.C.T </th> -->
                                  <!-- <th data-toggle="tooltip" data-placement="top" title="DIAS PARA ENTREGAR">D.P.E </th> -->
                                  <!-- <th data-toggle="tooltip" data-placement="top" title="FECHA LIMITE DE ENTREGA">F.L.E</th> -->
                               </tr>
                            </thead>
                            <!-- {{searchData.contract_status_r}} -->
                            <tbody v-if="searchData.length > 0">   
                             <tr v-for="(contract, index) in searchData" :key="contract.contractId">
                               <!-- {{contract}} -->
                                <td >{{index + 1}}</td>
                                <td class="text-left"> 
                                  <modal-switch-contract 
                                     pref-url="/" 
                                     :contract-id="contract.contractId"
                                     :contract-number="contract.contractNumber">
                                  </modal-switch-contract>

                                   <comments-contract v-if="$can('BDE')" 
                                     :componentNumber="index"
                                     pref-url=""
                                     :contract-id="contract.contractId"
                                     :contract-number="contract.contractNumber">
                                     </comments-contract>

                                </td>
                                <td class="text-left"> 
                                    <modal-client-details pref-url="/" 
                                    :client-id="contract.client.clientId" 
                                    :client-name="contract.client.clientName"
                                    :company-name="contract.client.companyName">
                                    </modal-client-details>
                                </td>
                                <td class="text-left"> 
                                  {{contract.siteAddress}}
                                    <br> 
                                  <p v-if="contract.projectName">( {{contract.projectName}} ) </p>
                               </td> 
                                <td class="text-left"> 
                                  <p v-for="(invoice,index) in contract.invoice" :key="invoice.invoiceId">
                                    - {{invoice.project_description.projectDescriptionName}}<br>
                                  </p>
                               <b>USO:</b> {{contract.project_use.projectUseName}}  <br>
                               <b>TIPO:</b> {{contract.contractType}}   
                               </td>  

                                 <!-- <td>{{contract.project_use.projectUseName}}   </td>
                                 <td>{{contract.contractType}}   </td> -->
                                 <td>{{contract.user.fullName}}   </td>
                                
                                 <!-- data-toggle="tooltip" data-placement="top" :title="contract.contract_status_r[0].contStatusName" -->
                                 <td v-if="contract.contractStatus == VACANT"  style="background-color: #3c8ddc;color:white;" > <a data-toggle="tooltip" data-placement="left"  :title="contract.contract_status_r[0].contStatusName">VER</a> </td>
                                 <td v-if="contract.contractStatus == STARTED"  style="background-color: #2ab25b;color:white;" > <a data-toggle="tooltip" data-placement="left"  :title="contract.contract_status_r[0].contStatusName">VER</a> </td>
                                 <td v-if="contract.contractStatus == READY_BUT_PENDING_PAYABLE"  style="background-color: #cbb956;color:white;" > <a data-toggle="tooltip" data-placement="left"  :title="contract.contract_status_r[0].contStatusName">VER</a> </td>
                                 <td v-if="contract.contractStatus == PROCESSING_PERMIT"  style="background-color: #f39c12;color:white;" > <a data-toggle="tooltip" data-placement="left"  :title="contract.contract_status_r[0].contStatusName">VER</a> </td>
                                 <td v-if="contract.contractStatus == WAITING_CLIENT"  style="background-color: red;color:white;" > <a data-toggle="tooltip" data-placement="left"  :title="contract.contract_status_r[0].contStatusName">VER</a> </td>
                                 <td v-if="contract.contractStatus == DOWNLOADING_FILES"  style="background-color: #666666;color:white;" > <a data-toggle="tooltip" data-placement="left"  :title="contract.contract_status_r[0].contStatusName">VER</a> </td>
                                 <td v-if="contract.contractStatus == SENT_TO_OFFICE"  style="background-color: #5dc1b9;color:white;" > <a data-toggle="tooltip" data-placement="left"  :title="contract.contract_status_r[0].contStatusName">VER</a> </td>
                                 <td v-if="contract.contractStatus == IN_PRODUCTION_QUEUE"  style="background-color: #7d2181;color:white;" > <a data-toggle="tooltip" data-placement="left"  :title="contract.contract_status_r[0].contStatusName">VER</a> </td>
                                 <td v-if="contract.contractStatus == SENT_TO_ENGINEER"  style="background-color: #804000 ;color:white;" > <a data-toggle="tooltip" data-placement="left"  :title="contract.contract_status_r[0].contStatusName">VER</a> </td>
                                 <td v-if="contract.contractStatus == WAITING_FOR_ADMINISTRATION"  style="background-color: #5e2129 ;color:white;" > <a data-toggle="tooltip" data-placement="left"  :title="contract.contract_status_r[0].contStatusName">VER</a> </td>
                                 <td v-if="contract.contractStatus == EXPORTED_TO_NEW_COMPANY"  style="background-color: black ;color:white;" > <a data-toggle="tooltip" data-placement="left"  :title="contract.contract_status_r[0].contStatusName">VER</a> </td>
                                 <td  v-if="contract.daysToDelivery < 0 " style="background-color: red;color:white;" :title="`DIAS DE TRABAJO ESTIMADO: ${contract.estimatedWorkDays} 
HORAS DE TRABAJO ESTIMADO: ${contract.estimatedWorkDays*8}
DIAS CONSECUTIVOS TRANSCURRIDOS: ${contract.consecutiveDaysElapsed}
DIAS PARA ENTREGAR: ${contract.daysToDelivery}`">  RETRASADO </td>
                                 <td  v-else style="background-color: green; color:white;" :title="`DIAS DE TRABAJO ESTIMADO: ${contract.estimatedWorkDays} 
HORAS DE TRABAJO ESTIMADO: ${contract.estimatedWorkDays*8}
DIAS CONSECUTIVOS TRANSCURRIDOS: ${contract.consecutiveDaysElapsed}
DIAS PARA ENTREGAR: ${contract.daysToDelivery}`"> A TIEMPO </td>
                                 <td>{{contract.contractDate | moment("MM/DD/YYYY hh:mm A")}} <br>
                                 <b>FECHA LIMITE DE ENTREGA:</b>  {{contract.productionDeliveryDate}}  </td>
                                 <!-- <td> {{contract.estimatedWorkDays}}  </td> -->
                                 <!-- <td> {{contract.estimatedWorkDays*8}}  </td> -->
                                 <!-- <td> {{contract.consecutiveDaysElapsed}} </td> -->
                                 <!-- <td> {{contract.daysToDelivery}} </td> -->
                                 <!-- <td> {{contract.deliveryDate.date | moment("MM/DD/YYYY")}} </td> -->
                                <!-- <td data-toggle="tooltip" data-placement="top" title="{{contract.contractStatusR[0].contStatusName}}"></td>  -->
                                <!-- <td> 
                                 <button @click="editData(index,contract.contractId)" class="btn btn-sm btn-primary" title="Editar"><i class="fa fa-edit"></i></button>  
                                 <button @click="deleteData(index,contract.contractId)" class="btn btn-sm btn-danger" title="Eliminar"><i class="fa fa-times-circle"></i></button> 
                                </td>  -->
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
        created(){
           this.VACANT = 1;
           this.STARTED = 2;
           this.FINISHED = 3;
           this.CANCELLED = 4;
           this.READY_BUT_PENDING_PAYABLE = 5;
           this.PROCESSING_PERMIT = 6;
           this.WAITING_CLIENT = 7;
           this.DOWNLOADING_FILES = 8;
           this.SENT_TO_OFFICE = 9;
           this.IN_PRODUCTION_QUEUE = 10;
           this.SENT_TO_ENGINEER = 11;
           this.WAITING_FOR_ADMINISTRATION = 12;
           this.EXPORTED_TO_NEW_COMPANY = 13;

        },
        mounted() {
            console.log('Component mounted.') 
            // console.log(this.contractList)
        },
        data(){
            return{
                inputSearch: '',
            }
        },
        props: {
            contractList: { type: Array},
        },  
        computed: {
            searchData: function () {
                return this.contractList.filter((contract) => {
                  // console.log(contract.contract_status_r[0].contStatusName)
                  if(contract.projectName == null ) 
                     contract.projectName = 'No Info'
                  
                  // return contract.contractName.toLowerCase().includes(this.inputSearch.toLowerCase())
                   return contract.contractNumber.toLowerCase().includes(this.inputSearch.toLowerCase()) ||
                          contract.client.clientName.toLowerCase().includes(this.inputSearch.toLowerCase()) ||
                          contract.siteAddress.toLowerCase().includes(this.inputSearch.toLowerCase()) ||
                          contract.contract_status_r[0].contStatusName.toLowerCase().includes(this.inputSearch.toLowerCase()) ||
                          contract.projectName.toLowerCase().includes(this.inputSearch.toLowerCase())  
                          
                          
                })
            } //end of the function searchData
        },
       methods: {
         editData(index, id){
                this.$emit('editData', id)
        },

      } //end of methods
    }//end of vue instance

</script>
