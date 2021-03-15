<template>
    <div class="row">
        <div class="col-md-7 col-md-offset-2">
            <div class="panel panel-default">

                <div v-if="editId === 0" class="panel-heading" style="background: #dff0d8"><h4 class="text-uppercase">Agregar Transaccion de Ingreso</h4></div>
                <div v-else class="panel-heading" style="background: #d9edf7"><h4 class="text-uppercase">Actualizar Transaccion de Ingreso</h4></div>

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
                          {{transaction.transactionDate}}
                    </div>

                        <div class="form-group col-md-9">
                                <label for="description" class="form-group">DESCRIPCION</label>
                                <input type="text" v-model="transaction.description" class="form-control" id="description" name="description">
                        </div>

                        <div class="form-group col-md-7">
                                <label for="reason" class="form-group">MOTIVO</label>
                                <input type="text" v-model="transaction.reason" class="form-control" id="reason" name="reason">
                        </div>

                        <div class="row"></div>
                        <select-bank-cashbox @shareData="getValueFromPayMethod" pref-url="../"></select-bank-cashbox>

                        <div class="form-group col-md-9">
                                <label for="payMethodDetails" class="form-group">DETALLES DEL METODO</label>
                                <input type="text" v-model="transaction.payMethodDetails" class="form-control" id="payMethodDetails" name="payMethodDetails">
                        </div>
                          
                          <div class="row"></div>
                        <div class="form-group col-lg-10 ">
                            <label for="transactionTypeId">TIPO DE TRANSACCION:</label>
                                 <select class="form-control" v-model="transaction.transactionTypeId" id="transactionTypeId">
                                    <option value=""> </option>
                                    <option v-for="item in transactionTypesList" :key="item.transactionTypeId" :value="item.transactionTypeId">{{item.transactionTypeName}}</option>
                                </select>
                        </div>

                         <div class="form-group col-md-5">
                              <label for="amount">MONTO</label>
                              <input type="number" class="form-control" step="0.01" id="amount" name="amount"  v-model="transaction.amount" >
                        </div>  


                        <div v-if="editId === 0">
                             <button-form 
                              :buttonType = 1
                               @cancf = "cancf"
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
    import {Spanish} from 'flatpickr/dist/l10n/es.js';

    export default {
        mounted() {
         console.log('componente agregar transaccion montado');

            axios.get('/transaction-types/+').then(response => {
                this.transactionTypesList = response.data;
               // console.log(this.transactionTypesList)
            })

            if (this.editId > 0) {
                // transaction to edit.
                axios.get(`/show/${this.editId}`).then((response) => {
                    this.data = response.data[0]

                    this.transaction.transactionDate = this.data.transactionDate;
                    this.transaction.description = this.data.description;
                    this.transaction.reason = this.data.reason;
                    this.transaction.payMethodId = this.data.payMethodId;
                    this.transaction.payMethodDetails = this.data.payMethodDetails;
                    this.transaction.transactionTypeId = this.data.transactionTypeId;
                    this.transaction.amount = this.data.amount;
                    this.transaction.cashboxId = this.data.cashboxId;
                    this.transaction.accountId = this.data.accountId;

                })
                
            }      
        },
        data(){
            return{
                errors: [],
                transactionTypesList: [],

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
                     payMethodId: '',
                     payMethodDetails: '',
                     transactionTypeId: '',
                     amount: '',
                     cashboxId: '',
                     accountId: '',
                     imagen: ''
                },

            }
         },
       props: {
            editId:'',
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
                 if (!this.transaction.payMethodDetails) 
                this.errors.push('Debe Escribir un Detalle Para el Metodo de Pago.');
                 if (!this.transaction.transactionTypeId) 
                this.errors.push('Debe escoger un Expense.');
                 if (!this.transaction.amount) 
                this.errors.push('Debe Ingresar Un Monto.');


           if (!this.errors.length) { 
                if (this.editId === 0) {

                let formData = new FormData();
                     formData.append('transactionDate',this.transaction.transactionDate);
                     formData.append('description',this.transaction.description);
                     formData.append('reason',this.transaction.reason);
                     formData.append('payMethodId',this.transaction.payMethodId);
                     formData.append('payMethodDetails',this.transaction.payMethodDetails);
                     formData.append('transactionTypeId',this.transaction.transactionTypeId);
                     formData.append('amount',this.transaction.amount);
                     formData.append('sign', '+');
                     if(this.transaction.payMethodId == 2){
                       formData.append('cashboxId',this.transaction.cashboxId);
                       formData.append('accountId','');
                     }else{
                       formData.append('cashboxId','');
                       formData.append('accountId',this.transaction.accountId);
                     }

                    axios.post('/transactions', formData)
                    .then((response) => {
                         toastr.success(response.data.message);
                           this.$emit('showlist', 0)
                   
                        })
                    .catch(function (response) {
                        alert("Faile post")
                    });

                }else {
                    axios.put('/transactions', params)
                    .then((response) => {
                        alert('Success')
                        })
                    .catch(function (error) {
                        console.log(error);
                    });
                }   // else end   
             }  //end if error.length 
            },
            cancf(n){
                console.log('vista a mostrar: ' + n)
                this.$emit('showlist', 0)
            },
            getValueFromPayMethod(payMethodId,accountId,cashboxId) {
                // console.log('metodo de pago'+payMethodId)
                // console.log('account Id'+accountId)
                // console.log('cashbox Id'+cashboxId)

                this.transaction.payMethodId = payMethodId;
                this.transaction.accountId = accountId;
                this.transaction.cashboxId = cashboxId;
            },
 
        }
    }

</script>