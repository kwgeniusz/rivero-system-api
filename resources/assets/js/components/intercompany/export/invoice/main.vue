<template>

<div class="row">
  <div class="col-sm-12">
   <h3><b>INTERCOMPANIA > FACTURA > EXPORTAR</b></h3>
       <div v-if="!loading" class="text-center">
         <button @click="sendInvoice()" v-if="companySelected != ''" class="btn btn-success"><i class="fa fa-arrows-rotate"></i> Procesar</button>
         <button @click="back()" class="btn btn-warning"> <span class="fa fa-hand-point-left" aria-hidden="true"></span> Regresar</button>
      </div>
      <div v-else class="col-sm-12 text-center">
              <br>
              <loading/><br>
               PROCESANDO...
              <br>
      </div>
  <br>

    <!-- <div class="row" v-if="invoice != null"> -->
    <div class="row">
      <div class="panel panel-default col-xs-12 col-sm-6">
          <div class="panel-heading"><h4><b>Factura #{{invoice.invId}}:</b></h4></div>
             <div class="panel-body">
   
            <h4><strong>Servicios</strong></h4>
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
                 </tr>
                </thead>
            <tbody>   
           <tr v-for="(item,index) in invoice.invoice_details">
              <td>{{item.itemNumber}}</td>
              <td>{{item.serviceName}}</td>
              <td>{{item.unit}}</td>
              <td>{{item.unitCost}}</td>
              <td>{{item.quantity}}</td>
              <td>{{item.amount}}</td> 
           </tr>
          </tbody>
          </table>
        </div>

      <!-- <h4><strong>Pagos</strong></h4>
      <div class="table-responsive tableother">
        <table class="table table-striped table-bordered text-center bg-info">
          <thead> 
                 <tr>  
                  <th>#</th>
                  <th>MONTO</th>  
                  <th>METODO</th>
                  <th>ESTADO</th>
                  <th>FECHA</th>
                 </tr>
            </thead>
           <tbody> 
             <tr v-for="(item,index) in invoice.receivable">
               {{item}}
                 <td width="5%">{{++index}})</td>
                 <td width="30%">{{item.amountDue}}</td>
                 <td width="35%">{{}}</td>
                 <td width="20%">{{item.recStatusName}}</td>
                 <td width="55%">{{item.datePaid}}</td>
              </tr>
           </tbody> 
         </table>
      </div> -->

      </div> <!-- fin del panel body -->
   </div>   <!-- fin del panel default principal -->

      <div class="panel panel-default col-xs-12 col-sm-6">
          <div class="panel-heading"> <h4><b>Preparacion de Datos:</b></h4> </div>
          <div class="panel-body">
            <div class="form-group col-lg-12 ">
              <!-- <h4><label for="accountTypeCode">Tipo de exportacion:</label></h4>
               <select name="" id="">
                 <option value="ONLY_ENTITY">SOLO LA ENTIDAD</option>
                 <option value="ENTITY_WITH_RELATIONS">ENTIDAD CON RELACIONES</option>
               </select> -->
                 <h4><label for="accountTypeCode">Aplicar Formulas de Costo?</label></h4>
               <select name="" id="">
                 <option value="0">No</option>
                 <option value="1">Si</option>
               </select>

              <h4><label for="accountTypeCode">Escoja una Compañia destino:</label></h4>
              <select-country-office pref-url="/" @company-value="setCompanyValue"></select-country-office>

              <!-- <v-select  @input="getPrecontractInfo()" :options="companyList" v-model="companySelected" :reduce="companyList => companyList.companyId" label="companyName"/> -->

            </div> 
          </div>
      </div>

    </div>
    <!-- <div v-else>
      <h3 class="text-center">
        <loading></loading><br>
          Cargando el Contenido...
      </h3>
    </div> -->

  </div>
</div>

</template>

<script>

    export default {
        
     mounted() {

      //  consulta Factura por Id
          axios.get('/invoices/'+this.invoiceId).then(response => {
                 this.invoice = response.data[0]
            });

           },
      props: {
           invoiceId: { type: [String,Number], default: null}, 
    },
     data: function () {
          return {
           loading: false,
           invoice: [],

           companyList: [],
           companySelected: '',
          }
    },
    methods: {
        sendInvoice: function () {
          //  this.loading = true;

          //llamar los detalles de la Factura
           axios.post("/intercompany/export/invoice", {
               invoiceId:   this.invoice.invoiceId,
               companyId:   this.companySelected,
             }).then(response => {
                if (response.data.alert == "success") {
                   toastr.success(response.data.message);
                 } else {
                   toastr.error(response.data.message);
                }

                // window.location.href = '/invoices/?id='+this.companySelected;
           });
        },
      setCompanyValue(value) {
        this.companySelected = value;
      },
       back: function () {
        history.back();
       }

      } //FIN DE METHODS
     }
</script>
