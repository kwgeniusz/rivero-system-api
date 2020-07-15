
<template> 
    <div> 
<!-- BUTTON PARA FORMULARIO MODAL DE COBRO DE CUOTA-->
             <a class="btn btn-warning btn-sm" @click="openModal()" data-toggle="tooltip" data-placement="top" title="Enviar a Collection">
<<<<<<< HEAD
              <span class="fa fa-sync" aria-hidden="true"></span>  
=======
              <i class="fa fa-sync" aria-hidden="true"></i>  
>>>>>>> aeefe06fae0c63d443ebaeb83e6950cd9ff2b9de
            </a>
<!-- MODALS -->
   <sweet-modal icon="warning" ref="modalCollection">
        <h2>¿Esta seguro de que desea pasar esta factura a collections?</h2> <br>
        <div class="text-center">
             N° Factura: {{invId}}
<<<<<<< HEAD
              <!-- {{invoice}} -->
           <!--    {{invoice.contract.contractNumber}} 
              {{invoice.contract.siteAddress}}
              {{invoice.invoiceDate}}
              {{invoice.projescription.projescriptionName}}
              {{invoice.netTotal}}
              {{invoice.balance}}
              {{invoice.shareSucceed}}
              {{invoice->pQuantity}}   -->
=======

>>>>>>> aeefe06fae0c63d443ebaeb83e6950cd9ff2b9de
        </div>
        <br>
        <button class="btn btn-success" @click="sendInvoiceToCollection">Confirmar</button>
  </sweet-modal>

<<<<<<< HEAD

=======
>>>>>>> aeefe06fae0c63d443ebaeb83e6950cd9ff2b9de
    </div>
 </template>

 <script>

export default {
        
     mounted() {
            console.log('Component InvoiceCollection mounted.')
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
             this.$refs.modalCollection.open()
             // console.log(typeof(this.invoiceId));
          },
          sendInvoiceToCollection: function() {
            // si this.checked no esta vacio ejecuta la funcion de borra multiple
            alert('Enviando');
            // if(Object.keys(this.checked).length != 0) {
               var url ='invoices/'+this.invoiceId+'/changeStatus';
               axios.put(url,{
                 newStatus :  'COLLECTION'
                  }).then(response => {
                    this.$refs.modalCollection.close();
                    toastr.success('Factura Enviada a Collection');
                    location.reload();

                  });
             }
          },
    } //end of methods
       // this.$forceUpdate()

 </script>
  
