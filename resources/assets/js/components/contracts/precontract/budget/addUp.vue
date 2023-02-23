<template>
 <div class="col-xs-12">
    <div class="row">
      <div class="panel panel-default col-xs-12">
          <div class="panel-heading"><h4><b>Crear Presupuesto:</b></h4></div>
             <div class="panel-body">

       <div class="tableother table-responsive">
          <table class="table table-bordered ">
            <thead class="bg-info"> 
              <tr>  
                <th>#</th>
                <th>Description</th>  
                <th>Label</th>
                <th>Quantity</th>
                <th>Unit</th>
                <th>Costs</th>
                <th v-if="!displayMode">ACCION</th>
              </tr>
            </thead>
            <tbody>   
              <tr v-for="(item,index) in services" :key="index">
                <td>{{++index}}</td>
                <td><a>{{item.serviceCode}} - {{item.serviceName}}</a></td>
                <td>
                  <p v-if="item.hasAPU == 'Y'">{{item.type}}</p>  
                  <select v-else class="form-control" v-model="item.type">
                    <option value="each">each</option>
                    <option value="sqft">sqft</option>
                  </select>
                </td>
               <td >
                  <p v-if="item.hasAPU == 'Y'">{{item.amount}}</p> 
                  <input v-else type="number" step="0.01" min="0.00" class="form-control" v-model="item.amount">  
                </td>
                 <td>
                  <p v-if="item.hasAPU == 'Y'">{{item.type}}</p>  
                  <select v-else class="form-control" v-model="item.type">
                    <option value="each">each</option>
                    <option value="sqft">sqft</option>
                  </select>
                </td>
                <td >
                  <p v-if="item.hasAPU == 'Y'">{{item.amount}}</p> 
                  <input v-else type="number" step="0.01" min="0.00" class="form-control" v-model="item.amount">  
                </td>
                <td v-if="!item.hasAPU == 'Y'"> 
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
  

    <div class="col-xs-offset-7 col-xs-5">
      <h3>Total Debito: {{totalDebit}} | Total Credito: {{totalCredit}}</h3>
    </div>

     <div v-if="editId === 0" class="text-center">
        <button v-if="totalDebit > 0 && totalCredit > 0" type="submit" class="btn btn-success"><span class="fa fa-check"></span> Guardar</button>
        <button @click="cancf" type="button"  class="btn btn-warning"><span class="fa fa-hand-point-left"></span> Regresar</button>
      </div>

     <div v-if="editId > 0" class="text-center">
        <button type="submit" class="btn btn-primary"><span class="fa fa-check"></span> Actualizar</button>
        <button @click="cancf" type="button"  class="btn btn-warning"><span class="fa fa-hand-point-left"></span> Regresar</button>
     </div>

 </div>
  </div>
   </div>
   </div>

</template>

<script>

    
    export default {
        mounted() {
         //obtengo los datos para llenar la tabla
          axios.get('/services').then((response) => {
                  this.services = response.data;
                  console.log(this.services)
                  this.services.map(function (x){
                       return x.item_data = `${x.accountCode} - (${x.accountName})`;
                 });
          }); //end of create clients

         //obtengo los datos para llenar las listas de selects

            // budget to edit.
            if (this.editId > 0) {
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

                services:[], 
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
      computed: {
       
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
                // if (this.totalDebit == this.totalCredit) 
                // this.errors.push('El total de debito y credito debe ser igual.');
                
                //  let error ='';
                 this.itemList.map(item => {
                      if (!item.generalLedgerId) 
                        this.errors.push('Debe escoger una cuenta contable es Requerido.');
                    //   if (!item.description) 
                    //     this.errors.push('Descripcion del Asiento es Requerido.');
                    //  if (!item.reference) 
                    //     this.errors.push('Referencia del Asiento es Requerido.');
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

<style scoped>
    .table{
        margin: auto;
    }
    .add-button{
        width: 95%;
        margin: auto;
        text-align: right;
        color: green;
        padding: 1rem;
        padding-right: 2.5rem;
        font-weight: bold;
    }
</style>