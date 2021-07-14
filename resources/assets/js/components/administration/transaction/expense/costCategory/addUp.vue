<template>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">

                <div v-if="editId === 0" class="panel-heading" style="background: #dff0d8"><h4 class="text-uppercase">Agregar Categoria de Costo</h4></div>
                <div v-else class="panel-heading" style="background: #d9edf7"><h4 class="text-uppercase">Actualizar Categoria de Costo</h4></div>

        <div class="panel-body">

            <div class="alert alert-danger" v-if="errors.length">
             <h4>Errores:</h4>
             <ul>
               <li v-for="(error,index) in errors"  :key="index">{{ error }}</li>
            </ul>
           </div>

        <form  class="form"  id="formTransaction" role="form" @submit.prevent="createUpdateTransaction()">

                        <div class="form-group col-md-9">
                                <label for="name" class="form-group">NOMBRE DEL TIPO DE EXPENSE</label>
                                <input type="text" v-model="transactionType.name" class="form-control" id="name" name="name">
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
    // import SelectBankCashbox from '../../SelectBankOrCashbox.vue'
    // import {Spanish} from 'flatpickr/dist/l10n/es.js';

    export default {
        mounted() {
         console.log('componente agregar tipo de expense montado');

            if (this.editId > 0) {
                // transaction to edit.
                axios.get(`/transaction-types/${this.editId}`).then((response) => {
                    let data = response.data[0]
                    console.log(data)
                    this.transactionType.name = data.transactionTypeName;
                })  
            }    
        },
        data(){
            return{
                errors: [],
                transactionTypesList: [],
                showSubmitBtn:true,

                transactionType:  {
                    //  code: '',
                     name: '',
                },

            }
         },
       props: {
            editId:'',
        },        
        methods: {
            createUpdateTransaction(){
              this.errors = [];

                if (!this.transactionType.name) 
                this.errors.push('Debe ingresar un nombre para el expense.');
  
           if (!this.errors.length) { 
               
                let formData = new FormData();
                     formData.append('transactionTypeName',this.transactionType.name);
                     formData.append('sign','-');
                   
                if (this.editId === 0) {
                     this.showSubmitBtn = false;

                    axios.post('/transaction-types', formData)
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

                   axios.post(`/transactions-types/${this.editId}`, formData)
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
            cancf(n){
                console.log('vista a mostrar: ' + n)
                this.$emit('showlist', 0)
            },
        }
    }

</script>