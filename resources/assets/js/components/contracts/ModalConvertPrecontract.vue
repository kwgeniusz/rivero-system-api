<template>
<label>
<!-- BUTTON PARA FORMULARIO MODAL DE COBRO DE CUOTA-->
             <a class="btn btn-warning btn-sm" @click="openMainModal()" data-toggle="tooltip" data-placement="top" title="Convertir en Contrato">
               <span class="fa fa-sync" aria-hidden="true"></span>  
            </a>
       
<!-- COMIENZA CODIGO DE LA VENTANA MODAL PARA CREAR AL CLIENTE-->
 <sweet-modal ref="mainModal">
    <h4 class="bg-primary">
      <b>PROPUESTAS <br>
    DEL PRECONTRATO</b>
  </h4>

         <div class="table-responsive"  style="font-size:59%;" >
            <table class="table table-striped table-bordered text-center ">
            <thead class="bg-info">
                <tr>
                 <th></th> 
                 <th>N° PROPUESTA</th> 
                 <th>CONDICION DE PAGO</th>
                 <th>FECHA</th>
                 <th>DESCRIPCION DEL PROYECTO</th>
                 <th>SUB-TOTAL</th>
                 <th>IMPUESTO</th>
                 <th>TOTAL</th>
                 <th>CUOTAS</th>
                 </th>
                </tr>
            </thead>
                <tbody>
               <tr v-for="(item,index) in proposals">
                <td>     
                 <a v-if="item.pQuantity > 0" class="btn btn-warning btn-sm" @click.prevent="openConfirmModal(item)" data-toggle="tooltip" data-placement="top" title="Convertir">
               <span class="fa fa-sync" aria-hidden="true"></span>  
                  </a>
               </td>
                   <td>{{item.propId}}</td>
                   <td>{{item.payment_condition.pCondName}}</td>
                   <td>{{item.proposalDate}}</td>
                   <td>{{item.project_description.projectDescriptionName}}</td>
                   <td>{{item.grossTotal}}</td>
                   <td>{{item.taxAmount}}</td>
                   <td>{{item.netTotal}}</td>
                   <td>{{item.pQuantity}}</td>
         </tr>
    
                </tbody>
            </table>
        </div>
 <!-- <a class="btn btn-success" slot="button" @click.prevent="$refs.nestedChild.open()">Open Child Modal</a> -->
</sweet-modal>


     <sweet-modal ref="confirmModal">
         <h3 class="bg-danger">¿Esta seguro de Convertir <br>La Propuesta #{{this.proposalSelected.propId}}?</h3>
              <br>
              <a v-if="btnSubmit" class="btn btn-success btn-lg" @click.prevent="convertPrecontract()" >SI</a>
              <a v-if="btnSubmit"class="btn btn-danger btn-lg" @click.prevent="$refs.confirmModal.close()">NO</a>
              <div v-if="!btnSubmit">Cargando...</div>
     </sweet-modal>

</label>   
</template>

<script>

    export default {
        
     mounted() {
            console.log('Component ModalConvertPrecontract mounted.')

           },
      props: {
           precontractId: { type: String, default: null}, 
           prefUrl: { type: String},
    },
     data: function () {
          return {
            proposals: {},
            proposalSelected: {},
            btnSubmit: true,
          }
    },
    methods: {
       openMainModal: function (){
          axios.get('proposals?id='+this.precontractId).then(response => {
                 this.proposals = response.data
            });
            this.$refs.mainModal.open()
        },
      openConfirmModal: function (item){
           this.proposalSelected = item;
           this.$refs.confirmModal.open()
        },
      convertPrecontract: function () {
       this.btnSubmit = false;
        var url =this.prefUrl+'precontractsConvert/add/'+this.proposalSelected.proposalId;
        axios.post(url,{
             id: this.proposalSelected.proposalId,
            }).then(response => {
                 if (response.data.alert == "error") {
                       toastr.error(response.data.message)
                         this.btnSubmit = true;
                   } else {
                       window.location.href = './contracts'
                       toastr.success('Conversion exitosa, Sera redirigido a la lista de contratos.')
                   }
            })

        },
      }
     }
</script>