<template>
<div>

<!-- COMIENZA CODIGO DE LA VENTANA MODAL PARA CREAR AL NOTA-->
 <a class="btn btn-success" @click="openModal()"><span class="fa fa-plus" aria-hidden="true"></span> Crear</a>

 <sweet-modal ref="modalNewTerm">
    <form class="form form-prevent-multiple-submits">

    <h3 class="bg-success"><b>NUEVO TERMINO</b></h3>
     <br>
       <div class="alert alert-danger" v-if="errors.length">
         <h4>Errores:</h4>
         <ul>
          <li v-for="error in errors">{{ error }}</li>
         </ul>
       </div>

  <div class="col-xs-offset-2 col-xs-8">
         <div class="form-group col-xs-10 col-xs-offset-1">
            <label for="termName">DESCRIPCION:</label>
            <input type="text" class="form-control" id="termName" name="termName" v-model="termName" >
          </div> 
            <div class="col-xs-12">
              <a @click="createTerm()" v-if="btnSubmitForm"  class="btn btn-primary button-prevent-multiple-submits"> <span class="fa fa-check" aria-hidden="true"></span>  GUARDAR</a>
            </div>
  </div>
 </form>

</sweet-modal>



</div>   
</template>

<script>

    export default {
        
     mounted() {
            console.log('Component FormNewTerm mounted.')
        },
    data: function () {
          return {
            errors: [],
            termName:'',
            btnSubmitForm: false,
          }
    },
   props: {
           prefUrl: { type: String},
    },
    methods: {
       openModal: function (){
          this.$refs.modalNewTerm.open()
              this.errors = [];
              this.termName = '';
              this.btnSubmitForm = true;
        },
       createTerm: function() {
          this.errors = [];
       //VALIDATIONS
      if (!this.termName) {
               this.errors.push('El Campo Descripcion Es Requerido');
             }

        if (!this.errors.length) { 
        this.btnSubmitForm = false;

           let url =this.prefUrl+'terms';
            axios.post(url,{
              termName: this.termName,
            }).then(response => {
          console.log(response);
              this.$emit("termcreated");
               toastr.info("Nuevo Registro Insertado")
               this.errors = [];
               this.termName = '';
               this.btnSubmitForm = true;
               this.$refs.modalNewTerm.close();
            }).catch(e => {
               toastr.error("Error de Servidor:"+ e)
               this.btnSubmitForm = true;
              })
           }

         },
     }
}
</script>
