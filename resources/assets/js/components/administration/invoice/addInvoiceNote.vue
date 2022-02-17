<template>
<div>

<!-- BUTTON PARA FORMULARIO MODAL DE COBRO DE CUOTA-->
           <a @click="modalMain()" class="btn btn-default btn-sm">
                <i class="fa fa-comments" aria-hidden="true"></i> Agregar Nota de Texto a Factura 
           </a>

<!-- COMIENZA CODIGO DE LA VENTANA MODAL PARA CREAR AL CLIENTE-->
<!-- VENTANA MODAL PRINCIPAL PARA MOSTRAR LOS COMENTARIOS -->
 <sweet-modal ref="modal" width="90%">
     <invoice-notes :invoice-id="invoiceId" ref="invoiceNotes"></invoice-notes>
      
     <br><br>

      <a @click.prevent="saveNotes()" class="btn btn-success">
        <span class="fa fa-save" aria-hidden="true"></span>  Guardar 
      </a>
</sweet-modal>

</div>   
</template>

<script>
import InvoiceNotes from './InvoiceNotes.vue'

    export default {
        
     mounted() {
          // this.$moment.tz.setDefault('UTC')
           },
     data: function () {
          return {
          }
    },
    components: {
          InvoiceNotes,
  //        InvoiceScopes
   }, 
    props: {
          invoiceId: { type: Number},
          },
    methods: {
         modalMain: function() {
         //obtener los detalles del contrato
          // axios.get(this.prefUrl+'contracts/'+this.invoiceId).then(response => {
          //        this.in = response.data[0]
          //   });
          //  this.getAllComments();
           this.$refs.modal.open();
         },
         saveNotes: function() {
           this.$refs.invoiceNotes.sendNotes();
         }
       },
    
}

</script>

