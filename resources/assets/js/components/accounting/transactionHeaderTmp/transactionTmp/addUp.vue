<template>
    <div class="row">
      <!-- <sweet-modal ref="modalNew" @close="cancf"> -->

        <div class="col-md-6 col-md-offset-2 col-xs-12">
            <div class="panel panel-default">

            <div v-if="editId === 0" class="panel-heading" style="background: #dff0d8"><h4 class="text-uppercase">Agregar Transaccion</h4></div>
            <div v-else class="panel-heading" style="background: #d9edf7"><h4 class="text-uppercase">Actualizar Transaccion</h4></div>

        <div class="panel-body">
            <div class="alert alert-danger" v-if="errors.length">
              <h4>Errores:</h4>
               <ul>
                 <li v-for="(error,index) in errors" :key="index">{{ error }}</li>
              </ul>
           </div>

      <p class="text-right"> <label style="color:red">* </label>REQUERIDOS </p>
        <form  class="form" id="form1" role="form" @submit.prevent="createUpdateTransaction()">


        <div class="form-group col-lg-7">
              <label style="color:red">*</label> <label for="transactionNumber">N DE TRANSACCION:</label>
                <input type="number" class="form-control" v-model="transaction.transactionNumber" name="transactionNumber" placeholder="">
        </div>

         <div class="form-group col-lg-12">
             <label style="color:red">*</label> <label for="generalLedgerId">CUENTA:</label>
                     <v-select :options="chartOfAccount" v-model="transaction.generalLedgerId" :reduce="chartOfAccount => chartOfAccount.generalLedgerId" label="item_data" /> 
          </div>
        <!-- {{chartOfAccount}} -->
       <div class="form-group col-md-7">
          <label style="color:red">*</label><label for="transactionDate">FECHA:</label>  
          <flat-pickr v-model="transaction.transactionDate" :config="configFlatPickr"  class="form-control" id="transactionDate"></flat-pickr>
      </div>

       <div class="form-group col-lg-10">
              <label style="color:red">*</label> <label for="transactionDescription">DESCRIPCION:</label>
                <input type="text" class="form-control" v-model="transaction.transactionDescription" name="transactionDescription" placeholder="">
        </div>
       <div class="form-group col-lg-10">
              <label style="color:red">*</label> <label for="transactionReference">REFERENCIA:</label>
                <input type="text" class="form-control" v-model="transaction.transactionReference" name="transactionReference" placeholder="">
        </div>
        <div class="form-group col-lg-4">
               <label for="debit">DEBITO:</label>
                <input type="number" class="form-control" v-model="transaction.debit" name="debit" placeholder="">
        </div>
          <div class="form-group col-lg-4">
               <label for="credit">CREDITO:</label>
                <input type="number" class="form-control" v-model="transaction.credit" name="credit" placeholder="">
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

   <!-- </sweet-modal>      -->

    </div>
</template>

<script>
    export default {
        mounted() {
         //obtengo los datos para llenar las listas de selects
          axios.get('/accounting/transactions/create').then((response) => {
            //   console.log(response.data)
                  this.chartOfAccount = response.data;
                  this.chartOfAccount.map(function (x){
                       return x.item_data = `${x.accountCode} - (${x.accountName})`;
                 });
          }); //end of create clients

            if (this.editId > 0) {
                // transaction to edit.
                axios.get(`/accounting/transactions/${this.editId}`).then((response) => {
                    this.data = response.data[0]

                    this.transaction.transactionNumber      = this.data.transactionNumber;
                    this.transaction.generalLedgerId          = this.data.generalLedgerId;
                    this.transaction.transactionDate        = this.data.transactionDate;
                    this.transaction.transactionDescription = this.data.transactionDescription;
                    this.transaction.transactionReference = this.data.transactionReference;
                    this.transaction.debit                = this.data.debit;
                    this.transaction.credit               = this.data.credit;

                });       
            } 
        },
        data(){
            return{
                errors: [],
                showSubmitBtn:true,

                chartOfAccount: [],
                configFlatPickr:{
                     altFormat: 'm/d/Y',
                     altInput: true,
                     dateFormat: 'Y-m-d',
                    //  locale: Spanish, // locale for this instance only  
                 },
                transaction:  {                    
                  transactionNumber: '',
                  generalLedgerId: '',
                  transactionDate: '',
                  transactionDescription: '',
                  transactionReference: '',
                  debit: 0,
                  credit: 0,
                },
            }
         },
      props: {
            // modal:false,
            editId:'',
        },
      methods: {
            createUpdateTransaction(){
              this.errors = [];

                 if (!this.transaction.transactionNumber) 
                this.errors.push('El Numero de la transaccion es requerido.');
                 if (!this.transaction.generalLedgerId) 
                this.errors.push('Nombre de la Cuenta es Requerido.');
                 if (!this.transaction.transactionDate) 
                this.errors.push('Ingrese un Valor numerico para el Margen.');
                if (!this.transaction.transactionDescription) 
                this.errors.push('La Clasificacion de la Cuenta es obligatoria.');
                
                  if (this.transaction.debit > 0 && this.transaction.credit > 0) 
                this.errors.push('Solo debe llenar una de las casillas debito o credito');
                  if (this.transaction.debit == 0 && this.transaction.credit == 0) 
                this.errors.push('Debe ingresar un Valor para Debito o Credito.');

           if (!this.errors.length) { 
                if (this.editId === 0) {  
                    this.showSubmitBtn = false;
                    
                    axios.post('/accounting/transactions', this.transaction).then((response) => {
                           toastr.success(response.data.message);
                          //  this.cancf()
                           this.$emit('showlist', 0)
                    }).catch((error) => {
                    //   this.errors.push(error.response.data.errors.businessPhone);
                    //   this.errors.push(error.response.data.errors.mainEmail);
                      this.showSubmitBtn = true;
                    });

                }else {
                    axios.put(`/accounting/transactions/${this.editId}`, this.transaction).then((response) => {
                          toastr.success(response.data.message);
                          this.$emit('showlist', 0)
                        })
                    .catch(function (error,response) {
                         toastr.success(response.data.message);
                    });
                }   // else end   
              }  //end if error.length 
            },
            cancf(n){
                // console.log('vista a mostrar: ' + n)
                this.$emit('showlist', 0)
                this.$emit('close') 
            },
        }
    }

</script>