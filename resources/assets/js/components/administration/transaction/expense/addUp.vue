<template>
    <div class="row">
        <div class="col-md-7 col-md-offset-2">
            <div class="panel panel-default">

                <div v-if="editId === 0" class="panel-heading" style="background: #dff0d8"><h4 class="text-uppercase">Agregar Transaccion de Egreso</h4></div>
                <div v-else class="panel-heading" style="background: #d9edf7"><h4 class="text-uppercase">Actualizar Transaccion de Egreso</h4></div>

        <div class="panel-body">

            <div class="alert alert-danger" v-if="errors.length">
             <h4>Errores:</h4>
             <ul>
               <li v-for="error in errors">{{ error }}</li>
            </ul>
           </div>
        <form  class="form" id="formTransaction" role="form" @submit.prevent="createUpdateTransaction()">

                   <div class="form-group col-md-7">
                         <label for="transactionDate">FECHA:</label>  
                         <datepicker :bootstrap-styling="true" :format="DatePickerFormat" v-model="transaction.transactionDate"></datepicker>
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
                            <label for="transactionTypeId">EXPENSES:</label>
                                 <select class="form-control" v-model="transaction.transactionTypeId" id="transactionTypeId">
                                    <option v-for="item in transactionTypesList" :key="item.transactionTypeId" :value="item.transactionTypeId">{{item.transactionTypeName}}</option>
                                </select>
                        </div>

                         <div class="form-group col-md-5">
                              <label for="amount">MONTO</label>
                              <input type="number" class="form-control" step="0.01" id="amount" name="amount"  v-model="transaction.amount" >
                        </div>  

               <div class="row"></div>
                  <div class="form-group col-lg-6">
                  <label for="file">COMPROBANTE DE EGRESO</label>
                  <input type="file" @change="obtenerImagen" name="file">
               </div>

               <div class="row"></div>
               <figure>
                   <img width="400" height="300" :src="imagen" alt="Foto del Producto">
               </figure>
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
import Datepicker from 'vuejs-datepicker';

    export default {
        mounted() {
         console.log('Component mounted.');

            axios.get('/transaction-types/-').then(response => {
                this.transactionTypesList = response.data;
               // console.log(this.transactionTypesList)
            })

            if (this.editId > 0) {
                // departments
                axios.get(`departments/edit/${this.editId}`).then((response) => {
                    // this.transactionData = response.data
                    // console.log(this.transactionData)
                    // this.selectCompany = document.querySelector("#selectCompani").value = this.transactionData[0].companyId
                    // this.nameCompany = document.querySelector("#department_name").value = this.transactionData[0].departmentName
                    // this.selectDepartmen =document.querySelector("#selectDepartmen").value = this.transactionData[0].parentDepartmentId
                    // this.deparmetIds = this.transactionData[0].departmentId
                    // console.log('deparmetIds ' +this.deparmetIds)
                })
                
            }      
        },
        data(){
            return{
                errors: [],
                transactionTypesList: [],
                
                imagenMiniatura:'',
                DatePickerFormat: 'MM/dd/yyyy',
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

                //  date: new Date(2016, 9, 16)
            }
         },
      components: {
            Datepicker
       },
       props: {
            editId:'',
        },
       computed: {
         imagen(){
             return this.imagenMiniatura;
         },
       },
        methods: {
            createUpdateTransaction(){
              this.errors = [];

                //  let mydate = "2018-11-16T22:12:00.000Z"


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
                 if (!this.transaction.imagen) 
                this.errors.push('Debe adjuntar una Imagen Obligatoria.');

                 let dateFormated = new Date(this.transaction.transactionDate);
                  dateFormated    = dateFormated.toLocaleDateString().replace(/\//g, "-")// output "16-11-2018"

           if (!this.errors.length) { 
                if (this.editId === 0) {


                let formData = new FormData();
                     formData.append('transactionDate',dateFormated);
                     formData.append('description',this.transaction.description);
                     formData.append('reason',this.transaction.reason);
                     formData.append('payMethodId',this.transaction.payMethodId);
                     formData.append('payMethodDetails',this.transaction.payMethodDetails);
                     formData.append('transactionTypeId',this.transaction.transactionTypeId);
                     formData.append('amount',this.transaction.amount);
                     formData.append('sign', '-');
                     formData.append('file',this.transaction.imagen);
                     if(this.transaction.payMethodId == 2){
                       formData.append('cashboxId',this.transaction.cashboxId);
                       formData.append('accountId',null);
                     }else{
                       formData.append('cashboxId',null);
                       formData.append('accountId',this.transaction.accountId);
                     }

                    axios.post('/transactions/store', formData, {
                           headers: {
                            'Content-Type': 'multipart/form-data'
                             }
                    })
                    .then((response) => {
                        console.log(response.message)
                        })
                    .catch(function (response) {
                        alert("Faile post")
                    });

                }else {
                    axios.put('/transactions/', params)
                    .then((response) => {
                        alert('Success')
                        })
                    .catch(function (error) {
                        console.log(error);
                    });
                }   // else end   
             }  //end if error.length 
            },
            obtenerImagen(e){
                let file = e.target.files[0];
                this.transaction.imagen = file;
                this.cargarImagen(file);
            },
            cargarImagen(file){
              let reader = new FileReader();

              reader.onload = (e) => {
                this.imagenMiniatura = e.target.result;
              }
              reader.readAsDataURL(file)
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