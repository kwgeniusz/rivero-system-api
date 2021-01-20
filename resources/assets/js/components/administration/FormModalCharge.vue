<template>
<div>
<!-- BUTTON PARA FORMULARIO MODAL DE COBRO DE CUOTA-->
             <a class="btn btn-success btn-sm" @click="openModal()">
              <span  class="fa fa-money-bill-alt" aria-hidden="true"></span> Cobrar
            </a>
  
<!-- COMIENZA CODIGO DE LA VENTANA MODAL PARA CREAR AL CLIENTE-->
 <sweet-modal ref="modal">
    <h3 class="bg-primary"><b>FACTURA N° {{ invId }}</b></h3>
    <h3 class="bg-success"><b>COBRO</b></h3>

          <div class="alert alert-danger" v-if="errors.length">
            <h4>Errores:</h4>
            <ul>
             <li v-for="error in errors">{{ error }}</li>
            </ul>
          </div>

              <div class="form-group">
                <label for="formAmountDue">MONTO DE LA CUOTA:</label> {{this.receivable.amountDue}}
              </div>

              <div class="form-group col-lg-8 col-lg-offset-2">
                <label for="formCollectMethod">METODO DE PAGO</label>
                <select class="form-control" id="formCollectMethod" v-model="formCollectMethod">
                  <option v-for="(item, index) in listPaymentMethods" :value="item.payMethodId">{{item.payMethodName}}</option>
                 </select>
              </div>
          
 
          <div class="form-group col-lg-8 col-lg-offset-2" v-if="formCollectMethod == 2">
            <label for="formCashBoxId">DESTINO:</label>
             <div> CAJA </div>
          </div>  

           <div class="form-group col-lg-8 col-lg-offset-2" v-if="formCollectMethod != 2">
            <label for="formBankId">BANCO DESTINO</label>
            <select class="form-control" id="formBankId" @change="getAccount()" v-model="formBankId">
                <option v-for="(item, index) in listBank" :value="item.bankId">{{item.bankName}}</option>
            </select>
          </div>  

           <div class="form-group col-lg-8 col-lg-offset-2" v-if="formCollectMethod != 2">
            <label for="formAccountId">CUENTA DE DESTINO</label>:<br> 
           <select class="form-control" id="formAccountId" v-model="formAccountId">
             <option v-for="(item, index) in listAccount" :value="item.accountId">{{item.accountCodeId}}</option>
            </select>
          </div> 

              <div class="form-group" v-if="formCollectMethod == 3">
                <label for="formSourceBank">BANCO DE ORIGEN</label>
                <input type="text" class="form-control" v-model="formSourceBank">
              </div>
              <div class="form-group" v-if="formCollectMethod == 3">
              <label for="formSourceBankAccount">CUENTA BANCARIA DE ORIGEN</label>
                <input type="text" class="form-control" v-model="formSourceBankAccount">
              </div>
              <div class="form-group" v-if="formCollectMethod != 2">
               <label for="formCheckNumber">N° REFERENCIA</label>
                <input type="text" class="form-control" v-model="formCheckNumber" placeholder="N° Check,N° Transfer, etc...">
              </div>

          <div class="form-group col-lg-6 col-lg-offset-3 ">
                 <label for="formAmountPaid">MONTO</label>
                 <input type="number" step="0.01" min="0" class="form-control" id="formAmountPaid"  pattern="^[0-9]+" v-model="formAmountPaid" >
          </div>

        <div class="form-group col-lg-4 col-lg-offset-4" v-if="formCollectMethod == 1 || formCollectMethod == 10">
            <label for="formFeeCharge">¿COBRAR FEE?</label>:<br> 
           <select class="form-control" id="formFeeCharge" v-model="formFeeCharge">
             <option value="N">NO</option>
             <option value="Y">SI</option>
            </select>
          </div> 

    <div v-if="formFeeCharge == 'Y'">
          <div class="form-group col-lg-4 col-lg-offset-2 col-lg-8 col-lg-offset-2">
                 <label for="formPercent">PORCENTAJE</label>
                 <input type="number" step="0.01" min="0" max="100" class="form-control" id="formPercent"  pattern="^[0-9]+" v-model="formPercent" >
          </div>
          <div class="form-group col-lg-3 col-lg-8 col-lg-offset-2">
                 <label for="formAmountPercent">FEE</label><br>
                   {{getFee}}
          </div>
          <div class="form-group col-lg-6 col-lg-offset-3">
                 <label>MONTO A COBRAR</label>
                   {{sumTotal}}

          </div>
     </div>

         <div class="form-group col-lg-6 col-lg-offset-3">
           <label for="formDatePaid">FECHA DEL COBRO</label>
            <input class="form-control flatpickr" id="formDatePaid" v-model="formDatePaid">
          </div>


              <div class="row"></div>
              <a @click="sendForm()" v-if="btnSubmitForm" class="btn btn-primary">
                <span class="fa fa-check" aria-hidden="true"></span>  ENVIAR
              </a>
              <br>

  </sweet-modal>
</div>   
</template>

<script>

    export default {
        
     mounted() {
            console.log('Component FormModalCharge mounted.')
           },
     data: function () {
          return {
           receivable : {},
           listPaymentMethods: {},
           listBank: {},
           listAccount: {},
           invId:'',

            errors: [],
            formCollectMethod: 1,
            formSourceBank : '',
            formSourceBankAccount : '',
            formCheckNumber : '',
            formCashboxId: '',
            formBankId: '',
            formAccountId:'',
            formAmountPaid: 0.00,

            formPercent: 0,
            formAmountPercent:'',
            formDatePaid: '',
            btnSubmitForm: false,

            formFeeCharge: 'N',
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
          },
   computed: {
      getFee: function () {
          let feet = (this.formAmountPaid * this.formPercent)/100;
          return  Number.parseFloat(feet).toFixed(2);  
       },
      sumTotal: function () {
          let sum = parseFloat(this.formAmountPaid) + parseFloat(this.getFee);
          return sum.toFixed(2);
       } 
    },   
    methods: {
       openModal: function (){

           axios.get('../receivables/get/'+this.rId).then(response => {
                 this.receivable = response.data[0];
                 this.invId = this.receivable.invoice.invId;
                });
           axios.get('../receivables-paymentMethod').then(response => {
                 this.listPaymentMethods = response.data
                });  
           axios.get('../banksByOffice').then(response => {
                 this.listBank = response.data
                 this.formBankId = this.listBank[0].bankId;
                 this.getAccount();
                }); 
           axios.get('../cashboxs').then(response => {
                 this.formCashboxId =  response.data[0].cashboxId
            });

            this.errors = [];
            this.btnSubmitForm = true;
            this.$refs.modal.open()
        },
        getAccount: function (){
        var url ='../accounts/'+this.formBankId;
            axios.get(url).then(response => {
              this.listAccount = response.data;
              this.formAccountId = this.listAccount[0].accountId;
            });
        },
       sendForm: function() {
           this.errors = [];
           //VALIDATIONS
        // if(this.formCollectMethod == 3){ 
        //        if (!this.formSourceBank) 
        //         this.errors.push('Banco de Origen es Requerido.');
        //        if (!this.formSourceBankAccount) 
        //         this.errors.push('Cuenta de Origen es Requerido.');
        //        if (!this.formCheckNumber) 
        //         this.errors.push('Numero de Cheque es Requerido.');
        //  }
        
               if (!this.formBankId && this.formCollectMethod == 3) 
                this.errors.push('Debe escoger un Banco de Destino.');

                 if (!this.formAccountId && this.formCollectMethod == 3) 
                this.errors.push('Debe escoger una Cuenta de Destino.');

                if (!this.formAmountPaid || this.formAmountPaid == 0) 
                this.errors.push('Monto es Requerido.');

                if(this.formFeeCharge == 'Y'){ 
                  if (!this.formPercent || this.formPercent == 0) 
                     this.errors.push('Monto de Porcentaje es requerido.');
                 }

               if (!this.formDatePaid) 
                this.errors.push('Fecha del Cobro es Requerida.');
           
       if (!this.errors.length) { 
            this.btnSubmitForm = false;
            this.formAmountPercent = this.getFee;

          //siempre paso todos los paremetros al controlador y modelo aqui coloco en null si es por banco o por caja
              if(this.formCollectMethod == 2){
                   this.formAccountId = null;
              }else{
                    this.formCashboxId = null;
              }

            axios.post('../receivables/share',{
                receivableId :  this.receivable.receivableId,
                amountDue: this.receivable.amountDue,
                collectMethod: this.formCollectMethod,
                sourceBank : this.formSourceBank,
                sourceBankAccount : this.formSourceBankAccount,
                checkNumber : this.formCheckNumber,
                cashboxId : this.formCashboxId,
                accountId: this.formAccountId,
                amountPaid: this.formAmountPaid,
                percent: this.formPercent,
                amountPercent: this.formAmountPercent,
                datePaid: this.formDatePaid,
            }).then(response => {
                   if (response.data.alert == "error") {
                       toastr.error(response.data.msj)
                         this.btnSubmitForm = true;
                   } else {
                       location.reload();
                       toastr.success(response.data.msj)
                   }
  
            })
           }
         },
     }
}
</script>