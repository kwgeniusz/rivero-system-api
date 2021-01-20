<template>
<label>
 <!-- BUTTON PARA FORMULARIO MODAL DE COBRO DE CUOTA-->
    <a @click="openModal()" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Ver">
        <span class="fa fa-search" aria-hidden="true"></span>  
    </a>

      <sweet-modal ref="modal">
         <h3><b>Cuentas por Paga Asociadas:</b></h3>
            <hr>
            <ul v-for="(payable,index) in payables">
            {{++index}}) <b>Direccion:</b> 
                {{payable.subcont_inv_detail.invoice.contract.propertyNumber}} 
                {{payable.subcont_inv_detail.invoice.contract.streetName}} 
                {{payable.subcont_inv_detail.invoice.contract.streetType}} 
                {{payable.subcont_inv_detail.invoice.contract.suiteNumber}} 
                {{payable.subcont_inv_detail.invoice.contract.city}} 
                {{payable.subcont_inv_detail.invoice.contract.state}} 
                {{payable.subcont_inv_detail.invoice.contract.zipCode}}
            <br>
                <b>Monto Pagado:</b> {{payable.pivot.amountPaid}} <br>
                <b>Motivo:</b> {{payable.pivot.reason}}<br>
       
                
            </ul>
            <hr>
    </sweet-modal>

</label>   
</template>

<script>

    export default {
        
     mounted() {
            console.log('Component Modal Transaction Details mounted.')
           },
     data: function () {
          return {

          }
    },
    props: {
           payables: { type: Array}
          },
    methods: {
       openModal: function (){
        //    axios.get('../receivables/get/'+this.rId).then(response => {
        //          this.receivable        = response.data[0]
        //          console.log(this.receivable)

        //          this.formCollectMethod = this.receivable.collectMethod
        //         });

        console.log(this.payables);
            this.$refs.modal.open()
        },
     },
    }
</script>