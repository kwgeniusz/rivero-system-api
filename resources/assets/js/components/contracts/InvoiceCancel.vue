
<template> 
    <div> 
<!-- BUTTON PARA FORMULARIO MODAL DE COBRO DE CUOTA-->
             <a class="btn btn-danger btn-sm" @click="openModal()" data-toggle="tooltip" data-placement="top" title="Anular">
              <span  class="fa fa-money-bill-alt" aria-hidden="true"></span>
            </a>
<!-- MODALS -->
   <sweet-modal icon="error" overlay-theme="dark" modal-theme="dark" ref="modalCanceling">
        <h2>¿Esta seguro de que desea Anular Esta Factura</h2> <br>
        <div class="text-center">
             N° Factura: {{invId}}
              <!-- {{invoice}} -->
           <!--    {{invoice.contract.contractNumber}} 
              {{invoice.contract.siteAddress}}
              {{invoice.invoiceDate}}
              {{invoice.projescription.projescriptionName}}
              {{invoice.netTotal}}
              {{invoice.balance}}
              {{invoice.shareSucceed}}
              {{invoice->pQuantity}}   -->
        </div>
        <br>
        <button class="btn btn-danger" @click="cancelInvoice">Confirmar</button>
  </sweet-modal>


    </div>
 </template>

 <script>

export default {
        
     mounted() {
         
        },
    data: function() {
        return {

        }
    },
    props: {
        invId:'',
        invoiceId:''
    },
    methods: {
        openModal: function() {
             this.$refs.modalCanceling.open()
             // console.log(typeof(this.invoiceId));
          },
          cancelInvoice: function() {
            // si this.checked no esta vacio ejecuta la funcion de borra multiple
            alert('anulando');
            // if(Object.keys(this.checked).length != 0) {
               var url ='invoices/'+this.invoiceId+'/changeStatus';
               axios.put(url,{
                 newStatus :  'CANCELLED'
                  }).then(response => {
                    this.$refs.modalCanceling.close();
                    toastr.success('Factura Anulada');
                    location.reload();

                  });
             }
          },
    } //end of methods
       // this.$forceUpdate()

 </script>
  
