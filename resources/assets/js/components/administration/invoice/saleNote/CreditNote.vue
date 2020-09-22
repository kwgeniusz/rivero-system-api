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

<div class="row">
  <div class="col-xs-7 col-xs-offset-2 ">

       <div class="alert alert-danger" v-if="errors.length">
         <h4>Errores:</h4>
         <ul>
          <li v-for="error in errors">{{ error }}</li>
         </ul>
       </div>

<form class="form-horizontal">

  <input type="hidden" class="form-control" v-model="noteType"> 

  <div class="form-group">
     <label for="formConcept" class="col-sm-2 control-label">CONCEPTO</label>
       <div class="col-sm-10">
            <select v-model="formConcept" class="form-control" id="formConcept">
                  <option value="1">Anulación</option>
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

  <div class="form-group">
    <div class="col-sm-offset-3 col-sm-9">
      <a class="btn btn-primary" @click="createNote()" v-if="btnSubmitForm">Crear</a>
      <a class="btn btn-danger">Vista Previa</a>
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

            formReference: '',
            formConcept: 1,
            noteType: 'credit',
            btnSubmitForm: true,
          }
    },
   props: {
           // prefUrl: { type: String},
           invoiceId: { type: String}
    },
    methods: {
       findInvoice: function (){
            let url ='/invoices/'+this.invoiceId;
            axios.get(url).then(response => {
             this.invoice = response.data[0]
              // console.log(this.invoice)
            });
        },
       createNote: function() {
          this.errors = [];

       //VALIDATIONS
          if (!this.formConcept) 
               this.errors.push('Campo Concepto Es Requerido');
          if (!this.formReference) 
               this.errors.push('Campo Referencia es Requerido');  
             
        if (!this.errors.length) { 
        this.btnSubmitForm = false;
           let url ='/invoices/sale-notes/store';
            axios.post(url, {
              invoiceId:     this.invoiceId,
              clientId:      this.invoice.client.clientId,
              noteType:      this.noteType,
              formReference: this.formReference,
              formConcept:   this.formConcept,
              netTotal:      this.invoice.balance
            }).then(response => {
              // console.log(response.data);
              // this.$emit("notecreated");
               toastr.info(response.data.message)
               this.errors = [];
               this.formReference = '';
               this.formConcept = '';
               this.btnSubmitForm = true;
               // this.$refs.modalNewNote.close();
            }).catch(e => {
               toastr.error("Error de Servidor:"+ e)
               this.btnSubmitForm = true;
              })
           }

         },
     }
}


</script>
