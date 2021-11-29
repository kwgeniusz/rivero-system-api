<template>
    <div class="">
    <!-- agregar -->
        <div v-if="formStatus === 1">
            <accounting-addUp-transaction
                @showlist = "showlist"
                :editId=0
            > </accounting-addUp-transaction> 
        </div>

    <!-- Vista actualizar -->
        <div v-if="formStatus === 2">
            <accounting-addUp-transaction
                @showlist = "showlist"
                :editId=editId                
            > </accounting-addUp-transaction> 
        </div>

    <!-- botones y listado -->
        <div v-if="formStatus === 0">
            <h3><b>ASIENTOS CONTABLES</b></h3>

            <button-form
                @addf = "addFormStatus"
                :buttonType = 0
                :btn4 = 0
            ></button-form>

            <accounting-table-transaction  
                :transactionList = transactionList
                @editData = "editData"
                @showlist = "showlist">
            </accounting-table-transaction>

        </div>  

    </div>         
</template>

<script>
    export default {
        mounted() {
            axios.get('/accounting/transactions').then((response) => {
                this.transactionList = response.data
                // console.log(this.transactionList)
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
            showlist(n){
                this.formStatus = 0
                axios.get('/accounting/transactions').then((response) => {
                    this.transactionList = response.data
                    // console.log(this.transactionList)
                })
            
            
            },
        }
    }

</script>