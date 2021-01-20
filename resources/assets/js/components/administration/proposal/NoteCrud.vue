<template>
  <div>
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
          <h3 class="text-center" v-if="modoEdicion">Editar nota</h3>
          <h3 class="text-center" v-else>Crear nota</h3>

          <!--Formulario para editar-->
          <form @submit.prevent="actualizar(note)" v-if="modoEdicion">
            <div class="form-group row col-sm-12">
              <label class="col-sm-3 col-form-label" for="noteName"
                >Nota:</label
              >
              <div class="col-sm-9">
                <input
                  type="text"
                  placeholder="Escriba una descripcion..."
                  class="mb-2 form-control"
                  v-model="note.noteName"
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
              <label class="col-sm-3 col-form-label" for="noteName"
                >Nota:</label
              >
              <div class="col-sm-9">
                <input
                  type="text"
                  placeholder="Escriba una descripcion..."
                  class="mb-2 form-control"
                  v-model="note.noteName"
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
                <tr v-for="(item, index) in allnotes" :key="index">
                  <td>{{ index + 1 }}</td>
                  <td>
                    <p class="text-left">
                      {{ item.noteName }}
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
      allnotes: [],
      note: {
        noteId: "",
        countryId: "",
        companyId: "",
        noteName: "",
        deleted_at: "",
      },
      modoEdicion: false,
    };
  },
  created() {
    axios.get("/crud-notes").then((res) => {
      this.allnotes = res.data;
    });
  },
  methods: {
    crear() {
      if (this.note.noteName.trim() === "") {
        alert(
          "Debes indicar un texto descriptivo para la nota antes de crearla"
        );
        return;
      }
      const params = {
        countryId: this.note.countryId,
        companyId: this.note.companyId,
        noteName: this.note.noteName,
      };
      axios
        .post("/crud-notes", params)
        .then((res) => {
          this.allnotes.unshift(res.data);
        })
        .then(() => {
          this.note.countryId = "";
          this.note.companyId = "";
          this.note.noteName = "";
        });
    },
    editar(item) {
      this.modoEdicion = true;
      this.note.countryId = item.countryId;
      this.note.companyId = item.companyId;
      this.note.noteName = item.noteName;
      this.note.noteId = item.noteId;
    },
    cancelarEdicion() {
      this.modoEdicion = false;
      this.note.countryId = "";
      this.note.companyId = "";
      this.note.noteName = "";
    },
    actualizar(item) {
      const params = {
        countryId: item.countryId,
        companyId: item.companyId,
        noteName: item.noteName,
      };

      axios.put(`/crud-notes/${item.noteId}`, params).then((res) => {
        this.modoEdicion = false;

        //Correccion al error de actualizar listado de datos locales encontrado en el video, solucion
        //sacada de aqui: https://stackoverflow.com/a/35206193
        const foundIndex = this.allnotes.findIndex(
          (item) => item.noteId === res.data.noteId
        );
        this.allnotes[foundIndex] = res.data;

        this.note.countryId = "";
        this.note.companyId = "";
        this.note.noteName = "";
      });
    },
    eliminar(item, index) {
      axios.delete(`/crud-notes/${item.noteId}`).then(() => {
        this.allnotes.splice(index, 1); // https://youtu.be/QW4dMbFxv3c min 49:11
      });
    },
  },
};
</script>

<style></style>
