<template>
<label>
<!-- BUTTON PARA MODAL DE CONTRATOS-->

             <a href="#" @click="openMainModal()" >
                {{this.contractNumber}}
            </a>
       
<!-- COMIENZA CODIGO DE LA VENTANA MODAL PARA CREAR AL CLIENTE-->
 <sweet-modal ref="mainModal">
<!-- button -->
<div class="bg-primary" role="button" data-toggle="collapse" :href="'#'+contractNumber" aria-expanded="false" >
   Contrato {{this.contractNumber}}
</div>
<!-- collapse -->
<div v-if="contract != null" class="collapse" :id="contractNumber">
  <div class="well">
    <h4>
       <b><u>Nombre del Proyecto:</u></b> <br>{{contract[0].projectName}}<br>
       <b><u>Fecha:</u></b> <br>{{contract[0].contractDate | moment("MM/DD/YYYY")}}<br>
       <!-- <b><u>Cliente:</u></b> <br>{{contract[0].client.clientName}}<br> -->
       <b><u>Tipo de Contrato:</u></b> <br>{{contract[0].contractType}}<br>
       <b><u>Direccion:</u></b> <br>
        {{contract[0].propertyNumber}}
        {{contract[0].streetName}}
        {{contract[0].streetType}}<br>
        {{contract[0].suiteNumber}}
        {{contract[0].city}}
        {{contract[0].state}}
        {{contract[0].zipCode}} 
       <br>
       <b><u>IBC:</u></b> <br>{{contract[0].building_code.buildingCodeName}}<br>
       <b><u>Grupo:</u></b> <br>{{contract[0].building_code_group.groupName}}<br>
       <b><u>Uso:</u></b> <br>{{contract[0].project_use.projectUseName}}<br>
       <b><u>Tipo de Construccion:</u></b> <br>{{contract[0].constructionType}}<br><br>
       <b><u>Comentario:</u></b>
       <br>
       <!-- {{contract[0].initialComment}}  -->
       <textarea class="form-control" rows="3" v-model="contract[0].initialComment" disabled="on"></textarea>
    </h4>
  </div>

</div>

    <h4 class="bg-primary"><b>Escoga Una Opcion</b></h4>
    <div class="bg-info">
    
                    <a v-if="$can('BCE')" :href="'contractsChangeStatus/'+contractId" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Estado">
                           <span class="fa fa-sync" aria-hidden="true"></span>  
                         </a>
                   
                       <a v-if="$can('BCF')" :href="'contractsStaff/'+contractId" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Personal">
                         <span class="fa fa-users" aria-hidden="true"></span> 
                          </a>
           
                       <a v-if="$can('BCG')" :href="'contractsFile/'+contractId" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Documentos">
                           <span class="fa fa-file" aria-hidden="true"></span> 
                       </a>
               
                        <a v-if="$can('BCH')":href="'invoices?id='+contractId" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Facturas">
                     <span class="fa fa-money-bill-alt" aria-hidden="true"></span> 
                    </a>
                       <br>
                         <a v-if="$can('BCI')" :href="'reportsContract?id='+contractId" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Imprimir">
                     <span class="fa fa-file-pdf" aria-hidden="true"></span> 
                    </a>

                       <a v-if="$can('BCC')" :href="'contracts/'+contractId+'/edit'" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Editar">
                        <span class="fa fa-edit" aria-hidden="true"></span> 
                    </a>
                        <a v-if="$can('BCB')" :href="'contracts/'+contractId" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Eliminar">
                            <span class="fa fa-times-circle" aria-hidden="true"></span> 
                       </a>

  </div>
</sweet-modal>

</label>   
</template>

<script>

    export default {
        
     mounted() {
            console.log('Component ModalContract mounted.')

           },
      props: {
           prefUrl: { type: String},
           contractId: { type: String, default: null}, 
           contractNumber: { type: String, default: null}, 
    },
     data: function () {
          return {
           contract: null,
          }
    },
    methods: {
       openMainModal: function (){
          axios.get('contracts/'+this.contractId+'/details').then(response => {
                 this.contract = response.data
            });
            this.$refs.mainModal.open()
        },
      // findContract: function () {
      //  this.btnSubmit = false;
      //   var url =this.prefUrl+'precontractsConvert/add/'+this.proposalSelected.proposalId;
      //   axios.post(url,{
      //        id: this.proposalSelected.proposalId,
      //       }).then(response => {
      //            if (response.data.alert == "error") {
      //                  toastr.error(response.data.message)
      //                    this.btnSubmit = true;
      //              } else {
      //                  window.location.href = './contracts'
      //                  toastr.success('Conversion exitosa, Sera redirigido a la lista de contratos.')
      //              }
      //       })

      //   },
      }
     }
</script>