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

<form class="form">
	<div class="form-group">
		 <label for="formConcept" class="col-sm-2 control-label">CONCEPTO</label>
			 <div class="col-sm-10">
						<select v-model="formConcept" class="form-control" id="formConcept">
									<option value="1">Anexar Servicios</option>
									<!-- <option value="2">Retraso en Pago</option> -->
						</select>
				</div>
		</div>

  <br>

	<div class="form-group">
		<label for="formReference" class="col-sm-2 control-label">REFERENCIA</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="formReference" v-model="formReference" autocomplete="off">
		</div>
	</div>

 <br>

<!-- OPCION 1 - ANULACION -->
<div v-if="formConcept == 1">

	<div class="form-group">
		 <label for="formService" class="col-sm-2 control-label">SERVICIOS</label>
			 <div class="col-sm-10">
				<select v-model="formService" @change="selectService(formService)" class="form-control" id="formService">
					<option :class="{ bold: item.hasCost == 'Y' ? true : false }" v-for="(item,index) in services" :value="item"> {{item.serviceName}}</option>
				</select>
				</div>

    <!--     <div class="form-group col-xs-12">
            <label for="serviceId">SERVICIO</label>
            <select v-model="formService" @change="selectService(formService)" class="form-control" name="serviceId" id="serviceId">
                <option :class="{ bold: item.hasCost == 'Y' ? true : false }" v-for="(item,index) in services" :value="item" > {{item.serviceName}}
                 </option>
                  }
            </select>
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

          <div v-if="hasCost" class="form-group  col-xs-4">
            <label for="quantity">CANTIDAD</label>
            <input v-model="modelQuantity" type="number" class="form-control" id="quantity" name="quantity"  autocomplete="off">
          </div>

         <div v-if="hasCost" class="form-group col-xs-4 col-xs-offset-4">
                <label>COSTO TOTAL:   {{sumTotal}}</label>
          </div>

		</div>
 <!-- <div class="row"> -->
			 <div class="text-right col-xs-7">
				 <button class="btn btn-primary" @click.prevent="addRow()"> 
					<span class="fa fa-plus" aria-hidden="true"></span> Agregar Renglon
				</button>
			 </div>
		<!-- </div> -->

<div class="table-responsive col-xs-12">
		<p><b>NOTA DE DEBITO</b></p> 
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
		<!-- 	 	{{item}} -->
						<td>{{++index}}</td>
						<td>{{item.serviceName}}</td>
						<td>{{item.unit}}</td>
						<td>{{item.unitCost}}</td>
						<td>{{item.quantity}}</td>
						<td>{{item.amount}}</td>
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
           <label>TOTAL NETO: {{noteNetTotal}}</label>
			 </div>
</div>
<!-- FIN DE LA OPCION 1 -->

<!-- OPCION 3 - DEVOLUCION PARCIAL -->
<!-- FIN DE LA DEVOLUCION PARCIAL -->
	
		<div class="text-center col-xs-12">
			<a class="btn btn-success" @click="createNote()" v-if="btnSubmitForm">Crear</a>
			    <a @click.prevent="itemList = []"  class="btn btn-danger btn-sm">
            <span class="fa fa-recycle" aria-hidden="true"></span>  Vaciar
          </a>  
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
						console.log('Component Debit Note mounted.')
						this.findInvoice();
						this.getAllServices();

				},
		data: function () {
					return {
						errors: [],
						invoice: '',
						balancePaid: 0,
						noteType: 'debit',

						formConcept: 1,
						formReference: '',
						formService: '',
						formPercent: 0,
						hasCost: false,
            modelQuantity: '',
            modelUnit: '',
            modelUnitCost: '',
						
						services: {},
						itemList: [],

						btnSubmitForm: true,
					}
		},
	 props: {
					 // prefUrl: { type: String},
					 invoiceId: { type: String}
		},
	 computed: {
			sumTotal: function () {
					let sum = this.modelQuantity * this.modelUnitCost;
					return  Number.parseFloat(sum).toFixed(2);
						
			 },
			noteNetTotal: function () {
					let suma = 0;

				 this.itemList.forEach(function(item){
						 if(item.amount == null) { item.amount = 0.00 }
						suma += parseFloat(item.amount);
						suma.toFixed(2);
					});

					return suma
			 }  
		},
		methods: {
			 findInvoice: function (){
					let url ='/invoices/'+this.invoiceId;

						axios.get(url).then(response => {
						 this.invoice = response.data[0]   

						 //sumar el total de cuotas pagadas de la factura y retornarla a this.balancePaid
						 let suma = 0;
						 this.invoice.shareSucceed.forEach(function(share){
								suma = parseFloat(suma) + parseFloat(share.amountPaid)
							});
							this.balancePaid = suma;
				 });

			},
			getAllServices: function (){
						let url ='/services';
						axios.get(url).then(response => {
						 this.services = response.data
						});
				},
		  selectService: function (item){
	
              if(item.hasCost == 'N'){
                 this.hasCost = false //oculta los input que tienen esta variable
                 this.modelQuantity =''
                 this.modelUnit =''
                 this.modelUnitCost =''
              }else{
                 this.hasCost = true
                 this.modelQuantity= 1.00
                 this.modelUnit = item.unit1;
                 this.modelUnitCost = item.cost1;
              }

        },	
       changeUnit: function(unit) {
             if(unit == 'sqft'){
               this.modelUnitCost = this.formService.cost1;
             }else {
               this.modelUnitCost = this.formService.cost2;
             }
            
        },   	
			addRow: function() {
					 this.errors = [];
					 //VALIDATIONS
							 if (!this.formService) 
								this.errors.push('Debe Escoger un Servicio.');
						 
					if (!this.errors.length) { 
						//AGREGAR A ITEMLIST
							//Nota al agregar el item debo meter un objeto con el nombre y el ID
                this.itemList.push({
                                     serviceId:this.formService.serviceId,
                                     serviceName:this.formService.serviceName,
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
					 if (!Array.isArray(this.itemList) || !this.itemList.length) {
							 this.errors.push('Necesitas Agregar Items a la Nota');
				     }
					netTotalSelected = this.noteNetTotal;
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
							itemList:      this.itemList,
							netTotal:      netTotalSelected,
						}).then(response => {
							 toastr.info(response.data.message)
							 this.findInvoice();
							 this.errors = [];

							 this.formConcept = '';
							 this.formReference = '';
		
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
<style>
.bold {
    font-weight:bold;
    background:#D7F7E2;
}
</style>