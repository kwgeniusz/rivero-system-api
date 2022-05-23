<template>
    <div class="row">
      <!-- <sweet-modal ref="modalNew" @close="cancf"> -->

        <div class="col-md-6 col-md-offset-2 col-xs-12">
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
        <form  class="form" id="formgeneralLedger" role="form" @submit.prevent="createUpdateAccount()">

         <div class="form-group col-lg-12 ">
              <label for="accountTypeCode">TIPO:</label>
              <v-select :options="accountTypeList" v-model="generalLedger.accountTypeCode" :reduce="accountTypeList => accountTypeList.accountTypeCode" label="accountTypeName" />
          </div>    
         <div class="form-group col-lg-12">
              <label for="parentAccountId">CUENTA PADRE:</label>
                     <v-select :options="chartOfAccount" v-model="generalLedger.parentAccountId" :reduce="chartOfAccount => chartOfAccount.generalLedgerId" label="item_data" /> 
          </div>

        <div class="form-group col-lg-7">
               <label for="accountCode"> CODIGO DE CUENTA:</label>
                <input type="text" class="form-control" v-model="generalLedger.accountCode" name="accountCode" placeholder="">
        </div>

       <div class="form-group col-lg-10">
               <label for="accountName"> NOMBRE DE CUENTA:</label>
                <input type="text" class="form-control" v-model="generalLedger.accountName" name="accountName" placeholder="">
        </div>

        <div class="form-group col-lg-10">
               <label for="leftMargin"> MARGEN IZQUIERDO:</label>
                <input type="number" class="form-control" v-model="generalLedger.leftMargin" name="leftMargin" placeholder="">
        </div>

         <div class="form-group col-lg-12 ">
              <label for="accountClassificationCode">CLASIFICACION:</label>
                 <v-select :options="accountClassificationList" v-model="generalLedger.accountClassificationCode" :reduce="accountClassificationList => accountClassificationList.accountClassificationCode" label="accountClassificationName" /> 
          </div>  

         <div class="form-group col-lg-12 ">
              <label for="accountClassificationCode">ENTIDAD:</label>
                 <v-select :options="entitiesList" v-model="generalLedger.entityId" :reduce="entitiesList => entitiesList.entityId" label="item_data" /> 
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
          axios.get('/accounting/general-ledgers/create').then((response) => {
                  this.chartOfAccount            = response.data.chartOfAccount;
                  this.chartOfAccount.map(function (x){
                       return x.item_data = `${x.accountCode} - (${x.accountName})`;
                   });
                  this.accountTypeList           = response.data.accountTypeList;
                  this.accountClassificationList = response.data.accountClassificationList;
                  this.entitiesList              = response.data.entitiesList;
                  this.entitiesList.map(function (x){
                       return x.item_data = `${x.entityName} - (${x.entityKey})`;
                  });

            }); //end of create clients

            if (this.editId > 0) {
                // transaction to edit.
                axios.get(`/accounting/general-ledgers/${this.editId}`).then((response) => {
                    this.data = response.data[0]

                    this.generalLedger.accountCode                = this.data.accountCode;
                    this.generalLedger.accountName                = this.data.accountName;
                    this.generalLedger.leftMargin                 = this.data.leftMargin;
                    this.generalLedger.parentAccountId            = this.data.parentAccountId;
                    this.generalLedger.accountClassificationCode  = this.data.accountClassificationCode;
                    this.generalLedger.accountTypeCode            = this.data.accountTypeCode;
                    this.generalLedger.entityId                   = this.data.entityId;
                });    
            } 
        },
        data(){
            return{
                errors: [],
                showSubmitBtn:true,

                chartOfAccount: [],
                accountTypeList: [],
                accountClassificationList:[],

                generalLedger:  {                    
                   accountCode:'',
                   accountName:'',
                   leftMargin:'',
                   parentAccountId:'',
                   accountClassificationCode:'',
                   accountTypeCode:'',
                   entityId:'',
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

        
            //    if (!this.generalLedger.parentAccountId) 
            //     this.errors.push('Campo Cuenta Padre es requerido.');
                

                 if (!this.generalLedger.accountCode) 
                this.errors.push('Codigo de la Cuenta es Requerido.');
                 if (!this.generalLedger.accountName) 
                this.errors.push('Nombre de la Cuenta es Requerido.');
                 if (!this.generalLedger.leftMargin) 
                this.errors.push('Ingrese un Valor numerico para el Margen.');
                if (!this.generalLedger.accountClassificationCode) 
                this.errors.push('La Clasificacion de la Cuenta es obligatoria.');
                if (!this.generalLedger.accountTypeCode) 
                this.errors.push('El tipo de Cuenta es Obligatorio.');

           if (!this.errors.length) { 
                if (this.editId === 0) {  
                    this.showSubmitBtn = false;
                    
                    axios.post('/accounting/general-ledgers', this.generalLedger).then((response) => {
                           toastr.success(response.data.message);
                          //  this.cancf()
                           this.$emit('showlist', 0)
                    }).catch((error) => {
                    //   this.errors.push(error.response.data.errors.businessPhone);
                    //   this.errors.push(error.response.data.errors.mainEmail);
                      this.showSubmitBtn = true;
                    });

                }else {
                    axios.put(`/accounting/general-ledgers/${this.editId}`, this.generalLedger).then((response) => {
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

