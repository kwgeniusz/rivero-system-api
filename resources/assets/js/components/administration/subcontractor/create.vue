<template>
<div class="panel panel-success col-xs-offset-1 col-xs-10">

          <div class="alert alert-danger" v-if="errors.length">
            <h4>Errores:</h4>
            <ul>
             <li v-for="error in errors">{{ error }}</li>
            </ul>
          </div>


        <h3 class="text-center"><b>Informacion Basica:</b></h3>

              <div class="form-group col-lg-8">
               <i class="fas fa-user-tie"></i> <label for="formSubcontType">TIPO DE SUBCONTRATISTA</label>
                <select class="form-control" id="formSubcontType" v-model="formSubcontType">
                  <option value="company" selected>Compañia</option>
                  <option value="individual">Individual</option>
                 </select>
              </div>

         <div class="form-group col-lg-6 ">
                <i class="fas fa-id-card-alt"></i> <label for="formDNIType">TIPO DNI</label>
                 <input type="text" class="form-control" id="formDNIType" v-model="formDNIType" placeholder="EIN, ITIN, SSN" autocomplete="off">
          </div>

        <div class="form-group col-lg-6 ">
               <i class="far fa-id-card"></i> <label for="formDNI">DNI</label>
                  <input type="text" class="form-control" id="formDNI" v-model="formDNI" placeholder="" autocomplete="off ">
          </div>
        <div class="form-group col-lg-6 ">
              <i class="fas fa-user-edit"></i><label for="formName">NOMBRE</label>
                  <input type="text" class="form-control" id="formName" v-model="formName" placeholder="" autocomplete="off ">
          </div>

         <div class="form-group col-lg-6 " v-if="formSubcontType == 'company'">
              <i class="fas fa-user-friends"></i> <label for="formRepresentative">REPRESENTANTE</label>
                  <input type="text" class="form-control" id="formRepresentative" v-model="formRepresentative" placeholder="" autocomplete="off ">
        </div>

       <div class="row"></div>
       <div class="form-group col-lg-6 ">
               <i class="fas fa-map-marked-alt"></i> <label for="formAddress">DIRECCION</label>
                  <input type="text" class="form-control" id="formAddress" v-model="formAddress" placeholder="" autocomplete="off ">
          </div>

        <div class="row"></div>
        <div class="form-group col-lg-6 ">
             <i class="fas fa-phone-square"></i>  <label for="formMainPhone">TELEFONO PRIMARIO</label>
                  <input type="text" class="form-control" id="formMainPhone" v-model="formMainPhone" placeholder="" autocomplete="off ">
          </div>

        <div class="form-group col-lg-6 ">
              <i class="fas fa-tty"></i>   <label for="formSecondaryPhone">TELEFONO SECUNDARIO</label>
                  <input type="text" class="form-control" id="formSecondaryPhone" v-model="formSecondaryPhone" placeholder="" autocomplete="off ">
          </div>

         <div class="form-group col-lg-6 ">
                <i class="fas fa-at"></i> <label for="formEmail">CORREO</label>
                  <input type="email" class="form-control" id="formEmail" v-model="formEmail" placeholder="" autocomplete="off ">
        </div>


      <!--    <div class="row"></div>
                <div class="form-group col-lg-6">
                <label for="file">COMPROBANTE DE EGRESO</label>
                <input type="file" name="file">
              </div> -->

      <div class="row"></div>
        <h3 class="text-center"><b>Informacion Financiera:</b></h3>


      <!--  <vue-phone-number-input :only-countries="['US','VE']"  v-model="yourValue" @update="generatePhoneNumber"/> -->
       <!-- {{yourValue}} -->
        <br>
        <div class="form-group col-lg-6 ">
               <i class="fas fa-piggy-bank"></i>  <label for="formBankName">BANCO</label>
                  <input type="text" class="form-control" id="formBankName" v-model="formBankName" placeholder="" autocomplete="off ">
          </div>
        <div class="form-group col-lg-6 ">
               <i class="fas fa-user-check"></i>  <label for="formHeadline">TITULAR DEL BANCO</label>
                  <input type="text" class="form-control" id="formHeadline" v-model="formHeadline" placeholder="" autocomplete="off ">
          </div>

         <div class="form-group col-lg-6 ">
              <i class="fas fa-money-check-alt"></i>   <label for="formAccountNumber">NUMERO DE CUENTA</label>
                  <input type="text" class="form-control" id="formAccountNumber" v-model="formAccountNumber" placeholder="" autocomplete="off ">
        </div>

         <div class="form-group col-lg-6 ">
                <i class="fas fa-user-chart"></i> <label for="formRoutingNumber">NUMERO DE RUTA</label>
                  <input type="text" class="form-control" id="formRoutingNumber" v-model="formRoutingNumber" placeholder="" autocomplete="off ">
        </div>

        <div class="form-group col-lg-6 ">
               <i class="fas fa-people-arrows"></i>  <label for="formWires">WIRES</label>
                  <input type="text" class="form-control" id="formWires" v-model="formWires" placeholder="" autocomplete="off ">
        </div>

         <div class="form-group col-lg-6 ">
              <i class="fas fa-comments-dollar"></i>   <label for="formZelle">ZELLE</label>
                  <input type="text" class="form-control" id="formZelle" v-model="formZelle" placeholder="" autocomplete="off ">
        </div>

            <div class="row"></div>

            <div class="text-center">
              <a @click="sendForm()" v-if="btnSubmitForm" class="btn btn-primary">
                <span class="fa fa-check" aria-hidden="true"></span>  ENVIAR
              </a>
            </div>  
            
         <br>
</div>
</template>

<script>
export default {

     mounted() {
            console.log('Component subcontractor create mounted.')
           },
     data: function () {
          return {
            errors: [],

           formSubcontType: 'company', 
           formName: '',  
           formRepresentative: '',  
           formDNIType: '', 
           formDNI: '', 
           formMainPhone: '', 
           formSecondaryPhone: '',
           formAddress: '', 
           formEmail: '',
           formBankName: '',
           formHeadline: '',
           formAccountNumber: '',
           formRoutingNumber: '',
           formWires: '',
           formZelle: '', 

           btnSubmitForm: true,

          }
    },
    watch: {
       formSubcontType: function() {
            this.formRepresentative = '';
       }
    },
    props: {
           // rId: { type: String},
          }, 
    methods: {
       // generatePhoneNumber: function (event){
       //  console.log(event)
       // },
       sendForm: function() {
           this.errors = [];

               if (!this.formDNIType) 
                this.errors.push('Debe escoger Tipo de DNI.');

               if (!this.formDNI) 
                this.errors.push('DNI es requerido.');

               if (!this.formName) 
                this.errors.push('Nombre es requerido.');

            if(this.formSubcontType == 'company'){
               if(!this.formRepresentative)
                 this.errors.push('Representante es requerido.');
             }
                 
               if(!this.formAddress) 
                 this.errors.push('La Direccion es requerida.');
                
              if(!this.formMainPhone) 
                 this.errors.push('El telefono principal es requerido.');
              
      

       if (!this.errors.length) { 
            this.btnSubmitForm = false;

            axios.post('../subcontractors',{ 
                 subcontType:    this.formSubcontType,  
                 name:           this.formName,  
                 representative: this.formRepresentative,  
                 DNIType:        this.formDNIType, 
                 DNI:            this.formDNI, 
                 mainPhone:      this.formMainPhone, 
                 secondaryPhone: this.formSecondaryPhone,
                 address:        this.formAddress, 
                 email:          this.formEmail,
                 bankName:       this.formBankName,
                 headline:       this.formHeadline,
                 accountNumber:  this.formAccountNumber,
                 routingNumber:  this.formRoutingNumber,
                 wires:          this.formWires,
                 zelle:          this.formZelle,  
            }).then(response => {
                   if (response.data.alert == "error") {
                       toastr.error(response.data.msj)
                         this.btnSubmitForm = true;
                   } else {
                       toastr.success(response.data.msj)
                       // location.reload();
                       window.location.href = '../subcontractors';
                   }
  
            })
           }
         }, //end of sendForm
     }  //end of methods
}
</script>