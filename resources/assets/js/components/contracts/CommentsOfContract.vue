<template>
<div>

<!-- BUTTON PARA FORMULARIO MODAL DE COBRO DE CUOTA-->
           <a @click="mainModal()" class="btn btn-default btn-sm">
                <i class="fa fa-comments" aria-hidden="true"></i> Comentarios 
           </a>

<!-- COMIENZA CODIGO DE LA VENTANA MODAL PARA CREAR AL CLIENTE-->
<!-- VENTANA MODAL PRINCIPAL PARA MOSTRAR LOS COMENTARIOS -->
 <sweet-modal ref="modal" width="90%">
    <h4 class="bg-warning text-principal"> 
       <b><i class="fa fa-comments"></i> Comentarios del Contrato {{contractNumber}}<br> 
       {{contract.siteAddress}} </b>
    </h4>

    <div class="tabs">
        <a v-on:click="activetab='precontract'" v-bind:class="[ activetab === 'precontract' ? 'active' : '' ]">Precontrato</a>
        <a v-on:click="activetab='all'" v-bind:class="[ activetab === 'all' ? 'active' : '' ]">Todos</a>

        <a v-for="tag in commentTagsList" :key="tag.commentTagId" @click="activetab = tag.commentTagId" :class="[ activetab === tag.commentTagId ? 'active' : '' ]">{{tag.commentTagName}}</a>
        <!-- <a v-on:click="activetab=1" v-bind:class="[ activetab === 1 ? 'active' : '' ]">Tab 1</a>
        <a v-on:click="activetab=2" v-bind:class="[ activetab === 2 ? 'active' : '' ]">Tab 2</a>
        <a v-on:click="activetab=3" v-bind:class="[ activetab === 3 ? 'active' : '' ]">Tab 3</a> -->
    </div>
  
  <!-- <v-select :options="commentTagsList" v-model="activetab" :reduce="commentTagsList => commentTagsList.commentTagId" label="commentTagName" />  -->
  
 <div class="content">
  <!-- SECTION PRECONTRACT COMMENTS -->
    <div v-if="activetab === 'precontract'" class="tabcontent">
        <div class="row comment" v-for="comment in contract.precontract.comments" :key="comment.commentId">
          <div class="col-xs-12">
            <p class="text-left" style="font-weight: bold"><i class="fa fa-user-circle"></i> {{comment.user.fullName}} - ({{comment.commentDate | moment('MM/DD/YYYY - hh:mm A')}})</p>
            <p class="text-left" v-html="nl2br(comment.commentContent,false) "> </p>
          </div>
        </div>
    </div>

<!-- SECTION ALL -->
    <div v-if="activetab === 'all'" class="tabcontent">

           <a @click="addCommentModal()" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Crear Comentario">   <span class="fa fa-plus" aria-hidden="true"></span> 
           </a>
        <div class="row comment" v-for="comment in commentListFiltered" :key="comment.commentId">
          <div class="col-xs-12">
            <p class="text-left" style="font-weight: bold"><i class="fa fa-user-circle"></i>{{comment.user.fullName}} - ({{comment.commentDate | moment('MM/DD/YYYY - hh:mm A')}}) <span v-if="comment.tag && comment.tag.commentTagName"> - [{{ comment.tag.commentTagName }}]</span></p>
            <p class="text-left" v-html="nl2br(comment.commentContent,false) "> </p>
          </div>
        </div>

        <div class="row comment">
          <div class="col-xs-12">
            <p class="text-left" style="font-weight: bold"><i class="fa fa-info-circle"></i>  COMENTARIO INICIAL: ({{contract.contractDate | moment('MM/DD/YYYY - hh:mm A') }})</p>
            <p class="text-left" v-html="nl2br(contract.initialComment,false) "></p>
          </div>
        </div>
    </div>

  <!-- SECTION LISTA DE TAGS -->
    <div v-for="tag in commentTagsList" :key="tag.commentTagId" v-if="activetab === tag.commentTagId" class="tabcontent">
          
          <a @click="addCommentModal()" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Crear Comentario">   <span class="fa fa-plus" aria-hidden="true"></span> 
           </a>
        <div class="row comment" v-for="comment in commentListFiltered" :key="comment.commentId">
          <div class="col-xs-12">
            <p class="text-left" style="font-weight: bold"><i class="fa fa-user-circle"></i> {{comment.user.fullName}} - ({{comment.commentDate | moment('MM/DD/YYYY - hh:mm A')}}) <span v-if="comment.tag && comment.tag.commentTagName"> - [{{ comment.tag.commentTagName }}]</span></p>
            <p class="text-left" v-html="nl2br(comment.commentContent,false) "> </p>
          </div>
        </div>

         <div class="row comment">
           <div class="col-xs-12">
             <p class="text-left" style="font-weight: bold"><i class="fa fa-info-circle"></i> COMENTARIO INICIAL: ({{contract.contractDate | moment('MM/DD/YYYY - hh:mm A') }})</p>
             <p class="text-left" v-html="nl2br(contract.initialComment,false) "></p>
          </div>
         </div>
    </div>
    </div>
</sweet-modal>

<!-- VENTANA MODAL SECUNDARIA PARA AGREGAR COMENTARIOS SEA POR AUDIO O TEXTO -->
<sweet-modal ref="nestedChild">
 <!-- <audio-recorder upload-url="some url" :attempts="3" :time="2"/> -->
<!-- <center>
   <div class="switch-field ">
      <input type="radio" :id="`switch_left_${componentNumber}`" :name="`radio_option_${componentNumber}`" value="yes" checked/>
      <label :for="`switch_left_${componentNumber}`">Texto</label>
      <input type="radio" :id="`switch_right_${componentNumber}`" :name="`radio_option_${componentNumber}`" value="no" />
      <label :for="`switch_right_${componentNumber}`">Audio</label>
    </div>
</center> -->

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
           commentList: [],
           commentTagsList:[
             {commentTagId: 'precontract',commentTagName: "Precontract"},
             {commentTagId: 'all', commentTagName: "Todos"},
           ],
           activetab: 0,

          // variables about the form
          errors:[],
          formCommentContent:'',
          btnSubmitForm: true,
          }
    },
  //   components: {
  //     Tabs,
  //     Tab
  // },
    props: {
           componentNumber: { type: Number},
           prefUrl: { type: String},
           contractId: { type: [String,Number], default: null}, 
           contractNumber: { type: String, default: null}, 
          },
      computed: {
            commentListFiltered: function () {

              if(this.activetab == 'all'){
                return this.commentList;
              }

              return this.commentList.filter((comment, index) => {
                 return comment.commentTagId == this.activetab; 
               });

            } //end of the function searchData
        },
    methods: {
       mainModal: function() {
         //obtener los detalles del contrato
          axios.get(this.prefUrl+'contracts/'+this.contractId).then(response => {
                 this.contract = response.data[0]
            });
           this.getAllComments();
           this.getAllCommentTags();
           this.$refs.modal.open();

       },
      addCommentModal: function() {
          this.$refs.nestedChild.open();
      },
      getAllComments: function(){
         //obtener los comentarios del contrato
          axios.get(this.prefUrl+'contracts/'+this.contractId+'/comments').then(response => {
                  this.commentList = response.data
                  console.log(this.commentList)
               
            });
       },
      getAllCommentTags: function(){
         //obtener los comentarios del contrato
          axios.get(this.prefUrl+'comment-tags').then(response => {
                  this.commentTagsList = response.data
                  // console.log(this.commentTagsList)
            });
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
              commentContent: this.formCommentContent,
              commentTagId: this.activetab
            }).then(response => {

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
       chanceSelectedTab: function (value) {
         this.currentTab = value
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