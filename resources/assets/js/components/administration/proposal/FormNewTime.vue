<template>
<div class="margindiv">

<!-- COMIENZA CODIGO DE LA VENTANA MODAL PARA CREAR AL NOTA-->
<a  class="submit paddingpro" style="background: green;" @click="openModal()"><span class="fa fa-plus" aria-hidden="true"></span> Crear</a>

 <sweet-modal ref="modalNewTime">
    <form class="form form-prevent-multiple-submits">

    <h3 class="bg-success"><b>NUEVO TIME FRAME</b></h3>
     <br>
       <div class="alert alert-danger" v-if="errors.length">
         <h4>Errores:</h4>
         <ul>
          <li v-for="error in errors">{{ error }}</li>
         </ul>
       </div>

  <div class="col-xs-offset-2 col-xs-8">
         <div class="form-group col-xs-10 col-xs-offset-1">
            <label for="timeName">DESCRIPCION:</label>
            <input type="text" class="form-control" id="timeName" name="timeName" v-model="timeName" >
          </div> 
            <div class="col-xs-12">
              <a @click="createTime()" v-if="btnSubmitForm"  class="btn btn-primary button-prevent-multiple-submits"> <span class="fa fa-check" aria-hidden="true"></span>  GUARDAR</a>
            </div>
  </div>

 </form>
</sweet-modal>



</div>   
</template>

<script>

    export default {
        
     mounted() {
            console.log('Component FormNewTime mounted.')
        },
    data: function () {
          return {
            errors: [],
            timeName:'',
            btnSubmitForm: false,
          }
    },
   props: {
           prefUrl: { type: String},
    },
    methods: {
       openModal: function (){
          this.$refs.modalNewTime.open()
              this.errors = [];
              this.timeName = '';
              this.btnSubmitForm = true;
        },
       createTime: function() {
          this.errors = [];
       //VALIDATIONS
      if (!this.timeName) {
               this.errors.push('Este campo no puede estar vacio.');
             }

        if (!this.errors.length) { 
        this.btnSubmitForm = false;

           let url =this.prefUrl+'time-frames';
            axios.post(url,{
              timeName: this.timeName,
            }).then(response => {
          console.log(response);
              this.$emit("timecreated");
               toastr.info("Nuevo Registro Insertado")
               this.errors = [];
               this.timeName = '';
               this.btnSubmitForm = true;
               this.$refs.modalNewTime.close();
            }).catch(e => {
               toastr.error("Error de Servidor:"+ e)
               this.btnSubmitForm = true;
              })
           }

         },
     }
}
</script>
<style>
  .margindiv {
    margin-top: 10px
  }
  .paddingpro {
    padding: 12px 20px;
  }
  @media (max-width: 500px) {
    .margindiv {
      margin-top: 5px;
    }
    .paddingpro {
      padding: 6px 10px;
    }
  }
</style>