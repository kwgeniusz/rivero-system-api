<template>
<label>
<!-- BUTTON PARA MODAL DE CONTRATOS-->
             <a href="#" @click="openMainModal()" >
                {{this.clientName}}
            </a>
       
<!-- COMIENZA CODIGO DE LA VENTANA MODAL PARA CREAR AL CLIENTE-->
 <sweet-modal ref="mainModal">
<!-- button -->
<div class="bg-info" role="button" data-toggle="collapse" :href="'#'+clientId" aria-expanded="false">
  <u>CLIENTE:</u> <br>{{this.clientName}}
</div>
<!-- collapse -->
<div v-if="client != null" class="collapse" :id="clientId">
  <div class="well">
    <h4>
       <b><u>Codigo de Cliente:</u></b> <br>{{client[0].clientCode}}<br>
       <b><u>Registrado desde:</u></b> <br>{{client[0].dateCreated | moment("MM/DD/YYYY")}}<br>
       <b><u>Direccion:</u></b> <br>{{client[0].clientAddress}} <br>
       <b><u>Telefonos:</u></b> <br>{{client[0].clientPhone}}<br>
       <b><u>Email:</u></b> <br>{{client[0].clientEmail}}<br>
    </h4>
  </div>

</div>

<br>

<div class="bg-info" role="button" data-toggle="collapse" :href="acum" aria-expanded="false">
   CONTRATOS
</div>
<!-- collapse -->
<div v-if="client != null" class="collapse" :id="acum++">
  <div class="well">
    <h4>
            {{client[0].contract}}
    </h4>
  </div>

</div>

<br>

<div class="bg-info" role="button" data-toggle="collapse" :href="invoices" aria-expanded="false">
   FACTURAS
</div>
<!-- collapse -->
<div v-if="client != null" class="collapse" :id="invoices">
  <div class="well">
    <h4>
          {{client[0].invoice}}
    </h4>
  </div>

</div>

<br>

<div class="bg-info" role="button" data-toggle="collapse" :href="proposals" aria-expanded="false">
   PROPUESTAS
</div>
<!-- collapse -->
<div v-if="client != null" class="collapse" :id="proposals">
  <div class="well">
    <h4>
            {{client[0].proposal}}
    </h4>
  </div>

</div>

</sweet-modal>

</label>   
</template>

<script>

    export default {
        
     mounted() {
            console.log('Component ModalContract mounted.')

           },
      props: {
           prefUrl: { type: String},
           clientId: { type: String, default: null}, 
           clientName: { type: String, default: null}, 
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

            });
            // console.log(this.client)
            this.$refs.mainModal.open()
        },
      }
     }
</script>