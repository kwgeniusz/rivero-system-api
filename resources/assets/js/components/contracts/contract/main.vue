<template>
    <div class="">
        <!-- agregar -->
        <!-- <div v-if="formStatus === 1">
            <addUp-contract
                @showlist = "showlist"
                :editId=0
            > </addUp-contract> 
        </div> -->

        <!-- Vista actualizar -->
        <!-- <div v-if="formStatus === 2">
            <addUp-contract
                @showlist = "showlist"
                :editId=editId                
            > </addUp-contract> 
        </div> -->


        <!-- botones y listado -->
        <div v-if="formStatus === 0">
            <h3><b>CONTRATOS</b></h3>

            <!-- <button-form
                @addf = "addFormStatus"
                :buttonType = 0
                :btn4 = 0
            ></button-form> -->

            <table-contract  
                :contractList = contractList
                @editData = "editData"
                @showlist = "showlist">
            </table-contract>
        </div>  

    </div>         
</template>

<script>
    export default {
        mounted() {
            axios.get('/contracts').then((response) => {
                this.contractList = response.data
            })
        },
        data() {
            return{
                contractList: [],
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
                // this.contractList[company[0]] = company[1]
            },
            // carga(){
            //     XMLHttpRequest.onprogress = function (event) {
            //     event.loaded;
            //     event.total;
            //     };
            // },
            showlist(n){
                this.formStatus = 0
                axios.get('/contracts').then((response) => {
                    this.contractList = response.data
                    // console.log(this.contractList)
                })
            
            
            },
        }
    }

</script>