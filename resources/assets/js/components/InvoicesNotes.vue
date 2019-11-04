
<template> 
    <form class="formNotes">
       <div class="alert alert-danger" v-if="errors.length">
            <h4>Errores:</h4>
                  <div v-for="error in errors">- {{ error }}</div>
         </div>

          <div class="form-group col-xs-10 col-xs-offset-1">
            <label for="noteId">NOTAS</label>
            <select v-model="modelNoteId" class="form-control" name="noteId" id="noteId">
                <option v-for="(item,index) in notes" :value="item.noteId" > {{item.noteName}}</option>
            </select>
          </div>

       <div class="form-group col-xs-12 text-center">
         <button class="btn btn-primary" @click.prevent="add()"> 
          <span class="fa fa-plus" aria-hidden="true"></span> Agregar Nota
        </button>
       </div>

    <div class="col-xs-12 text-left">
          <h4><b>Terminos y Condiciones</b></h4>
           <ul>
            <li v-for="note in listNotes">
              {{ note.noteName }}
              <a @click="deleteNoteSend(note.noteId)" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Eliminar">
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
            console.log('Component InvoicesNotes mounted.')
            // this.findInvoice();
            this.getAllNotes();
            this.getAllNotesForInvoice();
        },
    data: function() {
        return {
            errors: [],
            notes: {},
            listNotes:{},
            modelNoteId: '',
        }
    },
  props: {
           invoiceId: { type: String},
    },
    methods: {
         getAllNotes: function (){
            let url ='notes';
            axios.get(url).then(response => {
             this.notes = response.data
            });
        },
          getAllNotesForInvoice: function (){
            let url ='invoicesNotes?invoiceId='+this.invoiceId;
            axios.get(url).then(response => {
             this.listNotes = response.data
            });
        },
  /*----CRUD----- */
        add: function() {
           this.errors = [];
           //VALIDATIONS
               if (!this.modelNoteId) 
                this.errors.push('Debe Escoger una Nota.');
           
               // if (!this.modelServiceName) 
               //  this.errors.push('Campo Nombre de Servicio es Obligatorio.');

          if (!this.errors.length) { 

          axios.post('invoicesNotes/add',{
              invoiceId :  this.invoiceId,
              noteId :  this.modelNoteId,
            }).then(response => {
                       this.getAllNotesForInvoice();
                       this.modelNoteId = ''

                       if (response.data.alertType == 'info') {
                          toastr.info(response.data.message)
                       } else {
                          toastr.error(response.data.message)
                       }
            })
           }
         },
          deleteNoteSend: function(noteId) {
             let url ='invoicesNotes/'+this.invoiceId+'/remove/'+noteId;
             axios.delete(url).then(response => {
             this.getAllNotesForInvoice();

               if (response.data.alertType == 'info') {
                         toastr.info(response.data.message)
                       } else {
                          toastr.error(response.data.message)
                       }    
            });
          },
    }
       // this.$forceUpdate()
}
 </script>
  