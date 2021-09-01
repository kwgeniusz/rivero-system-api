<template>
    <div class="row">
      <!-- <sweet-modal ref="modalNew" @close="cancf"> -->
       <div class="col-xs-12">
         <div class="panel panel-default">
            <div v-if="editId === 0" class="panel-heading" style="background: #dff0d8"><h4 class="text-uppercase">Agregar Asientos Contables</h4></div>
            <div v-else class="panel-heading" style="background: #d9edf7"><h4 class="text-uppercase">Actualizar Asientos Contables</h4></div>

        <div class="panel-body">
            <div class="alert alert-danger" v-if="errors.length">
              <h4>Errores:</h4>
               <ul>
                 <li v-for="(error,index) in errors" :key="index">{{ error }}</li>
              </ul>
           </div>

    <p class="text-right"> <label style="color:red">* </label>REQUERIDOS </p>
      <form  class="" id="form1" role="form" @submit.prevent="sendForm()">
        
        <div class="form-group col-lg-6">
              <label style="color:red">*</label> <label for="date">FECHA:</label>
             <flat-pickr v-model="entry.date" :config="configFlatPickr"  class="form-control" id="formDatePaid"></flat-pickr>
        </div>
        <div class="form-group col-lg-6">
              <label style="color:red">*</label> <label for="description">DESCRIPCION:</label>
                <input type="text" class="form-control" v-model="entry.description" name="description" placeholder="">
        </div>

<div class="col-xs-12">
       <div class="table-responsive tableother">
          <table class="table table-bordered text-center">
            <thead class="bg-info"> 
              <tr>  
                <th>#</th>
                <th>CUENTA</th>  
                <th>DESCRIPCION</th>
                <th>REFERENCIA</th>
                <th>TIPO</th>
                <th>MONTO</th>
                <th>ACCION</th>
              </tr>
            </thead>
            <tbody>   
              <tr v-for="(item,index) in itemList" :key="index">
                <td>{{++index}}</td>
                <td>
                  <v-select v-if="editMode" :options="chartOfAccount"  v-model="item.generalLedgerId" :reduce="chartOfAccount => chartOfAccount.generalLedgerId" label="item_data"/>
                  <p v-else>{{item.generalLedgerId}}</p> 
                </td>
                <td>
                  <input v-if="editMode" type="text" class="form-control" v-model="item.description">
                  <p v-else>{{item.description}}</p> 
                </td>
                <td>
                  <input v-if="editMode" type="text" class="form-control" v-model="item.reference">
                  <p v-else>{{item.reference}}</p> 
                </td>
                <td>
                  <select v-if="editMode" class="form-control" v-model="item.type">
                    <option value="debit">D</option>
                    <option value="credit">C</option>
                  </select>
                  <p v-else>{{item.type}}</p> 
                </td>
                <td>
                  <input v-if="editMode" type="number" step=".00" class="form-control" v-model="item.amount">
                  <p v-else>{{item.amount}}</p> 
                </td>
                <td> 
                  <a @click="addRow()" class="btn btn-sm btn-success">
                    <i class="glyphicon glyphicon-ok"></i>
                  </a> 
                  <a @click="deleteRow(index)" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Eliminar">
                    <span class="fa fa-times-circle" aria-hidden="true"></span> 
                  </a>
                </td> 
              </tr>
            </tbody>
          </table>
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
</div>
            {{itemList}}

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
          axios.get('/accounting/transaction-headers/create').then((response) => {
            //   console.log(response.data)
                  this.chartOfAccount = response.data;
                  this.chartOfAccount.map(function (x){
                       return x.item_data = `${x.accountCode} - (${x.accountName})`;
                 });
          }); //end of create clients

            if (this.editId > 0) {
                // transaction to edit.
                axios.get(`/accounting/transaction-headers/${this.editId}`).then((response) => {
                    this.data = response.data[0]

                    this.transaction.transactionNumber      = this.data.transactionNumber;
                    this.transaction.generalLedgerId        = this.data.generalLedgerId;
                    this.transaction.transactionDate        = this.data.transactionDate;
                    this.transaction.description            = this.data.description;
                    this.transaction.reference              = this.data.reference;
                    this.transaction.debit                  = this.data.debit;
                    this.transaction.credit                 = this.data.credit;

                });       
            } 
        },
        data(){
            return{
                errors: [],
                editMode: true,
                showSubmitBtn:true,
                configFlatPickr:{
                     altFormat: 'm/d/Y',
                     altInput: true,
                     dateFormat: 'Y-m-d',
                    //  locale: Spanish, // locale for this instance only  
                 },

                chartOfAccount:[], 
                entry:  {                    
                     date: '',
                     description: '',
                   },
                itemList: [{
                   generalLedgerId:'',
                   description:'',
                   reference: '',
                   type:'debit',
                   amount: 0,
                   }],
            }
         },
      props: {
            editId:'',
        },
      methods: {
        addRow: function() {
           this.errors = [];
             //Validaciones.
              //  if (!this.modelServiceId) 
              //   this.errors.push('Debe Escoger un Servicio.');
  
               if (!this.errors.length) { 
                 //insertar en arreglo de items.
                 this.itemList.push({
                                     generalLedgerId:'',
                                     description:'',
                                     reference: '',
                                     type:'debit',
                                     amount: 0,
                                   });

           } //end of errors
         },
         deleteRow: function(id) {
            //borrar valor que encuentre del arreglo
                 this.itemList.splice(--id,1);
         }, 
         sendForm(){
              this.errors = [];

                 if (!this.entry.date) 
                this.errors.push('Fecha del Encabezado es Requerido.');
                 if (!this.entry.description) 
                this.errors.push('Descripcion del Encabezado es Requerido.');
               
               

           if (!this.errors.length) { 
                if (this.editId === 0) {  
                    this.showSubmitBtn = false;
                    
                    axios.post('/accounting/transaction-headers', [this.entry,this.itemList]).then((response) => {
                           toastr.success(response.data.message);
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