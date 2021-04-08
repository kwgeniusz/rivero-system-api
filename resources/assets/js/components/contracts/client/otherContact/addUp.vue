<template>
<div class="row">
 <sweet-modal ref="modalNew" @close="cancf">

            <div class="panel panel-default">
             <!-- {{clientId}} -->
                <div v-if="editId === 0" class="panel-heading" style="background: #dff0d8"><h3 class="text-uppercase">Agregar Otro Contacto</h3></div>
                <div v-else class="panel-heading" style="background: #d9edf7"><h3 class="text-uppercase">Actualizar Otro Contacto</h3></div>

        <div class="panel-body">
            <div class="alert alert-danger" v-if="errors.length">
             <h4>Errores:</h4>
             <ul>
               <li v-for="(error,index) in errors" :key="index">{{ error }}</li>
            </ul>
           </div>

      <p class="text-right"> <label style="color:red">* </label>REQUERIDOS </p>
      
        <form  class="form" role="form" @submit.prevent="createUpdateData()">

        <div class="form-group col-lg-12">
                <label style="color:red">*</label><label for="name"><i class="fas fa-user-friends"></i> NOMBRE Y APELLIDO</label>
                <input type="text" class="form-control" v-model="otherContact.name" name="name" placeholder="">
              </div>
            <div class="form-group col-lg-12">
                <label style="color:red">*</label><label for="relationship"><i class="fas fa-user-friends"></i>RELACION</label>
                <input type="text" class="form-control" v-model="otherContact.relationship" name="relationship" placeholder="">
              </div>

        <div class="form-group col-lg-12">
         <label style="color:red">*</label> <label for="mainPhone"><i class="fas fa-phone-square"></i>TELEFONO PRINCIPAL</label>
          <!-- <input type="text" class="form-control" id="mainPhone" v-model="otherContact.mainPhone"  placeholder="(000) 000 0000"  title="formato: (000) 000 0000"> -->
           <vue-phone-number-input size="sm" default-country-code="US" v-model="otherContact.mainPhone" required/>
        </div>

        <div class="form-group col-lg-12">
          <label for="homePhone"><i class="fas fa-phone-square"></i>TELEFONO SECUNDARIO</label>
          <!-- <input type="text" class="form-control" id="secundaryPhone" v-model="otherContact.secundaryPhone" placeholder="(000) 000 0000"  title="formato: (000) 000 0000"> -->
           <vue-phone-number-input size="sm" default-country-code="US" v-model="otherContact.secundaryPhone" />
        </div>

        <div class="form-group col-lg-12">  
          <label style="color:red">*</label><label for="mainEmail"><i class="fas fa-at"></i>CORREO PRINCIPAL</label>
          <input type="email" class="form-control" id="mainEmail" v-model="otherContact.mainEmail"  placeholder="CORREO DE CONTACTO">
        </div>
    <div class="form-group col-lg-12">  
          <label for="secondaryEmail"><i class="fas fa-at"></i> CORREO SECUNDARIO</label>
          <input type="email" class="form-control" id="secondaryEmail" v-model="otherContact.secondayEmail"  placeholder="CORREO DE CONTACTO">
        </div>

                        <div v-if="editId === 0">
                           <button v-if="showSubmitBtn" type="submit" class="btn btn-success">
                               <span class="fa fa-check"></span> Guardar
                          </button>

                            </div>

                            <div v-if="editId > 0">
                             <button type="submit" class="btn btn-primary">
                                 <span class="fa fa-check"></span>
                                  Actualizar
                            </button>
                            </div>

                    </form>
                </div>
            </div>
    
       </sweet-modal>
 
    </div>    
</template>

<script>
    export default {
        mounted() {
         console.log('Component mounted.');
              this.$refs.modalNew.open()
              
            if (this.editId > 0) {
                // transaction to edit.
                axios.get(`other-contacts/${this.editId}`).then((response) => {
                    this.data = response.data[0]

                    this.otherContact.name    = this.data.name;
                    this.otherContact.relationship        = this.data.relationship;
                    this.otherContact.mainPhone = this.data.mainPhone;
                    this.otherContact.secondaryPhone = this.data.secondaryPhone;
                    this.otherContact.mainEmail     = this.data.mainEmail;
                    this.otherContact.secondaryEmail   = this.data.secondaryEmail;
                });       
            } 
        },
        data(){
            return{
                errors: [],
                showSubmitBtn:true,

                otherContact:  {                   
                     name: '',
                     relationship: '',
                     mainPhone: '',
                     secondaryPhone: '',
                     mainEmail: '',
                     secondaryEmail: '',
                },

            }
         },
      props: {
            editId:'',
            clientId:''
        },
      methods: {
            createUpdateData(){
              this.errors = [];
               
                 if (!this.otherContact.name) 
                this.errors.push('El Nombre es obligatorio.');

                 if (!this.otherContact.relationship) 
                this.errors.push('La relacion con el cliente es obligatoria.');

                 if (!this.otherContact.mainPhone) 
                this.errors.push('El Telefono Principal es obligatorio.');

                if (!this.otherContact.mainEmail) 
                this.errors.push('Debe ingresar el correo principal.');

           if (!this.errors.length) { 
                if (this.editId === 0) { 
                    this.showSubmitBtn =false; 

                    axios.post(`/clients/${this.clientId}/other-contacts`, this.otherContact).then((response) => {
                           toastr.success(response.data.message);
                          this.$refs.modalNew.close()

                        //    this.$emit('showlist', 0)
                        })
                    .catch(function (response) {
                        alert("ERROR EN EL SERVIDOR")
                        this.showSubmitBtn =true;
                    });

                }else {
                    axios.put(`/other-contacts/${this.editId}`, this.otherContact).then((response) => {
                          toastr.success(response.data.message);
                          this.$refs.modalNew.close()
                        //   this.$emit('showlist', 0)
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
            },  
        }
    }

</script>