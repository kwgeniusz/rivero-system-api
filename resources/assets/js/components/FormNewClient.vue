<template>
<div>

<!-- COMIENZA CODIGO DE LA VENTANA MODAL PARA CREAR AL CLIENTE-->
 <a class="btn btn-success" @click="openModal()"><span class="fa fa-plus" aria-hidden="true"></span></a>

 <sweet-modal ref="modalNewClient">

    <h3 class="bg-success"><b>NUEVO CLIENTE</b></h3>
     <br>
       <div class="alert alert-danger" v-if="errors.length">
         <h4>Errores:</h4>
         <ul>
          <li v-for="error in errors">{{ error }}</li>
         </ul>
       </div>

  <div class="col-xs-offset-2 col-xs-8">
      <!--     <div class="form-group ">
            <label for="formClientCountry">PAIS</label>
            <select v-model="formClientCountry" class="form-control" name="formClientCountry" id="formClientCountry">
                  <option  :value="country.countryId"  v-for="(country) in countrys"> {{country.countryName}}</option>
            </select>
          </div> -->
         <div class="form-group ">
            <label for="clientNumberFormat">CODIGO</label>
            <input type="text" class="form-control" id="clientNumberFormat" name="clientNumberFormat" v-model="formClientNumberFormat" disabled="on">
          </div>
           <br>
              <div class="form-group">
                <label for="formClientName">NOMBRES Y APELLIDOS</label>
                <input type="text" class="form-control" name="formClientName" v-model="formClientName" placeholder="Nombres y Apellidos">
              </div>
  <br>
             
              <div class="form-group">
                <label for="formClientAddress">DIRECCION</label>
                <input type="text" class="form-control" name="formClientAddress" v-model="formClientAddress" placeholder="Direccion">
              </div>
      <br>    
          <div class="form-group ">
            <label for="formContactType">TIPO DE CONTACTO</label>
            <select v-model="formContactType" class="form-control" name="formContactType" id="formContactType">
                  <option  :value="contactType.contactTypeId"  v-for="(contactType) in contactTypes"> {{contactType.contactTypeName}}</option>
            </select>
          </div>
<br>
              <div class="col-xs-6">
              <div class="form-group">
                <label for="formClientPhone">TELEFONO</label>
                <input type="text" class="form-control" name="formClientPhone" v-model="formClientPhone" placeholder="04124231242" pattern="^([0-9]{3,11})" title="formato: 04124231242">
              </div>
            </div>
            <div class="col-xs-6">
              <div class="form-group">
                <label for="formClientEmail">CORREO</label>
                <input type="email" class="form-control" name="formClientEmail" v-model="formClientEmail" placeholder="Correo">
              </div>
            </div>
<br><br><br>
            <div class="col-xs-12">
              <a @click="createClient()" v-if="btnSubmitForm"  class="btn btn-primary">
                <span class="fa fa-check" aria-hidden="true"></span>  GUARDAR
              </a>
            </div>
         <br><br><br>    
  </div>

         <!--<a class="btn btn-success" slot="button" @click.prevent="$refs.nestedChild.open()">Open Child Modal</a>-->
</sweet-modal>

<!-- 
     <sweet-modal ref="nestedChild">
              This is the child modal.
     </sweet-modal> -->



</div>   
</template>

<script>

    export default {
        
     mounted() {
            console.log('Component FormNewClient mounted.')
    //Si Recibo propiedades desde afuera preparame el input busqueda con esos valores
          // if(this.cId && this.cName){
          //     this.clientId = this.cId
          //     this.clientName = this.cName
          //     this.btnRemove = true
          //     this.btnAgg = false
          //   }
          //  if(this.cAddress){
          //   this.clientAddress = this.cAddress
          // }

        },
     data: function () {
          return {
            errors: [],
            contactTypes:'',
            formClientCountry:'',
            formClientName: '',
            formClientAddress: '',
            formContactType: '', 
            formClientPhone: '',
            formClientEmail: '',
            formClientNumberFormat:'',
            btnSubmitForm: false,
          }
    },
     props: {
           url: { type: String},
    },
    methods: {

       openModal: function (){
          this.$refs.modalNewClient.open()
             this.btnSubmitForm = true;
             this.errors = [];
             if(this.url == "C") { 
                  var url ='../countrys/all';
                  var url2 ='../contactTypes/all'; 
                  var url3 ='../clientNumberFormat/get'; 
              }else{
                  var url ='../../countrys/all';
                  var url2 ='../../contactTypes/all';
                  var url3 ='../../clientNumberFormat/get'; 
                }
              axios.get(url).then(response => {
                 this.countrys = response.data
                });
              axios.get(url2).then(response => {
                 this.contactTypes = response.data
                }); 
              axios.get(url3).then(response => {
                 this.formClientNumberFormat = response.data
                }); 
        },
       createClient: function() {

          if(this.url == "C") { 
           var url ='../clients';
         }else{
           var url ='../../clients';
         }
           this.errors = [];
           //VALIDATIONS
           // if (!this.formClientCountry) {
           //      this.errors.push('Pais es Requerido.');
           // } 
           if (!this.formClientName) {
                this.errors.push('Nombre y Apellido es Requerido.');
           }
          if (!this.formContactType) {
                this.errors.push('Tipo de contacto es Requerido.');
           }
  

          if (!this.errors.length) { 
            this.btnSubmitForm = false;
            axios.post(url,{
             countryId: this.formClientCountry,
            clientName: this.formClientName,
            clientAddress: this.formClientAddress,
            contactTypeId: this.formContactType,
            clientPhone: this.formClientPhone,
            clientEmail: this.formClientEmail
            }).then(response => {
               // this.aggClient(response.data.clientId,response.data.clientName,response.data.clientAddress)
          console.log(response);
              this.$emit("sendClient", response.data.clientId,response.data.clientName,response.data.clientAddress);
               toastr.info("Cliente Nuevo Insertado")
               this.formClientCountry = "";
               this.formClientName = "";
               this.formClientAddress= "";
               this.formContactType = "";
               this.formClientPhone= "";
               this.formClientEmail = "";
               this.$refs.modalNewClient.close();
            }).catch(e => {
               toastr.error("Error de Servidor:"+ e)
               this.btnSubmitForm = true;
              })
           }

         },
     }
}
</script>
