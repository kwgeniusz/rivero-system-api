<template>
    <div class="">
    <!-- agregar -->
        <div v-if="formStatus === 1">
            <intercompany-addUp-note-equivalence
                @showlist = "showlist"
                :editId=0
            > </intercompany-addUp-note-equivalence> 
        </div>

    <!-- Vista actualizar -->
        <div v-if="formStatus === 2">
            <intercompany-addUp-note-equivalence
                @showlist = "showlist"
                :editId=editId                
            > </intercompany-addUp-note-equivalence> 
        </div>

    <!-- botones y listado -->
        <div v-if="formStatus === 0">
         <h3><b>EQUIVALENCIA DE NOTAS DE PROPUESTAS LOCALES A EXTERNAS</b></h3>

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
    
            <intercompany-table-note-equivalence  
                :noteEquivalenceList = noteEquivalenceList
                @editData = "editData"
                @showlist = "showlist">
            </intercompany-table-note-equivalence>

        </div>  

    </div>         
</template>

<script>
    export default {
        mounted() {
            
            axios.get(`/intercompany/note-equivalences`,  { params: { companyToLinkId: this.companyToLinkId } }).then((response) => {
                this.noteEquivalenceList = response.data
                // console.log(this.noteEquivalenceList)
            })
        },
        data() {
            return{
                companyToLinkId: 1,
                noteEquivalenceList: [],
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
                axios.get(`/intercompany/note-equivalences`, { params: { companyToLinkId: this.companyToLinkId } }).then((response) => {
                    this.noteEquivalenceList = response.data
                    // console.log(this.noteEquivalenceList)
                })
            },
           setCompanyValue(value) {
             this.companyToLinkId = value;
             this.showlist();
          },
        }
    }

</script>