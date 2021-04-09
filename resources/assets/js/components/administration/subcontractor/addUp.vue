<template>
    <div class="row">
        <div class="col-md-7 col-md-offset-2">
            <div class="panel panel-default">

                <div v-if="editId === 0" class="panel-heading" style="background: #dff0d8"><h4 class="text-uppercase">Agregar Subcontratista</h4></div>
                <div v-else class="panel-heading" style="background: #d9edf7"><h4 class="text-uppercase">Actualizar Subcontratista</h4></div>

        <div class="panel-body">
<center>            
 <button  v-on:click="cancf()" type="button"  class="btn btn-warning"><span class="fa fa-hand-point-left"></span> Regresar</button>
</center>
            <div class="alert alert-danger" v-if="errors.length">
             <h4>Errores:</h4>
             <ul>
               <li v-for="(error,index) in errors"  :key="index">{{ error }}</li>
            </ul>
           </div>

        <!-- <form  class="form" ref="formTransactionIncome" id="formTransaction" role="form" @submit.prevent="createUpdateSubcontractor()"> -->
<!-- @on-complete="createUpdateSubcontractor" -->
<form-wizard @on-complete="createUpdateSubcontractor" ref="wizard" step-size="xs" title="" subtitle="" shape="circle" next-button-text="Siguiente" back-button-text="Anterior">
    <!-- :before-change="validateFirstOption" -->
    <tab-content name="step1" title="Detalles personales" :before-change="validateFirstOption" >

         <div class="form-group col-lg-8">
            <i class="fas fa-user-tie"></i> <label for="formSubcontType">TIPO DE SUBCONTRATISTA</label>
            <select class="form-control" id="formSubcontType" v-model="subcontractor.subcontType">
                <option value="COMPANY">Compañia</option>
                <option value="INDIVIDUAL">Individual</option>
            </select>
        </div>

         <div class="form-group col-lg-6 ">
                <i class="fas fa-id-card-alt"></i> <label for="formDNIType">TIPO DNI</label>
                 <input type="text" class="form-control" id="formDNIType" v-model="subcontractor.typeTaxId" placeholder="EIN, ITIN, SSN" autocomplete="off">
          </div>

        <div class="form-group col-lg-6 ">
               <i class="far fa-id-card"></i> <label for="formDNI">DNI</label>
                  <input type="text" class="form-control" id="formDNI" v-model="subcontractor.taxId" placeholder="" autocomplete="off ">
          </div>
        <div class="form-group col-lg-6" v-if="subcontractor.subcontType == 'COMPANY'">
              <i class="fas fa-user-edit"></i><label for="formName">NOMBRE DE LA COMPANIA</label>
                  <input type="text" class="form-control" id="formName" v-model="subcontractor.companyName" placeholder="" autocomplete="off ">
          </div>

         <div class="form-group col-lg-6 ">
              <i class="fas fa-user-friends"></i> <label for="formRepresentative">NOMBRE Y APELLIDO / REPRESENTANTE</label>
                  <input type="text" class="form-control" id="formRepresentative" v-model="subcontractor.subcontractorName"  autocomplete="off ">
        </div>

       <div class="row"></div>
       <div class="form-group col-lg-6 ">
               <i class="fas fa-map-marked-alt"></i> <label for="formAddress">DIRECCION DE FACTURACION</label>
                  <input type="text" class="form-control" id="formAddress" v-model="subcontractor.address" placeholder="" autocomplete="off ">
          </div>

        <div class="row"></div>
        <div class="form-group col-lg-6 ">
             <i class="fas fa-phone-square"></i>  <label for="formMainPhone">TELEFONO PRIMARIO</label>
                  <!-- <input type="text" class="form-control" id="formMainPhone" v-model="subcontractor.mainPhone" placeholder="" autocomplete="off "> -->
                  <vue-phone-number-input size="sm" default-country-code="US" v-model="subcontractor.mainPhone" />
          </div>

        <div class="form-group col-lg-6 ">
              <i class="fas fa-tty"></i>   <label for="formSecondaryPhone">TELEFONO SECUNDARIO</label>
                  <!-- <input type="text" class="form-control" id="formSecondaryPhone" v-model="subcontractor.secondaryPhone" placeholder="" autocomplete="off "> -->
                  <vue-phone-number-input size="sm" default-country-code="US" v-model="subcontractor.secondaryPhone" />
           </div>

         <div class="form-group col-lg-6 ">
                <i class="fas fa-at"></i> <label for="formEmail">CORREO</label>
                  <input type="email" class="form-control" id="formEmail" v-model="subcontractor.mainEmail" placeholder="" autocomplete="off ">
        </div>

       <div class="form-group col-lg-6 ">
                <i class="fas fa-at"></i> <label for="formEmail">CORREO SECUNDARIO</label>
                  <input type="email" class="form-control" id="formEmail" v-model="subcontractor.secondaryEmail" placeholder="" autocomplete="off ">
        </div>

         <div class="form-group col-lg-12 ">
                <label for="typeForm1099">TIPO DE FORM 1099</label>
                <select class="form-control" id="typeForm1099" v-model="subcontractor.typeForm1099">
                  <option value="1099_MISC">1099 MISC</option>
                  <option value="1099_NEC">1099 NEC</option>
                </select>
        </div>
    </tab-content>

    <tab-content title="Información Financiera">
        <div class="form-group col-lg-6 ">
               <i class="fas fa-piggy-bank"></i>  <label for="formBankName">BANCO</label>
                  <input type="text" class="form-control" id="formBankName" v-model="subcontractor.bankName" placeholder="" autocomplete="off ">
          </div>
        <div class="form-group col-lg-6 ">
               <i class="fas fa-user-check"></i>  <label for="formHeadline">TITULAR DEL BANCO</label>
                  <input type="text" class="form-control" id="formHeadline" v-model="subcontractor.headline" placeholder="" autocomplete="off ">
          </div>

         <div class="form-group col-lg-6 ">
              <i class="fas fa-money-check-alt"></i>   <label for="formAccountNumber">NUMERO DE CUENTA</label>
                  <input type="text" class="form-control" id="formAccountNumber" v-model="subcontractor.accountNumber" placeholder="" autocomplete="off ">
        </div>

         <div class="form-group col-lg-6 ">
                <i class="fas fa-user-chart"></i> <label for="formRoutingNumber">NUMERO DE RUTA</label>
                  <input type="text" class="form-control" id="formRoutingNumber" v-model="subcontractor.routingNumber" placeholder="" autocomplete="off ">
        </div>

        <div class="form-group col-lg-6 ">
               <i class="fas fa-people-arrows"></i>  <label for="formWires">WIRES</label>
                  <input type="text" class="form-control" id="formWires" v-model="subcontractor.wires" placeholder="" autocomplete="off ">
        </div>

         <div class="form-group col-lg-6 ">
              <i class="fas fa-comments-dollar"></i>   <label for="formZelle">ZELLE</label>
                  <input type="text" class="form-control" id="formZelle" v-model="subcontractor.zelle" placeholder="" autocomplete="off ">
        </div>       
    </tab-content>
    <!-- <tab-content title="Documentos">
        <input type="file" ref="file" multiple="multiple">
    </tab-content>
        <tab-content title="Verificacion">
        Cuarto paso
    </tab-content> -->
    
</form-wizard>
        
  
                    <!-- </form> -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        mounted() {
         console.log('componente agregar Subcontratista montado');

            if (this.editId > 0) {
                // transaction to edit.
                axios.get(`/subcontractors/${this.editId}`).then((response) => {
                    let data = response.data[0]

                    this.subcontractor.subcontType = data.subcontType;
                    this.subcontractor.typeTaxId = data.typeTaxId;
                    this.subcontractor.taxId = data.taxId;
                    this.subcontractor.companyName = data.companyName;
                    this.subcontractor.subcontractorName = data.subcontractorName;
                    this.subcontractor.address = data.address;
                    this.subcontractor.mainPhone = data.mainPhone;
                    this.subcontractor.secondaryPhone = data.secondaryPhone;
                    this.subcontractor.mainEmail = data.mainEmail;
                    this.subcontractor.secondaryEmail = data.secondaryEmail;
                    this.subcontractor.typeForm1099 = data.typeForm1099;

                    this.subcontractor.bankName = data.bankName;
                    this.subcontractor.headline = data.headline;
                    this.subcontractor.accountNumber = data.accountNumber;
                    this.subcontractor.routingNumber = data.routingNumber;
                    this.subcontractor.wires = data.wires;
                    this.subcontractor.zelle = data.zelle;

                    console.log(typeof(this.subcontractor.accountNumber));
                });
            } 
            // else{
            //     this.subcontractor.payMethodId = 1;
            // }     
        },
        data(){
            return{
                errors: [],
                showSubmitBtn:true,

                subcontractor:  {
                    subcontType: 'INDIVIDUAL',
                    typeTaxId: '',
                    taxId: '',
                    companyName: '',
                    subcontractorName: '',
                    address: '',
                    mainPhone: '',
                    secondaryPhone: '',
                    mainEmail: '',
                    secondaryEmail: '',
                    typeForm1099: '1099_MISC',

                    bankName: '',
                    headline: '',
                    accountNumber: '',
                    routingNumber: '',
                    wires: '',
                    zelle: '',
                },

            }
         },
       props: {
            editId:'',
        },
        methods: {
           validateFirstOption(){
            //    return true
               this.errors = [];
                  
                 if(this.subcontractor.subcontType =='COMPANY'){
                     if(!this.subcontractor.companyName)
                      this.errors.push('Debe ingresar el nombre de la compania.');
                 }

                 if (!this.subcontractor.subcontractorName) 
                this.errors.push('Debe ingresar el nombre del subcontratista.');

                 if (!this.subcontractor.mainPhone) 
                this.errors.push('El Telefono Principal Es obligatorio.');
                  
                  if(this.errors == ''){
                     return true
                  }else{
                      return false
                  }
           }, 
            createUpdateSubcontractor(){
           if (!this.errors.length) { 

                 let formData = new FormData();
                     formData.append('subcontType',this.subcontractor.subcontType);
                     formData.append('typeTaxId',this.subcontractor.typeTaxId);
                     formData.append('taxId',this.subcontractor.taxId);
                     formData.append('companyName',this.subcontractor.companyName);
                     formData.append('subcontractorName',this.subcontractor.subcontractorName);
                     formData.append('address',this.subcontractor.address);
                     formData.append('mainPhone',this.subcontractor.mainPhone);
                     formData.append('secondaryPhone',this.subcontractor.secondaryPhone);
                     formData.append('mainEmail', this.subcontractor.mainEmail);
                     formData.append('secondaryEmail', this.subcontractor.secondaryEmail);
                     formData.append('typeForm1099', this.subcontractor.typeForm1099);

                     formData.append('bankName', this.subcontractor.bankName);
                     formData.append('headline', this.subcontractor.headline);
                     formData.append('accountNumber', JSON.stringify(this.subcontractor.accountNumber));
                     formData.append('routingNumber', JSON.stringify(this.subcontractor.routingNumber));
                     formData.append('wires', JSON.stringify(this.subcontractor.wires));
                     formData.append('zelle', JSON.stringify(this.subcontractor.zelle));


                if (this.editId === 0) {
                     this.showSubmitBtn =false;

                    axios.post('/subcontractors', formData)
                    .then((response) => {
                         toastr.success(response.data.message);
                           this.$emit('showlist', 0)
                        })
                    .catch(function (response) {
                        alert("Error de Servidor")
                         this.showSubmitBtn =true;
                    });

                }else {
                    formData.append("_method", "put");
                    console.log(formData);
                    
                    axios.post(`/subcontractors/${this.editId}`, formData,{ 
                           headers: {
                            'Content-Type': 'application/json'
                             }})
                    .then((response) => {
                        toastr.success(response.data.message);
                        this.$emit('showlist', 0);
                        })
                    .catch(function (error) {
                        console.log(error);
                    });
                }   // else end   
             }  //end if error.length 
            },
            cancf(n){
                console.log('vista a mostrar: ' + n)
                this.$emit('showlist', 0)
            },
            
        }
    }

</script>