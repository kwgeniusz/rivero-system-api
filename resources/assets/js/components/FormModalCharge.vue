<template>
<div>
<!-- BUTTON PARA FORMULARIO MODAL DE COBRO DE CUOTA-->
             <a class="btn btn-success btn-sm" @click="openModal()">
              <span  class="fa fa-money-bill-alt" aria-hidden="true"></span> COBRAR
            </a>
  
<!-- COMIENZA CODIGO DE LA VENTANA MODAL PARA CREAR AL CLIENTE-->
 <sweet-modal ref="modal">
    <h3 class="bg-success"><b>COBRO EN CONTRATO N° {{ this.receivable.sourceReference }}</b></h3>
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
                    <option value="1">EFECTIVO</option>
                    <option value="2">CHEQUE</option>
                    <option value="3">TARJETA</option>
                    <option value="4">TRANSFERENCIA</option>
                </select>
              </div>

              <div class="form-group" v-if="formCollectMethod != 1">
                <label for="formSourceBank">BANCO DE ORIGEN</label>
                <input type="text" class="form-control" v-model="formSourceBank">
              </div>
              <div class="form-group" v-if="formCollectMethod != 1">
              <label for="formSourceBankAccount">CUENTA BANCARIA DE ORIGEN</label>
                <input type="text" class="form-control" v-model="formSourceBankAccount">
              </div>
              <div class="form-group" v-if="formCollectMethod == 2">
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
            <label for="formTargetBankAccount">CUENTA DE DESTINO</label>: {{this.formTargetBankAccount}}
             <input type="hidden" class="form-control"  v-model="formTargetBankAccount">
          </div> 

         <div class="form-group col-xs-6 col-xs-offset-3">
           <label for="formDatePaid">FECHA DEL COBRO</label>
            <input class="form-control flatpickr" id="formDatePaid" v-model="formDatePaid">
          </div>
              <div class="row"></div>
            <div class="text-center" v-if="btnSubmitForm">
              <a @click="sendForm()" class="btn btn-primary">
                <span class="fa fa-check" aria-hidden="true"></span>  ENVIAR
              </a>
            </div>
              <br>
      </div>
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
           listBank: {},

            errors: [],
            formCollectMethod: 1,
            formSourceBank : '',
            formSourceBankAccount : '',
            formCheckNumber : '',
            formTargetBankId: '',
            formTargetBankAccount:'',
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
    methods: {
       openModal: function (){
           axios.get('../receivables/get/'+this.rId).then(response => {
                 this.receivable = response.data[0]
                })
           axios.get('../banks/country/'+this.countryId).then(response => {
                 this.listBank = response.data
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
        if(this.formCollectMethod != 1){ 
               if (!this.formSourceBank) 
                this.errors.push('Banco de Origen es Requerido.');
               if (!this.formSourceBankAccount) 
                this.errors.push('Cuenta de Origen es Requerido.');
        }
         if(this.formCollectMethod == 2){ 
               if (!this.formCheckNumber) 
                this.errors.push('Numero de Cheque es Requerido.');
         }
               if (!this.formTargetBankId) 
                this.errors.push('Debe escoger un Banco de Destino.');
           
               if (!this.formDatePaid) 
                this.errors.push('Fecha del Cobro es Requerida.');
           

          if (!this.errors.length) { 
    
            axios.post('../receivables/share',{
                receivableId :  this.receivable.receivableId,
                amountDue: this.receivable.amountDue,
                collectMethod: this.formCollectMethod,
                sourceBank : this.formSourceBank,
                sourceBankAccount : this.formSourceBankAccount,
                checkNumber : this.formCheckNumber,
                targetBankId: this.formTargetBankId,
                targetBankAccount:this.formTargetBankAccount,
                datePaid: this.formDatePaid,
            }).then(response => {
               location.reload();
               toastr.success("Cobro de Cuota Realizado")
            })
           }
         },
     }
}
</script>