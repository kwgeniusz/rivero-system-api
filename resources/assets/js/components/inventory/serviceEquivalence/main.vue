<template>
    <div class="">
    <!-- agregar -->
        <div v-if="formStatus === 1">
            <inventory-addUp-service-equivalence
                @showlist = "showlist"
                :editId=0
            > </inventory-addUp-service-equivalence> 
        </div>

    <!-- Vista actualizar -->
        <div v-if="formStatus === 2">
            <inventory-addUp-service-equivalence
                @showlist = "showlist"
                :editId=editId                
            > </inventory-addUp-service-equivalence> 
        </div>

    <!-- botones y listado -->
        <div v-if="formStatus === 0">
         <h3><b>EQUIVALENCIA DE SERVICIOS LOCALES A EXTERNOS</b></h3>

         <div class="panel panel-default" >
            <div class="container">
                <div class="row">
                   <div class="col-xs-4">
                     <select-country-office pref-url="/" @company-value="setCompanyValue"></select-country-office>
                  </div>   
              
                  <div class="col-xs-4">
                    <button-form
                         @addf = "addFormStatus"
                         :buttonType = 0
                         :btn4 = 0
                     ></button-form>
                  </div> 
              
                 <div class="col-xs-4">
               
                  </div>
                 </div>
             </div>
         </div>
    
            <inventory-table-service-equivalence  
                :serviceEquivalenceList = serviceEquivalenceList
                @editData = "editData"
                @showlist = "showlist">
            </inventory-table-service-equivalence>

        </div>  

    </div>         
</template>

<script>
    export default {
        mounted() {
            
            axios.get(`/service-equivalences`,  { params: { companyToLinkId: this.companyToLinkId } }).then((response) => {
                this.serviceEquivalenceList = response.data
                // console.log(this.serviceEquivalenceList)
            })
        },
        data() {
            return{
                companyToLinkId: 1,
                serviceEquivalenceList: [],
                // parents: [],
                formStatus: 0,
                editId: '',
            }
        },
        methods: {
            addFormStatus(){
                this.formStatus = 1
            },
            editData(id){
                // console.log('el id es: ' + id)
                this.editId = id
                this.formStatus = 2
            }, 
            showlist(n){
                this.formStatus = 0
                axios.get(`/service-equivalences`, { params: { companyToLinkId: this.companyToLinkId } }).then((response) => {
                    this.serviceEquivalenceList = response.data
                    // console.log(this.serviceEquivalenceList)
                })
            },
           setCompanyValue(value) {
             this.companyToLinkId = value;
             this.showlist();
          },
        }
    }

</script>