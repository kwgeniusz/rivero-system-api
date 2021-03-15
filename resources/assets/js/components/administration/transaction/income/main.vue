<template>
    <div class="">
        <!-- agregar -->
        <div v-if="formStatus === 1">
            <addUp-transaction-income
                @showlist = "showlist"
                :editId=0
            > </addUp-transaction-income> 
        </div>

        <!-- Vista actualizar -->
        <div v-if="formStatus === 2">
            <addUp-transaction-income
                @showlist = "showlist"
                :editId=editId                
            > </addUp-transaction-income> 
        </div>


        <!-- botones y listado -->
        <div v-if="formStatus === 0">
            <h3><b>TRANSACCIONES DE INGRESO</b></h3>

            <button-form
                @addf = "addFormStatus"
                :buttonType = 0
                :btn4 = 0
            ></button-form>

            <table-transaction-income  
                :transactionList = transactionList
                @editData = "editData"
                @showlist = "showlist">
            </table-transaction-income>
        </div>  

    </div>         
</template>

<script>
    export default {
        mounted() {

            axios.get('/transactions/+').then((response) => {
                this.transactionList = response.data
            console.log(this.transactionList)
            })
        
        },
        data() {
            return{
                transactionList: [],
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
            // carga(){
            //     XMLHttpRequest.onprogress = function (event) {
            //     event.loaded;
            //     event.total;
            //     };
            // },
            showlist(n){
                this.formStatus = 0
                axios.get('/transactions/+').then((response) => {
                    this.transactionList = response.data
                })
            
            
            },
        }
    }

</script>