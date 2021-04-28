<template>
    <div class="row">
      <!-- <sweet-modal ref="modalNew" @close="cancf"> -->

        <div class="col-md-6 col-xs-offset-2">
            <div class="panel panel-default">

            <div v-if="editId === 0" class="panel-heading" style="background: #dff0d8"><h4 class="text-uppercase">Agregar Cuenta</h4></div>
            <div v-else class="panel-heading" style="background: #d9edf7"><h4 class="text-uppercase">Actualizar Cuenta</h4></div>

        <div class="panel-body">
            <div class="alert alert-danger" v-if="errors.length">
              <h4>Errores:</h4>
               <ul>
                 <li v-for="(error,index) in errors" :key="index">{{ error }}</li>
              </ul>
           </div>

      <p class="text-right"> <label style="color:red">* </label>REQUERIDOS </p>
        <form  class="form" id="formClient" role="form" @submit.prevent="createUpdateAccount()">
      
        <div class="form-group col-lg-7">
               <label for="clientName"><i class="fas fa-user-friends"></i> CODIGO DE CUENTA:</label>
                <input type="text" class="form-control" v-model="client.clientName" name="clientName" placeholder="">
        </div>

       <div class="form-group col-lg-10">
               <label for="clientName"><i class="fas fa-user-friends"></i> NOMBRE DE CUENTA:</label>
                <input type="text" class="form-control" v-model="client.clientName" name="clientName" placeholder="">
        </div>

        <div class="form-group col-lg-12 ">
              <label for="contactTypeId">CUENTA PADRE:</label>
                   <select class="form-control" v-model="client.contactTypeId" id="contactTypeId">
                      <option v-for="item in contactTypes" :key="item.contactTypeId" :value="item.contactTypeId">{{item.contactTypeName}}</option>
                  </select>
          </div>

         <div class="form-group col-lg-12 ">
              <label for="contactTypeId">CLASIFICACION:</label>
                   <select class="form-control" v-model="client.contactTypeId" id="contactTypeId">
                      <option v-for="item in contactTypes" :key="item.contactTypeId" :value="item.contactTypeId">{{item.contactTypeName}}</option>
                  </select>
          </div>  

         <div class="form-group col-lg-12 ">
              <label for="contactTypeId">TIPO:</label>
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
            createUpdateAccount(){
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
                    this.showSubmitBtn = false;
                    
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
                    .catch((error) => {
                      
                      this.errors.push(error.response.data.errors.businessPhone);
                      this.errors.push(error.response.data.errors.mainEmail);
                        // alert("ERROR EN EL SERVIDOR")
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