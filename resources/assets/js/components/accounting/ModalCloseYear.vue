<template>
<div>

<!-- BUTTON PARA FORMULARIO MODAL DE COBRO DE CUOTA-->
       <button @click="confirm()" class="btn btn-danger btn-sm" id="drop2" >
            Cerrar Año Fiscal
       </button>

<!-- COMIENZA CODIGO DE LA VENTANA MODAL PARA CREAR AL CLIENTE-->
<!-- VENTANA MODAL PRINCIPAL PARA MOSTRAR LOS COMENTARIOS -->
 <sweet-modal ref="modal">

     <h2>Realmente Desea Cerrar el Año Contable?</h2>
       <button @click="closeYear()" v-if="btnSubmitForm" class="btn btn-success btn-sm">Confirmar</button>
       <button @click="closeModal()" class="btn btn-danger btn-sm">Cancelar</button>
</sweet-modal>

</div>   
</template>

<script>
    export default {
        
     mounted() {
          // this.$moment.tz.setDefault('UTC')
           },
     data: function () {
          return {
          btnSubmitForm: true,
          }
    },
    methods: {
       confirm: function() {
           this.$refs.modal.open();
       },
       closeModal: function() {
           this.$refs.modal.close();
       }, 
       closeYear: function() {
           this.errors = [];

      if (!this.errors.length) { 
           var url ='/accounting/close-year';
            this.btnSubmitForm = false;

          axios.get(url,).then(response => {
              console.log(response)

               toastr.info(response.data.message)
              //  this.getAllComments();
               this.$refs.modal.close();
               this.btnSubmitForm = true;

            }).catch(e => {
               toastr.error("Error de Servidor:"+ e)
               this.btnSubmitForm = true;
              })
           }//end if error.length
       },//end of method closeYear
    }
} // end of export

</script>
