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
               <label for="accountCode"> CODIGO DE CUENTA:</label>
                <input type="text" class="form-control" v-model="generalLedger.accountCode" name="accountCode" placeholder="">
        </div>

       <div class="form-group col-lg-10">
               <label for="accountName"> NOMBRE DE CUENTA:</label>
                <input type="text" class="form-control" v-model="generalLedger.accountName" name="accountName" placeholder="">
        </div>

        <div class="form-group col-lg-12 ">
              <label for="parentAccountCode">CUENTA PADRE:</label>
                   <select class="form-control" v-model="generalLedger.parentAccountCode" id="parentAccountCode">
                      <option v-for="item in chartOfAccount" :key="item.generalLedgerId" :value="item.generalLedgerId">{{item.accountCode}} - {{item.accountName}}</option>
                  </select>
          </div>

         <div class="form-group col-lg-12 ">
              <label for="accountClassificationCode">CLASIFICACION:</label>
                   <select class="form-control" v-model="generalLedger.accountClassificationCode" id="accountClassificationCode">
                      <option v-for="item in accountClassificationList" :key="item.accountClassificationCode" :value="item.accountClassificationCode">{{item.accountClassificationName}}</option>
                  </select>
          </div>  

         <div class="form-group col-lg-12 ">
              <label for="accountTypeCode">TIPO:</label>
                   <select class="form-control" v-model="generalLedger.accountTypeCode" id="accountTypeCode">
                      <option v-for="item in accountTypeList" :key="item.accountTypeCode" :value="item.accountTypeCode">{{item.accountTypeName}}</option>
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
            //obtengo los datos para llenar las listas de selects
          axios.get('/general-ledger/create').then((response) => {
              console.log(response.data)
                  this.chartOfAccount            = response.data.chartOfAccount;
                  this.accountTypeList           = response.data.accountTypeList;
                  this.accountClassificationList = response.data.accountClassificationList;
            }); //end of create clients

            if (this.editId > 0) {
                // transaction to edit.
                axios.get(`/general-ledger/${this.editId}`).then((response) => {
                    // this.data = response.data[0]

                    // this.clientNumberFormat   = this.data.clientCode;
                    // this.client.clientType    = this.data.clientType;
                    // this.client.companyName   = this.data.companyName;
                    // this.client.clientName    = this.data.clientName;
                    // this.client.gender        = this.data.gender;
                    // this.client.clientAddress = this.data.clientAddress;
                    // this.client.businessPhone = this.data.businessPhone;
                    // this.client.homePhone     = this.data.homePhone;
                    // this.client.mobilePhone   = this.data.mobilePhone;
                    // this.client.otherPhone    = this.data.otherPhone;
                    // this.client.fax           = this.data.fax;
                    // this.client.mainEmail     = this.data.mainEmail;
                    // this.client.secondaryEmail = this.data.secondaryEmail;
                    // this.client.contactTypeId = this.data.contactTypeId;
                });       
            } 
        },
        data(){
            return{
                errors: [],
                showSubmitBtn:true,

                chartOfAccount:'',
                accountTypeList:'',
                accountClassificationList:'',

                generalLedger:  {                    
                   accountCode:'',
                   accountName:'',
                   parentAccountCode:'',
                   accountClassificationCode:'',
                   accountTypeCode:'',
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

                 if (!this.generalLedger.accountCode) 
                this.errors.push('El Nombre del generalLedgere es obligatorio.');
                 if (!this.generalLedger.accountName) 
                this.errors.push('El Genero es obligatorio.');
                 if (!this.generalLedger.parentAccountCode) 
                this.errors.push('El Telefono para Negocios es obligatorio.');
                if (!this.generalLedger.accountClassificationCode) 
                this.errors.push('Debe ingresar el email principal.');
                if (!this.generalLedger.accountTypeCode) 
                this.errors.push('Debe escoger el metodo con el que se contacto al cliente.');


           if (!this.errors.length) { 
                if (this.editId === 0) {  
                    this.showSubmitBtn = false;
                    
                    axios.post('/clients', this.client).then((response) => {
                           toastr.success(response.data.message);
                          //  this.cancf()
                           this.$emit('showlist', 0)
                    })
                    .catch((error) => {
                      this.errors.push(error.response.data.errors.businessPhone);
                      this.errors.push(error.response.data.errors.mainEmail);

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