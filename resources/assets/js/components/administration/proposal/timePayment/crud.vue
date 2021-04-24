<template>
  <div>
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
          <h3 class="text-center" v-if="modoEdicion">
            Editar momento de pago
          </h3>
          <h3 class="text-center" v-else>Crear momento de pago</h3>

          <!--Formulario para editar-->
          <form @submit.prevent="actualizar(timepayment)" v-if="modoEdicion">
            <div class="form-group row col-sm-12">
              <label class="col-sm-3 col-form-label" for="timeName"
                >Descripcion:</label
              >
              <div class="col-sm-9">
                <input
                  type="text"
                  placeholder="Escriba una descripcion..."
                  class="mb-2 form-control"
                  v-model="timepayment.timeName"
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
                >Descripcion:</label
              >
              <div class="col-sm-9">
                <input
                  type="text"
                  placeholder="Escriba una descripcion..."
                  class="mb-2 form-control"
                  v-model="timepayment.timeName"
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

    <h3 class="text-center">Listado de momentos de pago</h3>

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
                <tr v-for="(item, index) in alltimepayments" :key="index">
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
      alltimepayments: [],
      timepayment: {
        timePaymentId: "",
        countryId: "",
        companyId: "",
        timeName: "",
        deleted_at: "",
      },
      modoEdicion: false,
    };
  },
  created() {
    axios.get("/crud-timepayments").then((res) => {
      this.alltimepayments = res.data;
    });
  },
  methods: {
    crear() {
      if (this.timepayment.timeName.trim() === "") {
        alert(
          "Debes indicar un texto descriptivo para el tiempo de pago antes de crearlo"
        );
        return;
      }
      const params = {
        countryId: this.timepayment.countryId,
        companyId: this.timepayment.companyId,
        timeName: this.timepayment.timeName,
      };
      axios
        .post("/crud-timepayments", params)
        .then((res) => {
          this.alltimepayments.unshift(res.data);
        })
        .then(() => {
          this.timepayment.countryId = "";
          this.timepayment.companyId = "";
          this.timepayment.timeName = "";
        });
    },
    editar(item) {
      this.modoEdicion = true;
      this.timepayment.countryId = item.countryId;
      this.timepayment.companyId = item.companyId;
      this.timepayment.timeName = item.timeName;
      this.timepayment.timePaymentId = item.timePaymentId;
    },
    cancelarEdicion() {
      this.modoEdicion = false;
      this.timepayment.countryId = "";
      this.timepayment.companyId = "";
      this.timepayment.timeName = "";
    },
    actualizar(item) {
      const params = {
        countryId: item.countryId,
        companyId: item.companyId,
        timeName: item.timeName,
      };

      axios
        .put(`/crud-timepayments/${item.timePaymentId}`, params)
        .then((res) => {
          this.modoEdicion = false;

          //Correccion al error de actualizar listado de datos locales encontrado en el video, solucion
          //sacada de aqui: https://stackoverflow.com/a/35206193
          const foundIndex = this.alltimepayments.findIndex(
            (item) => item.timePaymentId === res.data.timePaymentId
          );
          this.alltimepayments[foundIndex] = res.data;

          this.timepayment.countryId = "";
          this.timepayment.companyId = "";
          this.timepayment.timeName = "";
        });
    },
    eliminar(item, index) {
      axios.delete(`/crud-timepayments/${item.timePaymentId}`).then(() => {
        this.alltimepayments.splice(index, 1); // https://youtu.be/QW4dMbFxv3c min 49:11
      });
    },
  },
};
</script>

<style></style>
