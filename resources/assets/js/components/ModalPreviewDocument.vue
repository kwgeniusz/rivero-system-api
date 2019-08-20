<template>
<div>
<!-- BUTTON PARA FORMULARIO MODAL DE COBRO DE CUOTA-->
           <a @click="openModal()" class="btn btn-primary btn-sm">
                <span class="fa fa-times-circle" aria-hidden="true"></span>  Ver
           </a>
  
<!-- COMIENZA CODIGO DE LA VENTANA MODAL PARA CREAR AL CLIENTE-->
      <sweet-modal modal-theme="dark" overlay-theme="dark" ref="modal" width="80%" v-if="showModal">
            <b> Previzualicion Del Documento.</b>
           <br /><br />
           <div class="embed-responsive embed-responsive-4by3 iframe">
            <center><iframe class="iframe" :src="url" frameborder="0"></iframe></center>
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
           typeContract: {type:String},
           typeDoc: {type:String},
           directoryName: { type: String},
           file: { type: String},
           ext: { type: String}
          },
  computed: {
    url: function () {

      if(this.typeContract == 'precontracts') { 
          if(this.ext == 'docx' || this.ext == 'pptx'|| this.ext == 'xls'){
             return 'https://view.officeapps.live.com/op/embed.aspx?src='+window.location.protocol+'//'+window.location.host+'/storage/docs/'+this.typeContract+'/'+this.directoryName + '/' + this.file
          }else{ 
             return window.location.protocol+'//'+window.location.host+'/storage/docs/'+this.typeContract+'/'+this.directoryName + '/' + this.file
           }
        }else{
            if(this.ext == 'docx' || this.ext == 'pptx'|| this.ext == 'xls'){
             return 'https://view.officeapps.live.com/op/embed.aspx?src='+window.location.protocol+'//'+window.location.host+'/storage/docs/'+this.typeContract+'/'+this.typeDoc+'/'+this.directoryName + '/' + this.file
          }else{ 
             return window.location.protocol+'//'+window.location.host+'/storage/docs/'+this.typeContract+'/'+this.typeDoc+'/'+this.directoryName + '/' + this.file
           }

        }

    }
  }, methods: {
       openModal: function() {
           this.showModal = true
           this.$refs.modal.open()

       }
     }
}

</script>

<style scoped>

 .iframe{
  width:100%;
   height:100%;
 }

</style>