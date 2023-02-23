<template>
    <div class="">

        <!-- agregar -->
        <div v-if="formStatus === 1">
            <inventory-addUp-service
                @showlist = "showlist"
                :editId=0
            > </inventory-addUp-service> 
        </div>

        <!-- Vista actualizar -->
        <div v-if="formStatus === 2">
            <inventory-addUp-service
                @showlist = "showlist"
                :editId=editId                
            > </inventory-addUp-service> 
        </div>


        <!-- botones y listado -->
        <div v-if="formStatus === 0">
            <h3><b>CATALOGO DE SERVICIOS</b></h3>

            <button-form
                @addf = "addFormStatus"
                :buttonType = 0
                :btn4 = 0
            ></button-form>

            <inventory-table-service  
                :serviceList = serviceList
                @editData = "editData"
                @showlist = "showlist">
            </inventory-table-service>
            
        </div>  

    </div>         
</template>

<script>
    export default {
        mounted() {
            axios.get('/services').then((response) => {
                this.serviceList = response.data
            })
        
        },
        data() {
            return{
                serviceList: [],

                formStatus: 0,
                editId: '',
            }
        },
        methods: {
            addFormStatus(){
                this.formStatus = 1
            },
            editData(id){
                this.editId = id
                this.formStatus = 2
            }, 
            showlist(n){
                this.formStatus = 0
                axios.get('/services').then((response) => {
                    this.serviceList  = response.data
                })
            },
        }
    }

</script>