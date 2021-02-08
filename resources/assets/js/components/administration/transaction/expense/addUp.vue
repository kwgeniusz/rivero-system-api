<template>
    <div class="row">
        <div class="col-md-7 col-md-offset-2">
            <div class="panel panel-default">

                <div v-if="editId === 0" class="panel-heading" style="background: #dff0d8"><h4 class="text-uppercase">Agregar Transaccion de Egreso</h4></div>
                <div v-else class="panel-heading" style="background: #d9edf7"><h4 class="text-uppercase">Actualizar Transaccion de Egreso</h4></div>

                <div class="panel-body">
                    <form  class="form" role="form" @submit.prevent="createUpdateTransaction()"  id="formDepartment">
                      
                   <div class="form-group col-md-7">
                         <label for="transactionDate">FECHA:</label>  
                         <datepicker :bootstrap-styling="true" v-model="formTransactionDate"></datepicker>
                    </div>

                        <div class="form-group col-md-9">
                                <label for="description" class="form-group">DESCRIPCION</label>
                                <input type="text" v-model="formDescription" class="form-control" id="description" name="description">
                        </div>

                        <div class="form-group col-md-7">
                                <label for="reason" class="form-group">MOTIVO</label>
                                <input type="text" v-model="formReason" class="form-control" id="reason" name="reason">
                        </div>

                          <div class="row"></div>
                        <select-bank-cashbox pref-url="../"></select-bank-cashbox>

                        <div class="form-group col-md-9">
                                <label for="payMethodDetails" class="form-group">DETALLES DEL METODO</label>
                                <input type="text" v-model="formPayMethodDetails" class="form-control" id="payMethodDetails" name="payMethodDetails">
                        </div>
                          
                          <div class="row"></div>
                        <div class="form-group col-lg-10 ">
                            <label for="transactionTypeId">EXPENSES:</label>
                                 <select class="form-control" v-model="formTransactionTypeId" id="transactionTypeId">
                                    <option v-for="item in transactionTypesList" :key="item.transactionTypeId" :value="item.transactionTypeId">{{item.transactionTypeName}}</option>
                                </select>
                        </div>

                         <div class="form-group col-md-5">
                              <label for="amount">MONTO</label>
                              <input type="number" class="form-control" step="0.01" id="amount" name="amount"  v-model="formAmount" >
                        </div>  

               <div class="row"></div>
                  <div class="form-group col-lg-6">
                  <label for="file">COMPROBANTE DE EGRESO</label>
                  <input type="file" name="file">
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
import Datepicker from 'vuejs-datepicker';
    export default {
        mounted() {
         console.log('Component mounted.');

            axios.get('/transaction-types/-').then(response => {
                this.transactionTypesList = response.data;
                console.log(this.transactionTypesList)
            })

            if (this.editId > 0) {
                // departments
                axios.get(`departments/edit/${this.editId}`).then((response) => {
                    this.transactionData = response.data
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
                transactionData: [],
                transactionTypesList: [],

                formTransactionDate: '',
                formDescription: '',
                formReason: '',
                formPayMethodDetails: '',
                formTransactionTypeId: '',
                formAmount: '',

                 date: new Date(2016, 9, 16)
            }
         },
     components: {
        Datepicker
      },
        props: {
            editId:'',
        },
        methods: {
            createUpdateTransaction(){
                    const params = {
                        formTransactionDate:   this.formTransactionDate,
                        formDescription:       this.formDescription,
                        formReason:            this.formReason,
                        formPayMethodDetails:  this.formPayMethodDetails,
                        formTransactionTypeId: this.formTransactionTypeId,
                        formAmount:            this.formAmount,
                    }
                if (this.editId === 0) {

                    document.querySelector("#formDepartment").reset()
                    axios.post('/transactions/store', params)
                    .then((response) => {
                        // console.log(response)
                        // const department = response.data
                        alert("Success")
                        
                        // este emit era utilizado para insertar datos en el array de la vista
                        // this.$emit('new', department)
                    
                        })
                    .catch(function (response,error) {
                        alert("Faile")
                        console.log(error);
                        console.log(response);
                    });

                }else {
                    // console.log(params)
                    // document.querySelector("#formDepartment").reset()

                    // console.log( params)
                    // console.log('la url es: '+ url)
                    axios.put('/transactions/', params)
                    .then((response) => {
                        alert('Success')
                        })
                    .catch(function (error) {
                        console.log(error);
                    });
                }
                
                
                
            },
            cancf(n){
                console.log('vista a mostrar: ' + n)
                this.$emit('showlist', 0)
            },

        }
    }

</script>