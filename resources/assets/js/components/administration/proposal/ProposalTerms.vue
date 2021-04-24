<template> 
    <form class="input-label boxes2" style="margin-top: 30px">
      <div class="alert alert-danger " v-if="errors.length">
        <h4>Errores:</h4>
        <div v-for="error in errors">- {{ error }}</div>
      </div>
      <div class="input-label" style="display: flex; flex-wrap: wrap;">
        <div class="inputother" style="display: flex; align-items: center; flex-direction: column;">
          <div style="width: 48%;">
            <input style="position: relative; max-width: 10%; min-width: 10%;" type="radio" v-model="inputType" value="A"> PRECARGADOR
          </div>
          <div style="width: 48%;">
            <input style="position: relative; max-width: 10%; min-width: 10%;" type="radio" v-model="inputType" value="B"> LIBRE
          </div>
        </div>
        <div class="inputother" v-if="inputType == 'A'">
          <label for="termId">T&C</label>
          <select v-model="modelTermId"  class="form-control" name="termId" id="termId">
              <option v-for="(item,index) in notes" :value="item.termId" > {{item.termName}}</option>
          </select>
        </div>
        <div class="inputother" v-if="inputType == 'B'">
          <label for="termName">T&C</label>
          <input v-model="modelTermName" type="text" class="form-control" id="termName" name="termName"  autocomplete="off">
        </div>
      </div>  
      <div style="display: flex; justify-content: center; align-items: flex-start;">
        <button class="submit buttonmovil" style="margin-top: 0px;" @click.prevent="addRow()"> 
          <span class="fa fa-plus" aria-hidden="true"></span> Agregar
        </button>
        <a class="submit buttonmovil" style="background: #eea508; margin-top: 0px; margin-left: 20px" href="/crud-term" role="button">
          <span class="fa fa-list" aria-hidden="true"></span> Term&Cond</a>
        <div style="margin-left: 20px;" v-if="inputType == 'A'">
          <form-new-term pref-url='' @termcreated='getAllTerms()'/>
        </div>   
      </div>
      <div class="input-label">
        <h4><b>Terminos y Condiciones</b></h4>
          <ul>
            <li v-for="(note,index) in termsList">
              <span v-html="nl2br(note.termName,false) "></span> 
              <a @click="deleteTerm(++index)" class="supr" data-toggle="tooltip" data-placement="top" title="Eliminar">
                <span class="fa fa-times-circle" aria-hidden="true"></span> 
              </a>
            </li>
        </ul>
      </div>
    </form>    
 </template>



 <script>
import formNewTerm from './term/termFormNew.vue'


export default {
  mounted() {
    console.log("Component ProposalNotes mounted.");
    // this.findproposal();
    this.getAllTerms();
    this.getProposalTerms();
  },
  data: function() {
    return {
      errors: [],

      notes: {},
      termsList: {},

      inputType: "A",
      modelTermId: "",
      modelTermName: "",
    };
  },
  props: {
    proposalId: { type: Number },
  },
  components: {
    formNewTerm,
  },
  methods: {
    getAllTerms: function() {
      let url = "terms";
      axios.get(url).then((response) => {
        this.notes = response.data;
      });
    },
    getProposalTerms: function() {
      let url = "proposals/" + this.proposalId + "/terms";

      axios.get(url).then((response) => {
        this.termsList = response.data;
      });
    },
    // selectNote: function (id){
    //     let url ='notes/'+id;
    //     axios.get(url).then(response => {
    //       // console.log(response.data[0]);
    //      // this.modelTermName = response.data[0].termName;
    //     });
    // },
    /*----CRUD----- */
    addRow: function() {
      this.errors = [];

      if (this.inputType == "A") {
        //VALIDATIONS
        if (!this.modelTermId)
          this.errors.push("Debe Escoger un elemento de la lista.");

        if (!this.errors.length) {
          //BUSCAR EN ARREGLO DE JAVASCRIPT /SERVICE/ EL ID QUE SELECCIONO EL USUARIO PARA TRAER EL NOMBRE DEL SERVICIO
          let termId = this.modelTermId;

          function filtrarPorID(obj) {
            if ("termId" in obj && obj.termId == termId) {
              return true;
            } else {
              return false;
            }
          }
          let termSelected = this.notes.filter(filtrarPorID);
          //AGREGAR A ITEMLIST
          //Nota al agregar el item debo meter un objeto con el nombre y el ID
          this.termsList.push({
            termId: termSelected[0].termId,
            termName: termSelected[0].termName,
          });
        } //end of the errors.length
      } else {
        //end of de inputType A

        //VALIDATIONS
        if (!this.modelTermName) this.errors.push("Debe Escribir un Texto.");

        if (!this.errors.length) {
          this.termsList.push({ termId: null, termName: this.modelTermName });
          this.modelTermName = "";
        }
      } //end else
    }, //End of the function
    deleteTerm: function(id) {
      this.termsList.splice(--id, 1);
    },
    sendTerms: function() {
      axios
        .post("proposals/" + this.proposalId + "/terms", {
          // proposalId :  this.proposalId,
          termsList: this.termsList,
        })
        .then((response) => {
          this.getProposalTerms();
          this.modelTermId = "";
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
