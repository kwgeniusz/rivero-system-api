
<template> 

 <div class="panel panel-success col-xs-10 col-xs-offset-1 col-lg-8 col-lg-offset-2">
    <div class="panel-body">

<h3><b>Factura N° {{invoice[0].invoiceNumber}}</b></h3>
    <form class="form">
        
          <div class="form-group col-xs-12">
            <label for="serviceId">SERVICIO</label>
            <select v-model="modelService" @change="findService(modelService)" class="form-control" name="serviceId" id="serviceId">
                      <option v-for="(item,index) in services" :value="item.serviceId" > {{item.serviceName}} - Tiene Costo: {{item.hasCost}} </option>
            </select>
          </div>


          <div v-if="hasCost" class="form-group col-xs-5">
            <label for="quantity">CANTIDAD</label>
            <input v-model="modelQuantity" type="number" class="form-control" id="quantity" name="quantity"  autocomplete="off">
          </div>

 
        <div v-if="hasCost" class="form-group col-xs-7">
            <label for="unit">UNIDAD</label>
            <select v-model="modelUnit" @change="changeUnit(modelUnit)"  class="form-control" name="unit" id="unit">
                <option value="sqft" >sqft</option>
                <option value="each" >each</option>

            </select>
          </div>

           <div v-if="hasCost" class="form-group col-xs-4">
                <label for="unitCost">PRECIO</label>
                <input v-model="modelUnitCost" type="number" class="form-control" id="unitCost" name="unitCost" autocomplete="off">
          </div>

         COSTO TOTAL:   {{sumTotal}}
       <div class="form-group col-xs-12">
         <button class="btn btn-success" @click="aggRow()"> Agregar Renglon</button>
       </div>
    </form>
<!--    {{modelService}}
   {{modelQuantity}}
   {{modelUnit}}
   {{modelUnitCost}}
   {{hasCost}}
   {{sumTotal}} -->

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
             <a @click="deleteFile(item)" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Eliminar">
                            <span class="fa fa-times-circle" aria-hidden="true"></span> 
            </a>
           </td> 
         </tr>
         </tbody>
        </table>
       </div>

   <!--   <sweet-modal ref="modalEdit">
        <h2>Editar:</h2> <br>
            <div class="form-group ">
                <label for="input">Nombre:</label>
                <input type="text" class="form-control" v-model="doc.docName"><br>
              </div>
        <button class="btn btn-primary" >Actualizar</button>
      </sweet-modal>

     <sweet-modal icon="error" overlay-theme="dark" modal-theme="dark" ref="modalDelete">
        <h2>¿Esta seguro de eliminar este archivo?</h2> <br>
        <p>{{doc.docName}}</p>
        <button class="btn btn-danger" @click="sendDelete(doc.docId)">Eliminar</button>
      </sweet-modal> -->


   </div>
 </div>

 </template>

 <script>

// import modalPreviewDocument from './ModalPreviewDocument.vue'
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
            invoice: '',
            services: {},
            list: {},
            
            hasCost: true,
            modelService: '',
            modelQuantity: 1.00,
            modelUnit: '',
            modelUnitCost: 0.00,

        }
    },
  props: {
           invoiceId: { type: String},
    },
    computed: {
      sumTotal: function () {
          return this.modelQuantity * this.modelUnitCost
       } 
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
          findService: function (id){
            let url ='services/'+id;
            axios.get(url).then(response => {
              console.log(response.data[0]);
              if(response.data[0].hasCost == 'N'){
                 this.hasCost = false
                 this.modelQuantity =''
                 this.modelUnit =''
                 this.modelUnitCost =''

              }else{
                 this.hasCost = true
                 this.modelQuantity= 1.00
              }
             this.modelUnit = response.data[0].unit1;
             this.modelUnitCost = response.data[0].cost1;
            });
        },
       changeUnit: function(unit) {
             if(unit == 'sqft'){
               this.modelUnitCost = this.services[0].cost1;
             }else {
               this.modelUnitCost = this.services[0].cost2;
             }
            
          },
          /*----CRUD----- */
          create: function(item) {
             this.$refs.modalEdit.open()
             this.doc = item
          },
          delete: function(item) {
             this.$refs.modalDelete.open()
             this.doc= item
          },
          sendDelete: function(docId) {
             let url ='../fileDelete/'+docId;
             axios.get(url).then(response => {
               this.$refs.modalDelete.close()
               this.allFiles();
               toastr.success('Archivo Eliminado') 
            });
          },
    }
       // this.$forceUpdate()
}
 </script>
  
