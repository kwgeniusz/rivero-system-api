<template>
  <div>
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
          <h3 class="text-center" v-if="modoEdicion">Editar timeframe</h3>
          <h3 class="text-center" v-else>Crear timeframe</h3>

          <!--Formulario para editar-->
          <form @submit.prevent="actualizar(timeframe)" v-if="modoEdicion">
            <div class="form-group row col-sm-12">
              <label class="col-sm-3 col-form-label" for="timeName"
                >Timeframe:</label
              >
              <div class="col-sm-9">
                <input
                  type="text"
                  placeholder="Escriba una descripcion..."
                  class="mb-2 form-control"
                  v-model="timeframe.timeName"
                />
              </div>
            </div>
            <div class="row">
              <div class="col text-center">
                <button class="btn btn-warning" type="submit">Editar</button>
                <button class="btn btn-success" @click="cancelarEdicion()">
                  Cancelar
                </button>
              </div>
            </div>
          </form>

          <!--Formulario para crear-->
          <form @submit.prevent="crear" v-else>
            <div class="form-group row col-sm-12">
              <label class="col-sm-3 col-form-label" for="timeName"
                >Timeframe:</label
              >
              <div class="col-sm-9">
                <input
                  type="text"
                  placeholder="Escriba una descripcion..."
                  class="mb-2 form-control"
                  v-model="timeframe.timeName"
                />
              </div>
            </div>
            <div class="row">
              <div class="col text-center">
                <button class="btn btn-primary" type="submit">
                  Crear
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <h3 class="text-center">Listado de timeframes</h3>

    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
          <div class="table-responsive text-center">
            <table class="table table-striped table-bordered text-center">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Descripcion</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item, index) in alltimeframes" :key="index">
                  <td>{{ index + 1 }}</td>
                  <td>
                    <p class="text-left">
                      {{ item.timeName }}
                    </p>
                  </td>
                  <td>
                    <button
                      class="'btn btn-danger btn-sm"
                      @click="eliminar(item, index)"
                    >
                      Eliminar
                    </button>
                    <button
                      class="'btn btn-warning btn-sm"
                      @click="editar(item)"
                    >
                      Editar
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      alltimeframes: [],
      timeframe: {
        timeId: "",
        countryId: "",
        companyId: "",
        timeName: "",
        deleted_at: "",
      },
      modoEdicion: false,
    };
  },
  created() {
    axios.get("/timeframes").then((res) => {
      this.alltimeframes = res.data;
    });
  },
  methods: {
    crear() {
      if (this.timeframe.timeName.trim() === "") {
        alert(
          "Debes indicar un texto descriptivo para el timeframe antes de crearlo"
        );
        return;
      }
      const params = {
        countryId: this.timeframe.countryId,
        companyId: this.timeframe.companyId,
        timeName: this.timeframe.timeName,
      };
      axios
        .post("/timeframes", params)
        .then((res) => {
          this.alltimeframes.unshift(res.data);
        })
        .then(() => {
          this.timeframe.countryId = "";
          this.timeframe.companyId = "";
          this.timeframe.timeName = "";
        });
    },
    editar(item) {
      this.modoEdicion = true;
      this.timeframe.countryId = item.countryId;
      this.timeframe.companyId = item.companyId;
      this.timeframe.timeName = item.timeName;
      this.timeframe.timeId = item.timeId;
    },
    cancelarEdicion() {
      this.modoEdicion = false;
      this.timeframe.countryId = "";
      this.timeframe.companyId = "";
      this.timeframe.timeName = "";
    },
    actualizar(item) {
      const params = {
        countryId: item.countryId,
        companyId: item.companyId,
        timeName: item.timeName,
      };

      axios.put(`/timeframes/${item.timeId}`, params).then((res) => {
        this.modoEdicion = false;

        //Correccion al error de actualizar listado de datos locales encontrado en el video, solucion
        //sacada de aqui: https://stackoverflow.com/a/35206193
        const foundIndex = this.alltimeframes.findIndex(
          (item) => item.timeId === res.data.timeId
        );
        this.alltimeframes[foundIndex] = res.data;

        this.timeframe.countryId = "";
        this.timeframe.companyId = "";
        this.timeframe.timeName = "";
      });
    },
    eliminar(item, index) {
      axios.delete(`/timeframes/${item.timeId}`).then(() => {
        this.alltimeframes.splice(index, 1); // https://youtu.be/QW4dMbFxv3c min 49:11
      });
    },
  },
};
</script>

<style></style>
