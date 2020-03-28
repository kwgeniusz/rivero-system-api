
<template> 
    <form class="formNotes">

     <div class="col-xs-12  alert alert-danger " v-if="errors.length">
            <h4>Errores:</h4>
                  <div v-for="error in errors">- {{ error }}</div>
      </div>

          <div class="form-group col-xs-10 col-xs-offset-1">
            <label for="noteId">NOTAS</label>
            <select v-model="modelNoteId"  @change="selectNote(modelNoteId)" class="form-control" name="noteId" id="noteId">
                <option v-for="(item,index) in notes" :value="item.noteId" > {{item.noteName}}</option>
            </select>
          </div>

           <div class="form-group col-xs-10 col-xs-offset-1">
            <label for="noteName">NOMBRE DE LA NOTA</label>
            <input v-model="modelNoteName" type="text" class="form-control" id="noteName" name="noteName"  autocomplete="off">
          </div>
          
       <div class="form-group text-center col-xs-12">
         <button class="btn btn-primary" @click.prevent="add()"> 
          <span class="fa fa-plus" aria-hidden="true"></span> Agregar Nota
         </button>
       </div>

    <div class="col-xs-12 text-left">
          <h4><b>Terminos y Condiciones</b></h4>
           <ul>
            <li v-for="note in listNotes">
              {{ note.noteName }}
              <a @click="deleteNote(note.propNoteId)" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Eliminar">
                <span class="fa fa-times-circle" aria-hidden="true"></span> 
            </a>
            </li>
          </ul>
    </div>


    </form>    
 </template>



 <script>
// import modalPreviewDocument from './ModalPreviewDocument.vue'
// import vueUpload from './vueUpload.vue'

export default {
        
     mounted() {
            console.log('Component ProposalNotes mounted.')
            // this.findproposal();
            this.getAllNotes();
            this.getProposalNotes();
        },
    data: function() {
        return {
            errors: [],
            
            notes: {},
            listNotes:{},

            modelNoteId: '',
            modelNoteName: '',
        }
    },
  props: {
           proposalId: { type: Number},
    },
    methods: {
         getAllNotes: function (){
            let url ='notes';
            axios.get(url).then(response => {
             this.notes = response.data
            });
        },
          getProposalNotes: function (){
            let url ='proposalsNotes/'+this.proposalId;
            // let url ='proposalsNotes?proposalId='+this.proposalId;
            axios.get(url).then(response => {
             this.listNotes = response.data
            });
        },
         selectNote: function (id){
            let url ='notes/'+id;
            axios.get(url).then(response => {
              // console.log(response.data[0]);
             this.modelNoteName = response.data[0].noteName;
            });
        },
  /*----CRUD----- */
        add: function() {
           this.errors = [];
           //VALIDATIONS
               if (!this.modelNoteId) 
                this.errors.push('Debe Escoger una Nota.');
                if (!this.modelNoteName) 
                this.errors.push('Campo Nombre de Nota es Obligatorio.');
              
          if (!this.errors.length) { 

          axios.post('proposalsNotes',{
              proposalId :  this.proposalId,
              noteId :  this.modelNoteId,
              noteName :  this.modelNoteName,
            }).then(response => {
                       this.getProposalNotes();
                       this.modelNoteId = ''
                       this.modelNoteName = ''

                       if (response.data.alertType == 'success') {
                          toastr.success(response.data.message)
                       } else {
                          toastr.error(response.data.message)
                       }
            })
           }
         },
          deleteNote: function(propNoteId) {
             let url ='proposalsNotes/'+propNoteId;
             axios.delete(url).then(response => {
             this.getProposalNotes();

               if (response.data.alertType == 'info') {
                         toastr.info(response.data.message)
                       } else {
                          toastr.error(response.data.message)
                       }    
            });
          },
    }
       // this.$ceUpdate()
}
 </script>
  