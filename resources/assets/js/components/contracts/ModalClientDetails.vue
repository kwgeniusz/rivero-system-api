<template>
<div>
<!-- BUTTON PARA MODAL DE CONTRATOS-->
             <a href="#" @click="openMainModal()" >
                <p v-if="this.companyName">{{this.companyName}} <br> </p>
                <p v-if="this.clientName"> ({{this.clientName}}) </p>
            </a>
       
<!-- COMIENZA CODIGO DE LA VENTANA MODAL PARA CREAR AL CLIENTE-->
 <sweet-modal ref="mainModal">
   <h3 class="bg-info">Cliente:
      <span v-if="this.companyName"> {{this.companyName}} </span>
      <span v-if="this.clientName"> ({{this.clientName}}) </span>
   </h3>
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

  <div class="panel panel-info">
    <div class="panel-heading" role="tab" id="headingOne">
        <div role="button" data-toggle="collapse" data-parent="#accordion" :href="'#'+clientId" aria-expanded="true" aria-controls="collapseOne">
           Datos Basicos
        </div>
    </div>
    <div v-if="client != null" :id="clientId" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
      <div class="panel-body well">
             <div class="text-left">
                <center>
                <b><u>Codigo de Cliente</u></b> <br>{{client[0].clientCode}}<br>
                <b><u>Tipo</u></b> <br>{{client[0].clientType}}<br>
                <b><u>Compañia</u></b> <br>{{client[0].companyName}}<br>
                <b><u>Representante/Cliente</u></b> <br>{{client[0].clientName}}<br>
                <b><u>Genero</u></b> <br>{{client[0].gender}}<br>
                <b><u>Registrado desde</u></b> <br>{{client[0].created_at | moment("MM/DD/YYYY")}}<br>
                <b><u>Direccion</u></b> <br>{{client[0].clientAddress}} <br>
                <b><u>Telf. Principal</u></b> <br>{{client[0].businessPhone}}<br>
                <b><u>Telf. Casa</u></b> <br>{{client[0].homePhone}}<br>
                <b><u>Mobile</u></b> <br>{{client[0].mobilePhone}}<br>
                <b><u>Otro Telf.</u></b> <br>{{client[0].otherPhone}}<br>
                <b><u>Fax</u></b> <br>{{client[0].fax}}<br>
                <b><u>Email Principal</u></b> <br>{{client[0].mainEmail}}<br>
                <b><u>Email Secundario</u></b> <br>{{client[0].secondaryEmail}}<br>
                <b><u>Idiomas</u></b> <br>{{client[0].clientLanguages}}<br>
                </center>
             </div>  
      </div>
    </div>
  </div>

  <!-- <div class="panel panel-info">
    <div class="panel-heading" role="tab" id="headingTwo">
        <div class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" :href="'#'+clientId+'2'" aria-expanded="false" aria-controls="collapseTwo">
          Otro Contactos
        </div>
    </div>
    <div v-if="client != null" :id="clientId+'2'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
      <div class="panel-body well">
             <main-other-contact :client-id="clientId"/>

      </div>
    </div>
  </div> -->

  <!-- <div class="panel panel-info">
    <div class="panel-heading" role="tab" id="headingThree">
        <div class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" :href="'#'+clientId+'3'" aria-expanded="false" aria-controls="collapseThree">
          Collapsible Group Item #3
        </div>
    </div>
    <div :id="clientId+'3'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
      <div class="panel-body well">
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
      </div>
    </div>

  </div> -->
</div>
</sweet-modal>

</div>   
</template>
<script>

    export default {
        
     mounted() {
            // console.log('Component ModalContract mounted.')

           },
      props: {
           prefUrl: { type: String},
           clientId: { type: [String,Number], default: null}, 
           clientName: { type: String, default: null}, 
           companyName: { type: String, default: null}, 
    },
     data: function () {
          return {
           client: null,
           acum: 0,
          }
    },
    methods: {
       openMainModal: function (){
          axios.get('clients/'+this.clientId).then(response => {
                 this.client = response.data
                 console.log(this.client)

            });
            // console.log(this.client)
            this.$refs.mainModal.open()
        },
      }
     }
</script>

<style lang="scss">
// @import '../../../sass/app.scss'
</style>