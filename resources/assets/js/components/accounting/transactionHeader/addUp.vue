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
     
        <div class="form-group col-lg-4">
              <label style="color:red">*</label> <label for="date">FECHA:</label>
             <p v-if="displayMode">{{entry.date}}</p>  
             <flat-pickr v-else v-model="entry.date" :config="configFlatPickr"  class="form-control" id="formDatePaid"></flat-pickr>
        </div>
        <div class="form-group col-lg-4">
              <label style="color:red">*</label> <label for="description">DESCRIPCION:</label>
                <p v-if="displayMode">{{entry.description}}</p> 
                <input v-else type="text" class="form-control" v-model="entry.description" name="description" placeholder="">     
        </div>

         <div class="form-group col-lg-4">
              <label style="color:red">*</label> <label for="description">TASA DE CAMBIO:</label>
                <p v-if="displayMode">{{entry.conversionRate}}</p> 
                <input v-else type="number" class="form-control" v-model.number="entry.conversionRate" name="tasa" placeholder="" min="1" step="0.01"  >     
        </div>

         <div class="text-center" v-if="!displayMode">
            <a @click="addRow()" class="btn btn-sm btn-info">
                Agregar Fila<i ></i>
            </a> 
         </div>

         <br>
         
<div class="col-xs-12">
       <div class="tableother">
          <table class="table table-bordered text-center">
            <thead class="bg-info"> 
              <tr>  
                <th>#</th>
                <th>CUENTA</th>  
                <th>DESCRIPCION</th>
                <th>REFERENCIA</th>
                <th>TIPO</th>
                <th>MONTO</th>
                <th v-if="!displayMode">ACCION</th>
              </tr>
            </thead>
            <tbody>   
              <tr v-for="(item,index) in itemList" :key="index">
                <td>{{++index}}</td>
                <td class="col-xs-4">
                  <p v-if="displayMode">{{item.accountName}}</p> 
                  <v-select v-else :options="chartOfAccount"  v-model="item.generalLedgerId" :reduce="chartOfAccount => chartOfAccount.generalLedgerId" label="item_data"/>
                </td>
                <td>
                  <p v-if="displayMode">{{item.description}}</p> 
                  <input v-else type="text" class="form-control" v-model="item.description">
                </td>
                <td>
                  <p v-if="displayMode">{{item.reference}}</p> 
                  <input v-else type="text" class="form-control" v-model="item.reference">
                </td>
                <td>
                  <p v-if="displayMode">{{item.type}}</p>  
                  <select v-else class="form-control" v-model="item.type">
                    <option value="debit">D</option>
                    <option value="credit">C</option>
                  </select>
                </td>
                <td>
                  <p v-if="displayMode">{{item.amount}}</p> 
                  <input v-else type="number" step="0.01" min="0.00" class="form-control" v-model="item.amount">
                </td>
                <td v-if="!displayMode"> 
                  <!-- <a @click="addRow()" class="btn btn-sm btn-success">
                    <i class="glyphicon glyphicon-ok"></i>
                  </a>  -->
                  <a @click="deleteRow(index)" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Eliminar">
                    <span class="fa fa-times-circle" aria-hidden="true"></span> 
                  </a>
                </td> 
              </tr>
            </tbody>
          </table>
        </div>


    <div v-if="editId === 0" class="text-center">
        <button type="submit" class="btn btn-success"><span class="fa fa-check"></span> Guardar</button>
        <button @click="cancf" type="button"  class="btn btn-warning"><span class="fa fa-hand-point-left"></span> Regresar</button>
      </div>

     <div v-if="editId > 0" class="text-center">
        <button type="submit" class="btn btn-primary"><span class="fa fa-check"></span> Actualizar</button>
        <button @click="cancf" type="button"  class="btn btn-warning"><span class="fa fa-hand-point-left"></span> Regresar</button>
     </div>
</div>
            <!-- {{itemList}} -->

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
                  this.chartOfAccount = response.data;
                  this.chartOfAccount.map(function (x){
                       return x.item_data = `${x.accountCode} - (${x.accountName})`;
                 });
          }); //end of create clients

            if (this.editId > 0) {
                // transaction to edit.
                this.itemList = [];
                axios.get(`/accounting/transaction-headers/${this.editId}`).then((response) => {
                    this.data = response.data[0]

                    if(this.data.entryUpdated == 1){this.displayMode == false; }

                    this.entry.date                      = this.data.entryDate;
                    this.entry.description               = this.data.entryDescription;
                    this.entry.conversionRate               = this.data.conversionRate;

                    for (var i=0; i<this.data.transaction.length; i++) { 
                      let transaction = this.data.transaction[i];
                        
                        if(transaction.debit > 0){
                          transaction.type   = 'debit';
                          transaction.amount = transaction.debit;
                        }else if(transaction.credit > 0) {
                          transaction.type   = 'credit';
                          transaction.amount = transaction.credit;
                        }
                       this.itemList.push({
                                     generalLedgerId: transaction.generalLedgerId,
                                     description:transaction.transactionDescription,
                                     reference: transaction.transactionReference,
                                     type: transaction.type,
                                     amount: transaction.amount,
                                     accountName: transaction.general_ledger.accountName,
                                   });
                         }

                });       
            } 
        },
        data(){
            return{
                errors: [],
                displayMode: false,
                showSubmitBtn: true,
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
                     conversionRate: 1,
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
                
                // console.log(JSON.stringify(this.itemList))

                //  let error ='';
                 this.itemList.map(item => {
                
                      if (!item.generalLedgerId) 
                        this.errors.push('Debe escoger una cuenta contable es Requerido.');
                      if (!item.description) 
                        this.errors.push('Descripcion del Asiento es Requerido.');
                     if (!item.reference) 
                        this.errors.push('Referencia del Asiento es Requerido.');
                      if (item.amount == 0) 
                        this.errors.push('El campo monto debe ser mayor a cero');
                 });
               

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
                    axios.put(`/accounting/transactions/${this.editId}`,  [this.entry,this.itemList]).then((response) => {
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