<template>
    <div class="">
        <!-- agregar -->
        <div v-if="formStatus === 1">
            <addUp-client
                @showlist = "showlist"
                :editId=0
            > </addUp-client> 
        </div>

        <!-- Vista actualizar -->
        <div v-if="formStatus === 2">
            <addUp-client
                @showlist = "showlist"
                :editId=editId                
            > </addUp-client> 
        </div>


        <!-- botones y listado -->
        <div v-if="formStatus === 0">
            <h3><b>CLIENTES</b></h3>

            <button-form
                @addf = "addFormStatus"
                :buttonType = 0
                :btn4 = 0
            ></button-form>

            <table-client  
                :clientList = clientList
                @editData = "editData"
                @showlist = "showlist">
            </table-client>
        </div>  

    </div>         
</template>

<script>
    export default {
        mounted() {

            axios.get('/clients').then((response) => {
                this.clientList = response.data
            console.log(this.clientList)
            })
        
        },
        data() {
            return{
                clientList: [],
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
            upDepartment( company){
                // console.log(company)
                // this.clientList[company[0]] = company[1]
            },
            // carga(){
            //     XMLHttpRequest.onprogress = function (event) {
            //     event.loaded;
            //     event.total;
            //     };
            // },
            showlist(n){
                this.formStatus = 0
                axios.get('/clients').then((response) => {
                    this.clientList = response.data
                    // console.log(this.clientList)
                })
            
            
            },
        }
    }

</script>