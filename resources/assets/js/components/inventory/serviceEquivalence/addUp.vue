<template>
    <div class="row">
      <!-- <sweet-modal ref="modalNew" @close="cancf"> -->

        <div class="col-md-6 col-md-offset-2 col-xs-12">
            <div class="panel panel-default">

            <div v-if="editId === 0" class="panel-heading" style="background: #dff0d8"><h4 class="text-uppercase">Enlazar Servicio</h4></div>
            <div v-else class="panel-heading" style="background: #d9edf7"><h4 class="text-uppercase">Actualizar Cuenta</h4></div>

        <div class="panel-body">
            <div class="alert alert-danger" v-if="errors.length">
              <h4>Errores:</h4>
               <ul>
                 <li v-for="(error,index) in errors" :key="index">{{ error }}</li>
              </ul>
           </div>

      <p class="text-right"> <label style="color:red">* </label>REQUERIDOS </p>
        <form  class="form" id="formgeneralLedger" role="form" @submit.prevent="linkService()">

        <label for="parentAccountId">ESCOJA UNA EMPRESA PARA ENLAZAR:</label>
        <select-country-office pref-url="/" @company-value="setCompanyValue"></select-country-office>

         <div class="form-group col-lg-12" v-if="companyToLinkId">
              <label for="accountTypeCode">SERVICIOS LOCALES SIN ENLAZAR:</label>
              <v-select :options="localServiceList" v-model="form.localService" :reduce="localServiceList => localServiceList" label="serviceName" />
          </div> 


         <div class="form-group col-lg-12" v-if="companyToLinkId">
              <label for="parentAccountId">SERVICIOS EXTERNOS SIN ENLAZAR:</label>
              <v-select :options="destinationServiceList" v-model="form.destinationService" :reduce="destinationServiceList => destinationServiceList" label="serviceName" /> 
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
             this.getCreateData();

            if (this.editId > 0) {
                // transaction to edit.
                axios.get(`/service-equivalences/${this.editId}`).then((response) => {
                    this.data = response.data[0]
                    this.generalLedger.accountCode  = this.data.accountCode;
                    this.generalLedger.accountName  = this.data.accountName;
                });    
            } 
        },
        data(){
            return{
                errors: [],
                showSubmitBtn:true,

                localServiceList: [],
                destinationServiceList: [],
                companyToLinkId: 1,
                
                form: { 
                  localService: {},
                  destinationService: {}
                }, 
            }
         },
      props: {
            editId:'',
        },
      methods: {
            linkService(){
              this.errors = [];

                 if (!this.form.localService.serviceId) 
                this.errors.push('Debe escoger un servicio local.');
                 if (!this.form.destinationService.serviceId) 
                this.errors.push('Debe escoger un servicio de destino.');

           if (!this.errors.length) { 
                if (this.editId === 0) {  
                    this.showSubmitBtn = false;
                    
                    axios.post('/service-equivalences',this.form).then((response) => {
                           toastr.success(response.data.message);
                          //  this.cancf()
                           this.$emit('showlist', 0)
                    }).catch((error) => {
                    //   this.errors.push(error.response.data.errors.businessPhone);
                    //   this.errors.push(error.response.data.errors.mainEmail);
                      this.showSubmitBtn = true;
                    });

                }else {
                    axios.put(`/service-equivalences/${this.editId}`, this.generalLedger).then((response) => {
                          toastr.success(response.data.message);
                          this.$emit('showlist', 0)
                        })
                    .catch(function (error,response) {
                         toastr.success(response.data.message);
                    });
                }   // else end   
              }  //end if error.length 
            },
           getCreateData(){
                  axios.get('service-equivalences/create',  { params: { companyToLinkId: this.companyToLinkId } }).then((response) => {
                  this.localServiceList           = response.data.localServiceList;
                  this.destinationServiceList     = response.data.destinationServiceList;
                });
            },
           setCompanyValue(value) {
             this.companyToLinkId = value;
             this.getCreateData();
          },
            cancf(n){
                // console.log('vista a mostrar: ' + n)
                this.$emit('showlist', 0)
                this.$emit('close') 
            },
        }
    }

</script>

