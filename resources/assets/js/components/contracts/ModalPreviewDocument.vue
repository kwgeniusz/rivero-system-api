<template>
<div>
<!-- BUTTON PARA FORMULARIO MODAL DE COBRO DE CUOTA-->
           <a @click="openModal()" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Ver">
                <span class="fa fa-search" aria-hidden="true"></span>  
           </a>
<!-- COMIENZA CODIGO DE LA VENTANA MODAL PARA CREAR AL CLIENTE-->
<!-- Sweet modal is something awful, needs a lot of testing -->
      <sweet-modal ref="modal" width="100%">
       <b>Previzualicion Del Documento</b>
        <br /><br />
        <div class="iframe" v-if="showModal">
           <!-- {{docUrl}} -->
          <iframe v-if="ext == 'docx' || ext == 'pptx'|| ext == 'xls' || ext == 'pdf'" :src="url" width='100%' frameborder='0'/>
          <img v-else class="resp-container" :src="url">
        </div>
     </sweet-modal>
</div>   
</template>
<script>

    export default {
        
     mounted() {
            console.log('Component Modal previuw Doc mounted.')
           },
     data: function () {
          return {
            showModal:false
          }
    },
    props: {
           docUrl: { type: String},
           ext: { type: String}
          },
  computed: {
    url: function () {

          if(this.ext == 'docx' || this.ext == 'pptx'|| this.ext == 'xls'){
             return 'https://view.officeapps.live.com/op/embed.aspx?src='+window.location.protocol+'//'+window.location.host+'/storage/'+this.docUrl
          }else{ 
             return window.location.protocol+'//'+window.location.host+'/storage/'+this.docUrl
           }
    }
  }, methods: {
       openModal: function() {
           this.showModal = true
           this.$refs.modal.open();

       }
     }
}

</script>

<style lang="scss">
@import '../../../sass/app.scss'
</style>