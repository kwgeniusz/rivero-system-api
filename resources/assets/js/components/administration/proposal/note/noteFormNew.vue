<template>
<div class="margindiv">

<!-- COMIENZA CODIGO DE LA VENTANA MODAL PARA CREAR AL NOTA-->
 <a class="submit paddingpro" style="background: green;" @click="openModal()"><span class="fa fa-plus" aria-hidden="true"></span> Crear</a>

 <sweet-modal ref="modalNewNote">
    <form class="form form-prevent-multiple-submits">

    <h3 class="bg-success"><b>NUEVA NOTA</b></h3>
     <br>
       <div class="alert alert-danger" v-if="errors.length">
         <h4>Errores:</h4>
         <ul>
          <li v-for="error in errors">{{ error }}</li>
         </ul>
       </div>

  <div class="col-xs-offset-2 col-xs-8">

         <div class="form-group col-xs-8 col-xs-offset-2">
            <label for="noteName">DESCRIPCION:</label>
            <input type="text" class="form-control" id="noteName" name="noteName" v-model="noteName" >
          </div> 
            <div class="col-xs-12">
              <a @click="createNote()" v-if="btnSubmitForm"  class="btn btn-primary button-prevent-multiple-submits"> <span class="fa fa-check" aria-hidden="true"></span>  GUARDAR</a>
            </div>
  </div>
 </form>
        
</sweet-modal>



</div>   
</template>

<script>

    export default {
        
     mounted() {
            console.log('Component FormNewNote mounted.')
        },
    data: function () {
          return {
            errors: [],
            noteName:'',
            btnSubmitForm: false,
          }
    },
   props: {
           prefUrl: { type: String},
    },    
    methods: {
       openModal: function (){
          this.$refs.modalNewNote.open()
              this.errors = [];
              this.noteName = '';
              this.btnSubmitForm = true;
        },
       createNote: function() {
          this.errors = [];
       //VALIDATIONS
      if (!this.noteName) {
               this.errors.push('Campo Nota Es Requerido');
             }

        if (!this.errors.length) { 
        this.btnSubmitForm = false;

           let url =this.prefUrl+'notes';
            axios.post(url,{
              noteName: this.noteName,
            }).then(response => {
          console.log(response);
              this.$emit("notecreated");
               toastr.info("Nota Creada")
               this.errors = [];
               this.noteName = '';
               this.btnSubmitForm = true;
               this.$refs.modalNewNote.close();
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