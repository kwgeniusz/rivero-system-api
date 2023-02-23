<template>
<div>

<!-- BUTTON PARA FORMULARIO MODAL DE COBRO DE CUOTA-->
           <a @click="modalMain()" class="btn btn-default btn-sm">
                <i class="fa fa-comments" aria-hidden="true"></i> Comentarios 
           </a>


<!-- COMIENZA CODIGO DE LA VENTANA MODAL PARA CREAR AL CLIENTE-->

 <sweet-modal ref="modal" width="90%">
    <h4 class="bg-warning text-principal"> 
    <b><i class="fa fa-comments"></i> Comentarios del Pre-contrato {{precontract.preId}}<br> 
    {{precontract.siteAddress}} </b></h4>

     <a @click="addComment()" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Crear Comentario">   <span class="fa fa-plus" aria-hidden="true"></span> 
     </a>

        <div class="row comment" v-for="(comment,index) in commentsList">
          <div class="col-xs-12">
            <p class="text-left" style="font-weight: bold"><i class="fa fa-user-circle"></i> {{comment.user.fullName}} - ({{comment.commentDate | moment('MM/DD/YYYY - hh:mm A') }})</p>
            <p class="text-left" v-html="nl2br(comment.commentContent,false) "></p>
          </div>
        </div>

        <div class="row comment">
          <div class="col-xs-12">
            <p class="text-left" style="font-weight: bold"><i class="fa fa-info-circle"></i> COMENTARIO INICIAL: ({{precontract.precontractDate | moment('MM/DD/YYYY - hh:mm A')  }})</p>
            <p class="text-left" v-html="nl2br(precontract.comment,false) "></p>
          </div>
        </div>
   </sweet-modal>


<sweet-modal ref="nestedChild">

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
           precontract: '',
           commentsList: {},

          //variables about the form
          formCommentContent:'',
          btnSubmitForm: true,
          errors:[],

          }
    },
    props: {
           prefUrl: { type: String},
           precontractId: { type: String, default: null}, 
           // contractNumber: { type: String, default: null}, 
          },
    methods: {
       modalMain: function() {
         //obtener los detalles del contrato
          axios.get(this.prefUrl+'precontracts/'+this.precontractId).then(response => {
                 this.precontract = response.data[0]
            });
           this.getAllComments();
           this.$refs.modal.open();

       },
       getAllComments: function(){
         //obtener los comentarios del contrato
          axios.get(this.prefUrl+'precontracts/'+this.precontractId+'/comments').then(response => {
                  this.commentsList = response.data
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
           var url =this.prefUrl+'precontracts/'+this.precontractId+'/comments';
            this.btnSubmitForm = false;

          axios.post(url,{
              precontractId: this.precontract.precontractId,
              commentContent: this.formCommentContent,
              commentTagId: 0
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
// @import '../../../sass/app.scss'
</style>


