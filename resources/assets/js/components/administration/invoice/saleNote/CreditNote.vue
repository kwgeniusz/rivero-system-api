<template>
<div>

<div class="panel panel-default col-xs-12" v-if="invoice != ''">
    <div class="panel-body">
           <div class="row">
             <div class="col-xs-4">
                <p><b>FACTURA #</b>:   {{invoice.invId}}</p>

                <p><b>CLIENTE:</b>     {{invoice.client.clientCode}} {{invoice.client.clientName}}<br>

                <p><b>REFERENCIA:</b>  {{invoice.contract.propertyNumber}}
                                       {{invoice.contract.streetName}}
                                       {{invoice.contract.streetType}}
                                       {{invoice.contract.suiteNumber}}
                                       {{invoice.contract.city}}
                                       {{invoice.contract.state}}
                                       {{invoice.contract.zipCode}}</p>

                <p><b>FECHA:</b>       {{invoice.invoiceDate}} </p>
                <p><b>MONTO TOTAL:</b>      {{invoice.netTotal}} </p>
                <p><b>BALANCE:</b>          {{invoice.balanceTotal}} </p>

                </p>
             </div>   <!-- end col-6 -->
    <div class="col-xs-8">
          <p><b>DETALLES</b></p> 
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
                <!-- <th>COMPROMISOS</th> -->
                <th>ACCION</th>
                <!-- <th></th> -->
            </tr>
            </thead>
          <tbody>   
       <tr v-for="(item,index) in invoice.invoice_details" v-if="item.unit != null">
       <!-- <tr v-for="(item,index) in invoice.invoice_details"> -->
            <td>{{++index}}</td>
            <td>{{item.serviceName}}</td>
            <td>{{item.unit}}</td>
            <td>{{item.unitCost}}</td>
            <td>{{item.quantity}}</td>
            <td>{{item.amount}}</td>
            <!-- <td>{{item.subcontractor_inv_detail.length}} SB</td> -->
            <td> 
           <!--   <a @click="deleteRow(index)" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Eliminar">
                            <span class="fa fa-times-circle" aria-hidden="true"></span> 
            </a>
           <button class="btn btn-info btn-sm" @click.prevent="moveUp(index)"> 
              <span class="fa fa-angle-double-up" aria-hidden="true"></span>
             </button>
            <button class="btn btn-info btn-sm" @click.prevent="moveDown(index)">
              <span class="fa fa-angle-double-down" aria-hidden="true"></span>
             </button> -->
           </td> 
         </tr>
         </tbody>
        </table>
       </div>
    </div><!-- end table-responsive -->
  </div><!-- end col-6 -->
<hr> 
<!-- /////////////////comienza la segunda parte (formulario de selects de esta vista)////////////////////////-->
<div class="row">
  <div class="col-xs-12 ">

       <div class="alert alert-danger" v-if="errors.length">
         <h4>Errores:</h4>
         <ul>
          <li v-for="error in errors">{{ error }}</li>
         </ul>
       </div>

<form class="form-horizontal">

  <!-- <input type="hidden" class="form-control" v-model="noteType">  -->
  <div class="form-group">
     <label for="formConcept" class="col-sm-2 control-label">CONCEPTO</label>
       <div class="col-sm-10">
            <select v-model="formConcept" class="form-control" id="formConcept">
                  <option value="1">Anulación de Factura</option>
                  <option value="2">Descuento</option>
                  <option value="3">Devolución parcial</option>
            </select>
        </div>
    </div>

  <div class="form-group">
    <label for="formReference" class="col-sm-2 control-label">REFERENCIA</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="formReference" v-model="formReference">
    </div>
  </div>

<div v-if="formConcept == 2">
  <div class="form-group">
      <label for="formPercent" class="col-sm-2 control-label">PORCENTAJE</label>
       <div class="col-sm-10">
                 <input type="number" step="0.01" min="0" max="100" class="form-control" id="formPercent"  pattern="^[0-9]+" v-model="formPercent" >
          </div>
  </div>
  <div class="form-group">  
        <label class="col-sm-3 control-label">MONTO DE LA NOTA</label>
          <div class="col-sm-4">
                   {{discount}}
          </div>
  </div>
</div>

<div v-if="formConcept == 3">

  <div class="form-group">
     <label for="formService" class="col-sm-2 control-label">SERVICIOS</label>
       <div class="col-sm-10">
        <select v-model="formService" class="form-control" id="formService">
          <option v-for="(item,index) in invoiceDetails" :value="item" v-if="item.unit != null"> {{item.serviceName}}</option>
        </select>
        </div>
    </div>
 <div class="row">
       <div class="text-right col-xs-6">
         <button class="btn btn-primary" @click.prevent="addRow()"> 
          <span class="fa fa-plus" aria-hidden="true"></span> Agregar Renglon
        </button>
       </div>
    </div>

<div class="table-responsive col-xs-12">
    <p><b>DEVOLVER</b></p> 
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
            <!-- <td>{{item.subcontractor_inv_detail.length}} SB</td> -->
            <td> 
             <a @click="deleteRow(index)" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Eliminar">
                            <span class="fa fa-times-circle" aria-hidden="true"></span> 
            </a>
                  
           </td> 
         </tr>
         </tbody>
        </table>
  </div>

</div>

  
  <div class="form-group">
    <div class="col-sm-offset-3 col-sm-9">
      <a class="btn btn-success" @click="createNote()" v-if="btnSubmitForm">Crear</a>
      <!-- <a class="btn btn-danger">Vista Previa</a> -->
    </div>
  </div>
</form>
          </div>
       </div>

    </div>    <!--END PANEL BODY  -->
</div>   <!-- END PANEL DEFAULT -->

</div>   
</template>

<script>

    export default {
        
     mounted() {
            console.log('Component Credit Note mounted.')
            this.findInvoice();

        },
    data: function () {
          return {
            errors: [],
            invoice: '',
            noteType: 'credit',

            formConcept: 1,
            formPercent: 0,
            formService: '',
            formReference: '',

            invoiceDetails: [],
            itemList: [],


            btnSubmitForm: true,
          }
    },
   props: {
           // prefUrl: { type: String},
           invoiceId: { type: String}
    },
   watch: {
       formConcept: function(){
            this.formPercent = 0;
            this.formService = '';
       },
    }, 
   computed: {
      discount: function () {
        let percentRs = (this.invoice.balanceTotal * this.formPercent)/100;
       return parseFloat(percentRs).toFixed(2);  
       } 
    },   
    methods: {
       findInvoice: function (){
            let url ='/invoices/'+this.invoiceId;
            axios.get(url).then(response => {
             this.invoice = response.data[0]
             this.invoiceDetails = this.invoice.invoice_details;
              // console.log(this.invoice)
            });
        },
      addRow: function() {
           this.errors = [];
          //buscar si en el arreglo itemList si ya se agrego el servicio
           let pos  = this.itemList.findIndex(item => item.invDetailId === this.formService.invDetailId);
           //VALIDATIONS
               if (!this.formService) 
                this.errors.push('Debe Escoger un Servicio.');
               if (pos != -1) 
                this.errors.push('Ya se Agrego el Servicio a la Nota.');

          if (!this.errors.length) { 
         
            //AGREGAR A ITEMLIST
              //Nota al agregar el item debo meter un objeto con el nombre y el ID
                this.itemList.push(this.formService);   

              }
        },
       deleteRow: function(id) {
            //borrar valor que encuentre del arreglo
                 this.itemList.splice(--id,1);
        },  
       createNote: function() {
          this.errors = [];

   //--------------VALIDATIONS-------------------//
          if (!this.formReference) 
               this.errors.push('Campo Referencia es Requerido');

          if (!this.formConcept) 
               this.errors.push('Campo Concepto Es Requerido');

   //-------------------------------
     let netTotalSelected = 0;
        if(this.formConcept == 1){
          netTotalSelected = this.invoice.balanceTotal;
        }
        if(this.formConcept == 2){
          netTotalSelected = this.discount;
            if (!this.formPercent) 
               this.errors.push('Campo Porcentaje es requerido');  
            if (this.formPercent > 60) 
               this.errors.push('Porcentaje no puede ser mayor a 60%');  
        }
        if(this.formConcept == 3){
           if (!this.itemList) 
               this.errors.push('Necesitas Agregar Servicios a la Nota');
        }
             
        if (!this.errors.length) { 
        this.btnSubmitForm = false;
           let url ='/invoices/sale-notes/store';
            axios.post(url,{
              invoiceId:     this.invoiceId,
              clientId:      this.invoice.client.clientId,
              noteType:      this.noteType,
              formConcept:   this.formConcept,
              formReference: this.formReference,
              formPercent:   this.formPercent,
              netTotal:      netTotalSelected,
            }).then(response => {
              // console.log(response.data);
              // this.$emit("notecreated");
               toastr.info(response.data.message)
               this.errors = [];
               this.formConcept = '';
               this.formReference = '';
               this.btnSubmitForm = true;
               // this.$refs.modalNewNote.close();
               this.findInvoice();
            }).catch(e => {
               toastr.error("Error de Servidor:"+ e)
               this.btnSubmitForm = true;
              })
           }

         },
     }
}


</script>
