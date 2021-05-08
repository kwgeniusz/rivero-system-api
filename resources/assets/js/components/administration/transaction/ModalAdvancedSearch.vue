<template>
 <!-- <div class="col-xs-8 col-xs-offset-3">
        <div class="form-group col-md-5">
          <label for="transactionDate">DESDE:</label>  
          <flat-pickr v-model="searcher.date1" :config="configFlatPickr"  class="form-control" id="transactionDate"></flat-pickr>
        </div>

        <div class="form-group col-md-5">
          <label for="transactionDate">HASTA:</label>  
          <flat-pickr v-model="searcher.date2" :config="configFlatPickr"  class="form-control" id="transactionDate"></flat-pickr>
        </div>  
   </div>

  <div class="col-xs-8 col-xs-offset-3">
     <button type="submit" class="btn btn-primary"  data-toggle="tooltip" data-placement="top" title="Buscar">
         
    </button>
  </div> -->
<!-- COMIENZA CODIGO DE LA VENTANA MODAL PARA CREAR AL CLIENTE-->
 <!-- <a @click="openModal()"><span class="fa fa-plus" aria-hidden="true"></span> Crear Servicio</a> -->

 <div class="row">
      <sweet-modal ref="modalNew" @close="cancf">

        <div class="col-xs-12">
            <div class="panel panel-default">

                <div v-if="editId === 0" class="panel-heading" style="background: #dff0d8"><h4 class="text-uppercase">Agregar Cliente</h4></div>
                <div v-else class="panel-heading" style="background: #d9edf7"><h4 class="text-uppercase">Actualizar Cliente</h4></div>

        <div class="panel-body">
            <div class="alert alert-danger" v-if="errors.length">
             <h4>Errores:</h4>
             <ul>
               <li v-for="(error,index) in errors" :key="index">{{ error }}</li>
            </ul>
           </div>

      <p class="text-right"> <label style="color:red">* </label>REQUERIDOS </p>
      
        <form  class="form" id="formClient" role="form" @submit.prevent="createUpdateClient()">
            
       <div class="form-group col-lg-12">
          <label for="clientNumberFormat"><i class="far fa-id-card"></i> CODIGO</label>
          <input type="text" style="cursor: no-drop" class="form-control" id="clientNumberFormat" v-model="clientNumberFormat" disabled="on">
        </div>

        <div class="form-group col-lg-12">
          <label for="clientType"><i class="fas fa-people-arrows"></i>TIPO DE CLIENTE</label>
          <select @change="client.companyName = ''" class="form-control" v-model="client.clientType" name="clientType" id="clientType">
                    <option value="INDIVIDUAL">INDIVIDUAL</option>
                    <option value="COMPANY">COMPANIA</option>
          </select>
        </div>

           <div class="form-group col-lg-12" v-if="client.clientType == 'COMPANY'">
               <label style="color:red">*</label> <label for="companyName"><i class="fas fa-building"></i>NOMBRE DE LA COMPANIA</label>
                <input  type="text" class="form-control" v-model="client.companyName" name="companyName" placeholder="">
           </div>

        <div class="form-group col-lg-12">
               <label for="clientName"><i class="fas fa-user-friends"></i> NOMBRE Y APELLIDO / REPRESENTANTE</label>
                <input type="text" class="form-control" v-model="client.clientName" name="clientName" placeholder="">
              </div>

        <div class="form-group col-lg-12">
          <label for="gender"><i class="fas fa-venus-mars"></i>GENERO</label>
          <select class="form-control" v-model="client.gender" name="gender" id="gender">
                    <option value="M">MASCULINO</option>
                    <option value="F">FEMENINO</option>
          </select>
        </div>

        <div class="form-group col-lg-12">
          <label for="clientAddress"><i class="fas fa-map-marked-alt"></i> DIRECCION</label>
          <input type="text" class="form-control" v-model="client.clientAddress"  name="clientAddress"  placeholder="5924 Azalea Ln Dallas, TX 75230">
        </div>

        <div class="form-group col-lg-12">
         <label style="color:red">*</label> <label for="businessPhone"><i class="fas fa-phone-square"></i> TELEFONO DEL NEGOCIO</label>
          <!-- <input type="text" class="form-control" id="businessPhone" v-model="client.businessPhone"  placeholder="(000) 000 0000"  title="formato: (000) 000 0000"> -->
           <vue-phone-number-input size="sm" default-country-code="US" v-model="client.businessPhone" required/>
        </div>

        <div class="form-group col-lg-12">
          <label for="homePhone"><i class="fas fa-phone-square"></i>TELEFONO DE CASA</label>
          <!-- <input type="text" class="form-control" id="homePhone" v-model="client.homePhone" placeholder="(000) 000 0000"  title="formato: (000) 000 0000"> -->
           <vue-phone-number-input size="sm" default-country-code="US" v-model="client.homePhone" />
        </div>

          <div class="form-group col-lg-12">
          <label for="mobilePhone"><i class="fas fa-phone-square"></i>CELULAR</label>
          <!-- <input type="text" class="form-control" id="mobilePhone" v-model="client.mobilePhone" placeholder="(000) 000 0000"  title="formato: (000) 000 0000"> -->
           <vue-phone-number-input size="sm" default-country-code="US" v-model="client.mobilePhone" />
        
        </div>

         <div class="form-group col-lg-12">
          <label for="otherPhone"><i class="fas fa-phone-square"></i>OTRO TELEFONO</label>
          <!-- <input type="text" class="form-control" id="otherPhone" v-model="client.otherPhone" placeholder="(000) 000 0000"  title="formato: (000) 000 0000"> -->
           <vue-phone-number-input size="sm" default-country-code="US" v-model="client.otherPhone" />
        
        </div>

          <div class="form-group col-lg-12">
          <label for="fax"><i class="fas fa-phone-square"></i> FAX</label>
          <!-- <input type="text" class="form-control" id="fax" v-model="client.fax" placeholder="(000) 000 0000"  title="formato: (000) 000 0000"> -->
           <vue-phone-number-input size="sm" default-country-code="US" v-model="client.fax" />
        </div> 

        <div class="form-group col-lg-12">  
          <label style="color:red">*</label><label for="clientEmail"><i class="fas fa-at"></i>CORREO PRINCIPAL</label>
          <input type="email" class="form-control" id="clientEmail" v-model="client.mainEmail"  placeholder="CORREO DE CONTACTO">
        </div>
    <div class="form-group col-lg-12">  
          <label for="secondaryEmail"><i class="fas fa-at"></i> CORREO SECUNDARIO</label>
          <input type="email" class="form-control" id="secondaryEmail" v-model="client.secondayEmail"  placeholder="CORREO DE CONTACTO">
        </div>
       <div class="form-group col-lg-12 ">
              <label for="contactTypeId">¿COMO NOS CONTACTO?</label>
                   <select class="form-control" v-model="client.contactTypeId" id="contactTypeId">
                      <option v-for="item in contactTypes" :key="item.contactTypeId" :value="item.contactTypeId">{{item.contactTypeName}}</option>
                  </select>
          </div>
                        <div v-if="editId === 0">
                             <button-form 
                              :buttonType = 1
                               @cancf = "cancf"
                               v-if="showSubmitBtn"
                             ></button-form>
                            </div>

                            <div v-if="editId > 0">
                                <button-form 
                                    :buttonType = 2
                                    @cancf = "cancf"
                                ></button-form>
                            </div>

                    </form>
                </div>
            </div>
        </div>

   </sweet-modal>     
</div>   

</template>
<script>

    export default {
        
    mounted() {
            console.log('Component FormNewService mounted.')
            console.log(this.showModal)
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
       showModal: { type: Boolean},
    },
    watch: {
      showModal: function (value) {
        // console.log(value)
        // console.log(this.showModal)
        //  if(this.showModal){
           this.openModal();
        //  }
       },
      
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
<style>
  .margindivw {
    margin-top: 40px
  }
  @media (max-width: 500px) {
    .margindivw {
      margin-top: 35px;
    }
  }
</style>