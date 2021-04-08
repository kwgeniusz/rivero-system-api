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
                :transactionList  = transactionList
                :transactionCodes = transactionCodes
                @editData = "editData"
                @showlist = "showlist">
            </table-transaction-income>
        </div>  

    </div>         
</template>

<script>
    export default {
        mounted() {

            axios.get('/transactions/+/index').then((response) => {
                // console.log(response.data.fee)
                this.transactionList = response.data.transaction
                this.transactionCodes.push(response.data.income_invoice[0])
                this.transactionCodes.push(response.data.fee[0])
            console.log(this.transactionCodes)
            })
        
        },
        data() {
            return{
                transactionList: [],
                transactionCodes: [],
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
                axios.get('/transactions/+/index').then((response) => {
                    this.transactionList  = response.data.transaction
                    this.transactionCodes.push(response.data.income_invoice[0])
                    this.transactionCodes.push(response.data.fee[0])
                })
            
            
            },
        }
    }

</script>