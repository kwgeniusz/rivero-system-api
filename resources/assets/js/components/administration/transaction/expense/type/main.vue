<template>
    <div class="">
        <!-- agregar -->
        <div v-if="formStatus === 1">
            <addUp-expense-type
                @showlist = "showlist"
                :editId=0
            > </addUp-expense-type> 
        </div>

        <!-- Vista actualizar -->
        <div v-if="formStatus === 2">
            <addUp-expense-type
                @showlist = "showlist"
                :editId=editId                
            > </addUp-expense-type> 
        </div>


        <!-- botones y listado -->
        <div v-if="formStatus === 0">
            <h3><b>TIPOS DE EXPENSES</b></h3>

            <button-form
                @addf = "addFormStatus"
                :buttonType = 0
                :btn4 = 0
            ></button-form>

            <table-expense-type  
                :transactionTypeList = transactionTypeList
                @editData = "editData"
                @showlist = "showlist">
            </table-expense-type>
        </div>  

    </div>         
</template>

<script>
    export default {
        mounted() {
            axios.get('/transaction-types/-/index').then((response) => {
                this.transactionTypeList = response.data
            })
        },
        data() {
            return{
                transactionTypeList: [],
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
                this.editId = id
                this.formStatus = 2
            }, 

            showlist(n){
                this.formStatus = 0
                axios.get('/transaction-types/-/index').then((response) => {
                    this.transactionTypeList = response.data
                })
            
            
            },
        }
    }

</script>