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

  <div class="form-group">
     <label for="formConcept" class="col-sm-2 control-label">CONCEPTO</label>
       <div class="col-sm-10">
            <select v-model="formConcept" class="form-control" id="formConcept">
                  <option value="1">Anulación de Factura</option>
                  <!-- <option value="2">Descuento</option> -->
                  <option value="3">Devolución parcial</option>
            </select>
        </div>
    </div>

  <div class="form-group">
    <label for="formReference" class="col-sm-2 control-label">REFERENCIA</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="formReference" v-model="formReference" autocomplete="off">
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



<!-- OPCION 1 - ANULACION -->
<div v-if="formConcept == 1">
<div class="table-responsive col-xs-12">
    <p class="text-center"><b>ESTA FACTURA TIENE PAGOS QUE DEBE DISTRIBUIRSE EN LOS SERVICIOS</b></p> 
    <p class="text-center"><b>MONTO PAGADO EN FACTURA: {{invoiceTotalPaid}} / MONTO ASIGNADO: {{acumInput}}</b></p> 
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
                <th>ASIGNADOS</th>
            </tr>
            </thead>
          <tbody>   

       <tr v-for="(item,index) in itemList" v-if="item.unit != null">
            <td>{{++index}}</td>
            <td>{{item.serviceName}}</td>
            <td>{{item.unit}}</td>
            <td>{{item.unitCost}}</td>
            <td>{{item.quantity}}</td>
            <td>{{item.amount}}</td>
            <!-- <td>{{item.subcontractor_inv_detail.length}} SB</td> -->
            <td> 
            
             <div class="form-group col-lg-6 col-lg-offset-3 ">
                 <input type="number" step="0.01" min="0" value="0" class="form-control" :ref="item.invDetailId" :id="item.invDetailId" pattern="^[0-9]+" @keyup="calculateAssigned(item.amount,$event)">
             </div>
<!--              <a @click="deleteRow(index)" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Eliminar">
                            <span class="fa fa-times-circle" aria-hidden="true"></span> 
            </a> -->
    
           </td> 
         </tr>
         </tbody>
        </table>
 
</div>
</div>
<!-- FIN DE LA OPCION 1 -->

<!-- OPCION 3 - DEVOLUCION PARCIAL -->
<div v-if="formConcept == 3">
  <div class="form-group">
     <label for="formService" class="col-sm-2 control-label">SERVICIOS</label>
       <div class="col-sm-10">
        <select v-model="formService" class="form-control" id="formService">
          <option v-for="(item,index) in invoice.invoice_details" :value="item" v-if="item.unit != null"> {{item.serviceName}}</option>
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
    <p><b>NOTA DE CREDITO</b></p> 
          <table class="table table-striped table-bordered text-center bg-info">
            <thead> 
            <tr>  
                <th>#</th>
                <th>SERVICIO</th>  
                <th>UNIDAD</th>
                <th>COSTO</th>
                <th>CANTIDAD</th>
                <th>MONTO</th>
                <th>ACCION</th>
            </tr>
            </thead>
          <tbody>   
       <tr v-for="(item,index) in itemList">
            <td>{{++index}}</td>
            <td>{{item.serviceName}}</td>
            <td>{{item.unit}}</td>
            <td>
              <input v-if="editMode === index" type="text" class="form-control" v-model="item.unitCost" @keyup="calculateItemAmount(index,item)">
              <p v-else>{{item.unitCost}}</p> 
            </td>
            <td>
              <input v-if="editMode === index" type="text" class="form-control" v-model="item.quantity" @keyup="calculateItemAmount(index,item)">
              <p v-else>{{item.quantity}}</p> 
            </td>
            <td>{{item.amount}}</td>
            <td> 

            <a v-if="editMode === index" @click="updateItemList(index, item)" class="btn btn-sm btn-success">
               <i class="glyphicon glyphicon-ok"></i>
            </a> 
            <a v-else @click="editItemList(index)" class="btn btn-sm btn-primary" title="Editar" > 
                <i class="fa fa-edit"></i>
            </a> 

             <a @click="deleteRow(index)" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Eliminar">
                            <span class="fa fa-times-circle" aria-hidden="true"></span> 
            </a>
                  
           </td> 
         </tr>
         </tbody>
        </table>
  </div>

</div>
<!-- FIN DE LA DEVOLUCION PARCIAL -->
  
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
            noteType: 'credit',
            errors: [],
            invoice: '',
            invoiceTotalPaid: 0,
            acumInput:0,

            formConcept: 1,
            formPercent: 0,
            formService: '',
            formReference: '',

            itemList: [],
            editMode: -1,
 

            btnSubmitForm: true,
          }
    },
   props: {
           // prefUrl: { type: String},
           invoiceId: { type: String}
    },
   watch: {
       formConcept: function(){
            // console.log(this.formConcept)

             if(this.formConcept == 1) {
                this.itemList = this.invoice.invoice_details;   
             }else{
               this.itemList = [];
             }

            this.formPercent = 0;
            this.formService = '';
       },
    }, 
   computed: {
      discount: function () {
        let percentRs = (this.invoice.balanceTotal * this.formPercent)/100;
       return parseFloat(percentRs).toFixed(2);  
       },
    },   
    methods: {
       findInvoice: function (){
          let url ='/invoices/'+this.invoiceId;

            axios.get(url).then(response => {
             this.invoice = response.data[0]
             this.itemList = this.invoice.invoice_details;   

             //sumar el total de cuotas pagadas de la factura y retornarla a this.invoiceTotalPaid
             let suma = 0;
             this.invoice.shareSucceed.forEach(function(share){
                suma = parseFloat(suma) + parseFloat(share.amountPaid)
              });
               this.invoiceTotalPaid = suma;

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
     calculateItemAmount: function(index,item)
     
             const found = this.invoice.invoice_details.find(invDetail => invDetail.invDetailId == item.invDetailId);
             console.log(found.amount);

             console.log(item)

             const found2 = this.itemList.find(item => item == item.invDetailId);
             console.log(found2.amount);
                // this.editMode = index
                // this.$emit('delete',index)
            },
      editItemList: function(index){
                // console.log(id)
                    this.editMode = index
                // this.$emit('delete',index)
            },
      updateItemList: function(index, item){
                console.log(index) 
                console.log(item) 
             
             //buscar el monto total del item para no sobrepasarlo con la modificacion
             // const found = this.invoice.invoice_details.find(invDetail => invDetail.invDetailId == item.invDetailId);
             // console.log(found.amount);
                // const params = {
                //     departmentName: item.departmentName,
                // }
                // this.editMode = -1

            },  
       calculateAssigned: function(amount,event){
         //primera regla si el monto ingresado es mayor que el precio del servicio borrar lo del input
          if(parseFloat(event.target.value) > parseFloat(amount)) {
               event.target.value = 0; 
          }
         //regla: si no es un numero ponle cero
           if(event.target.value == '') {
              event.target.value = 0;
          }
           
        //suma todos los valores ingresados en los inputs de asignacion
           var acum = 0;
             Object.keys(this.$refs).forEach(index => {
               this.$refs[index].forEach(inputAssign => {

                  acum = parseFloat(acum) + parseFloat(inputAssign.value);

                });
             });

          this.acumInput = acum; 
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

              if(this.acumInput > this.invoiceTotalPaid) 
               this.errors.push('Ha asignado mas del monto permitido');

              if(this.acumInput < this.invoiceTotalPaid) 
               this.errors.push('Debe Asignar el monto pagado de esta factura')
 
        }//end of formConcept 1 - ""
        if(this.formConcept == 2){
          netTotalSelected = this.discount;

            if (!this.formPercent) 
               this.errors.push('Campo Porcentaje es requerido');  
            if (this.formPercent > 60) 
               this.errors.push('Porcentaje no puede ser mayor a 60%');  
        }
        if(this.formConcept == 3){
          netTotalSelected = acum;

           if (!Array.isArray(this.itemList) || !this.itemList.length) {
               this.errors.push('Necesitas Agregar Servicios a la Nota');
         }
           //suma todos los amount de ItemList
              let acum = 0;
                this.itemList.forEach(item => {
                  acum = parseFloat(acum) + parseFloat(item.amount);
                });
           if(acum > parseFloat(this.invoice.balanceTotal)) {
               this.errors.push('El Suma de Los item no puede superar el balance de la factura.');
              }
              
        }
             
        if (!this.errors.length) { 
        this.btnSubmitForm = false;

            if(this.formConcept == 1){
         //sacame el indice del arreglo $ref de vue donde tengo los input de asignaciones
          //luego recorre ese arreglo $ref con esos indices obtenidos cno Object.key
          //y luego recorre itemLista para modificar donde corresponda y restar lo ingresado en los input antes de enviarlo a backend
            Object.keys(this.$refs).forEach(index => {
               this.$refs[index].forEach(inputAssign => {
                     this.itemList.map(function(service) {
                         if(parseInt(index) == service.invDetailId){
                           service.amount =  parseFloat(service.amount).toFixed(2) - parseFloat(inputAssign.value).toFixed(2);
                         } 
                           return service;
                      });
                   });  
                });
            }

           let url ='/invoices/sale-notes/store';
            axios.post(url,{
              invoiceId:     this.invoiceId,
              clientId:      this.invoice.client.clientId,
              noteType:      this.noteType,
              formConcept:   this.formConcept,
              formReference: this.formReference,
              formPercent:   this.formPercent,
              itemList:      this.itemList,
              netTotal:      netTotalSelected,
            }).then(response => {
               toastr.info(response.data.message)
               this.findInvoice();
               this.errors = [];

               this.formConcept = '';
               this.formReference = '';
               this.acumInput = 0;
    
               window.location.href = '/invoices/'+this.invoiceId+'/sale-notes'
              

               // this.btnSubmitForm = true;
            }).catch(e => {
               toastr.error("Error de Servidor:"+ e)

               window.location.href = '/invoices/'+this.invoiceId+'/sale-notes'
               // this.btnSubmitForm = true;
              })
           }

         },
     }
}


</script>
