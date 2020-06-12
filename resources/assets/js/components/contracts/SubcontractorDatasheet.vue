
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
 <div class="table-responsive">
          <table class="table table-striped table-bordered text-center">
            <thead> 
            <tr>  
                <th><input v-if="showMultiples" type="checkbox" v-model="checkAll"> # </th>
                <th>CONTRATO</th>
                <th>FACTURA</th>
                <th>MONTO DEUDA</th>  
                <th>MONTO PAGADO</th>
                <th colspan="2" >ACCION</th>
            </tr>
            </thead>
          <tbody>   
         <tr v-for="(payable,index) in payables">
            <!-- <td v-if="!showMultiples">{{++index}}</td> -->
          <!--   <td v-if="showMultiples">
           <label :for="payable.payableId">
              <input type="checkbox" :id="payable.payableId" :value="payable" v-model="checked" number>
              {{++index}}
          </label>
            </td> -->
            <!-- <td>{{payable.subcont_inv_detail.invoice_detail}}</td> -->
            <td></td>
            <td></td>
            <td>{{payable.payableId}}</td>
            <td>{{payable.amountDue}}</td>
            <td>{{payable.amountPaid}}</td> 
            <td v-for="(user) in payable.user"> {{user.fullName}}</td> 
            <td>  
             <a v-if="$can('BDGAC') && typeDoc == 'previous'" :href="'../fileDownload/'+payable.docId" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Descargar">
                     <span class="fa fa-file" aria-hidden="true"></span> 
            </a>
 
             <a v-if="$can('BDGDB') && typeDoc == 'ready'" @click="deleteFile(payable)" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Eliminar">
                            <span class="fa fa-times-circle" aria-hidden="true"></span> 
            </a>
           </td> 
         </tr>
         </tbody>
        </table>
       </div>

   </div>
       <div class="text-center"> 
       <!--    <a @click.prevent="saveInvoice()" class="btn btn-info btn-sm">
            <span class="fa fa-save" aria-hidden="true"></span>  Guardar Factura
          </a>
           <a @click.prevent="itemList = []"  class="btn btn-danger btn-sm">
            <span class="fa fa-recycle" aria-hidden="true"></span>  Vaciar
          </a>    -->
      </div>
       <br>
  </div>


 </template>
 <script>

    export default {
        
     mounted() {
            console.log('Component Sub mounted.')
            this.getPayables();
           },
      props: {
           prefUrl: { type: String},
           subcontractorId: { type: String, default: null}, 
    },
     data: function () {
          return {
           subcontractor: '',
           payables:{}
          }
    },
    methods: {
       getPayables: function () {
            //datos del subcontratista
          axios.get(this.prefUrl+'subcontractors/'+this.subcontractorId).then(response => {
                  this.subcontractor = response.data
                 console.log(this.subcontractor);
            });
          //llamar las cuentas que se le deben pagar a este subcontratista
          axios.get(this.prefUrl+'subcontractors/'+this.subcontractorId+'/getPayables').then(response => {
                  this.payables = response.data
                 console.log(this.payables);
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