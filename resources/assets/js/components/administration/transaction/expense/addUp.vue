<template>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">

                <div v-if="editId === 0" class="panel-heading" style="background: #dff0d8"><h4 class="text-uppercase">Agregar Transaccion de Egreso</h4></div>
                <div v-else class="panel-heading" style="background: #d9edf7"><h4 class="text-uppercase">Actualizar Transaccion de Egreso</h4></div>

        <div class="panel-body">

            <div class="alert alert-danger" v-if="errors.length">
             <h4>Errores:</h4>
             <ul>
               <li v-for="(error,index) in errors"  :key="index">{{ error }}</li>
            </ul>
           </div>
        <form  class="form" ref="formTransactionIncome" id="formTransaction" role="form" @submit.prevent="createUpdateTransaction()">

                   <div class="form-group col-md-7">
                         <label for="transactionDate">FECHA:</label>  
                        <flat-pickr v-model="transaction.transactionDate" :config="configFlatPickr"  class="form-control" id="transactionDate"></flat-pickr>
                          <!-- {{transaction.transactionDate}} -->
                    </div>

                        <div class="form-group col-md-9">
                                <label for="description" class="form-group">REFERENCIA EN BANCO O BENEFICIARIO</label>
                                <input type="text" v-model="transaction.description" class="form-control" id="description" name="description">
                        </div>

                        <div class="form-group col-md-7">
                                <label for="reason" class="form-group">MOTIVO</label>
                                <input type="text" v-model="transaction.reason" class="form-control" id="reason" name="reason">
                        </div>

                        <div class="form-group col-md-7">
                                <label for="reference" class="form-group">REFERENCIA DE TRANSACCION</label>
                                <input type="text" v-model="transaction.reference" class="form-control" id="reference" name="reference">
                        </div>

                        <div class="row"></div>
                          <select-bank-cashbox v-if="transaction.payMethodId" @shareData="getValueFromPayMethod" 
                         :prop-paymethod = "transaction.payMethodId"
                         :prop-bank      = "transaction.bankId"
                         :prop-account   = "transaction.accountId"
                         :prop-cashbox   = "transaction.cashboxId"></select-bank-cashbox>


                        <div class="form-group col-md-9">
                                <label for="payMethodDetails" class="form-group">DETALLES DEL METODO</label>
                                <input type="text" v-model="transaction.payMethodDetails" class="form-control" id="payMethodDetails" name="payMethodDetails">
                        </div>
                          
                          <div class="row"></div>
                        <div class="form-group col-lg-10 ">
                            <label for="transactionTypeId">EXPENSES:</label>
                                 <select class="form-control" v-model="transaction.transactionTypeId" id="transactionTypeId">
                                    <!-- <option value=""> </option> -->
                                    <option v-for="item in transactionTypesList" :key="item.transactionTypeId" :value="item.transactionTypeId">{{item.transactionTypeName}}</option>
                                </select>
                        </div>

                         <div class="form-group col-md-5">
                              <label for="amount">MONTO</label>
                              <input type="number" class="form-control" step="0.01" id="amount" name="amount"  v-model="transaction.amount" >
                        </div>  
    <div v-if="editId === 0">
               <div class="row"></div>
                <div class="form-group col-lg-6">
                  <label for="file">COMPROBANTE DE EGRESO</label>
                  <input type="file" @change="obtenerImagen" name="file">
               </div>
               <div class="row"></div>
               <figure v-if="transaction.imagen">
                <img width="400" height="300" :src="imagenMiniatura" >
                   <!-- <img v-if="editId > 0"   width="400" height="300" :src="transaction.imagen" alt="Foto del Producto"> -->
                   <!-- <img v-else width="400" height="300" :src="imagen" alt="Foto del Producto"> -->
               </figure>
   </div>
                        <div v-if="editId === 0">
                             <button-form 
                              :buttonType = 1
                               @cancf = "cancf"
                                v-if="showSubmitBtn"
                             ></button-form>

                            </div>

                            <div v-if="editId > 0">
                                <button-form 
                                    :buttonType = 2
                                    @cancf = "cancf"
                                ></button-form>
                            </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import SelectBankCashbox from '../../SelectBankOrCashbox.vue'
    import {Spanish} from 'flatpickr/dist/l10n/es.js';

    export default {
        mounted() {
         console.log('componente agregar transaccion montado');

            axios.get('/transaction-types/-/index').then(response => {
                this.transactionTypesList = response.data;
               // console.log(this.transactionTypesList)
            })

            if (this.editId > 0) {
                // transaction to edit.
                axios.get(`/transactions/${this.editId}`).then((response) => {
                    let data = response.data[0]

                    this.transaction.transactionDate = data.transactionDate;
                    this.transaction.description = data.description;
                    this.transaction.reason = data.reason;
                    this.transaction.reference = data.reference;
                    this.transaction.payMethodId = data.payMethodId;
                    this.transaction.payMethodDetails = data.payMethodDetails;
                    this.transaction.transactionTypeId = data.transactionTypeId;
                    this.transaction.amount = data.amount;
                    this.transaction.cashboxId = data.cashboxId;
                    this.transaction.accountId = data.accountId;
                    this.transaction.bankId = data.account.bankId;
                    this.transaction.imagen = this.raizUrl+data.document.docUrl;
                    
                    this.cargarImagen(this.transaction.imagen);

                })  
            }else{
                this.transaction.payMethodId = 1;
            }      
        },
        data(){
            return{
                errors: [],
                transactionTypesList: [],
                showSubmitBtn:true,
                raizUrl: window.location.protocol+'//'+window.location.host+'/storage/',
                imagenMiniatura:'',

                 configFlatPickr:{
                    //  enableTime: true,
                    //  time_24hr: false,
                     altFormat: 'm/d/Y',
                     altInput: true,
                     dateFormat: 'Y-m-d',
                     locale: Spanish, // locale for this instance only  
                 },
                transaction:  {
                     transactionDate: '',
                     description: '',
                     reason: '',
                     reference: '',
                     payMethodId: '',
                     payMethodDetails: '',
                     transactionTypeId: '',
                     amount: '',
                     cashboxId: '',
                     bankId: '',
                     accountId: '',
                     imagen: ''
                },

            }
         },
       props: {
            editId:'',
        },
    components: {
         SelectBankCashbox
     },          
       computed: {
        //  imagen(){
        //      return this.imagenMiniatura;
        //  },
       },
        methods: {
            createUpdateTransaction(){
              this.errors = [];

               if (!this.transaction.transactionDate) 
                this.errors.push('Debe escoger una Fecha Para la Transaccion.');
                if (!this.transaction.description) 
                this.errors.push('Debe Ingresar Una Descripcion.');
                 if (!this.transaction.reason) 
                this.errors.push('Debe escoger una Razon.');
                //  if (!this.transaction.payMethodDetails) 
                // this.errors.push('Debe Escribir un Detalle Para el Metodo de Pago.');
                 if (!this.transaction.transactionTypeId) 
                this.errors.push('Debe escoger un Expense.');
                 if (!this.transaction.amount) 
                this.errors.push('Debe Ingresar Un Monto.');
            
                //  if (!this.transaction.imagen && this.editId === 0) 
                // this.errors.push('Debe adjuntar una Imagen Obligatoria.');

              if(this.transaction.payMethodId != 2){
                     if (!this.transaction.bankId) 
                        this.errors.push('Debe Escoger un Banco.');
                     if (!this.transaction.accountId) 
                        this.errors.push('Debe Escoger una Cuenta.');

                    }
           if (!this.errors.length) { 
               
                let formData = new FormData();
                     formData.append('transactionDate',this.transaction.transactionDate);
                     formData.append('description',this.transaction.description);
                     formData.append('reason',this.transaction.reason);
                     formData.append('reference',this.transaction.reference);
                     formData.append('payMethodId',this.transaction.payMethodId);
                     formData.append('payMethodDetails',this.transaction.payMethodDetails);
                     formData.append('transactionTypeId',this.transaction.transactionTypeId);
                     formData.append('amount',this.transaction.amount);
                     formData.append('sign', '-');
                     formData.append('file',this.transaction.imagen);
                     if(this.transaction.payMethodId == 2){
                       formData.append('cashboxId',this.transaction.cashboxId);
                       formData.append('accountId','');
                     }else{
                       formData.append('cashboxId','');
                       formData.append('accountId',this.transaction.accountId);
                     }

                if (this.editId === 0) {
                     this.showSubmitBtn =false;

                    axios.post('/transactions', formData, {
                           headers: {
                            'Content-Type': 'multipart/form-data'
                             }
                    })
                    .then((response) => {
                         toastr.success(response.data.message);
                           this.$emit('showlist', 0)
                        })
                    .catch((error) => {
                      
                      this.errors.push(error.response.data.errors);
                        // alert("ERROR EN EL SERVIDOR")
                       this.showSubmitBtn = true;
                    });

                }else {
                    formData.append("_method", "put");
                   axios.post(`/transactions/${this.editId}`, formData)
                    .then((response) => {
                         toastr.success(response.data.message);
                        this.$emit('showlist', 0);
                        })
                    .catch((error) => {
                      
                      this.errors.push(error.response.data.errors.file);
                        // alert("ERROR EN EL SERVIDOR")
                       this.showSubmitBtn = true;
                    });
                }   // else end   
             }  //end if error.length 
            },
            obtenerImagen(e){
                let file = e.target.files[0];
                this.transaction.imagen = file;
                // console.log(this.transaction.imagen)

                this.cargarImagen(file);
            },
            cargarImagen(file){
              let reader = new FileReader();
              console.log(file)

              reader.readAsDataURL(file);
              reader.onload = (e) => {
                this.imagenMiniatura = e.target.result;
                 console.log(this.imagenMiniatura);
              }
            },
            cancf(n){
                console.log('vista a mostrar: ' + n)
                this.$emit('showlist', 0)
            },
             getValueFromPayMethod(payMethodId,bankId,accountId,cashboxId) {
                console.log('metodo de pago'+payMethodId)
                console.log('bank Id'+bankId)
                console.log('account Id'+accountId)
                console.log('cashbox Id'+cashboxId)

                this.transaction.payMethodId = payMethodId;
                this.transaction.bankId = bankId;
                this.transaction.accountId = accountId;
                this.transaction.cashboxId = cashboxId;
            },
 
        }
    }

</script>