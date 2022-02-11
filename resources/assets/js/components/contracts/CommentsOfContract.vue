<template>
<div>

<!-- BUTTON PARA FORMULARIO MODAL DE COBRO DE CUOTA-->
           <a @click="modalMain()" class="btn btn-default btn-sm">
                <i class="fa fa-comments" aria-hidden="true"></i> Comentarios 
           </a>


<!-- COMIENZA CODIGO DE LA VENTANA MODAL PARA CREAR AL CLIENTE-->
<!-- VENTANA MODAL PRINCIPAL PARA MOSTRAR LOS COMENTARIOS -->
 <sweet-modal ref="modal" width="90%">
    <h4 class="bg-warning text-principal"> 
    <b><i class="fa fa-comments"></i> Comentarios del Contrato {{contractNumber}}<br> 
    {{contract.siteAddress}} </b></h4>

     <a @click="addComment()" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Crear Comentario">   <span class="fa fa-plus" aria-hidden="true"></span> 
     </a>

        <div class="row comment" v-for="comment in commentsList">
          <div class="col-xs-12">
            <p class="text-left" style="font-weight: bold"><i class="fa fa-user-circle"></i> {{comment.user.fullName}} - ({{comment.commentDate | moment('MM/DD/YYYY - hh:mm A')}})</p>
            <p class="text-left" v-html="nl2br(comment.commentContent,false) "> sfsdfasdfas</p>
          </div>
        </div>

        <div class="row comment">
          <div class="col-xs-12">
            <p class="text-left" style="font-weight: bold"><i class="fa fa-info-circle"></i> COMENTARIO INICIAL: ({{contract.contractDate | moment('MM/DD/YYYY - hh:mm A') }})</p>
            <p class="text-left" v-html="nl2br(contract.initialComment,false) "></p>
          </div>
        </div>
   </sweet-modal>

<!-- VENTANA MODAL SECUNDARIA PARA AGREGAR COMENTARIOS SEA POR AUDIO O TEXTO -->
<sweet-modal ref="nestedChild">

 <!-- <audio-recorder upload-url="some url" :attempts="3" :time="2"/> -->
<center>
   <div class="switch-field ">
      <input type="radio" :id="`switch_left_${componentNumber}`" :name="`radio_option_${componentNumber}`" value="yes" checked/>
      <label :for="`switch_left_${componentNumber}`">Texto</label>
      <input type="radio" :id="`switch_right_${componentNumber}`" :name="`radio_option_${componentNumber}`" value="no" />
      <label :for="`switch_right_${componentNumber}`">Audio</label>
    </div>
</center>

         <div class="alert alert-danger" v-if="errors.length">
            <h4>Errores:</h4>
            <ul>
             <li v-for="error in errors">{{ error }}</li>
            </ul>
          </div>

    <form  v-on:submit.prevent="sendForm()">
        <div class="col-xs-12">
             <div class="form-group">
                <label for="commentContent">Ingrese un Comentario:</label>
                <textarea class="form-control" v-model="formCommentContent" rows="3"></textarea>
              </div>
              <input class="btn btn-primary" type="submit" value="Agregar" v-if="btnSubmitForm">
              <br>
        </div>
    </form>
</sweet-modal>

</div>   
</template>

<script>
    export default {
        
     mounted() {
          // this.$moment.tz.setDefault('UTC')
           },
     data: function () {
          return {
           contract: '',
           commentsList: '',

          // variables about the form
          btnSubmitForm: true,
          formCommentContent:'',
          errors:[],
          }
    },
    props: {
           componentNumber: { type: Number},
           prefUrl: { type: String},
           contractId: { type: [String,Number], default: null}, 
           contractNumber: { type: String, default: null}, 
          },
    methods: {
       modalMain: function() {
         //obtener los detalles del contrato
          axios.get(this.prefUrl+'contracts/'+this.contractId).then(response => {
                 this.contract = response.data[0]
            });
           this.getAllComments();
           this.$refs.modal.open();

       },
       getAllComments: function(){
         //obtener los comentarios del contrato
          axios.get(this.prefUrl+'contracts/'+this.contractId+'/comments').then(response => {

                  this.commentsList = response.data
                 // console.log(this.commentsList);
            });

       },
       addComment: function() {
           this.$refs.nestedChild.open();
       },
       sendForm: function() {

           this.errors = [];

           if (!this.formCommentContent) {
                this.errors.push('Debe Escribir un Comentario.');
           }

      if (!this.errors.length) { 
           var url =this.prefUrl+'contracts/'+this.contractId+'/comments';
            this.btnSubmitForm = false;

          axios.post(url,{
              contractId: this.contract.contractId,
              commentContent: this.formCommentContent
            }).then(response => {
              // console.log(response)

               toastr.info(response.data.message)
               this.formCommentContent = "";
               this.getAllComments();

               this.$refs.nestedChild.close();
               this.btnSubmitForm = true;

            }).catch(e => {
               toastr.error("Error de Servidor:"+ e)
               this.btnSubmitForm = true;
              })
           }//end if error.length
       },
       nl2br: function(str, is_xhtml) {
        if (typeof str === 'undefined' || str === null) {
              return '';
         }
      var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
      return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
      },
     }
}

</script>

<style lang="scss">
@import '../../../sass/app.scss'
</style>