
<template> 

 <div class="panel panel-success col-xs-12">
    <div class="panel-body">
      <h4><b>SUBCONTRATISTA:</b></h4>
     <div class="table-responsive">
            <table class="table table-striped table-bordered text-center ">
            <thead>
                <tr class="bg-success">
                 <th>DNI</th>
                 <th>NOMBRE</th>
                 <th>TIPO</th>
                 <th>DIRECCION</th>
                 <th>TELEFONO</th>
                 <th>EMAIL</th>
                </tr>
            </thead>
          <tbody>
                <tr v-for="(subcont,index) in subcontractor">
                    <td>{{subcont.subcontDNI}} </td>
                    <td>{{subcont.subcontName}} </td>
                    <td>{{subcont.subcontType}} </td>
                    <td>{{subcont.subcontAddress}} </td>
                    <td>{{subcont.subcontPhone}} </td>
                    <td>{{subcont.subcontEmail}} </td>
                </tr>
        </tbody>
      </table>
     </div>

<h4><b>CUENTAS POR PAGAR:</b></h4>

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
                <th>DIRECCION</th>
                <th>FACTURA</th>
                <th>MONTO DEUDA</th>  
                <th>SALDO</th>
            </tr>
            </thead>
          <tbody>   
         <tr v-for="(payable,index) in payables">
            <!-- <td v-if="!showMultiples">{{++index}}</td> -->
            <td >
           <label :for="payable.payableId">
              <input type="checkbox" :id="payable.payableId" :value="payable" v-model="checked" number>
              {{++index}}
          </label>
            </td>
            <td>
                {{payable.subcont_inv_detail.invoice_detail.invoice.contract.propertyNumber}} 
                {{payable.subcont_inv_detail.invoice_detail.invoice.contract.streetName}} 
                {{payable.subcont_inv_detail.invoice_detail.invoice.contract.streetType}} 
                {{payable.subcont_inv_detail.invoice_detail.invoice.contract.suiteNumber}} 
                {{payable.subcont_inv_detail.invoice_detail.invoice.contract.city}} 
                {{payable.subcont_inv_detail.invoice_detail.invoice.contract.state}} 
                {{payable.subcont_inv_detail.invoice_detail.invoice.contract.zipCode}}
            </td>
            <td>{{payable.subcont_inv_detail.invoice_detail.invoice.invId}}</td>
            <td>{{payable.amountDue}}</td>
            <td>{{payable.balance}}</td> 
            <!-- <td>{{payable.payableId}}</td> -->
            <td v-for="(user) in payable.user"> {{user.fullName}}</td> 
  
         </tr>
         </tbody>
        </table>
       </div>

<!-- MODALS -->
  <sweet-modal ref="modalPaymentForm">
        <h2><b>Cuentas por Pagar Seleccionadas:</b></h2> <br>
    <table class="table table-striped table-bordered text-center">
          <tbody>   
         <tr v-for="(payable,index) in checked">
            <td>
             {{++index}}) {{payable.balance}}
            </td>
            <td>
                {{payable.subcont_inv_detail.invoice_detail.invoice.contract.propertyNumber}} 
                {{payable.subcont_inv_detail.invoice_detail.invoice.contract.streetName}} 
                {{payable.subcont_inv_detail.invoice_detail.invoice.contract.streetType}} 
                {{payable.subcont_inv_detail.invoice_detail.invoice.contract.suiteNumber}} 
                {{payable.subcont_inv_detail.invoice_detail.invoice.contract.city}} 
                {{payable.subcont_inv_detail.invoice_detail.invoice.contract.state}} 
                {{payable.subcont_inv_detail.invoice_detail.invoice.contract.zipCode}}
            </td>
            <td>
              <div class="form-group">
                <label for="inputEmail3" class=" control-label">Monto:</label>
                <div class="">
                   <input type="email" class="form-control" id="inputEmail3">
                </div>
              </div>
            </td>
         </tr>
         </tbody>
        </table>
        <button class="btn btn-primary" >Procesar</button>
  </sweet-modal>


   </div>
  </div>


 </template>
 <script>

    export default {
        
     mounted() {
            console.log('Component Sub mounted.')
            this.getPayables();
           },
     data: function () {
          return {
             subcontractor: '',
             checked: [],
             payables:{}
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
    }
  },
    methods: {
       getPayables: function () {
            //datos del subcontratista
          axios.get(this.prefUrl+'subcontractors/'+this.subcontractorId).then(response => {
                  this.subcontractor = response.data
                 // console.log(this.subcontractor);
            });
          //llamar las cuentas que se le deben pagar a este subcontratista
          axios.get(this.prefUrl+'subcontractors/'+this.subcontractorId+'/getPayables').then(response => {
                  this.payables = response.data
                 // console.log(this.payables);
            });
        },
      modalPaymentForm: function () {
        this.$refs.modalPaymentForm.open();
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