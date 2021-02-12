<template>
<div class="submit buttonmovil" style="background: green">

<!-- COMIENZA CODIGO DE LA VENTANA MODAL PARA CREAR AL CLIENTE-->
 <a class="submit buttonmovil" style="background: green" @click="openModal()"><span class="fa fa-plus" aria-hidden="true"></span> Crear Servicio</a>

 <sweet-modal ref="modalNewService">
    <form class="form form-prevent-multiple-submits">

    <h3 class="bg-success"><b>NUEVO SERVICIO</b></h3>

     <br>
       <div class="alert alert-danger" v-if="errors.length">
         <h4>Errores:</h4>
         <ul>
          <li v-for="error in errors">{{ error }}</li>
         </ul>
       </div>


  <div class="col-xs-8 col-xs-offset-2">
          <div class="form-group col-xs-8 col-xs-offset-2">
            <label for="hasCost">Tiene Precio?:</label>
            <select v-model="hasCost" class="form-control" name="hasCost" id="hasCost">
                  <option value="Y">YES</option>
                  <option value="N">NO</option>
            </select>
          </div>

         <div class="form-group col-xs-8 col-xs-offset-2">
            <label for="serviceName">NOMBRE DEL SERVICIO</label>
            <input type="text" class="form-control" id="serviceName" name="serviceName" v-model="serviceName" >
          </div> 

         <div class="form-group col-xs-8 col-xs-offset-2" v-if="hasCost === 'Y'">
            <label for="cost1">PRECIO POR SQFT:</label>
            <input type="number" class="form-control" id="cost1" name="cost1" v-model="cost1">
          </div>

          <div class="form-group col-xs-8 col-xs-offset-2" v-if="hasCost === 'Y'">
                <label for="cost2">PRECIO POR EA:</label>
                <input type="number" class="form-control" id="cost2" name="cost2" v-model="cost2" >
          </div>

  </div>
          <div class="col-xs-12">
              <a @click="createService()" v-if="btnSubmitForm"  class="btn btn-primary"> <span class="fa fa-check" aria-hidden="true"></span> GUARDAR</a>
           </div>
        
</form>
</sweet-modal>


</div>   
</template>

<script>

    export default {
        
     mounted() {
            console.log('Component FormNewService mounted.')
        },
    data: function () {
          return {
            errors: [],
            hasCost:'',
            serviceName:'',
            cost1:'',
            cost2:'',
            btnSubmitForm: false,
          }
    },
   props: {
           prefUrl: { type: String},
    },
    methods: {
       openModal: function (){
          this.$refs.modalNewService.open()
              this.errors = [];
              this.hasCost = 'N';
              this.serviceName = '';
              this.cost1 = '';
              this.cost2 = '';
              this.btnSubmitForm = true;
        },
       createService: function() {
          this.errors = [];
       //VALIDATIONS
      if (!this.serviceName) {
               this.errors.push('Nombre del Servicio Es Requerido');
             }
      if(this.hasCost === 'Y') { 
            if (!this.cost1) {
               this.errors.push('Debe ingresar Costo para la Unidad 1');
             }
             if (!this.cost2) {
               this.errors.push('Debe ingresar Costo para la Unidad 2');
             }
      }
          if (!this.errors.length) { 
            this.btnSubmitForm = false;
            let url =this.prefUrl+'services';
            axios.post(url,{
            serviceName: this.serviceName,
            hasCost: this.hasCost,
            cost1: this.cost1,
            cost2: this.cost2,
            }).then(response => {
          console.log(response);
              this.$emit("servicecreated");
               toastr.info("Servicio Nuevo Insertado")
               this.errors = [];
               this.serviceName = '';
               this.hasCost = '';
               this.cost1 = '';
               this.cost2 = '';
               this.btnSubmitForm = true;
               this.$refs.modalNewService.close();
            }).catch(e => {
               toastr.error("Error de Servidor:"+ e)
               this.btnSubmitForm = true;
              })
           }

         },
     }
}
</script>
