
<template> 

 <div class="panel panel-success col-xs-10 col-xs-offset-1 col-lg-8 col-lg-offset-2">
    <div class="panel-body">
<h4><b>Propuesta N°:</b> {{proposal[0].propId}}</h4>
<h4><b>Fecha:</b> {{proposal[0].proposalDate | moment("MM/DD/YYYY") }}</h4>
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
             <a @click="sendDelete(item.propDetailId)" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Eliminar">
                            <span class="fa fa-times-circle" aria-hidden="true"></span> 
            </a>

           </td> 
         </tr>
         </tbody>
        </table>
       </div>
       <div class="col-xs-12 text-center">
            <b>Sub-Total:</b> {{proposal[0].grossTotal}} <br>
            <b>Impuesto {{proposal[0].taxPercent}}%:</b> {{proposal[0].taxAmount}} <br>
            <b>Total Neto:</b> {{proposal[0].netTotal}}<br>
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
        <p>{{proposalDetail.serviceName}}</p>
        <button class="btn btn-danger" @click="sendDelete(proposalDetail.propDetailId)">Eliminar</button>
      </sweet-modal>
 -->
  <hr>
<proposal-notes :proposal-id="proposal[0].proposalId"></proposal-notes>


   </div>
       <div class="text-center"> 
           <a :href="'proposals?id='+proposal[0].precontractId" class="btn btn-warning btn-sm">
                  <span class="fa fa-hand-point-left" aria-hidden="true"></span>  Regresar
          </a>

       </div>
       <br>
  </div>


 </template>
 <script>

import proposalNotes from './ProposalNotes.vue'
// import vueUpload from './vueUpload.vue'

export default {
        
     mounted() {
            console.log('Component mounted.')
            this.findProposal();
            this.getAllProposalDetails();
            this.getAllServices();
        },
    data: function() {
        return {
            errors: [],

            proposal: '',
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
            //proposalDetail: '',
        }
    },
  props: {
           proposalId: { type: Number},
    },
  computed: {
      sumTotal: function () {
          let sum = this.modelQuantity * this.modelUnitCost;
          return  Number.parseFloat(sum).toFixed(2);
            
       } 
    },
   components: {
         proposalNotes
  },
    methods: {
        findProposal: function (){
            let url ='proposals/'+this.proposalId;
            axios.get(url).then(response => {
             this.proposal = response.data
            });
        },
         getAllServices: function (){
            let url ='services';
            axios.get(url).then(response => {
             this.services = response.data
            });
        },
         getAllProposalDetails: function (){
            let url ='proposalsDetails/'+this.proposalId;
            axios.get(url).then(response => {
             this.list = response.data
            });
        },
          selectService: function (id){
            let url ='services/'+id;
            axios.get(url).then(response => {
              this.selectedService =response.data[0];
              console.log(this.selectedService);
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

              let itemNumber = this.list.length + 1;

          if (!this.errors.length) { 

            axios.post('proposalsDetails',{
              proposalId :  this.proposal[0].proposalId,
              itemNumber:   itemNumber,
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
                       this.getAllProposalDetails();
                       this.findProposal();

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
          // deleteProposalDetail: function(item) {
          //    this.$refs.modalDelete.open()
          //    this.proposalDetail= item
          // },
          sendDelete: function(id) {
             let url ='proposalsDetails/'+id;
             axios.delete(url).then(response => {
               // this.$refs.modalDelete.close()
               this.getAllProposalDetails();
               this.findProposal();
               if (response.data.alertType == 'success') {
                         toastr.info(response.data.message)
                       } else {
                          toastr.error(response.data.message)
                       }    
            });
          },
         closeProposal: function(proposal) {
             // this.$refs.modalClose.open()
             // this.proposalDetail= proposal
             if(proposal.netTotal == 0){
                toastr.error('Error: Total Neto debe ser Mayor a 0.00')
             }else{
               let url ='proposalsClose';
                axios.put(url,{proposalId: proposal.proposalId}).then(response => {
                   if (response.data.alertType == 'success') {
                         window.location.href ="proposals?id="+proposal.contractId;
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