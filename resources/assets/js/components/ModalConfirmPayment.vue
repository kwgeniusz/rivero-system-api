<template>
<label>
<!-- BUTTON PARA FORMULARIO MODAL DE COBRO DE CUOTA-->
             <a class="btn btn-warning btn-sm" @click="openModal()">
              <span  class="fa fa-handshake" aria-hidden="true"></span> Verificar
            </a>
  
<!-- COMIENZA CODIGO DE LA VENTANA MODAL PARA CREAR AL CLIENTE-->
 <sweet-modal ref="modal">
    <h3 class="bg-primary"><b>FACTURA N° {{ this.receivable.invoiceId }}</b></h3>
    <h3 class="bg-warning"><b>CONFIRMAR COBRO </b></h3>

     <br>
<!--           <div class="alert alert-danger" v-if="errors.length">
            <h4>Errores:</h4>
            <ul>
             <li v-for="error in errors">{{ error }}</li>
            </ul>
          </div> -->
        <div class="col-xs-offset-1 col-xs-10">

              <div class="form-group">
                <label for="formAmountDue">MONTO DE LA CUOTA</label><br>{{this.receivable.amountDue}}
              </div>

          <div class="form-group col-xs-6 col-xs-offset-3">
                 <label for="formAmountPaid">MONTO PAGADO</label><br> {{this.receivable.amountPaid}}
                 <!-- <input type="number" step="0.01" min="0" class="form-control" id="formAmountPaid"  pattern="^[0-9]+"v-model="formAmountPaid" > -->
          </div>
              <div class="form-group col-xs-8 col-xs-offset-2">
                <label for="formCollectMethod">METODO DE PAGO</label><br> {{this.paymentMethod}}
                <input type="hidden" id="formCollectMethod" v-model="formCollectMethod">
              </div>

              <div class="form-group" v-if="formCollectMethod != 2 && formCollectMethod != 4 && formCollectMethod != 5">
                <label for="formSourceBank">BANCO DE ORIGEN</label><br>{{this.receivable.sourceBank}}
                <!-- <input type="text" class="form-control" v-model="formSourceBank"> -->
              </div>
              <div class="form-group" v-if="formCollectMethod != 2 && formCollectMethod != 4 && formCollectMethod != 5">
              <label for="formSourceBankAccount">CUENTA BANCARIA DE ORIGEN</label><br>{{this.receivable.sourceBankAccount}}
                <!-- <input type="text" class="form-control" v-model="formSourceBankAccount"> -->
              </div>
              <div class="form-group" v-if="formCollectMethod == 3">
               <label for="formCheckNumber">N° CHEQUE</label><br>{{this.receivable.checkNumber}}
                <!-- <input type="number" class="form-control" v-model="formCheckNumber"> -->
              </div>

          
           <div class="form-group col-xs-8 col-xs-offset-2">
            <label for="formTargetBankId">BANCO DESTINO</label><br>{{this.bank}}
          </div>  

           <div class="form-group col-xs-8 col-xs-offset-2">
            <label for="formTargetBankAccount">CUENTA DE DESTINO</label><br>{{this.receivable.targetBankAccount}}    
                     <!-- <input type="hidden" class="form-control"  v-model="formTargetBankAccount"> -->
          </div> 


         <div class="form-group col-xs-6 col-xs-offset-3">
           <label for="formDatePaid">FECHA DEL COBRO</label><br> {{this.receivable.datePaid | moment("MM/DD/YYYY")}}
            <!-- <input class="form-control flatpickr" id="formDatePaid" v-model="formDatePaid"> -->
          </div>
              <div class="row"></div>

              <a @click="success()" class="btn btn-success">
                <span class="fa fa-check" aria-hidden="true"></span>  EXITOSO
              </a>

              <a @click="declined()" class="btn btn-danger">
                <span class="fa fa-times-circle" aria-hidden="true"></span>  DECLINAR
              </a>

              <br><br>
      </div>
  </sweet-modal>

</label>   
</template>

<script>

    export default {
        
     mounted() {
            console.log('Component ModalConfirmPayment mounted.')
           },
     data: function () {
          return {
           receivable : {},
           paymentMethod: '',
           bank: '',
              

            formCollectMethod: 1,

          }
    },
    watch: {
       formCollectMethod: function(){
            this.formSourceBank = '';
            this.formSourceBankAccount = '';
            this.formCheckNumber = '';
       }
    },
    props: {
           rId: { type: String},
           countryId: { type: String}
          },
    methods: {
       openModal: function (){
           axios.get('../receivables/get/'+this.rId).then(response => {
                 this.receivable = response.data
                 this.formCollectMethod = this.receivable.collectMethod
                 this.paymentMethod=this.receivable.payment_method.payMethodName;
                 this.bank=this.receivable.bank.bankName;
                });
            this.$refs.modal.open()
        },
       success: function() {
            axios.post('../receivablesConfirmPayment',{
                invoiceId :  this.receivable.invoiceId,
                receivableId :  this.receivable.receivableId,
                status: 4
            }).then(response => {
                   if (response.data.alert == "error") {
                       toastr.error(response.data.msj)
                   } else {
                       location.reload();
                       toastr.success(response.data.msj)
                   }
  
            })
           },
         declined: function() {
            axios.post('../receivablesConfirmPayment',{
                invoiceId :  this.receivable.invoiceId,
                receivableId :  this.receivable.receivableId,
                status: 3
            }).then(response => {
                   if (response.data.alert == "error") {
                       toastr.error(response.data.msj)
                   } else {
                       location.reload();
                       toastr.success(response.data.msj)
                   }
  
            })
           }
         },
     }
</script>