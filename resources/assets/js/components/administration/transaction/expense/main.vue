<template>
    <div class="container">
        <!-- agregar -->
        <div v-if="formStatus === 1">
            <addUp-transaction-expense
                @new = "addTransactionExpense"
                @showlist = "showlist"
                :editId=0
            > </addUp-transaction-expense> 
        </div>

        <!-- Vista actualizar -->
        <div v-if="formStatus === 2">
            <addUp-transaction-expense
                @new = "addTransactionExpense"
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
                @delete = "delDepartment">
            </table-transaction-expense>
        </div>  

    </div>         
</template>

<script>
    export default {
        mounted() {

            axios.get('/transactions/-').then((response) => {
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
                nameField1: 'EMPRESA',
                nameField2: 'DEPARTAMENTO',
                nameField3: 'DEPARTAMENTO PADRE',
            }
        },
        methods: {
            addFormStatus(){
                this.formStatus = 1
            },
            addTransactionExpense(department){
                // console.log(department)
                // this.transactionList.push(department)
            },
            delDepartment(index){
                // console.log(index)
                this.transactionList.splice(index, 1)
            },
            upDepartment( company){
                // console.log(company)
                // this.transactionList[company[0]] = company[1]
            },
            carga(){
                XMLHttpRequest.onprogress = function (event) {
                event.loaded;
                event.total;
                };
            },
            editData(id){
                // console.log('el id es: ' + id)
                this.editId = id
                this.formStatus = 2
            },
            showlist(n){
                this.formStatus = 0
                axios.get('/transactions/-').then((response) => {
                    this.transactionList = response.data
                    // console.log(this.transactionList)
                })
            
            
            },
        }
    }

</script>