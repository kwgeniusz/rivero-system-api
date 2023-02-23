<template>
    <div class="">
    <!-- agregar -->
        <div v-if="formStatus === 1">
            <intercompany-addUp-time-frame-equivalence
                @showlist = "showlist"
                :editId=0
            > </intercompany-addUp-time-frame-equivalence> 
        </div>

    <!-- Vista actualizar -->
        <div v-if="formStatus === 2">
            <intercompany-addUp-time-frame-equivalence
                @showlist = "showlist"
                :editId=editId                
            > </intercompany-addUp-time-frame-equivalence> 
        </div>

    <!-- botones y listado -->
        <div v-if="formStatus === 0">
         <h3><b>EQUIVALENCIA DE PERIODOS DE TIEMPO DE LOCALES A EXTERNOS</b></h3>

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
    
            <intercompany-table-time-frame-equivalence  
                :timeFrameEquivalenceList = timeFrameEquivalenceList
                @editData = "editData"
                @showlist = "showlist">
            </intercompany-table-time-frame-equivalence>

        </div>  

    </div>         
</template>

<script>
    export default {
        mounted() {
            
            axios.get(`/intercompany/time-frame-equivalences`,  { params: { companyToLinkId: this.companyToLinkId } }).then((response) => {
                this.timeFrameEquivalenceList = response.data
                // console.log(this.timeFrameEquivalenceList)
            })
        },
        data() {
            return{
                companyToLinkId: 1,
                timeFrameEquivalenceList: [],
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
                axios.get(`/intercompany/time-frame-equivalences`, { params: { companyToLinkId: this.companyToLinkId } }).then((response) => {
                    this.timeFrameEquivalenceList = response.data
                    // console.log(this.timeFrameEquivalenceList)
                })
            },
           setCompanyValue(value) {
             this.companyToLinkId = value;
             this.showlist();
          },
        }
    }

</script>