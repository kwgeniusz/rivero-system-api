
<template> 

 <div class="panel panel-success col-xs-10 col-xs-offset-1">
    <div class="panel-body">
<h4><b>Factura N°:</b> {{invoice[0].invId}}</h4>
<h4><b>Fecha:</b> {{invoice[0].invoiceDate | moment("MM/DD/YYYY") }}</h4>
<!-- <h4><b>Cuentas por Pagar: </b> {{subcontractorCounter}}</h4> -->
            <a :href="'reportsInvoice?id='+invoice[0].invoiceId" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Imprimir">
                     <span class="fa fa-file-pdf" aria-hidden="true"></span> Previzualizar Factura
                    </a>
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

<!-- 
         <div class="form-group col-xs-10">
            <label for="quantity">NOMBRE DEL SERVICIO</label>
            <input v-model="modelServiceName" type="text" class="form-control" id="serviceName" name="serviceName"  autocomplete="off">
          </div> -->
 
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

     <div class="row">
       <div class="text-right col-xs-6">
         <button class="btn btn-primary" @click.prevent="addRow()"> 
          <span class="fa fa-plus" aria-hidden="true"></span> Agregar Renglon
        </button>
       </div>
      <div class="col-xs-6"> 
        <form-new-service pref-url='' @servicecreated='getAllServices()'></form-new-service>
       </div>
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
                <th>COMPROMISOS</th>
                <th>ACCION</th>
                <!-- <th></th> -->
            </tr>
            </thead>
          <tbody>   
       <tr v-for="(item,index) in itemList">
            <td>{{++index}}</td>
            <td>{{item.serviceName}}</td>
            <td>{{item.unit}}</td>
            <td>{{item.unitCost}}</td>
            <td>{{item.quantity}}</td>
            <td>{{item.amount}}</td>
            <td>{{item.subcontractor_inv_detail.length}} SB</td>
            <td> 
             <a @click="deleteRow(index)" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Eliminar">
                            <span class="fa fa-times-circle" aria-hidden="true"></span> 
            </a>
           <button class="btn btn-info btn-sm" @click.prevent="moveUp(index)"> 
              <span class="fa fa-angle-double-up" aria-hidden="true"></span>
             </button>
            <button class="btn btn-info btn-sm" @click.prevent="moveDown(index)">
              <span class="fa fa-angle-double-down" aria-hidden="true"></span>
             </button>
           </td> 
         </tr>
         </tbody>
        </table>
       </div>
       <div class="col-xs-12 text-center">
<!--             <b>Sub-Total:</b> {{invoice[0].grossTotal}} <br>
            <b>Impuesto {{invoice[0].taxPercent}}%:</b> {{invoice[0].taxAmount}} <br>
            <b>Total Neto:</b> {{invoice[0].netTotal}}<br> -->

            {{invoiceNetTotal}}

       </div>

  <hr>
<invoice-notes :invoice-id="invoice[0].invoiceId" ref="invoiceNotes"></invoice-notes>
<hr>
<invoice-scopes :invoice-id="invoice[0].invoiceId" ref="invoiceScopes"></invoice-scopes>

   </div>
       <div class="text-center"> 
        <!--    <a :href="'invoices?id='+invoice[0].contractId" class="btn btn-warning btn-sm">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  Regresar
          </a> -->
          <a @click.prevent="saveInvoice()" class="btn btn-info btn-sm">
            <span class="fa fa-save" aria-hidden="true"></span>  Guardar Factura
          </a>
           <a @click.prevent="itemList = []"  class="btn btn-danger btn-sm">
            <span class="fa fa-recycle" aria-hidden="true"></span>  Vaciar
          </a>   
              </div>
       <br>

<!-- MODALES -->

  </div>
 </template>
 <script>

import InvoiceNotes from './InvoiceNotes.vue'
import InvoiceScopes from './InvoiceScopes.vue'

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

            itemList: {},
          
            
            hasCost: false,
            modelServiceId: '',
            // modelServiceName: '',
            modelQuantity: '',
            modelUnit: '',
            modelUnitCost: '',

        }
    },
  props: {
           invoiceId: { type: String},
    },
  computed: {
      sumTotal: function () {
          let sum = this.modelQuantity * this.modelUnitCost;
          return  Number.parseFloat(sum).toFixed(2);
            
       },
      invoiceNetTotal: function () {
          let suma = 0;

         this.itemList.forEach (function(item){
             if(item.amount == null){item.amount=0.00}
            suma += parseFloat(item.amount);
            suma.toFixed(2);
          });
          // console.log(suma);

              let taxAmount   = (parseFloat(suma).toFixed(2) * parseFloat(this.invoice[0].taxPercent).toFixed(2))/100;
              // taxAmount.toFixed(2);
          // console.log(taxAmount);

              let netTotal    = parseFloat(taxAmount) + parseFloat(suma);
              // netTotal.toFixed(2);
          // console.log(netTotal);
               return (
                `Sub Total: ${suma} /
               Impuesto:${this.invoice[0].taxPercent}% = ${taxAmount} /
               Total Neto: ${netTotal}
               ` )
       }  
    },
   components: {
         InvoiceNotes,
         InvoiceScopes
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
             this.itemList = response.data
            });
        },
          selectService: function (id){
          let serviceId = id;

          function filtrarPorID(obj) {
           if ('serviceId' in obj && obj.serviceId == serviceId) {
            return true;
          } else {
            return false;
          }
        }
        this.selectedService = this.services.filter(filtrarPorID);
              console.log(this.selectedService);
              if(this.selectedService[0].hasCost == 'N'){
                 this.hasCost = false //oculta los input que tienen esta variable
                 this.modelQuantity =''
                 this.modelUnit =''
                 this.modelUnitCost =''
              }else{
                 this.hasCost = true
                 this.modelQuantity= 1.00
                 this.modelUnit = this.selectedService[0].unit1;
                 this.modelUnitCost = this.selectedService[0].cost1;
              }

        },
       changeUnit: function(unit) {
             if(unit == 'sqft'){
               this.modelUnitCost = this.selectedService[0].cost1;
             }else {
               this.modelUnitCost = this.selectedService[0].cost2;
             }
            
          },
  /*----CRUD----- */
        addRow: function() {
           this.errors = [];
           //VALIDATIONS
               if (!this.modelServiceId) 
                this.errors.push('Debe Escoger un Servicio.');
  
          if (!this.errors.length) { 
          //BUSCAR EN ARREGLO DE JAVASCRIPT /SERVICE/ EL ID QUE SELECCIONO EL USUARIO PARA TRAER EL NOMBRE DEL SERVICIO
        let serviceId = this.modelServiceId;
    
        function filtrarPorID(obj) {
          if ('serviceId' in obj && obj.serviceId == serviceId) {
            return true;
          } else {
            return false;
          }
        }

        // alert(this.modelUnitCost);
        let service = this.services.filter(filtrarPorID);
            //AGREGAR A ITEMLIST
              //Nota al agregar el item debo meter un objeto con el nombre y el ID
                 this.itemList.push({
                                     serviceId:service[0].serviceId,
                                     serviceName:service[0].serviceName,
                                     quantity:this.modelQuantity,
                                     unit:this.modelUnit,
                                     unitCost:this.modelUnitCost,
                                     amount:this.sumTotal,
                                   });
           }
         },
       deleteRow: function(id) {
            //borrar valor que encuentre del arreglo
                 this.itemList.splice(--id,1);
          },
         moveUp: function(rowIndex) {
             --rowIndex;
             this.itemList.splice(rowIndex - 1, 0, this.itemList.splice(rowIndex, 1)[0]);
           },
         moveDown: function(rowIndex) {
             --rowIndex;
             this.itemList.splice(rowIndex + 1, 0, this.itemList.splice(rowIndex, 1)[0]);
           },

         saveInvoice: function() {
           this.errors = [];
           //VALIDATIONS

            //verificando si existe una relacion con subcontractista para lanzar alerta
                // let acum = 0;
                //   this.itemList.forEach(function (item) {
                //       acum += Object.keys(item.subcontractor_inv_detail).length;
                //    });

                // if(acum > 0){
                //   this.$refs.modalConfirm.open();
                //   return;
                // }

               if (!this.itemList) 
                this.errors.push('Debe Escoger Ingresar servicio para Guardar la Factura.');

          if (!this.errors.length) { 
        //ejecuta la funciona que esta en el componente hijo Proposal Notes
          this.$refs.invoiceNotes.sendNotes();
          this.$refs.invoiceScopes.sendScopes();

          axios.post('invoicesDetails',{
              invoiceId :  this.invoice[0].invoiceId,
              itemList:   this.itemList,
         
            }).then(response => {
                   // if (response.data.alert == "error") {
                   //     toastr.error(response.data.msj)
                   // } else {
                       this.getAllInvoicesDetails();
                       this.findInvoice();

                       this.modelServiceId = ''
                       // this.modelServiceName = ''
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
    }//fin de method
       // this.$forceUpdate()
}
 </script>
  
<style>
.bold {
    font-weight:bold;
    background:#D7F7E2;
}
</style>