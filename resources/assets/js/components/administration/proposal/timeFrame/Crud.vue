<template>
  <div class="create">
    <div class="formulario">
      <div>
        <h3 v-if="modoEdicion">Editar timeframe</h3>
        <h3 v-else>Crear timeframe</h3>
        <div class="boxes">
          <!--Formulario para editar-->
          <form style="width:100%;" @submit.prevent="actualizar(timeframe)" v-if="modoEdicion">
            <div class="input-label boxes2">
              <label for="timeName">Timeframe:</label>
                <input type="text" placeholder="Escriba una descripcion..." v-model="timeframe.timeName"/>
            </div>
              <!-- <div class="input-label boxes2">
              <label for="timeName">Dias Representados:</label>
                <input type="number" placeholder="Dias en Numero" v-model="timeframe.timeName"/>
            </div>  -->
            <div style="width: 100%; text-align: center;">
              <button class="submit" type="submit">Editar</button>
              <button class="submit"  style="background: #d60101;" @click="cancelarEdicion()">
                Cancelar
              </button>
            </div>
          </form>
          <!--Formulario para crear-->
          <form style=" width: 100%;" @submit.prevent="crear" v-else>
            <div class="input-label boxes2">
              <label for="timeName"
                >Timeframe:</label
              >
              <input type="text" placeholder="Escriba una descripcion..." v-model="timeframe.timeName"/>
              <input type="text" placeholder="Escriba una descripcion..." v-model="timeframe.timeName"/>
            </div>
            <div style="width: 100%; text-align: center;">
              <button class="submit" type="submit">
                Crear
              </button>
            </div>
          </form>
          <h3 style="width: 100%; margin-bottom: 20px;">Listado de timeframes</h3>
          <div class="table-responsive" style="width: 100%;">
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
                      class="return"
                      style="padding: 5px 10px;
                      margin: 0; 
                      background: #d60101;"
                      @click="eliminar(item, index)"
                    >
                      Eliminar
                    </button>
                    <button
                      class="return"
                      style="padding: 5px 10px;
                      margin: 0;"
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
    axios.get("/crud-timeframes").then((res) => {
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
        .post("/crud-timeframes", params)
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

      axios.put(`/crud-timeframes/${item.timeId}`, params).then((res) => {
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
      axios.delete(`/crud-timeframes/${item.timeId}`).then(() => {
        this.alltimeframes.splice(index, 1); // https://youtu.be/QW4dMbFxv3c min 49:11
      });
    },
  },
};
</script>
<style>
  .create {
  position: relative;
  padding: 40px;
  display: flex;
  justify-content: center;
  align-items: flex-start;
  background: #dadada;
  border-radius: 20px;
  flex-wrap: wrap;
}

.formulario {
  background: #fff;
  width: 80%;
  padding: 40px;
  border-radius: 20px;
  position: relative;
}
.formulario2 {
  background: #fff;
  width: 40%;
  padding: 40px;
  border-radius: 20px;
  position: relative;
  margin-left: 40px;
}
.title {
  font-weight: 400;
  color: rgb(134, 134, 134);
  padding: 20px 0px;
}

.boxes {
  border-top: 2px solid #ccc;
  width: 100%;
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
}
.input-label{
  position: relative;
  max-width: 100%;
  min-width: 100%;
  margin-bottom: 0px;
}
.input {
  position: relative;
  max-width: 48%;
  min-width: 48%;
  margin-bottom: 0px;
}
.inputother {
  position: relative;
  max-width: 48%;
  min-width: 48%;
  margin-bottom: 30px;
}
.textarea {
  position: relative;
  max-width: 48%;
  min-width: 48%;
  margin-bottom: 30px;
  display: flex;
  flex-direction: column;
}
input,
select {
  padding: 10px;
  border-radius: 5px;
  width: 100%;
  border: 1px solid #ccc;
  background: rgba(248, 248, 248, 0.815);
}

label {
  margin-bottom: 10px;
}
textarea {
  max-width: 100%;
  min-width: 100%;
  max-height: 100px;
  min-height: 100px;
}
.birthday {
  display: flex;
  flex-direction: column;
}

.submit {
  margin-top: 30px;
  font-size: 1em;
  padding: 10px 20px;
  background: #0062be;
  border: none;
  border-radius: 5px;
  color: #fff;
}
.return {
  margin-top: 30px;
  font-size: 1em;
  padding: 12px 20px;
  background: #eea508;
  border: none;
  border-radius: 5px;
  color: #fff;
  text-decoration: none;
}
.return:hover {
  text-decoration: none;
  color: #ffff;
}
.tableother {
  position: relative;
  max-width: 100%;
  min-width: 100%;
  margin-bottom: 10px;
}
@media (max-width: 500px) {
  .formulario, .formulario2 {
    width: 95%;
    padding: 10px;
    border-radius: 10px;
    margin-left: 0;
  }
  .formulario2 {
    margin-top: 20px;
  }
  .buttonmovil {
    padding: 5px 10px;
  }
  .create  {
    margin-top: 30px;
    margin-bottom: 30px;
    width: 95%;
    padding: 20px 0;
    border-radius: 10px;
  }

  .input {
    margin-bottom: 15px;
  }
 
  .inputother {
    margin-bottom: 15px;
  }

  input,
  select {
    border-radius: 3px;
  }

  label {
    margin-bottom: 5px;
    font-weight: 300;
    width: 150px;
    white-space: nowrap;
    text-overflow: ellipsis;
    overflow: hidden;
  }
}
</style>
