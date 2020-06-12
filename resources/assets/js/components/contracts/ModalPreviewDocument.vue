<template>
<div>
<!-- BUTTON PARA FORMULARIO MODAL DE COBRO DE CUOTA-->
           <a @click="openModal()" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Ver">
                <span class="fa fa-search" aria-hidden="true"></span>  
           </a>
<!-- COMIENZA CODIGO DE LA VENTANA MODAL PARA CREAR AL CLIENTE-->
      <sweet-modal modal-theme="dark" overlay-theme="dark" ref="modal" width="100%">
            <b> Previzualicion Del Documento.</b>
           <br /><br />
           <div class="embed-responsive embed-responsive-4by3 iframe" v-if="showModal">
            <center>
              <iframe class="iframe" :src="url" frameborder="0">
                
              </iframe>
            </center>
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
             return 'https://view.officeapps.live.com/op/embed.aspx?src='+window.location.protocol+'//'+window.location.host+'/storage/'+this.url
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

<style scoped>

 .iframe{
   width:100%;
    height: calc(100vh - 88px);  
 }

</style>