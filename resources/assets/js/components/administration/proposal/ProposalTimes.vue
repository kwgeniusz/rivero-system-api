<template>
  <form class="input-label boxes2" style="margin-top: 30px">
    <div class="alert alert-danger " v-if="errors.length">
      <h4>Errores:</h4>
      <div v-for="error in errors">- {{ error }}</div>
    </div>
    <div class="input-label" style="display: flex; flex-wrap: wrap;">
      <!-- <div class="inputother" style="display: flex; align-items: center; flex-direction: column;">
        <div style="width: 48%;">
          <input style="position: relative; max-width: 10%; min-width: 10%;" type="radio" v-model="inputType" value="A" /> PRECARGADOS
        </div>
        <div style="width: 48%;">
          <input style="position: relative; max-width: 10%; min-width: 10%;" type="radio" v-model="inputType" value="B" /> LIBRE
        </div>
      </div> -->
      <div class="col-xs-offset-3 inputother"  v-if="timesList == ''">
        <label for="timeId">TIME FRAME</label>
        <select
          v-model="modelTimeId"
          class="form-control"
          name="timeId"
          id="timeId"
        >
          <option v-for="(item, index) in times" :value="item.timeId">
            {{ item.timeName }}</option
          >
        </select>
      </div>
      <!-- <div class="inputother" v-if="inputType == 'B'">
      <label for="timeName">TIME FRAME</label>
      <input
        v-model="modelTimeName"
        type="text"
        class="form-control"
        id="timeName"
        name="timeName"
        autocomplete="off"
      />
    </div> -->
    </div>
    <div style="display: flex; justify-content: center; align-items: flex-start;">
        <button v-if="timesList == ''"  class="submit buttonmovil" style="margin-top: 0px;" @click.prevent="addRow()">
          <span class="fa fa-plus" aria-hidden="true"></span> Agregar
        </button>
        <a class="submit buttonmovil" style="background: #eea508; margin-top: 0px; margin-left: 20px" href="/timeframes" role="button">
          <span class="fa fa-list" aria-hidden="true"></span> Timeframes
          </a>
      <div style="margin-left: 20px;" v-if="inputType == 'A'">
        <form-new-time pref-url="" @timecreated="getAllTimes()"></form-new-time>
      </div>
    </div>
    <div class="input-label">
      <h4><b>Time Frame</b></h4>
      <ul>
        <li v-for="(item, index) in timesList">
          <span v-html="nl2br(item.timeName, false)"></span>
          <a
            @click="deleteTime(++index)"
            class="supr"
            data-toggle="tooltip"
            data-placement="top"
            title="Eliminar"
          >
            <span class="fa fa-times-circle" aria-hidden="true"></span>
          </a>
        </li>
      </ul>
    </div>

    <!-- {{timesList}} -->
  </form>
</template>

<script>
import formNewTime from "./timeFrame/timeFormNew.vue";

export default {
  mounted() {
    console.log("Component Proposaltimes mounted.");
    // this.findproposal();
    this.getAllTimes();
    this.getProposalTimes();
  },
  data: function() {
    return {
      errors: [],

      times: {},
      timesList: {},

      // inputType: "A",
      modelTimeId: "",
      modelTimeName: "",
    };
  },
  props: {
    proposalId: { type: Number },
  },
  components: {
    formNewTime,
  },
  methods: {
    getAllTimes: function() {
      let url = "timeframes";
      axios.get(url).then((response) => {
        this.times = response.data;
      });
    },
    getProposalTimes: function() {
      let url = "proposals/" + this.proposalId + "/time-frames";

      axios.get(url).then((response) => {
        this.timesList = response.data;
      });
    },
    // selectNote: function (id){
    //     let url ='times/'+id;
    //     axios.get(url).then(response => {
    //       // console.log(response.data[0]);
    //      // this.modelTimeName = response.data[0].timeName;
    //     });
    // },
    /*----CRUD----- */
    addRow: function() {
      this.errors = [];

      // if (this.inputType == "A") {
        //VALIDATIONS
        if (!this.modelTimeId) this.errors.push("Debe Escoger un Time Frame.");

        if (!this.errors.length) {
          //BUSCAR EN ARREGLO DE JAVASCRIPT /SERVICE/ EL ID QUE SELECCIONO EL USUARIO PARA TRAER EL NOMBRE DEL SERVICIO
          let timeId = this.modelTimeId;

          function filtrarPorID(obj) {
            if ("timeId" in obj && obj.timeId == timeId) {
              return true;
            } else {
              return false;
            }
          }
          let timeSelected = this.times.filter(filtrarPorID);
          //AGREGAR A ITEMLIST
          //Nota al agregar el item debo meter un objeto con el nombre y el ID
          this.timesList.push({
            timeId: timeSelected[0].timeId,
            timeName: timeSelected[0].timeName,
          });
        } //end of the errors.length
      // } else {
      //   //end of de inputType A

      //   //VALIDATIONS
      //   if (!this.modelTimeName) this.errors.push("Debe Escribir un Texto.");

      //   if (!this.errors.length) {
      //     this.timesList.push({ timeId: null, timeName: this.modelTimeName });
      //     this.modelTimeName = "";
      //   }
      // } //end else
    }, //End of the function
    deleteTime: function(id) {
      this.timesList.splice(--id, 1);
    },
    sendTimes: function() {
      axios
        .post("proposals/" + this.proposalId + "/time-frames", {
          timesList: this.timesList,
        })
        .then((response) => {
          this.getProposalTimes();
          this.modelTimeId = "";
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
