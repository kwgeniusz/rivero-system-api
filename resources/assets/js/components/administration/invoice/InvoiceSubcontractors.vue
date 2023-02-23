
<template> 
 <div class="panel panel-success col-xs-12  col-lg-8 col-lg-offset-2">
    <div class="panel-body">
<h4><b>Factura N°:</b> {{invoice[0].invId}}</h4>
<h4><b>Fecha:</b> {{invoice[0].invoiceDate | moment("MM/DD/YYYY") }}</h4>
    
<hr>

      <h3 class="text-center">Servicios con Precio</h3>
      <div class="table-responsive col-xs-12">
          <table class="table table-bordered text-center">
            <thead class="bg-info"> 
            <tr>  
                <th>#</th>
                <th>SERVICIO</th>  
                <th>UNIDAD</th>
                <th>COSTO UNITARIO</th>
                <th>CANTIDAD</th>
                <th>MONTO</th>
                <th colspan="2" >ACCION</th>
            </tr>
            </thead>
          <tbody>   
           <template v-for="(item,index) in invoiceDetails">      
          <tr>
            <td>{{++index}}</td>
            <td>{{item.serviceName}}</td>
            <td>{{item.unit}}</td>
            <td>{{item.unitCost}}</td>
            <td>{{item.quantity}}</td>
            <td>{{item.amount}}</td>
            <td>
                <a @click="openModal(item)" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Agregar Subcontratista">
                            <span class="fa fa-plus" aria-hidden="true"></span> 
               </a>   
           </td> 
         </tr>
            <tr>
            <td></td>
             <td colspan="6" >
              <div class="text-left">
                   <div v-for="(item2,index2) in item.subcontractor_inv_detail">
                   <a @click="removeSubcontractor(item2.subcontInvDetailId)" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Remover Subcontratista">
                            <span class="fa fa-times-circle" aria-hidden="true"></span> 
                   </a>   
                    <b>{{++index2}})
                     Nombre: {{item2.subcontractor.companyName}} ({{item2.subcontractor.subcontractorName}}) /
                     Monto a Pagar:   {{item2.transactionAmount}}</b>
                  <br>
                 </div>
              </div>
            </td>
           </tr> 

           </template>
         </tbody>   
        </table>
       </div>
       <div class="col-xs-12 text-center">
             <b>{{invoiceNetTotal}}</b>
       </div>
     <hr>
   </div>


<!-- Ventana modal para relacionar subcontratista con el servicio de la factura -->

 <sweet-modal ref="modal">
    <h3 class="bg-success"><b>{{serviceSelected.serviceName}} <br> MONTO DEL SERVICIO: {{serviceSelected.amount}}</b></h3>

          <div class="alert alert-danger" v-if="errors.length">
            <h4>Errores:</h4>
            <ul>
             <li v-for="error in errors">{{ error }}</li>
            </ul>
          </div>

   <br>
    <h4><b>SUBCONTRATISTA:</b></h4>
     <v-select :options="subcontractors"  v-model="form.subcontractorId" :reduce="subcontractors => subcontractors.subcontId" label="item_data"/>
   <br>
         <div class="form-group col-sm-6">
            <label for="formTypeOfAgreement">TIPO DE ACUERDO</label>:<br> 
           <select class="form-control" id="formTypeOfAgreement" v-model="form.typeOfAgreement" @change="resetForm()">
             <option value="amountPayable">Monto</option>
             <option value="percentage">Porcentaje</option>
             <option value="detailed">Detallado</option>
            </select>
          </div> 

           <div class="form-group col-sm-6" v-if="form.typeOfAgreement == 'amountPayable'">
                 <label for=".a">MONTO A PAGAR</label>
                 <input type="number" step="0.01" min="0" class="form-control" id=".a"  pattern="^[0-9]+" v-model="form.amountPayable" >
             </div>

          <div class="form-group col-sm-6" v-if="form.typeOfAgreement == 'percentage'">
                 <label for="formPercent">PORCENTAJE</label>
                 <input type="number" step="0.01" min="0" max="100" class="form-control" id="formPercent"  pattern="^[0-9]+" v-model="form.percent" >
          </div>

          <div class="row"></div>
          <div class="form-group col-sm-6 col-sm-offset-3" v-if="form.typeOfAgreement == 'percentage'">
                 <p>MONTO A PAGAR: {{sumTotalPercent}}</p>
          </div>

 <!-- Modalidad detallada -->
         <div v-if="form.typeOfAgreement == 'detailed'" class="table-responsive col-xs-12">
          <table class="table table-bordered text-center">
            <thead class="bg-info"> 
            <tr>  
                <th>UNIDAD</th>
                <th>COSTO UNITARIO</th>
                <th>CANTIDAD</th>
                <th>MONTO</th>
            </tr>
            </thead>
          <tbody>   
          <tr>
            <td>{{serviceSelected.unit}}</td>
            <td><input type="number" step="0.01" min="0.00" class="form-control" v-model="form.unitCost"></td>
            <td><input type="number" step="0.01" min="0.00" class="form-control" v-model="form.quantity"></td>
            <td>{{sumTotalDetailed}}</td>
         </tr>
         </tbody>   
        </table>
       </div>

      <div class="row"></div>
      <a @click="sendForm()" v-if="btnSubmitForm" class="btn btn-primary">
          <span class="fa fa-check" aria-hidden="true"></span>  ENVIAR
      </a>
    <br>

  </sweet-modal>

</div>
</template>


<script>

export default {
        
     mounted() {
            console.log('Component mounted.')
            this.findInvoice();
            this.getAllInvoicesDetails();

            axios.get('/subcontractors').then((response) => {
                  this.subcontractors = response.data;
                  this.subcontractors.map(function (x){
                       return x.item_data = `${x.companyName} - (${x.subcontractorName})`;
                 });
             }); //end of create subcontractors
        },
    data: function() {
        return {
            errors: [],

            invoice: '',
            invoiceDetails: [],
            subcontractors:[],

            serviceSelected: '',
            form :  {                    
                      subcontractorId: '',
                      typeOfAgreement: 'amountPayable',
                      percent: '',
                      unitCost: '',
                      quantity: '',
                      amountPayable: '',
                   },
            btnSubmitForm: false,
        }
    },
  props: {
     invoiceId: { type: String},
    },
  computed: {
      sumTotalPercent: function () {
          let amountTotal = (this.serviceSelected.amount * this.form.percent)/100;
          return  Number.parseFloat(amountTotal).toFixed(2);  
       },
      sumTotalDetailed: function () {
          let amountTotal = this.form.unitCost * this.form.quantity;
          return  Number.parseFloat(amountTotal).toFixed(2);  
       },
      invoiceNetTotal: function () {
          let suma = 0;

         this.invoiceDetails.forEach (function(item){
             if(item.amount == null){item.amount=0.00}
            suma += parseFloat(item.amount);
            suma.toFixed(2);
          });

              let taxAmount   = (parseFloat(suma).toFixed(2) * parseFloat(this.invoice[0].taxPercent).toFixed(2))/100;
              let netTotal    = parseFloat(taxAmount) + parseFloat(suma);

               return (
                `Sub Total: ${suma} /
                 Impuesto:  ${this.invoice[0].taxPercent}% = ${taxAmount} /
                 Total Neto: ${netTotal}
                ` )
       }  
    },
    methods: {
/*------------------SEARCH METHODS-------------------- */
        findInvoice: function (){
            let url ='../../invoices/'+this.invoiceId;
            axios.get(url).then(response => {
             this.invoice = response.data
            });
        },
        getAllInvoicesDetails: function (){
          let url ='../../invoicesDetails/'+this.invoiceId+'/withPrice';
            axios.get(url).then(response => {
             this.invoiceDetails = response.data
            });
        },
/*------------------FORM METHODS-------------------- */
      openModal: function (item){
            this.serviceSelected = item;

            this.errors = [];
            this.btnSubmitForm = true;
            this.$refs.modal.open()
       },
       resetForm: function() {
         if(this.form.typeOfAgreement == 'detailed'){
            this.form.percent       = ''; 
            this.form.unitCost = this.serviceSelected.unitCost;
            this.form.quantity = this.serviceSelected.quantity;
            this.form.amountPayable = '';
         } else{
            this.form.percent       = ''; 
            this.form.unitCost      = ''; 
            this.form.quantity      = ''; 
            this.form.amountPayable = '';
         }
            
       },
       sendForm: function() {
           this.errors = [];
           
              //VALIDATIONS
               if (!this.form.subcontractorId) {
                    this.errors.push('Debe Escoger un Subcontratista.');
               } 
               if (this.form.typeOfAgreement == 'amountPayable') {
                    if(!this.form.amountPayable) 
                    this.errors.push('Debe Ingresar un Monto.');
               }
               if (this.form.typeOfAgreement == 'percentage') {
                    if(!this.form.percent) 
                    this.errors.push('Debe Ingresar un Porcentaje.');
               }
              if (this.form.typeOfAgreement == 'detailed') {
                    if(!this.form.unitCost || this.form.unitCost == 0) 
                    this.errors.push('Debe Ingresar un costo para la unidad y debe ser mayor a cero.');
                    if(this.form.unitCost > this.serviceSelected.unitCost) 
                    this.errors.push('El costo por unidad no puede ser mayor al monto ofrecido.');

                    if(!this.form.quantity || this.form.quantity == 0) 
                    this.errors.push('Debe Ingresar la cantidad y debe ser mayor a cero.');
                    if(this.form.quantity > this.serviceSelected.quantity) 
                    this.errors.push('La cantidad no puede ser mayor a la ofrecida');
               }
      
       if (!this.errors.length) { 
            // this.btnSubmitForm = false;
           if(this.form.typeOfAgreement == 'percentage'){
               this.form.amountPayable  = this.sumTotalPercent;
           }
          if(this.form.typeOfAgreement == 'detailed'){
               this.form.amountPayable  = this.sumTotalDetailed;
           }
            axios.post('../../subcontractors/add/invDetail',{
                subcontId :  this.form.subcontractorId,
                invoiceId: this.serviceSelected.invoiceId,
                invDetailId: this.serviceSelected.invDetailId,
                transactionPercentage: this.form.percent,
                transactionUnitCost: this.form.unitCost,
                transactionQuantity: this.form.quantity,
                transactionAmount : this.form.amountPayable,
            }).then(response => {
                   if (response.data.alertType == "error") {
                         toastr.error(response.data.message)
                         this.btnSubmitForm = true;
                   } else {
                       toastr.success(response.data.message)
                         this.serviceSelected = '';
                         this.errors = [];

                         this.form.typeOfAgreement = 'amountPayable';
                         this.form.unitCost = '';
                         this.form.quantity = '';
                         this.form.percent = '';
                         this.form.amountPayable = '';
                         this.btnSubmitForm =  false;

                        this.getAllInvoicesDetails();//actualiza los detalles
                        this.$refs.modal.close();
                        // this.$refs.searchSubcontractor.forceUpdate();//resetea comnponente hijo search 
                   }
            })
           }
         },
      removeSubcontractor: function(subcontInvDetailId) {
        axios.post('../../subcontractors/remove/invDetail',{
                subcontInvDetailId :  subcontInvDetailId,
          }).then(response => {
                   if (response.data.alertType == "error") {
                       toastr.error(response.data.message)
                   } else {
                       toastr.success(response.data.message)
                        this.getAllInvoicesDetails();
                   }
            })
         },
    }//fin de method
       // this.$forceUpdate()
}
 </script>
  
<style>
.bold {
    font-weight:bold;
    background:#D7F7E2;
}
.opened {
  background-color: #D2f8E2;
}
</style>