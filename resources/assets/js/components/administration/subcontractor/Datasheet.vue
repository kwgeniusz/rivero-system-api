<template> 
 <div class="panel panel-success col-xs-12">
    <div class="panel-body">

    <h3><b>SUBCONTRATISTA:</b></h3>
     <div class="table-responsive">
            <table class="table table-striped table-bordered text-center ">
            <thead>
                <tr class="bg-success">
                 <th>#</th>
                 <th>TIPO TAX ID</th>
                 <th>TAX ID</th>
                 <th>TIPO</th>
                 <th>COMPANIA
                   (RESPONSABLE / CLIENTE)
                 </th>
                 <th>DIRECCION DE FACTURACION</th>
                 <th>TELEFONO</th>
                 <th>CORREO</th>
                 <th>SERVICIO QUE OFRECE</th>                
                 <th>ACCIONES</th>                
                </tr>
            </thead>
          <tbody>
                <tr v-for="(subcont,index) in subcontractor" :key="subcont.subcontId">
                   <td >{{index + 1}}</td>
                   <td class="text-left"> {{subcont.typeTaxId}}</td>  
                   <td class="text-left"> {{subcont.taxId}} </td>           
                   <td class="text-left">{{subcont.subcontType}}</td>
                   <td class="text-left">
                      <p v-if="subcont.companyName != 'No Info'"> 
                          {{subcont.companyName}}
                           </p>
                      <p v-if="subcont.subcontractorName != 'No Info'">
                          ({{subcont.subcontractorName}}) 
                          </p>
                   </td>
                   <td class="text-left">{{subcont.address}}</td>
                   <td class="text-left">{{subcont.mainPhone}}</td>
                   <td class="text-left">{{subcont.mainEmail}}</td>
                   <td class="text-left">{{subcont.serviceOffered}}</td>
                   <td class="text-left">{{subcont.typeForm1099}}</td>
                </tr>
        </tbody>
      </table>
     </div>

  <hr>

<h3><b>CUENTAS POR PAGAR:</b></h3>
 <h4>Total Monto Contratado: {{totals.amountDue}} <br>
     Total Monto Pagado:     {{totals.amountPaid}}   <br>
     Total Monto Pendiente:  {{totals.balance}} <br></h4>

    <div class="row text-center">
         <button class="btn btn-success" @click.prevent="modalPaymentForm()"> 
          <span class="fa fa-dollar" aria-hidden="true"></span> Pagar Seleccionados
        </button>
    </div>

    <br>


 <div class="table-responsive">
          <table class="table table-striped table-bordered text-center">
            <thead> 
            <tr>  
                <th><input type="checkbox" v-model="checkAll"> # </th>
                <th>FECHA CREACION</th>
                <th>DIRECCION</th>
                <th>FACTURA</th>
                <th>MONTO CONTRATADO</th>  
                <th>MONTO PAGADO</th>  
                <th>PENDIENTE POR PAGAR</th>
                <!-- <th>SALDO POR PAGAR</th> -->
            </tr>
            </thead>
          <tbody>   
          
         <tr v-for="(payable,index) in payables" :key="payable.payableId">
            <!-- <td v-if="!showMultiples">{{++index}}</td> -->
            <td >
           <label :for="payable.payableId">
              <input type="checkbox" :id="payable.payableId" :value="payable" v-model="checked" number>
              {{++index}}
          </label>
            </td>
            <td>{{payable.created_at | moment("MM/DD/YYYY hh:mm A") }}</td>
            <td>
                {{payable.subcont_inv_detail.invoice.contract.siteAddress}} 
            </td>
            <td>{{payable.subcont_inv_detail.invoice.invId}}</td>
            <td>{{payable.amountDue}}</td>
            <td>{{payable.acumAmountPaid}}</td>
            <td>{{payable.balance}}</td> 
            <td v-for="(user) in payable.user"> {{user.fullName}}</td> 
  
         </tr>
         </tbody>
        </table>
  </div>


<sweet-modal ref="modalPaymentForm">
  <h2><b>Cuentas por Pagar Seleccionadas:</b></h2> <br>
    <table class="table table-striped table-bordered text-center">
          <tbody>   
         <tr v-for="(payable,index) in checked" >
            <td>
             {{++index}}) 
            </td>
            <td>
                {{payable.subcont_inv_detail.invoice.contract.propertyNumber}} 
                {{payable.subcont_inv_detail.invoice.contract.streetName}} 
                {{payable.subcont_inv_detail.invoice.contract.streetType}} 
                {{payable.subcont_inv_detail.invoice.contract.suiteNumber}} 
                {{payable.subcont_inv_detail.invoice.contract.city}} 
                {{payable.subcont_inv_detail.invoice.contract.state}} 
                {{payable.subcont_inv_detail.invoice.contract.zipCode}}
            </td>
            <td>
              {{payable.balance}}
            </td>
            <td>

              <div class="form-group">
                <label for="amount" class=" control-label">Monto:</label>
                <div class="">
                  <input type="number" step="0.01" min="0" class="form-control" pattern="^[0-9]+" v-model="payable.amountPaid">
                </div>
              </div>
            </td>

            <td>

              <div class="form-group">
                <label for="reason" class=" control-label">Motivo:</label>
                <div class="">
                   <textarea class="form-control" v-model="payable.reason" rows="3"></textarea>
                </div>
              </div>


            </td>
         </tr>
         </tbody>
    </table>

        <div class="col-xs-offset-1 col-xs-10 text-center">

          <div class="form-group col-lg-offset-1 col-lg-10">
            <label for="payMethodId">METODO DE PAGO</label>
            <select class="form-control" id="payMethodId" name="payMethodId" v-model="payMethodId">
               <option v-for="(item, index) in listPaymentMethods" :value="item.payMethodId">{{item.payMethodName}}</option>
              </select>
           </div>
          
          <div class="form-group col-lg-offset-1 col-lg-10" v-if="payMethodId == 2">
            <label for="cashboxId">DESTINO:</label>
             <div> CAJA </div>
             <input type="hidden" name="cashboxId" :value="cashboxId">
          </div>  

           <div class="form-group col-lg-offset-1 col-lg-10" v-if="payMethodId != 2">
            <label for="bankId">BANCO</label>
            <select class="form-control" id="bankId" @change="getAccount()" name="bankId" v-model="bankId">
                <option v-for="(item, index) in listBank" :value="item.bankId">{{item.bankName}}</option>
            </select>
          </div>  

          <div class="form-group col-lg-offset-1 col-lg-10" v-if="payMethodId != 2">
            <label for="accountId">CUENTA DE DESTINO</label>:<br> 
           <select class="form-control" id="accountId" v-model="accountId" name="accountId">
             <option v-for="(item, index) in listAccount" :value="item.accountId">{{item.accountCodeId}}</option>
            </select>
          </div> 


           <div class="form-group col-lg-7 col-lg-offset-2">
               <label for="payMethodDetails">DETALLES DEL METODO:</label>
               <input type="text" class="form-control" id="payMethodDetails" v-model="formPayMethodDetails" placeholder="N° DE TDD,TDC,CUENTA,CHEQUE...">
           </div>

          <div class="form-group col-lg-8 col-lg-offset-2">
            <label for="formTypeExpense">EXPENSE</label>
            <select class="form-control" id="formTypeExpense" name="formTypeExpense" v-model="formTypeExpense">
               <option value="SUPPLIES">SUPPLIES</option>
               <option value="INTERNATIONAL_SUPPLIES">INTERNATIONAL SUPPLIER</option>
              </select>
           </div>

        </div>

        <div class="col-xs-12">
          <button @click="sendForm()" class="btn btn-primary" v-if="btnSubmitForm">Procesar</button>
        </div>

        
  </sweet-modal>
   </div>
  </div>
 </template>


 <script>

  export default {
     mounted() {
            console.log('Component Sub mounted.')
             this.getPayables();

              axios.get(this.prefUrl+'receivables-paymentMethod').then(response => {
                 this.listPaymentMethods = response.data
                });  

               axios.get(this.prefUrl+'banksByOffice').then(response => {
                 this.listBank = response.data
                 this.bankId = this.listBank[0].bankId;
                 this.getAccount();
                }); 
               
               axios.get(this.prefUrl+'cashboxs').then(response => {
                 this.cashboxId =  response.data[0].cashboxId
                });
              
           },
     data: function () {
          return {
             subcontractor: '',
             payables:[],
             checked: [],
             acum: 0,

            listPaymentMethods: {},
            listBank: {},
            listAccount: {},

            errors: [],
            payMethodId: 1,
            formPayMethodDetails:'',
            formTypeExpense:'SUPPLIES',
            bankId: '',
            cashboxId: '',
            accountId:'',
            btnSubmitForm:true,

            totals: [],
          }
    },
    props: {
           prefUrl: { type: String},
           subcontractorId: { type: String, default: null}, 
    },
  computed: {
    checkAll: {
      get: function () {
        return this.payables ? this.checked.length == this.payables.length : false;
      },
      set: function (value) {
        var checked = [];
        if (value) {
          this.payables.forEach(function (doc) {
            checked.push(doc);
          });
        }
        this.checked = checked;
      }
    },   
  },
    methods: {
  
       getPayables: function () {
         //datos del subcontratista
          axios.get(this.prefUrl+'subcontractors/'+this.subcontractorId).then(response => {
                  this.subcontractor = response.data
            });
          //llamar las cuentas que se le deben pagar a este subcontratista
          axios.get(this.prefUrl+'subcontractors/'+this.subcontractorId+'/payables').then(response => {
          this.payables = response.data

          this.totals.amountDue = this.payables.reduce((prev, cur) => (+prev + +cur.amountDue), 0);
          this.totals.amountPaid = this.payables.reduce((prev, cur) => (+prev + +cur.acumAmountPaid), 0);
          this.totals.balance   = this.payables.reduce((prev, cur) => (+prev + +cur.balance), 0);
            });

        },
      modalPaymentForm: function () {
          if(this.checked != '') {
          this.$refs.modalPaymentForm.open();
          this.checked.forEach((ob)=> this.$set(ob, 'amountPaid', 0.00));
          this.checked.forEach((ob)=> this.$set(ob, 'reason', ""));
          }
        },
      sendForm: function() {
           this.errors = [];
           //VALIDATIONS
             //  if (!this.formPayMethodDetails) 
             //  this.errors.push('El detalle del pago es obligatorio.');
           
       if (!this.errors.length) { 
            this.btnSubmitForm = false;
                  //siempre paso todos los paremetros al controlador y modelo aqui coloco en null si es por banco o por caja
              if(this.payMethodId == 2){
                   this.accountId = null;
              }else{
                    this.cashboxId = null;
              }

            axios.post('/payables/pay',{
                checked :         this.checked,
                payMethodId:      this.payMethodId, 
                payMethodDetails: this.formPayMethodDetails,
                typeExpense:      this.formTypeExpense,
                bankId:           this.bankId, 
                cashboxId:        this.cashboxId, 
                accountId:        this.accountId, 
            }).then(response => {
                   if (response.data.alert == "error") {
                       toastr.error(response.data.message)
                         this.btnSubmitForm = true;
                   } else {
                       location.reload();
                       toastr.success(response.data.message)
                   }
  
            })
           }
         },
         getAccount: function (){
         var url = this.prefUrl+'accounts/'+this.bankId;
            axios.get(url).then(response => {
              this.listAccount = response.data;
              this.accountId = this.listAccount[0].accountId;
            });
        }, 
      } //FIN DE METHODS
     }
 </script>
  
<style>
.bold {
    font-weight:bold;
    background:#D7F7E2;
}
</style>