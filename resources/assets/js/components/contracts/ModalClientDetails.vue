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
  <u>CLIENTE:</u> {{this.clientName}}
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