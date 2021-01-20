<template>
  <div>
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
          <h3 class="text-center" v-if="modoEdicion">
            Editar Termino/Condicion
          </h3>
          <h3 class="text-center" v-else>Crear Termino/Condicion</h3>

          <!--Formulario para editar-->
          <form @submit.prevent="actualizar(TyC)" v-if="modoEdicion">
            <div class="form-group row col-sm-12">
              <label class="col-sm-3 col-form-label" for="termName"
                >Descripcion:</label
              >
              <div class="col-sm-9">
                <input
                  type="text"
                  placeholder="Escriba una descripcion..."
                  class="mb-2 form-control"
                  v-model="TyC.termName"
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
              <label class="col-sm-3 col-form-label" for="termName"
                >Descripcion:</label
              >
              <div class="col-sm-9">
                <input
                  type="text"
                  placeholder="Escriba una descripcion..."
                  class="mb-2 form-control"
                  v-model="TyC.termName"
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

    <h3 class="text-center">Listado de notas</h3>

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
                <tr v-for="(item, index) in allterms" :key="index">
                  <td>{{ index + 1 }}</td>
                  <td>
                    <p class="text-left">
                      {{ item.termName }}
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
      allterms: [],
      TyC: {
        termId: "",
        countryId: "",
        companyId: "",
        termName: "",
        deleted_at: "",
      },
      modoEdicion: false,
    };
  },
  created() {
    axios.get("/crud-term").then((res) => {
      this.allterms = res.data;
    });
  },
  methods: {
    crear() {
      if (this.TyC.termName.trim() === "") {
        alert(
          "Debes indicar un texto descriptivo para el Termino/Condicion antes de crearlo"
        );
        return;
      }
      const params = {
        countryId: this.TyC.countryId,
        companyId: this.TyC.companyId,
        termName: this.TyC.termName,
      };
      axios
        .post("/crud-term", params)
        .then((res) => {
          this.allterms.unshift(res.data);
        })
        .then(() => {
          this.TyC.countryId = "";
          this.TyC.companyId = "";
          this.TyC.termName = "";
        });
    },
    editar(item) {
      this.modoEdicion = true;
      this.TyC.countryId = item.countryId;
      this.TyC.companyId = item.companyId;
      this.TyC.termName = item.termName;
      this.TyC.termId = item.termId;
    },
    cancelarEdicion() {
      this.modoEdicion = false;
      this.TyC.countryId = "";
      this.TyC.companyId = "";
      this.TyC.termName = "";
    },
    actualizar(item) {
      const params = {
        countryId: item.countryId,
        companyId: item.companyId,
        termName: item.termName,
      };

      axios.put(`/crud-term/${item.termId}`, params).then((res) => {
        this.modoEdicion = false;

        //Correccion al error de actualizar listado de datos locales encontrado en el video, solucion
        //sacada de aqui: https://stackoverflow.com/a/35206193
        const foundIndex = this.allterms.findIndex(
          (item) => item.termId === res.data.termId
        );
        this.allterms[foundIndex] = res.data;

        this.TyC.countryId = "";
        this.TyC.companyId = "";
        this.TyC.termName = "";
      });
    },
    eliminar(item, index) {
      axios.delete(`/crud-term/${item.termId}`).then(() => {
        this.allterms.splice(index, 1); // https://youtu.be/QW4dMbFxv3c min 49:11
      });
    },
  },
};
</script>

<style></style>
