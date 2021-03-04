<template>
    <div class="row">
        <div class="col-md-7 col-md-offset-2">
            <div class="panel panel-default">

                <div v-if="editId === 0" class="panel-heading" style="background: #dff0d8"><h4 class="text-uppercase">Agregar Cliente</h4></div>
                <div v-else class="panel-heading" style="background: #d9edf7"><h4 class="text-uppercase">Actualizar Cliente</h4></div>

        <div class="panel-body">
            <div class="alert alert-danger" v-if="errors.length">
             <h4>Errores:</h4>
             <ul>
               <li v-for="(error,index) in errors"  :key="index">{{ error }}</li>
            </ul>
        </div>

        <form  class="form" id="formClient" role="form" @submit.prevent="createUpdateClient()">
            
        <div class="inputother birthday">
                <label for="clientName"><i class="fas fa-user-friends"></i> NOMBRE Y APELLIDO / EMPRESA</label>
                <input type="text" v-model="client.clientName" class="form-control" id="description" name="description" placeholder="NOMBRE Y APELLIDO / EMPRESA">
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
    export default {
        mounted() {
         console.log('Component mounted.');

            if (this.editId > 0) {
                // transaction to edit.
                axios.get(`-/show/${this.editId}`).then((response) => {
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
                client:  {                    
                     clientType: '',
                     companyName: '',
                     clientName: '',
                     gender: '',
                     clientAddress: '',
                     businessPhone: '',
                     homePhone: '',
                     mobilePhone: '',
                     otherPhone: '',
                     fax: '',
                     mainEmail: '',
                     secondaryEmail: '',
                },

            }
         },
       props: {
            editId:'',
        },
        methods: {
            createUpdateClient(){
              this.errors = [];

               if (!this.client.clientDate) 
                this.errors.push('Debe escoger una Fecha Para la Transaccion.');
                if (!this.client.description) 
                this.errors.push('Debe Ingresar Una Descripcion.');
                 if (!this.client.reason) 
                this.errors.push('Debe escoger una Razon.');
                 if (!this.client.payMethodDetails) 
                this.errors.push('Debe Escribir un Detalle Para el Metodo de Pago.');
                 if (!this.client.clientTypeId) 
                this.errors.push('Debe escoger un Expense.');
                 if (!this.client.amount) 
                this.errors.push('Debe Ingresar Un Monto.');
                 if (!this.client.imagen) 
                this.errors.push('Debe adjuntar una Imagen Obligatoria.');

                 let dateFormated = new Date(this.client.clientDate);
                  dateFormated    = dateFormated.toLocaleDateString('en-US')// output "16-11-2018"
                //   console.log(dateFormated)

           if (!this.errors.length) { 
                if (this.editId === 0) {

                let formData = new FormData();
                     formData.append('clientDate',dateFormated);
                     formData.append('description',this.client.description);
                     formData.append('reason',this.client.reason);
                     formData.append('payMethodId',this.client.payMethodId);
                     formData.append('payMethodDetails',this.client.payMethodDetails);
                     formData.append('clientTypeId',this.client.clientTypeId);
                     formData.append('amount',this.client.amount);
                     formData.append('sign', '-');
                     formData.append('file',this.client.imagen);
                     if(this.client.payMethodId == 2){
                       formData.append('cashboxId',this.client.cashboxId);
                       formData.append('accountId','');
                     }else{
                       formData.append('cashboxId','');
                       formData.append('accountId',this.client.accountId);
                     }

                    axios.post('/clients/store', formData, {
                           headers: {
                            'Content-Type': 'multipart/form-data'
                             }
                    })
                    .then((response) => {

                         toastr.success(response.data.message);

                         this.client.clientDate = '';
                         this.client.description = '';
                         this.client.reason = '';
                         this.client.payMethodId = '';
                         this.client.payMethodDetails = '';
                         this.client.clientTypeId = '';
                         this.client.amount = '';
                         this.client.cashboxId = '';
                         this.client.accountId = '';
                         this.client.imagen = '';


                           this.$emit('showlist', 0)
                        //   console.log(client)
                        })
                    .catch(function (response) {
                        alert("Faile post")
                    });

                }else {
                    axios.put('/clients/', params)
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
        }
    }

</script>