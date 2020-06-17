<template>
<div>



<!-- BUTTON PARA FORMULARIO MODAL DE COBRO DE CUOTA-->
           <a @click="modalMain()" class="btn btn-warning btn-sm">
                <span class="fa fa-book" aria-hidden="true">COMENTARIOS</span>  
           </a>
<!-- COMIENZA CODIGO DE LA VENTANA MODAL PARA CREAR AL CLIENTE-->
 <sweet-modal ref="modal" width="90%">
    <h4 class="bg-warning text-principal"> 
       <b>Comentarios del Contrato {{contractNumber}}<br> 
    {{contract.propertyNumber}} 
    {{contract.streetName}} 
    {{contract.streetType}} 
    {{contract.suiteNumber}} 
    {{contract.city}} 
    {{contract.state}} 
    {{contract.zipCode}}</b></h4>

     <a @click="addComment()" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Crear Comentario">   <span class="fa fa-plus" aria-hidden="true"></span> 
     </a>

        <div class="row comment" v-for="(comment,index) in commentsList">
          <div class="col-xs-12">
            <p class="text-left" style="font-weight: bold">{{comment.user.fullName}} - ({{comment.commentDate | moment("MM/DD/YYYY - hh:mm A")}})</p>
            <p class="text-left">{{comment.commentContent}}</p>
          </div>
        </div>
<!-- {{ new Date()  }} -->
        <div class="row comment">
          <div class="col-xs-12">
            <p class="text-left" style="font-weight: bold">COMENTARIO INICIAL: ({{contract.contractDate | moment("MM/DD/YYYY - hh:mm A") }})</p>
            <p class="text-left">{{contract.initialComment}}</p>
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
              .
        </div>
    </form>
</sweet-modal>






</div>   
</template>

<script>

    export default {
        
     mounted() {
           
           },
     data: function () {
          return {
           contract: '',
           commentsList: {},

          // variables about the form
          btnSubmitForm: true,
          formCommentContent:'',
          errors:[],
          }
    },
    props: {
           prefUrl: { type: String},
           contractId: { type: String, default: null}, 
           contractNumber: { type: String, default: null}, 
          },
    methods: {
       modalMain: function() {
         //llamar los detalles del contrato
          axios.get(this.prefUrl+'contracts/'+this.contractId+'/details').then(response => {
                 this.contract = response.data[0]
            });
           this.getAllComments();
           this.$refs.modal.open();

       },
       getAllComments: function(){
         //llamar las facturas activas del contrato, con detalles, notas, alcances
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
           var url =this.prefUrl+'comments';
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

            }).catch(e => {
               toastr.error("Error de Servidor:"+ e)
               this.btnSubmitForm = true;
              })
           }//end if error.length
       }
     }
}

</script>

<style scoped>

.text-principal{
  overflow-wrap: break-word;
}
.comment {
    font-size: 12px;
    overflow-wrap: break-word;
    white-space: normal;
     }


</style>