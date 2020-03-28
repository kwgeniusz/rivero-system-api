<template>
<label>
<!-- BUTTON PARA FORMULARIO MODAL DE COBRO DE CUOTA-->
             <a class="btn btn-success btn-sm" @click="openModal()">
              <span  class="fa fa-money-bill-alt" aria-hidden="true"></span> Cobrar
            </a>
  
<!-- COMIENZA CODIGO DE LA VENTANA MODAL PARA CREAR AL CLIENTE-->
 <sweet-modal ref="modal">
    <h3 class="bg-primary"><b>FACTURA N° {{ this.receivable.invoiceId }}</b></h3>
    <h3 class="bg-success"><b>COBRO</b></h3>

     <br>
          <div class="alert alert-danger" v-if="errors.length">
            <h4>Errores:</h4>
            <ul>
             <li v-for="error in errors">{{ error }}</li>
            </ul>
          </div>
        <div class="col-xs-offset-1 col-xs-10">
        
              <div class="form-group">
                <label for="formAmountDue">MONTO DE LA CUOTA:</label> {{this.receivable.amountDue}}
              </div>

              <div class="form-group col-xs-8 col-xs-offset-2">
                <label for="formCollectMethod">METODO DE PAGO</label>
                <select class="form-control" id="formCollectMethod" v-model="formCollectMethod">
                  <option v-for="(item, index) in paymentMethod" :value="item.payMethodId">{{item.payMethodName}}</option>
                 </select>
              </div>

              <div class="form-group" v-if="formCollectMethod != 2 && formCollectMethod != 4 && formCollectMethod != 5">
                <label for="formSourceBank">BANCO DE ORIGEN</label>
                <input type="text" class="form-control" v-model="formSourceBank">
              </div>
              <div class="form-group" v-if="formCollectMethod != 2 && formCollectMethod != 4 && formCollectMethod != 5">
              <label for="formSourceBankAccount">CUENTA BANCARIA DE ORIGEN</label>
                <input type="text" class="form-control" v-model="formSourceBankAccount">
              </div>
              <div class="form-group" v-if="formCollectMethod == 3">
               <label for="formCheckNumber">N° CHEQUE</label>
                <input type="number" class="form-control" v-model="formCheckNumber">
              </div>

          
           <div class="form-group col-xs-8 col-xs-offset-2">
            <label for="formTargetBankId">BANCO DESTINO</label>
            <select class="form-control" id="formTargetBankId" @change="getAccount()" v-model="formTargetBankId">
                <option v-for="(item, index) in listBank" :value="item.bankId">{{item.bankName}}</option>
            </select>
          </div>  

           <div class="form-group col-xs-8 col-xs-offset-2">
            <label for="formTargetBankAccount">CUENTA DE DESTINO</label>:<br> {{this.formTargetBankAccount}}
             <input type="hidden" class="form-control"  v-model="formTargetBankAccount">
          </div> 

          <div class="form-group col-xs-6 col-xs-offset-3">
                 <label for="formAmountPaid">MONTO</label>
                 <input type="number" step="0.01" min="0" class="form-control" id="formAmountPaid"  pattern="^[0-9]+" v-model="formAmountPaid" >
          </div>
    
    <div v-if="formCollectMethod == 1 || formCollectMethod == 10">
          <div class="form-group col-xs-4 col-xs-offset-2">
                 <label for="formPercent">PORCENTAJE</label>
                 <input type="number" step="0.01" min="0" class="form-control" id="formPercent"  pattern="^[0-9]+" v-model="formPercent" >
          </div>
          <div class="form-group col-xs-3">
                 <label for="formAmountPercent">FEE</label><br>
                   {{getFee}}
          </div>
          <div class="form-group col-xs-6 col-xs-offset-3">
                 <label>MONTO A COBRAR</label>
                   {{sumTotal}}

          </div>
  </div>
         <div class="form-group col-xs-6 col-xs-offset-3">
           <label for="formDatePaid">FECHA DEL COBRO</label>
            <input class="form-control flatpickr" id="formDatePaid" v-model="formDatePaid">
          </div>


              <div class="row"></div>
            <div id="btnSubmit"class="text-center" v-if="btnSubmitForm">
              <a @click="sendForm()" class="btn btn-primary">
                <span class="fa fa-check" aria-hidden="true"></span>  ENVIAR
              </a>
            </div>
              <br>
      </div>
  </sweet-modal>

</label>   
</template>

<script>

    export default {
        
     mounted() {
            console.log('Component FormModalCharge mounted.')
           },
     data: function () {
          return {
           receivable : {},
           paymentMethod: {},
           listBank: {},

            errors: [],
            formCollectMethod: 1,
            formSourceBank : '',
            formSourceBankAccount : '',
            formCheckNumber : '',
            formTargetBankId: '',
            formTargetBankAccount:'',
            formAmountPaid: 0.00,
            formPercent: 0,
            formAmountPercent:'',
            formDatePaid: '',
            btnSubmitForm: true,
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
                 this.receivable = response.data
                });
           axios.get('../banks').then(response => {
                 this.listBank = response.data
                }); 
           axios.get('../receivables-paymentMethod').then(response => {
                 this.paymentMethod = response.data
                });  
            this.errors = [];
            this.$refs.modal.open()
        },
        getAccount: function (){
        var url ='../banks/account/'+this.formTargetBankId;
            axios.get(url).then(response => {
               console.log(response.data)
               this.formTargetBankAccount = response.data[0]['bankAccount']
            });
        },
       sendForm: function() {
           this.errors = [];
           //VALIDATIONS
        // if(this.formCollectMethod != 1 && this.formCollectMethod != 5){ 
        //        if (!this.formSourceBank) 
        //         this.errors.push('Banco de Origen es Requerido.');
        //        if (!this.formSourceBankAccount) 
        //         this.errors.push('Cuenta de Origen es Requerido.');
        // }
        //  if(this.formCollectMethod == 2){ 
        //        if (!this.formCheckNumber) 
        //         this.errors.push('Numero de Cheque es Requerido.');
        //  }
                if(this.formCollectMethod == 1 || this.formCollectMethod == 10){ 
                  if (!this.formPercent || this.formPercent == 0) 
                     this.errors.push('Monto de Porcentaje es requerido.');
                 }
               if (!this.formTargetBankId) 
                this.errors.push('Debe escoger un Banco de Destino.');
           
               if (!this.formDatePaid) 
                this.errors.push('Fecha del Cobro es Requerida.');
           
                if (!this.formAmountPaid || this.formAmountPaid == 0) 
                this.errors.push('Monto es Requerido.');
    
           if (!this.errors.length) { 

            this.formAmountPercent = this.getFee;
        
            axios.post('../receivables/share',{
                receivableId :  this.receivable.receivableId,
                amountDue: this.receivable.amountDue,
                collectMethod: this.formCollectMethod,
                sourceBank : this.formSourceBank,
                sourceBankAccount : this.formSourceBankAccount,
                checkNumber : this.formCheckNumber,
                targetBankId: this.formTargetBankId,
                targetBankAccount:this.formTargetBankAccount,
                amountPaid: this.formAmountPaid,
                percent: this.formPercent,
                amountPercent: this.formAmountPercent,
                datePaid: this.formDatePaid,
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
}
</script>