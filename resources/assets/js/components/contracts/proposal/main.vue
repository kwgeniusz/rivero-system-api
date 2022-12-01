<template>
    <div class="">
        <!-- agregar -->
        <!-- <div v-if="formStatus === 1">
            <addUp-proposal
                @showlist = "showlist"
                :editId=0
            > </addUp-proposal> 
        </div> -->

        <!-- Vista actualizar -->
        <!-- <div v-if="formStatus === 2">
            <addUp-proposal
                @showlist = "showlist"
                :editId=editId                
            > </addUp-proposal> 
        </div> -->

       <!-- Vista de Subcontratistas -->
        <div v-if="formStatus === 3">
            <subcontractor-proposal
                @showlist = "showlist"
                :proposalId = proposalId                 
            > </subcontractor-proposal> 
        </div>

        <!-- botones y listado -->
        <div v-if="formStatus === 0">
            <h3><b>COTIZACIONES</b></h3>

            <button-form
                @addf = "addFormStatus"
                :buttonType = 0
                :btn4 = 0
            ></button-form>

            <table-proposal  
                :proposalList = proposalList
                @editData = "editData"
                @subcontractors = "subcontractors"
                @showlist = "showlist">
            </table-proposal>
        </div>  

    </div>         
</template>

<script>
    export default {
        mounted() {
            axios.get('/proposals').then((response) => {
                this.proposalList = response.data
            })
        },
        data() {
            return{
                proposalList: [],
                // parents: [],
                formStatus: 0,
                editId: '',
                proposalId: '',
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
            subcontractors(proposalId){
                // console.log('el id es: ' + id)
                this.proposalId = proposalId
                this.formStatus = 3
            }, 
            upDepartment( company){
                // console.log(company)
                // this.proposalList[company[0]] = company[1]
            },
            // carga(){
            //     XMLHttpRequest.onprogress = function (event) {
            //     event.loaded;
            //     event.total;
            //     };
            // },
            showlist(n){
                this.formStatus = 0
                axios.get('/proposals').then((response) => {
                    this.proposalList = response.data
                    // console.log(this.proposalList)
                })
            
            
            },
        }
    }

</script>