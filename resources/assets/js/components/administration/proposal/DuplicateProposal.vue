<template>

<div class="row">
  <div class="col-sm-12">
   <h3><b>PROPUESTAS > Duplicar</b></h3>
       <div v-if="!loading" class="text-center">
         <button @click="duplicateProposal()" v-if="precontractInfo != '' || contractInfo != ''" class="btn btn-success"> Procesar</button>
         <button @click="back()" class="btn btn-warning"> <span class="fa fa-hand-point-left" aria-hidden="true"></span> Regresar</button>
      </div>
      <div v-else class="col-sm-12 text-center">
              <br>
              <loading/><br>
               PROCESANDO...
              <br>
      </div>

        <div class="inputother boxes2">
            <label for="entity">Entidad:</label>
            <select v-model="entity" class="form-control" name="entity" id="entity">
                <option value="precontract">Precontratos</option>
                <option value="contract">Contratos</option>
            </select>
        </div>

    <!-- <div class="row" v-if="proposal != null"> -->
    <div class="row">
      <div class="panel panel-default col-xs-12 col-sm-6">
          <div class="panel-heading"><h4><b>Propuesta #{{proposal.propId}}:</b></h4></div>
             <div class="panel-body">
        
               <h4><strong>Alcances de la Propuesta</strong></h4>
               <ul>
                 <li v-for="(item,index) in proposal.scope"> {{item.description}} </li>
               </ul>

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
           <tr v-for="(item,index) in proposal.proposal_detail">
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

       <h4><strong>Time Frame</strong></h4>
        <ul>
          <li v-for="(item,index) in proposal.time_frame"> {{item.timeName}} </li>
        </ul>

      <h4><strong>Terminos y Condiciones</strong></h4>
        <ul>
          <li v-for="(item,index) in proposal.term"> {{item.termName}} </li>
        </ul>

      <h4><strong>Notas</strong></h4>
        <ul>
          <li v-for="(item,index) in proposal.note"> {{item.noteName}} </li>
        </ul>

        <h4><strong>Payment Breakdown</strong></h4>
        <ul>
          <li v-for="(item,index) in proposal.payment_proposal"> {{item.paymentDate}} (Amount: {{item.amount}}) </li>
        </ul>

      </div> <!-- fin del panel body -->
   </div>   <!-- fin del panel default principal -->

<!-- @change="changeUnit(modelUnit)" -->

  <div v-if="entity == 'precontract'" class="panel panel-default col-xs-12 col-sm-6">
          <div class="panel-heading"> <h4><b>Lista de Precontratos:</b></h4> </div>
          <div class="panel-body">
            <div class="form-group col-lg-12 ">

              <h4><label for="accountTypeCode">Escoja un Precontrato de Destino:</label></h4>
              <v-select  @input="getPrecontractInfo()" :options="precontractList" v-model="precontractIdSelected" :reduce="precontractList => precontractList.precontractId" label="siteAddress"/>
                <br>
                 <ul>
                   <li><b>Precontract Number:</b> {{precontractInfo.preId}}</li>
                   <li><b>Nombre del Proyecto:</b> {{precontractInfo.projectName}}</li>
                   <li><b>Fecha:</b> {{precontractInfo.precontractDate}}</li>
                   <li><b>Cliente:</b> {{precontractInfo.clientId}}</li>
                   <li><b>Direccion:</b> {{precontractInfo.siteAddress}}</li>
                   <li><b>Comentario Inicial:</b> {{precontractInfo.comment}} </b></li>
                 </ul>

            </div> 
          </div>
      </div>

      <div v-if="entity == 'contract'" class="panel panel-default col-xs-12 col-sm-6">
          <div class="panel-heading"> <h4><b>Lista de Contratos:</b></h4> </div>
          <div class="panel-body">
            <div class="form-group col-lg-12 ">

              <h4><label for="accountTypeCode">Escoja un Contrato de Destino:</label></h4>
              <v-select  @input="getContractInfo()" :options="contractList" v-model="contractIdSelected" :reduce="contractList => contractList.contractId" label="siteAddress"/>
                <br>
                 <ul>
                   <li><b>Contract Number:</b> {{contractInfo.contractNumber}}</li>
                   <li><b>Nombre del Proyecto:</b> {{contractInfo.projectName}}</li>
                   <li><b>Fecha:</b> {{contractInfo.contractDate}}</li>
                   <li><b>Cliente:</b> {{contractInfo.clientId}}</li>
                   <li><b>Direccion:</b> {{contractInfo.siteAddress}}</li>
                   <li><b>Comentario Inicial:</b> {{contractInfo.comment}} </b></li>
                 </ul>

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
       //  consultar Propuesta por ID
           axios.get('/proposals/'+this.proposalId).then(response => {
                  this.proposal = response.data[0]
             });
      //  consulta lista de precontratos
         axios.get('/unconverted-precontracts').then(response => {
                 this.precontractList = response.data
            });
     //  consulta lista de contratos
         axios.get('/unconverted-contracts').then(response => {
                 this.contractList = response.data
            });
           },
      props: {
           proposalId: { type: [String,Number], default: null}, 
    },
     data: function () {
          return {
           entity: 'precontract',
           loading: false,
           proposal: [],

           precontractList: [],
           precontractIdSelected: '',
           precontractInfo: [],

           contractList: [],
           contractIdSelected: '',
           contractInfo: [],
          }
    },
    methods: {
       getPrecontractInfo: function () {
          //llamar los detalles del precontrato
          axios.get('/precontracts/'+this.precontractIdSelected).then(response => {
                 this.precontractInfo = response.data[0]
            });
        },
       getContractInfo: function () {
          //llamar los detalles del Contracto
          axios.get('/contracts/'+this.contractIdSelected).then(response => {
                 this.contractInfo = response.data[0]
            });
        },
        duplicateProposal: function () {
           this.loading = true;

          //llamar los detalles de la propuesta
           axios.post("/proposals/duplicate", {
               proposalId:      this.proposal.proposalId,
               precontractId:   this.precontractIdSelected,
             }).then(response => {
                if (response.data.alert == "success") {
                   toastr.success(response.data.message);
                 } else {
                   toastr.error(response.data.message);
                }

                window.location.href = '/proposals/?id='+this.precontractIdSelected;
           });
        },
       back: function () {
        history.back();
       }

      } //FIN DE METHODS
     }
</script>
