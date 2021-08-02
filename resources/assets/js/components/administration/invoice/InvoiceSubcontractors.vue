
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
                <th>COSTO</th>
                <th>CANTIDAD</th>
                <th>MONTO</th>
                <th colspan="2" >ACCION</th>
            </tr>
            </thead>
          <tbody>   
           <template v-for="(item,index) in itemList">      
          <tr>
            <!-- {{item}} -->
            <td>{{++index}}</td>
            <!-- <td>{{item.itemNumber}}</td> -->
            <td>{{item.serviceName}}</td>
            <td>{{item.unit}}</td>
            <td>{{item.unitCost}}</td>
            <td>{{item.quantity}}</td>
            <td>{{item.amount}}</td>
            <td>
               <!--  <a @click="toggle(item.invDetailId)" :class="{ opened: opened.includes(item.invDetailId) }" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Ver Compromisos">
                            <span class="fa fa-user" aria-hidden="true"></span> 
               </a>   -->
                <a @click="openModal(item)" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Agregar Subcontratista">
                            <span class="fa fa-plus" aria-hidden="true"></span> 
               </a>   
           </td> 
         </tr>

            <!-- <tr v-if="opened.includes(item.invDetailId)"> -->
            <tr>
            <td></td>
             <td colspan="6" >
              <div class="text-left">
                   <div v-for="(item2,index2) in item.subcontractor_inv_detail">
                   <a @click="removeSubcontractor(item2.subcontInvDetailId)" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Remover Subcontratista">
                            <span class="fa fa-times-circle" aria-hidden="true"></span> 
                   </a>   
                    <b>{{++index2}})
                     Nombre: {{item2.subcontractor.name}} /
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


 <sweet-modal ref="modal">
    <h3 class="bg-success"><b>{{service.serviceName}} <br> MONTO DEL SERVICIO: {{service.amount}}</b></h3>

          <div class="alert alert-danger" v-if="errors.length">
            <h4>Errores:</h4>
            <ul>
             <li v-for="error in errors">{{ error }}</li>
            </ul>
          </div>

        <search-subcontractor pref-url='../../'
         @subcontractorSelected ='formSubcontId = $event' 
         @subcontractorRemoved  ="formSubcontId = ''" 
         ref="searchSubcontractor">
         </search-subcontractor >
<!-- 
              <div class="form-group">
                <label>MONTO DEL SERVICIO: {{service.amount}}</label> 
              </div> -->

         <div class="form-group col-sm-6">
            <label for="formTypeOfAgreement">TIPO DE ACUERDO</label>:<br> 
           <select class="form-control" id="formTypeOfAgreement" v-model="formTypeOfAgreement" @change="formPercent = ''; formAmountPayable = '' ">
             <option value="amountPayable">Monto</option>
             <option value="percentage">Porcentaje</option>
            </select>
          </div> 

           <div class="form-group col-sm-6" v-if="formTypeOfAgreement == 'amountPayable'">
                 <label for="formAmountPayable">MONTO A PAGAR</label>
                 <input type="number" step="0.01" min="0" class="form-control" id="formAmountPayable"  pattern="^[0-9]+" v-model="formAmountPayable" >
             </div>

          <div class="form-group col-sm-6" v-if="formTypeOfAgreement == 'percentage'">
                 <label for="formPercent">PORCENTAJE</label>
                 <input type="number" step="0.01" min="0" max="100" class="form-control" id="formPercent"  pattern="^[0-9]+" v-model="formPercent" >
          </div>

          <div class="row"></div>
          <div class="form-group col-sm-6 col-sm-offset-3" v-if="formTypeOfAgreement == 'percentage'">
                 <p>MONTO A PAGAR: {{sumTotal}}</p>
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
import searchSubcontractor from '../payables/subcontractor/searchSubcontractor.vue';

export default {
        
     mounted() {
            console.log('Component mounted.')
            this.findInvoice();
            this.getAllInvoicesDetails();
        },
    data: function() {
        return {
            errors: [],
            opened: [],

            invoice: '',
            itemList: {},
            itemList2: {},
            service: '',

            formSubcontId:'',
            formTypeOfAgreement:'amountPayable',
            formAmountPayable:'',
            formPercent:'',
            btnSubmitForm: false,
        }
    },
  props: {
     invoiceId: { type: String},
    },
  components: {
     searchSubcontractor
  },  
  computed: {
      sumTotal: function () {
          let amountTotal = (this.service.amount * this.formPercent)/100;
          return  Number.parseFloat(amountTotal).toFixed(2);  
       },
      invoiceNetTotal: function () {
          let suma = 0;

         this.itemList.forEach (function(item){
             if(item.amount == null){item.amount=0.00}
            suma += parseFloat(item.amount);
            suma.toFixed(2);
          });

              let taxAmount   = (parseFloat(suma).toFixed(2) * parseFloat(this.invoice[0].taxPercent).toFixed(2))/100;
              let netTotal    = parseFloat(taxAmount) + parseFloat(suma);

               return (
                `Sub Total: ${suma} /
               Impuesto:${this.invoice[0].taxPercent}% = ${taxAmount} /
               Total Neto: ${netTotal}
               ` )
       }  
    },

    methods: {
       //  toggle(id) {
       //   const index = this.opened.indexOf(id);
       //   if (index > -1) {
       //     this.opened.splice(index, 1)
       //   } else {
       //     this.opened.push(id)
       //   }
       // },
        findInvoice: function (){
            let url ='../../invoices/'+this.invoiceId;
            axios.get(url).then(response => {
             this.invoice = response.data
            });
        },
        getAllInvoicesDetails: function (){
          let url ='../../invoicesDetails/'+this.invoiceId+'/withPrice';
            axios.get(url).then(response => {
             this.itemList = response.data
            });
        },
  /*------------------FORM METHODS-------------------- */
   openModal: function (item){
            this.service = item;


            this.errors = [];
            this.btnSubmitForm = true;
            this.$refs.modal.open()
    },
    sendForm: function() {
           this.errors = [];
           
              //VALIDATIONS
               if (!this.formSubcontId) {
                    this.errors.push('Debe Escoger un Subcontratista.');
               } 
               if (this.formTypeOfAgreement == 'amountPayable') {
                    if(!this.formAmountPayable) 
                    this.errors.push('Debe Ingresar un Monto.');
               }
               if (this.formTypeOfAgreement == 'percentage') {
                    if(!this.formPercent) 
                    this.errors.push('Debe Ingresar un Porcentaje.');
               }
      
       if (!this.errors.length) { 
            // this.btnSubmitForm = false;
           if(this.formTypeOfAgreement == 'percentage'){
               this.formAmountPayable = this.sumTotal;
           }
            axios.post('../../subcontractors/add/invDetail',{
                subcontId :  this.formSubcontId,
                invoiceId: this.service.invoiceId,
                invDetailId: this.service.invDetailId,
                transactionPercentage: this.formPercent,
                transactionAmount : this.formAmountPayable,
            }).then(response => {
                   if (response.data.alertType == "error") {
                       toastr.error(response.data.message)
                         this.btnSubmitForm = true;
                   } else {
                       toastr.success(response.data.message)
                         this.service = '';
                         this.errors = [];

                         // this.formSubcontId = '';
                         this.formTypeOfAgreement = 'amountPayable';
                         this.formAmountPayable = '';
                         this.formPercent = '';
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