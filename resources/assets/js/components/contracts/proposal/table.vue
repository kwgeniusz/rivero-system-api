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
      <!-- <a href="{{route('reports.proposals')}}" class="btn btn-danger btn-sm text-right">
                     <span class="fa fa-file-pdf" aria-hidden="true"></span> Imprimir proposales de la Corporacion
           </a> -->
        <div class="dropdown">
          <button  class="btn btn-info btn-sm" id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Opciones<span class="caret"></span>
          </button>
          <ul class="dropdown-menu" aria-labelledby="dLabel">
            <li><a v-if="$can('FE')" href="/contactTypes">Time Frames</a></li>
            <li><a v-if="$can('FE')" href="/contactTypes">Terminos y condiciones</a></li>
            <li><a v-if="$can('FE')" href="/contactTypes">Notas</a></li>
          </ul>
        </div>
           
    </div>

            <div class="col-xs-12">
                <div class="panel panel-default">          

                    <div class="table-responsive text-center">
                        <table class="table table-striped table-bordered text-center">
                            <thead>
                              <tr>
                                <th>#</th>
                                <th>COTIZACION ID</th>
                                <th>CLIENTE</th> 
                                <th>FECHA</th>
                                <th>DESCRIPCION DEL PROYECTO</th>
                                <!-- <th>MONTO TOTAL</th> -->
                                <th>CUOTAS</th>
                                <!-- <th>PROSPECTADO POR</th>  -->
                                <th>REGISTRADA POR</th> 
                                <th>ESTADO</th> 
                                <th>ACCIONES</th> 
                               </tr>
                            </thead>
                            <!-- {{searchData.proposal_status_r}} -->
                            <tbody v-if="searchData.length > 0">   
                             <tr v-for="(proposal, index) in searchData" :key="proposal.proposalId">
                                <td >{{index + 1}}</td>
                                <td class="text-left">{{proposal.propId}}</td>
                                <td class="text-left">
                                   <modal-client-details pref-url="/" 
                                    :client-id="proposal.client.clientId" 
                                    :client-name="proposal.client.clientName"
                                    :company-name="proposal.client.companyName">
                                    </modal-client-details>

                                    Tlf: {{proposal.client.businessPhone}}   <br>
                                    Correo: {{proposal.client.mainEmail}} <br>
                                    Idioma: {{proposal.client.clientLanguages}} 
                                </td>
                              
                                <td class="text-left">{{proposal.proposalDate}}</td>
                                <td class="text-left">{{proposal.project_description.projectDescriptionName}}</td>
                                <!-- <td class="text-left">{{proposal.netTotal}}</td> -->
                                <td class="text-left">{{proposal.pQuantity}}</td>
                                <!-- <td class="text-left"></td> -->
                                <td class="text-left">{{proposal.user.fullName}}</td>
                                <td class="text-left">EN PROCESO</td>
                                <td class="text-left">
                                  <button @click="subcontractors(proposal.proposalId)"  class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Subcontratistas">  <span class="fa fa-user" aria-hidden="true"></span> </button>  
                                  <!-- <a :href="`proposals/${proposal.proposalId}/subcontractors`" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Subcontratistas">
                                       <span class="fa fa-user" aria-hidden="true"></span> 
                                  </a>     -->
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
        created(){
           this.VACANT = 1;
           this.STARTED = 2;
        },
        mounted() {
            console.log('Component mounted.') 
      
        },
        data(){
            return{
                inputSearch: '',
            }
        },
        props: {
            proposalList: { type: Array},
        },  
        computed: {
            searchData: function () {
                return this.proposalList.filter((proposal) => {
                   return proposal;
                  // if(proposal.client == null ) 
                  //    proposal.client = 'No Info'
                  
                  // // return proposal.proposalName.toLowerCase().includes(this.inputSearch.toLowerCase())
                  //  return proposal.client.clientName.toLowerCase().includes(this.inputSearch.toLowerCase())  

                })
            } //end of the function searchData
        },
       methods: {
         editData(index, id){
                this.$emit('editData', id)
        },
         subcontractors(proposalId){
                this.$emit('subcontractors', proposalId)
        },
      } //end of methods
    }//end of vue instance

</script>
