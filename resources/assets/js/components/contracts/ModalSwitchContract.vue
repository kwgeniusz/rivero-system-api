<template>
<label>
<!-- BUTTON PARA MODAL DE CONTRATOS-->

             <a href="#" @click="openMainModal()" >
                {{this.contractNumber}}
            </a>
       
<!-- COMIENZA CODIGO DE LA VENTANA MODAL PARA DETALLES DEL CONTRATO-->
 <sweet-modal ref="mainModal">
<!-- button -->
<div class="bg-primary hover round glow" role="button" data-toggle="collapse" :href="'#'+contractNumber" aria-expanded="false" style="" >
  <i class="fa fa-chevron-circle-down"></i> Contrato {{this.contractNumber}}<br>
   <span v-if="contract != null">
        {{contract[0].siteAddress}}
   </span>
</div>
<!-- collapse -->
<div v-if="contract != null" class="collapse" :id="contractNumber">
  <div class="well">
       <!-- Using properly a better class for "p" text -->
       <div class="text-left">
       <center>
  <!--     {{contract[0]}} -->
       <b><u>Nombre del Proyecto</u></b> <br>{{contract[0].projectName}}<br>
       <b><u>Fecha</u></b> <br>{{contract[0].contractDate | moment("MM/DD/YYYY")}}<br>
       <!-- <b><u>Cliente:</u></b> <br>{{contract[0].client.clientName}}<br> -->
       <b><u>Tipo de Contrato</u></b> <br>{{contract[0].contractType}}<br>
       <b><u>Direccion:</u></b> <br>
        {{contract[0].siteAddress}}
        <br>
       <b><u>Uso</u></b> <br>{{contract[0].project_use.projectUseName}}<br>
     <div v-if="contract[0].building_code != null">
       <b><u>IBC</u></b> <br>{{contract[0].building_code.buildingCodeName}}<br>
       <b><u>Grupo</u></b> <br>{{contract[0].building_code_group.groupName}}<br>
       <b><u>Tipo de Construccion</u></b> <br>{{contract[0].constructionType}}<br><br>
     </div>
       <b><u>Comentario</u></b>
       </center>
  
       <textarea class="form-control" rows="3" v-model="contract[0].initialComment" disabled="on"></textarea>
    </div>
  </div>

</div>

<!--COMIENZO A VER LOS DETALLES DE REQUERIMIENTOS DE FACTURAS-->
<!-- button -->
<div class="bg-primary hover round glow" role="button" data-toggle="collapse" :href="'#'+contractNumber+'-scope'" aria-expanded="false" style="" >
   <i class="fa fa-chevron-circle-down"></i> Ver Alcances
</div>
<!-- collapse -->
<div v-if="contract != null" class="collapse" :id="contractNumber+'-scope'">
  <div class="well">
     <div v-for="(invoice,index) in invoicesList" >

             <div class="bg-info" role="button" data-toggle="collapse" :href="'#'+invoice.invId+'-request'" aria-expanded="false" style="" >
                         <b>Solicitud #{{++index}} {{invoice.project_description.projectDescriptionName}}</b>
              </div>
                 <!-- collapse -->
              <div  class="collapse" :id="invoice.invId+'-request'">

                <div class="well" >
                <!-- Using properly a better class for "p" text -->
                  <div class="text-left">

                  <!-- Centering the text with just a "center" tag-->
                    <center><b><u>Requerimientos</u></b></center>
                    <br>
                     <p v-for="(invoiceDetail,index1) in invoice.invoice_details">
                           - {{invoiceDetail.serviceName}}      
                     </p>

                    <center><b><u>Términos y Condiciones</u></b></center>
                    <br>
                     <p v-for="(term,index2) in invoice.proposal.term">
                           - {{term.termName}}     
                     </p>

                    <center><b><u>Alcance</u></b></center>
                    <br>
                    <p v-for="(scope,index3) in invoice.proposal.scope">
                             - {{scope.description}}
                     </p>

                       </div>
                     </div>    
                </div>

        </div>
  </div>
</div>

    <h4 class="bg-primary round glow"><b>Escoja Una Opcion</b></h4>
    <div>
    
                    <a v-if="$can('BDE')" :href="'contractsChangeStatus/'+contractId" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Estado">
                           <span class="fa fa-sync" aria-hidden="true"></span>  
                         </a>
                   
                       <a v-if="$can('BDF')" :href="'contractsStaff/'+contractId" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Personal">
                         <span class="fa fa-users" aria-hidden="true"></span> 
                          </a>
           
                       <a v-if="$can('BDG')" :href="'contractsFile/'+contractId" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Documentos">
                           <span class="fa fa-file" aria-hidden="true"></span> 
                       </a>
               
                        <a v-if="$can('BE')":href="'invoices?id='+contractId" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Facturas">
                     <span class="fa fa-money-bill-alt" aria-hidden="true"></span> 
                    </a>
                       <br>
                    <!--      <a v-if="$can('BCI')" :href="'reportsContract?id='+contractId" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Imprimir">
                     <span class="fa fa-file-pdf" aria-hidden="true"></span> 
                    </a>
 -->
                       <a :href="'contracts/'+contractId+'/edit'" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Editar">
                        <span class="fa fa-edit" aria-hidden="true"></span> 
                    </a>
                        <a v-if="$can('BDB')" :href="'contracts/'+contractId" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Eliminar">
                            <span class="fa fa-times-circle" aria-hidden="true"></span> 
                       </a>

  </div>
</sweet-modal>

</label>   
</template>

<script>

    export default {
        
     mounted() {
            // console.log('Component ModalContract mounted.')

           },
      props: {
           prefUrl: { type: String},
           contractId: { type: String, default: null}, 
           contractNumber: { type: String, default: null}, 
    },
     data: function () {
          return {
           contract: null,
           invoicesList: {}
          }
    },
    methods: {
       openMainModal: function (){
          //llamar los detalles del contrato
          axios.get('contracts/'+this.contractId).then(response => {
                 this.contract = response.data
            });

          //llamar las facturas activas del contrato, con detalles, notas, alcances
          axios.get('invoices?id='+this.contractId).then(response => {
                  this.invoicesList = response.data
                //  console.log(this.invoicesList);
            });

            this.$refs.mainModal.open()
        },
             nl2br: function(str, is_xhtml) {
        if (typeof str === 'undefined' || str === null) {
              return '';
         }
      var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
      return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
    },

      } //FIN DE METHODS
     }
</script>

<style lang="scss">
@import '../../../sass/app.scss'
</style>