<template> 
  <form class="input-label boxes2" style="margin-top: 30px;">

    <div class="alert alert-danger " v-if="errors.length">
      <h4>Errores:</h4>
      <div v-for="error in errors">- {{ error }}</div>
    </div>
    
    <div class="input-label" style="display: flex; flex-wrap: wrap;">
      <div class="inputother" style="display: flex; align-items: center; flex-direction: column;">
        <div style="width: 48%">
          <input style="position: relative; max-width: 10%; min-width: 10%;" type="radio" v-model="inputType" value="A"> PRECARGADOR
        </div>
        <div style="width: 48%">
          <input style="position: relative; max-width: 10%; min-width: 10%;" type="radio" v-model="inputType" value="B"> LIBRE
        </div>
      </div>
      <div class="inputother" v-if="inputType == 'A'">
        <label for="noteId">NOTA</label>
        <select v-model="modelNoteId"  class="form-control" name="noteId" id="noteId">
            <option v-for="(item,index) in notes" :value="item.noteId" > {{item.noteName}}</option>
        </select>
      </div>
    <div class="inputother" v-if="inputType == 'B'">
      <label for="noteName">NOTA</label>
      <input v-model="modelNoteName" type="text" class="form-control" id="noteName" name="noteName"  autocomplete="off">
    </div>
    </div>
    <div style="display: flex; justify-content: center; align-items: flex-start;">
      <button class="submit buttonmovil" style="margin-top: 0px" @click.prevent="addRow()"> 
        <span class="fa fa-plus" aria-hidden="true"></span> Agregar
      </button>
      <a class="submit buttonmovil" style="background: #eea508; margin-top: 0px; margin-left: 20px" href="/notes" role="button">
          <span class="fa fa-list" aria-hidden="true"></span> Notas</a>
      <div style="margin-left: 20px;" v-if="inputType == 'A'">
        <form-new-note pref-url='' @notecreated='getAllNotes()'></form-new-note> 
      </div>
    </div>
    <div class="input-label">
          <h4><b>Notas</b></h4>
            <ul>
            <li v-for="(note,index) in notesList">
                 <a @click="deleteNote(++index)" class="supr" data-toggle="tooltip" data-placement="top" title="Eliminar">
                <span class="fa fa-times-circle" aria-hidden="true"></span> 
              </a>
              <span v-html="nl2br(note.noteName,false) "></span> 
           
            </li>
          </ul>
    </div>
  </form>
</template>


 <script>
import formNewNote from './note/noteFormNew.vue'


export default {
  mounted() {
    console.log("Component ProposalNotes mounted.");
    // this.findproposal();
    this.getAllNotes();
    this.getProposalNotes();
  },
  data: function() {
    return {
      errors: [],

      notes: {},
      notesList: {},

      inputType: "A",
      modelNoteId: "",
      modelNoteName: "",
    };
  },
  props: {
    proposalId: { type: Number },
  },
  components: {
    formNewNote,
  },
  methods: {
    getAllNotes: function() {
      let url = "notes";
      axios.get(url).then((response) => {
        this.notes = response.data;
      });
    },
    getProposalNotes: function() {
      let url = "proposals/" + this.proposalId + "/notes";

      axios.get(url).then((response) => {
        this.notesList = response.data;
      });
    },
    // selectNote: function (id){
    //     let url ='notes/'+id;
    //     axios.get(url).then(response => {
    //       // console.log(response.data[0]);
    //      // this.modelNoteName = response.data[0].noteName;
    //     });
    // },
    /*----CRUD----- */
    addRow: function() {
      this.errors = [];

      if (this.inputType == "A") {
        //VALIDATIONS
        if (!this.modelNoteId) this.errors.push("Debe Escoger una Nota.");

        if (!this.errors.length) {
          //BUSCAR EN ARREGLO DE JAVASCRIPT /SERVICE/ EL ID QUE SELECCIONO EL USUARIO PARA TRAER EL NOMBRE DEL SERVICIO
          let noteId = this.modelNoteId;

          function filtrarPorID(obj) {
            if ("noteId" in obj && obj.noteId == noteId) {
              return true;
            } else {
              return false;
            }
          }
          let noteSelected = this.notes.filter(filtrarPorID);
          //AGREGAR A ITEMLIST
          //Nota al agregar el item debo meter un objeto con el nombre y el ID
          this.notesList.push({
            noteId: noteSelected[0].noteId,
            noteName: noteSelected[0].noteName,
          });
        } //end of the errors.length
      } else {
        //end of de inputType A

        //VALIDATIONS
        if (!this.modelNoteName) this.errors.push("Debe Escribir una Nota.");

        if (!this.errors.length) {
          this.notesList.push({ noteId: null, noteName: this.modelNoteName });
          this.modelNoteName = "";
        }
      } //end else
    }, //End of the function
    deleteNote: function(id) {
      this.notesList.splice(--id, 1);
    },
    sendNotes: function() {
      axios
        .post("proposals/" + this.proposalId + "/notes", {
          notesList: this.notesList,
        })
        .then((response) => {
          this.getProposalNotes();
          this.modelNoteId = "";
          if (response.data.alertType == "success") {
            toastr.success(response.data.message);
          } else {
            toastr.error(response.data.message);
          }
        });
    },
    nl2br: function(str, is_xhtml) {
      if (typeof str === "undefined" || str === null) {
        return "";
      }
      var breakTag =
        is_xhtml || typeof is_xhtml === "undefined" ? "<br />" : "<br>";
      return (str + "").replace(
        /([^>\r\n]?)(\r\n|\n\r|\r|\n)/g,
        "$1" + breakTag + "$2"
      );
    },
  },
  // this.$forceUpdate()
};
</script>
