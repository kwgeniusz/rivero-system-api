<template> 
  <div class="create">
    <div class="formulario">
      <div class="boxes">
        <div class="inputother boxes2">
          <h4><b>Factura N°:</b> {{invoice[0].invId}}</h4>
          <h4><b>Fecha:</b> {{invoice[0].invoiceDate | moment("MM/DD/YYYY") }}</h4>
          <h4><b>Compromisos:</b> {{commitments()}}</h4>
          <!-- <h4><b>Cuentas por Pagar: </b> {{subcontractorCounter}}</h4> -->
          <a :href="'reportsInvoice?id='+invoice[0].invoiceId" class="submit" style="text-align: center;" data-toggle="tooltip" data-placement="top" title="Imprimir">
            <span class="fa fa-file-pdf" aria-hidden="true"></span> Previzualizar Factura
          </a>
        </div>
        <!-- <div$invoice->netTotal > 0 </div>  -->
        <!-- @can('BEE') -->
          <!--<a href="{{route('invoices.payments', ['btnReturn'=> 'mod_cont','id' => $invoice->invoiceId])}}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Cuotas">
            <span class="fa fa-dollar-sign" aria-hidden="true"></span> 
          </a>-->
        <!-- @endcan -->
        <form class="input-label" style="margin-bottom: 30px; display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap;">
          <div class="alert alert-danger" v-if="errors.length">
            <h4>Errores:</h4>
            <div v-for="error in errors">- {{ error }}</div>
          </div>
          <div class="input-label boxes2" style="margin-bottom: 30px;">
            <label for="serviceId">SERVICIO</label>
            <select v-model="modelServiceId" @change="selectService(modelServiceId)" name="serviceId" id="serviceId">
              <option :class="{ bold: item.hasCost == 'Y' ? true : false }" v-for="(item,index) in services" :value="item.serviceId" > {{item.serviceName}}
              </option>
              }
            </select>
          </div>
          <!--<div class="form-group col-xs-10">
            <label for="quantity">NOMBRE DEL SERVICIO</label>
            <input v-model="modelServiceName" type="text" class="form-control" id="serviceName" name="serviceName"  autocomplete="off">
          </div> -->
          <div v-if="hasCost" class="inputother boxes2">
            <label for="unit">UNIDAD</label>
            <select v-model="modelUnit" @change="changeUnit(modelUnit)" name="unit" id="unit">
              <option value="sqft" >sqft</option>
              <option value="ea" >ea</option>
            </select>
          </div>
          <div v-if="hasCost" class="inputother boxes2">
            <label for="unitCost">PRECIO</label>
            <input v-model="modelUnitCost" type="number" class="input-label" id="unitCost" name="unitCost" autocomplete="off">
          </div>
          <div v-if="hasCost" class="inputother boxes2">
            <label for="quantity">CANTIDAD</label>
            <input v-model="modelQuantity" type="number" class="input-label" id="quantity" name="quantity"  autocomplete="off">
          </div>
          <div v-if="hasCost" class="inputother boxes2">
            <label fo> COSTO TOTAL:   {{sumTotal}}</label>
          </div>
          <div style="width: 100%; display: flex; justify-content: center; align-items: flex-start;">
            <button class="submit" style="margin-right: 20px;" @click.prevent="addRow()"> 
              <span class="fa fa-plus" aria-hidden="true"></span> Agregar Renglon
            </button>
            <form-new-service pref-url='' @servicecreated='getAllServices()'></form-new-service>
          </div>
        </form> 
        <br>
        <div class="table-responsive tableother">
          <table class="table table-striped table-bordered text-center bg-info">
            <thead> 
              <tr>  
                <th>#</th>
                <th>SERVICIO</th>  
                <th>UNIDAD</th>
                <th>COSTO</th>
                <th>CANTIDAD</th>
                <th>MONTO</th>
                <!-- <th>COMPROMISOS</th> -->
                <th>ACCION</th>
                <!-- <th></th> -->
              </tr>
            </thead>
            <tbody>   
              <tr v-for="(item,index) in itemList">
                <td>{{++index}}</td>
                <td>{{item.serviceName}}</td>
                <td>
                  <select v-if="editMode === index" class="form-control" v-model="item.unit">
                    <option value="sqft">sqft</option>
                    <option value="ea">ea</option>
                  </select>
                  <p v-else>{{item.unit}}</p> 
                </td>
                <td>
                  <input v-if="editMode === index" type="number" step=".00" class="form-control" v-model="item.unitCost" @keyup="calculateItemAmount(index,item)">
                  <p v-else>{{item.unitCost}}</p> 
                </td>
                <td>
                  <input v-if="editMode === index" type="number" step=".00" class="form-control" v-model="item.quantity" @keyup="calculateItemAmount(index,item)">
                  <p v-else>{{item.quantity}}</p> 
                </td>
                <td> {{item.amount}}</td>
                <!-- <td>{{item.subcontractor_inv_detail.length}} SB</td> -->
                <td> 
                  <a v-if="editMode != index && item.unit != null" @click="editRow(index)" class="btn btn-sm btn-primary" title="Editar" > 
                    <i class="fa fa-edit"></i>
                  </a>   
                  <a v-if="editMode === index" @click="updateRow()" class="btn btn-sm btn-success">
                    <i class="glyphicon glyphicon-ok"></i>
                  </a> 
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
        <div style="text-align: center; width: 100%; margin: auto;">
          <!--<b>Sub-Total:</b> {{invoice[0].grossTotal}} <br>
            <b>Impuesto {{invoice[0].taxPercent}}%:</b> {{invoice[0].taxAmount}} <br>
            <b>Total Neto:</b> {{invoice[0].netTotal}}<br> -->
            {{invoiceNetTotal}}
        </div>
        <hr>
        <invoice-notes :invoice-id="invoice[0].invoiceId" ref="invoiceNotes"></invoice-notes>
        <!-- <hr> -->
        <!-- <invoice-scopes :invoice-id="invoice[0].invoiceId" ref="invoiceScopes"></invoice-scopes> --> 
      </div>
    </div>
    <div class="botonera"> 
      <a @click.prevent="saveInvoice()" class="submit buttonmovil">
        <span class="fa fa-save" aria-hidden="true"></span>  Guardar Factura
      </a>
        <a @click.prevent="itemList = []"  class="submit buttonmovil" style="margin-left: 20px; background: #d60101;">
        <span class="fa fa-recycle" aria-hidden="true"></span>  Vaciar
      </a> 
      <a v-if="invoice.netTotal > 0" :href="'invoicesPayments/'+invoice[0].invoiceId+'?btnReturn=mod_cont'" class="submit buttonmovil" style="margin-left: 20px; background: green;" data-toggle="tooltip" data-placement="top" title="Cuotas">
        <span class="fa fa-dollar-sign" aria-hidden="true"></span> Cuotas
      </a>  
    </div>
    <!-- MODALES -->
  </div>
 </template>
 <script>

import InvoiceNotes from './InvoiceNotes.vue'
// import InvoiceScopes from './InvoiceScopes.vue'

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
            // commitments: 0,
            itemList: [],
          
            
            hasCost: false,
            modelServiceId: '',
            // modelServiceName: '',
            modelQuantity: '',
            modelUnit: '',
            modelUnitCost: '',
           
           editMode: -1,

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

         this.itemList.forEach(function(item){
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
  //        InvoiceScopes
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
          });//end axios
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
                 this.modelUnit = null
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
      commitments: function () {
         let acum=0;
           this.itemList.forEach(function (item) {
            // console.log(item)
                acum += Object.keys(item.subcontractor_inv_detail).length;
            });
           return acum;
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
                                     subcontractor_inv_detail:0,
                                   });
           }
         },
       editRow: function(index){
             this.editMode = index
        },
       updateRow: function(){
              this.editMode = -1
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
      calculateItemAmount: function(index,item) { 
          //regla: si no es un numero ponle cero
           if(item.unitCost == '' || item.unitCost == 0) {
              item.unitCost = 1;
          }
           if(item.quantity == '' || item.quantity == 0) {
              item.quantity = 1;
          }

             let amountRs = item.unitCost * item.quantity;

             let myObj = this.itemList.find(el => el.invDetailId == item.invDetailId);
              myObj.amount = parseFloat(amountRs).toFixed(2);
              console.log(myObj);
        }, 
       saveInvoice: function() {
           this.errors = [];
           //VALIDATIONS
                // if(acum > 0){
                //   this.$refs.modalConfirm.open();
                //   return;
                // }

               if (!this.itemList) 
                this.errors.push('Debe Escoger Ingresar servicio para Guardar la Factura.');

          if (!this.errors.length) { 
        //ejecuta la funciona que esta en el componente hijo Proposal Notes
           this.$refs.invoiceNotes.sendNotes();
          // this.$refs.invoiceScopes.sendScopes();

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
.create {
  position: relative;
  padding: 40px;
  display: flex;
  justify-content: center;
  align-items: flex-start;
  background: #dadada;
  border-radius: 20px;
  flex-wrap: wrap;
  margin: auto;
}

.formulario {
  background: #fff;
  width: 80%;
  padding: 40px;
  border-radius: 20px;
  position: relative;
}
.title {
  font-weight: 400;
  color: rgb(134, 134, 134);
  padding: 20px 0px;
}

.boxes {
  border-top: 2px solid #ccc;
  width: 100%;
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  flex-wrap: wrap;
  padding-top: 10px;
}
.input-label{
  position: relative;
  max-width: 100%;
  min-width: 100%;
  margin-bottom: 0px;
}
.input {
  position: relative;
  max-width: 48%;
  min-width: 48%;
  margin-bottom: 0px;
}
.textarea {
  position: relative;
  max-width: 48%;
  min-width: 48%;
  margin-bottom: 30px;
  display: flex;
  flex-direction: column;
}
.inputother {
  position: relative;
  max-width: 48%;
  min-width: 48%;
  margin-bottom: 30px;
}
.tableother {
  position: relative;
  max-width: 100%;
  min-width: 100%;
  margin-bottom: 10px;
}
input,
select {
  padding: 10px;
  border-radius: 5px;
  width: 100%;
  border: 1px solid #ccc;
  background: rgba(248, 248, 248, 0.815);
}
textarea {
  max-width: 100%;
  min-width: 100%;
  max-height: 100px;
  min-height: 100px;
}
label {
  margin-bottom: 10px;
}

.boxes2 {
  display: flex;
  flex-direction: column;
}

.submit {
  margin-top: 30px;
  font-size: 1em;
  padding: 10px 20px;
  background: #0062be;
  border: none;
  border-radius: 5px;
  color: #fff;
  cursor: pointer;
}
.submit:hover {
  color: #fff;
  text-decoration: none;
}
.return {
  margin-top: 30px;
  font-size: 1em;
  padding: 12px 20px;
  background: #eea508;
  border: none;
  border-radius: 5px;
  color: #fff;
  text-decoration: none;
}
.supr {
  font-size: 1em;
  padding: 5px;
  background: #d60101;
  border: none;
  border-radius: 5px;
  color: #fff;
  cursor: pointer;
}
.edit {
  font-size: 1em;
  padding: 5px;
  background: #0d7ae0;
  border: none;
  border-radius: 5px;
  color: #fff;
  cursor: pointer;
}
.supc {
  font-size: 1em;
  padding: 5px;
  background: #0cdf17;
  border: none;
  border-radius: 5px;
  color: #fff;
  cursor: pointer;
}
.supr:hover {
  color: #fff
}
.edit:hover {
  color: #fff
}
.supc:hover {
  color: #fff
}
.return:hover {
  text-decoration: none;
  color: #ffff;
}
.alert {
  width: 100%;
  margin-top: 19px;
}
.botonera {
  width: 50%;
  display: flex; 
  justify-content: space-between; 
  align-items: flex-start;
}
@media (max-width: 500px) {
  .formulario, .formulario2 {
    width: 95%;
    padding: 10px;
    border-radius: 10px;
    margin-left: 0;
  }
  .buttonmovil {
    padding: 5px 10px;
  }
  .formulario2 {
    margin-top: 20px;
  }
  .create  {
    margin-top: 30px;
    margin-bottom: 30px;
    width: 95%;
    padding: 20px 0;
    border-radius: 10px;
  }

  .input {
    margin-bottom: 15px;
  }
  .textarea{
    max-width: 100%;
    min-width: 100%;
  }
  .inputother {
    max-width: 100%;
  min-width: 100%;
    margin-bottom: 15px;
  }

  input,
  select {
    border-radius: 3px;
  }

  label {
    margin-bottom: 5px;
    font-weight: 300;
    width: 150px;
    white-space: nowrap;
    text-overflow: ellipsis;
    overflow: hidden;
  }
  .botonera {
    width: 95%;
  }
}
</style>