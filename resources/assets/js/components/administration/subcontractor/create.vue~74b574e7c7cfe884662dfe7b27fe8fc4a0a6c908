<template>
<div class="create">
  <div class="alert alert-danger" v-if="errors.length">
    <h4>Errores:</h4>
    <ul>
      <li v-for="error in errors">{{ error }}</li>
    </ul>
  </div>
  <div class="formulario">
    <div>
      <h3><i class="fas fa-user-tie"></i> Informacion Basica:</h3>
      <div class="boxes">
        <div class="other boxes2">
          <label for="formSubcontType"><i class="fas fa-user-tie"></i> TIPO DE SUBCONTRATISTA</label>
          <select id="formSubcontType" v-model="formSubcontType">
            <option value="company" selected>Compañia</option>
            <option value="individual">Individual</option>
          </select>
        </div>
        <div class="inputother boxes2">
            <label for="formDNIType"><i class="fas fa-id-card-alt"></i>  TIPO DNI</label>
            <input type="text" class="input-label" id="formDNIType" v-model="formDNIType" placeholder="EIN, ITIN, SSN" autocomplete="off">
        </div>
        <div class="inputother boxes2">
          <label for="formDNI"><i class="far fa-id-card"></i> DNI</label>
          <input type="text" class="input-label" id="formDNI" v-model="formDNI" placeholder="DNI" autocomplete="off ">
        </div>
        <div class="inputother boxes2">
          <label for="formName"><i class="fas fa-user-edit"></i> NOMBRE</label>
          <input type="text" class="input-label" id="formName" v-model="formName" placeholder="NOMBRE" autocomplete="off ">
        </div>
        <div class="inputother boxes2" v-if="formSubcontType == 'company'">
          <label for="formRepresentative"><i class="fas fa-user-friends"></i>  REPRESENTANTE</label>
          <input type="text" class="input-label" id="formRepresentative" v-model="formRepresentative" placeholder="NOMBRE DE LA COMPAÑIA" autocomplete="off ">
        </div>
        <div class="inputother boxes2">
          <label for="formAddress"><i class="fas fa-map-marked-alt"></i> DIRECCION</label>
          <input type="text" class="input-label" id="formAddress" v-model="formAddress" placeholder="" autocomplete="off ">
        </div>
        <div class="inputother boxes2">
          <label for="formMainPhone"><i class="fas fa-phone-square"></i> TELEFONO PRIMARIO</label>
          <input type="text" class="input-label" id="formMainPhone" v-model="formMainPhone" placeholder="" autocomplete="off ">
        </div>
        <div class="inputother boxes2">
          <label for="formSecondaryPhone"><i class="fas fa-tty"></i> TELEFONO SECUNDARIO</label>
          <input type="text" class="input-label" id="formSecondaryPhone" v-model="formSecondaryPhone" placeholder="" autocomplete="off ">
        </div>
        <div class="inputother boxes2">
          <label for="formEmail"><i class="fas fa-at"></i> CORREO</label>
          <input type="email" class="input-label" id="formEmail" v-model="formEmail" placeholder="" autocomplete="off ">
        </div>
        <div class="other boxes2">
          <label for="typeForm1099">TIPO DE FORM 1099</label>
          <select id="typeForm1099" v-model="typeForm1099">
            <option value="1099_MISC" selected>1099 MISC</option>
            <option value="1099_NEC">1099 NEC</option>
          </select>
        </div>
      </div>
    </div>
  </div>
  <div class="formulario2">
    <div>
      <h3><i class="fas fa-money-check-alt"></i> Informacion Financiera:</h3>
      <div class="boxes">
        <div class="inputother boxes2">
          <label for="formBankName"><i class="fas fa-piggy-bank"></i> BANCO</label>
          <input type="text" class="input-label" id="formBankName" v-model="formBankName" placeholder="" autocomplete="off ">
        </div>
        <div class="inputother boxes2">
          <label for="formHeadline"><i class="fas fa-user-check"></i> TITULAR DEL BANCO</label>
          <input type="text" class="input-label" id="formHeadline" v-model="formHeadline" placeholder="" autocomplete="off ">
        </div>
        <div class="inputother boxes2">
            <label for="formAccountNumber"><i class="fas fa-money-check-alt"></i> NUMERO DE CUENTA</label>
            <input type="text" class="input-label" id="formAccountNumber" v-model="formAccountNumber" placeholder="" autocomplete="off ">
        </div>
        <div class="inputother boxes2">
            <label for="formRoutingNumber"><i class="fas fa-user-chart"></i> NUMERO DE RUTA</label>
            <input type="text" class="input-label" id="formRoutingNumber" v-model="formRoutingNumber" placeholder="" autocomplete="off ">
        </div>
        <div class="inputother boxes2">
          <label for="formWires"><i class="fas fa-people-arrows"></i> WIRES</label>
          <input type="text" class="input-label" id="formWires" v-model="formWires" placeholder="" autocomplete="off ">
        </div>
        <div class="inputother boxes2">
          <label for="formZelle"><i class="fas fa-comments-dollar"></i> ZELLE</label>
          <input type="text" class="input-label" id="formZelle" v-model="formZelle" placeholder="" autocomplete="off ">
        </div>
      </div>
    </div>
  </div>
  <div style="width: 100%; text-align: center;">
     <a @click="sendForm()" v-if="btnSubmitForm" >
        <button class="submit">
          <span class="fa fa-check" aria-hidden="true"></span>  ENVIAR
        </button>
      </a>
  </div>
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
           typeForm1099: '1099_MISC',

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
                 typeForm1099:   this.typeForm1099
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
<style>
  .create {
  position: relative;
  width: 100%;
  padding: 40px;
  display: flex;
  justify-content: center;
  align-items: flex-start;
  background: #dadada;
  border-radius: 20px;
  flex-wrap: wrap;
  margin: auto;
}

.formulario {
  background: #fff;
  width: 45%;
  padding: 40px;
  border-radius: 20px;
  position: relative;
}
.formulario2 {
  background: #fff;
  width: 45%;
  padding: 40px;
  border-radius: 20px;
  position: relative;
  margin-left: 40px;
}
.title {
  font-weight: 400;
  color: rgb(134, 134, 134);
  padding: 20px 0px;
}

.boxes {
  border-top: 2px solid #ccc;
  width: 100%;
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  padding-top: 10px;
}
.input-label{
  position: relative;
  max-width: 100%;
  min-width: 100%;
  margin-bottom: 0px;
}
.input {
  position: relative;
  max-width: 48%;
  min-width: 48%;
  margin-bottom: 0px;
}
.textarea {
  position: relative;
  max-width: 48%;
  min-width: 48%;
  margin-bottom: 30px;
  display: flex;
  flex-direction: column;
}
.inputother {
  position: relative;
  max-width: 48%;
  min-width: 48%;
  margin-bottom: 30px;
}
.other {
  position: relative;
  max-width: 100%;
  min-width: 100%;
  margin-bottom: 30px;
}
input,
select {
  padding: 10px;
  border-radius: 5px;
  width: 100%;
  border: 1px solid #ccc;
  background: rgba(248, 248, 248, 0.815);
}
textarea {
  max-width: 100%;
  min-width: 100%;
  max-height: 100px;
  min-height: 100px;
}
label {
  margin-bottom: 10px;
}

.boxes2 {
  display: flex;
  flex-direction: column;
}

.submit {
  margin-top: 30px;
  font-size: 1em;
  padding: 10px 20px;
  background: #0062be;
  border: none;
  border-radius: 5px;
  color: #fff;
}
.return {
  margin-top: 30px;
  font-size: 1em;
  padding: 10px 20px;
  background: #eea508;
  border: none;
  border-radius: 5px;
  color: #fff;
}
.alert {
  width: 100%;
  margin-top: 19px;
}
@media (max-width: 500px) {
  .formulario, .formulario2 {
    width: 95%;
    padding: 10px;
    border-radius: 10px;
    margin-left: 0;
  }
  .formulario2 {
    margin-top: 20px;
  }
  .create  {
    margin-top: 30px;
    margin-bottom: 30px;
    width: 95%;
    padding: 20px 0;
    border-radius: 10px;
  }

  .input {
    margin-bottom: 15px;
  }
  .textarea{
    max-width: 100%;
    min-width: 100%;
  }
  .inputother {
    margin-bottom: 15px;
  }
  .other {
    margin-bottom: 15px;
  }

  input,
  select {
    border-radius: 3px;
  }

  label {
    margin-bottom: 5px;
    font-weight: 300;
    width: 150px;
    white-space: nowrap;
    text-overflow: ellipsis;
    overflow: hidden;
  }
}
</style>