<template>
    <div class="row">
      <!-- <sweet-modal ref="modalNew" @close="cancf"> -->

        <div class="col-md-8 col-xs-offset-1">
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

   <!-- </sweet-modal>      -->

    </div>
</template>

<script>
    export default {
        mounted() {
         console.log('Component mounted.');
              // this.$refs.modalNew.open()
        

          axios.get('/clients/create').then((response) => {
              if (this.editId === 0) {
                this.clientNumberFormat= response.data.clientNumberFormat;
                }
                  this.contactTypes= response.data.contactTypes;
            }); //end of create clients

            if (this.editId > 0) {
                // transaction to edit.
                axios.get(`/clients/${this.editId}`).then((response) => {
                    this.data = response.data[0]

                    this.clientNumberFormat   = this.data.clientCode;
                    this.client.clientType    = this.data.clientType;
                    this.client.companyName   = this.data.companyName;
                    this.client.clientName    = this.data.clientName;
                    this.client.gender        = this.data.gender;
                    this.client.clientAddress = this.data.clientAddress;
                    this.client.businessPhone = this.data.businessPhone;
                    this.client.homePhone     = this.data.homePhone;
                    this.client.mobilePhone   = this.data.mobilePhone;
                    this.client.otherPhone    = this.data.otherPhone;
                    this.client.fax           = this.data.fax;
                    this.client.mainEmail     = this.data.mainEmail;
                    this.client.secondaryEmail = this.data.secondaryEmail;
                    this.client.contactTypeId = this.data.contactTypeId;
                });       
            } 
        },
        data(){
            return{
                errors: [],
                showSubmitBtn:true,
                clientNumberFormat:'',
                contactTypes:'',

                client:  {                    
                     clientType: 'INDIVIDUAL',
                     companyName: '',
                     clientName: '',
                     gender: 'M',
                     clientAddress: '',
                     businessPhone: '',
                     homePhone: '',
                     mobilePhone: '',
                     otherPhone: '',
                     fax: '',
                     mainEmail: '',
                     secondaryEmail: '',
                     contactTypeId: '',
                },

            }
         },
      props: {
            // modal:false,
            editId:'',
        },
      methods: {
            createUpdateClient(){
              this.errors = [];
               
               if(this.client.clientType == 'COMPANY') {
                if (!this.client.companyName) 
                this.errors.push('El Nombre de la Compania es obligatorio.');
               }
                //  if (!this.client.clientName) 
                // this.errors.push('El Nombre del Cliente es obligatorio.');
                 if (!this.client.gender) 
                this.errors.push('El Genero es obligatorio.');
                 if (!this.client.businessPhone) 
                this.errors.push('El Telefono para Negocios es obligatorio.');
                if (!this.client.mainEmail) 
                this.errors.push('Debe ingresar el email principal.');
                if (!this.client.contactTypeId) 
                this.errors.push('Debe escoger el metodo con el que se contacto al cliente.');


           if (!this.errors.length) { 
                if (this.editId === 0) {  
                    // that = this 
                    this.showSubmitBtn =false;
                    
                    axios.post('/clients', this.client).then((response) => {
                           toastr.success(response.data.message);

                           this.$emit("sendClient",
                           this.client.clientId, 
                           this.clientNumberFormat,
                           this.client.clientName,
                           this.client.clientAddress);

                          //  this.cancf()
                           this.$emit('showlist', 0)
   
                        })
                    .catch(function (e) {
                      toastr.error(e.data.erros);
                        alert("ERROR EN EL SERVIDOR")
                        // console.log(this)
                        this.showSubmitBtn = true;
                    });

                }else {
                    axios.put(`/clients/${this.editId}`, this.client).then((response) => {
                          toastr.success(response.data.message);
                         this.$emit('showlist', 0)

                        })
                    .catch(function (error,response) {
                         toastr.success(response.data.message);
                    });
                }   // else end   
              }  //end if error.length 
            },
            cancf(n){
                // console.log('vista a mostrar: ' + n)
                this.$emit('showlist', 0)
                this.$emit('close') 
            },
        }
    }

</script>