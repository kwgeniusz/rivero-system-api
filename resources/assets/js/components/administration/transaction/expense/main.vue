<template>
    <div class="">
        <!-- agregar -->
        <div v-if="formStatus === 1">
            <addUp-transaction-expense
                @showlist = "showlist"
                :editId=0
            > </addUp-transaction-expense> 
        </div>

        <!-- Vista actualizar -->
        <div v-if="formStatus === 2">
            <addUp-transaction-expense
                @showlist = "showlist"
                :editId=editId                
            > </addUp-transaction-expense> 
        </div>


        <!-- botones y listado -->
        <div v-if="formStatus === 0">
            <h3><b>TRANSACCIONES DE EGRESO</b></h3>

            <button-form
                @addf = "addFormStatus"
                :buttonType = 0
                :btn4 = 0
            ></button-form>

            <table-transaction-expense  
                :transactionList = transactionList
                @editData = "editData"
                @showlist = "showlist">
            </table-transaction-expense>
        </div>  

    </div>         
</template>

<script>
    export default {
        mounted() {

            axios.get('/transactions/-/index').then((response) => {
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
            // addTransactionExpense(department){
            //     // console.log(department)
            //     // this.transactionList.push(department)
            // },
            // delDepartment(index){
            //     // console.log(index)
            //     this.formStatus = 0;
            //     this.transactionList.splice(index, 1)
            // },
            editData(id){
                // console.log('el id es: ' + id)
                this.editId = id
                this.formStatus = 2
            }, 
            upDepartment( company){
                // console.log(company)
                // this.transactionList[company[0]] = company[1]
            },
            // carga(){
            //     XMLHttpRequest.onprogress = function (event) {
            //     event.loaded;
            //     event.total;
            //     };
            // },
            showlist(n){
                this.formStatus = 0
                axios.get('/transactions/-/index').then((response) => {
                    this.transactionList = response.data
                    // console.log(this.transactionList)
                })
            
            
            },
        }
    }

</script>