
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

       <!--     <div class="form-group col-xs-10 col-xs-offset-1">
            <label for="noteName">NOMBRE DE LA NOTA</label>
            <input v-model="modelNoteName" type="text" class="form-control" id="noteName" name="noteName"  autocomplete="off">
          </div>
           -->

           
       <div class="form-group text-center col-xs-12">
         <button class="btn btn-primary" @click.prevent="addRow()"> 
          <span class="fa fa-plus" aria-hidden="true"></span> Agregar Nota
         </button>
          <form-new-note pref-url='' @notecreated='getAllNotes()'></form-new-note>
       </div>

    <div class="col-xs-12 text-left">
          <h4><b>Terminos y Condiciones</b></h4>
           <ul>
            <li v-for="note in notesList">
              {{ note.noteName }}
              <a @click="deleteNote(++index)" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Eliminar">
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
            console.log('Component InvoiceNotes mounted.')
            // this.findInvoice();
            this.getAllNotes();
            this.getInvoiceNotes();
        },
    data: function() {
        return {
            errors: [],
            
            notes: {},
            notesList:{},

            modelNoteId: '',
            // modelNoteName: '',
        }
    },
  props: {
           invoiceId: { type: Number},
    },
    methods: {
         getAllNotes: function (){
            let url ='notes';
            axios.get(url).then(response => {
             this.notes = response.data
            });
        },
          getInvoiceNotes: function (){
            let url ='invoicesNotes/'+this.invoiceId;
            axios.get(url).then(response => {
             this.notesList = response.data
            });
        },
         selectNote: function (id){
            let url ='notes/'+id;
            axios.get(url).then(response => {
              // console.log(response.data[0]);
             // this.modelNoteName = response.data[0].noteName;
            });
        },
  /*----CRUD----- */
        addRow: function() {
           this.errors = [];
           //VALIDATIONS
               if (!this.modelNoteId) 
                this.errors.push('Debe Escoger una Nota.');
                // if (!this.modelNoteName) 
                // this.errors.push('Campo Nombre de Nota es Obligatorio.');
              
          if (!this.errors.length) { 
          //BUSCAR EN ARREGLO DE JAVASCRIPT /SERVICE/ EL ID QUE SELECCIONO EL USUARIO PARA TRAER EL NOMBRE DEL SERVICIO
        let noteId = this.modelNoteId;
    
        function filtrarPorID(obj) {
          if ('noteId' in obj && obj.noteId == noteId) {
            return true;
          } else {
            return false;
          }
        }
        let noteSelected = this.notes.filter(filtrarPorID);
            //AGREGAR A ITEMLIST
              //Nota al agregar el item debo meter un objeto con el nombre y el ID
                 this.notesList.push({
                                     noteId:noteSelected[0].noteId,
                                     noteName:noteSelected[0].noteName,
                                   });
           }
         },
         deleteNote: function(id) {
                 this.notesList.splice(--id,1);
          },
        sendNotes: function() {
            axios.post('invoicesNotes',{
              invoiceId :  this.invoiceId,
              notesList:   this.notesList,
            }).then(response => {
                       this.getInvoiceNotes();
                       this.modelNoteId = '';
                       if (response.data.alertType == 'success') {
                         toastr.success(response.data.message)
                       } else {
                          toastr.error(response.data.message)
                       }
            })
           
      },
    }
       // this.$ceUpdate()
}
 </script>
  