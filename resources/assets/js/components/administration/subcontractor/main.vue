<template>
    <div class="">
        <!-- agregar -->
        <div v-if="formStatus === 1">
            <addUp-subcontractor
                @showlist = "showlist"
                :editId=0
            > </addUp-subcontractor> 
        </div>

        <!-- Vista actualizar -->
        <div v-if="formStatus === 2">
            <addUp-subcontractor
                @showlist = "showlist"
                :editId=editId                
            > </addUp-subcontractor> 
        </div>


        <!-- botones y listado -->
        <div v-if="formStatus === 0">
            <h3><b>SUBCONTRATISTAS</b></h3>

            <button-form
                @addf = "addFormStatus"
                :buttonType = 0
                :btn4 = 0
            ></button-form>

            <table-subcontractor  
                :subcontractorList  = subcontractorList
                @editData = "editData"
                @showlist = "showlist">
            </table-subcontractor>
        </div>  

    </div>         
</template>

<script>
    export default {
        mounted() {

            axios.get('/subcontractors').then((response) => {
                // console.log(response.data)
                this.subcontractorList = response.data
            })
        
        },
        data() {
            return{
                subcontractorList: [],

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
                axios.get('/subcontractors').then((response) => {
                    this.subcontractorList  = response.data
                })
            },
        }
    }

</script>