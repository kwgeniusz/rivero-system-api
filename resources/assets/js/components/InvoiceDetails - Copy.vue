
<template> 

 <div class="panel panel-success col-xs-10 col-xs-offset-1 col-lg-8 col-lg-offset-2">
    <div class="panel-body">
<h4><b>Factura N°:</b> {{invoice[0].invId}}</h4>
<h4><b>Fecha:</b> {{invoice[0].invoiceDate | moment("MM/DD/YYYY") }}</h4>
<hr>
    <form class="form">
                 
       <div class="alert alert-danger" v-if="errors.length">
            <h4>Errores:</h4>
                  <div v-for="error in errors">- {{ error }}</div>
         </div>

          <div class="form-group col-xs-12">
            <label for="serviceId">SERVICIO</label>
            <select v-model="modelServiceId" @change="selectService(modelServiceId)" class="form-control" name="serviceId" id="serviceId">
                <option :class="{ bold: item.hasCost == 'Y' ? true : false }" v-for="(item,index) in services" :value="item.serviceId" > {{item.serviceName}}
                 </option>
                  }
            </select>
          </div>

         <div class="form-group col-xs-10">
            <label for="quantity">NOMBRE DEL SERVICIO</label>
            <input v-model="modelServiceName" type="text" class="form-control" id="serviceName" name="serviceName"  autocomplete="off">
          </div>
 
        <div v-if="hasCost" class="form-group col-xs-4">
            <label for="unit">UNIDAD</label>
            <select v-model="modelUnit" @change="changeUnit(modelUnit)"  class="form-control" name="unit" id="unit">
                <option value="sqft" >sqft</option>
                <option value="ea" >ea</option>

            </select>
          </div>


           <div v-if="hasCost" class="form-group col-xs-4">
                <label for="unitCost">PRECIO</label>
                <input v-model="modelUnitCost" type="number" class="form-control" id="unitCost" name="unitCost" autocomplete="off">
          </div>

          <div v-if="hasCost" class="form-group col-xs-4">
            <label for="quantity">CANTIDAD</label>
            <input v-model="modelQuantity" type="number" class="form-control" id="quantity" name="quantity"  autocomplete="off">
          </div>

         <div v-if="hasCost" class="form-group col-xs-4 col-xs-offset-4">
                <label fo> COSTO TOTAL:   {{sumTotal}}</label>
          </div>
       <div class="form-group col-xs-12 text-center">
         <button class="btn btn-success" @click.prevent="aggRow()"> 
          <span class="fa fa-plus" aria-hidden="true"></span> Agregar Renglon
        </button>
       </div>
    </form>

      <br>
      <div class="table-responsive col-xs-12">
          <table class="table table-striped table-bordered text-center bg-info">
            <thead> 
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
         <tr v-for="(item,index) in list">
            <td>{{++index}}</td>
            <td>{{item.serviceName}}</td>
            <td>{{item.unit}}</td>
            <td>{{item.unitCost}}</td>
            <td>{{item.quantity}}</td>
            <td>{{item.amount}}</td>
            <td>  
             <!-- <a :href="'../download/'+item.docId" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Descargar">
                     <span class="fa fa-file" aria-hidden="true"></span> 
            </a> -->
          <!--    <a @click="editFile(item)" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Editar">
                        <span class="fa fa-edit" aria-hidden="true"></span> 
            </a> -->
             <a @click="sendDelete(item.invDetailId)" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Eliminar">
                            <span class="fa fa-times-circle" aria-hidden="true"></span> 
            </a>
           </td> 
         </tr>
         </tbody>
        </table>
       </div>
       <div class="col-xs-12 text-center">
            <b>Sub-Total:</b> {{invoice[0].grossTotal}} <br>
            <b>Impuesto {{invoice[0].taxPercent}}%:</b> {{invoice[0].taxAmount}} <br>
            <b>Total Neto:</b> {{invoice[0].netTotal}}<br>
       </div>


<!--      <sweet-modal ref="modalEdit">
        <h2>Editar:</h2> <br>
            <div class="form-group ">
                <label for="input">Nombre:</label>
                <input type="text" class="form-control" v-model="doc.docName"><br>
              </div>
        <button class="btn btn-primary" >Actualizar</button>
      </sweet-modal>
     <sweet-modal icon="error" overlay-theme="dark" modal-theme="dark" ref="modalDelete">
        <h2>¿Esta seguro de eliminar este Renglon?</h2> <br>
        <p>{{invoiceDetail.serviceName}}</p>
        <button class="btn btn-danger" @click="sendDelete(invoiceDetail.invDetailId)">Eliminar</button>
      </sweet-modal>
 -->

  <hr>
<invoice-notes :invoice-id="invoice[0].invoiceId"></invoice-notes>


   </div>
       <div class="text-center"> 
           <a :href="'invoices?id='+invoice[0].contractId" class="btn btn-warning btn-sm">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  Regresar
          </a>
          <!-- <a @click="closeInvoice(invoice[0])" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top">
                <span class="fa fa-circle" aria-hidden="true"></span> Cerrar Factura
          </a> -->
          <a :href="'reportsInvoice?id='+invoice[0].invoiceId" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Imprimir">
                     <span class="fa fa-file-pdf" aria-hidden="true"></span> Previzualizar Factura
                    </a>
       </div>
       <br>
  </div>


 </template>
 <script>

import InvoiceNotes from './InvoiceNotes.vue'
// import vueUpload from './vueUpload.vue'

export default {
        
     mounted() {
            console.log('Component mounted.')
            this.findInvoice();
            this.getAllInvoicesDetails();
            this.getAllServices();
        },
    data: function() {
        return {
            errors: [],

            invoice: '',
            services: {},
            selectedService: {},

            list: {},
            
            hasCost: false,
            modelServiceId: '',
            modelServiceName: '',
            modelQuantity: '',
            modelUnit: '',
            modelUnitCost: '',
            
            //para delete
            invoiceDetail: '',
        }
    },
  props: {
           invoiceId: { type: String},
    },
  computed: {
      sumTotal: function () {
          let sum = this.modelQuantity * this.modelUnitCost;
          return  Number.parseFloat(sum).toFixed(2);
            
       } 
    },
   components: {
         InvoiceNotes
  },
    methods: {
        findInvoice: function (){
            let url ='invoices/'+this.invoiceId;
            axios.get(url).then(response => {
             this.invoice = response.data
            });
        },
         getAllServices: function (){
            let url ='services';
            axios.get(url).then(response => {
             this.services = response.data
            });
        },
         getAllInvoicesDetails: function (){
            let url ='invoicesDetails/'+this.invoiceId;
            axios.get(url).then(response => {
             this.list = response.data
            });
        },
          selectService: function (id){
            let url ='services/'+id;
            axios.get(url).then(response => {
              this.selectedService =response.data[0];

              if(response.data[0].hasCost == 'N'){
                 this.hasCost = false //oculta los input que tienen esta variable
                 this.modelQuantity =''
                 this.modelUnit =''
                 this.modelUnitCost =''
              }else{
                 this.hasCost = true
                 this.modelQuantity= 1.00
                 this.modelUnit = response.data[0].unit1;
                 this.modelUnitCost = response.data[0].cost1;
              }
             this.modelServiceName = response.data[0].serviceName;
            });
        },
       changeUnit: function(unit) {
             if(unit == 'sqft'){
               this.modelUnitCost = this.selectedService.cost1;
             }else {
               this.modelUnitCost = this.selectedService.cost2;
             }
            
          },
  /*----CRUD----- */
        aggRow: function() {
           this.errors = [];
           //VALIDATIONS
               if (!this.modelServiceId) 
                this.errors.push('Debe Escoger un Servicio.');
           
               if (!this.modelServiceName) 
                this.errors.push('Campo Nombre de Servicio es Obligatorio.');
  
                if(this.hasCost == true){
                     if (!this.modelUnitCost) 
                      this.errors.push('El Costo de la Unidad es Requerida.');
                      if (!this.modelQuantity) 
                      this.errors.push('La Cantidad de este Articulo es Requerida.');
                }
          if (!this.errors.length) { 

            axios.post('invoicesDetails',{
              invoiceId :  this.invoice[0].invoiceId,
              serviceId :  this.modelServiceId,
              serviceName: this.modelServiceName,
              quantity :   this.modelQuantity,
              unit :       this.modelUnit,
              unitCost :   this.modelUnitCost,
              amount :     this.sumTotal,

            }).then(response => {
                   // if (response.data.alert == "error") {
                   //     toastr.error(response.data.msj)
                   // } else {
                       this.getAllInvoicesDetails();
                       this.findInvoice();

                       this.modelServiceId = ''
                       this.modelServiceName = ''
                       this.modelQuantity =''
                       this.modelUnit =''
                       this.modelUnitCost =''
                       this.hasCost = false //oculta los input que tienen esta variable
                       if (response.data.alertType == 'success') {
                         toastr.success(response.data.message)
                       } else {
                          toastr.error(response.data.message)
                       }
                   // }
  
            })
           }
         },

          // deleteInvoiceDetail: function(item) {
          //    this.$refs.modalDelete.open()
          //    this.invoiceDetail= item
          // },
          sendDelete: function(id) {
             let url ='invoicesDetails/'+id;
             axios.delete(url).then(response => {
               // this.$refs.modalDelete.close()
               this.getAllInvoicesDetails();
               this.findInvoice();
               if (response.data.alertType == 'success') {
                         toastr.success(response.data.message)
                       } else {
                          toastr.error(response.data.message)
                       }    
            });
          },
         closeInvoice: function(invoice) {
             // this.$refs.modalClose.open()
             // this.invoiceDetail= invoice
             if(invoice.netTotal == 0){
                toastr.error('Error: Total Neto debe ser Mayor a 0.00')
             }else{
               let url ='invoicesClose';
                axios.put(url,{invoiceId: invoice.invoiceId}).then(response => {
                   if (response.data.alertType == 'success') {
                         window.location.href ="invoicesPayments/"+invoice.invoiceId;
                         toastr.success(response.data.message)
                       } else {
                          toastr.error(response.data.message)
                       }    
                    });

             }

          },
    }
       // this.$forceUpdate()
}
 </script>
  
<style>
.bold {
    font-weight:bold;
    background:#D7F7E2;
}
</style>