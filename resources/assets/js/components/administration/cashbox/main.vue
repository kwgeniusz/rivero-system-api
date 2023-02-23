<template>
    <div class="">
        <!-- agregar -->
        <div v-if="formStatus === 1">
            <addUp-cashbox
                @showlist = "showlist"
                :editId=0
            > </addUp-cashbox> 
        </div>

        <!-- Vista actualizar -->
        <div v-if="formStatus === 2">
            <addUp-cashbox
                @showlist = "showlist"
                :editId=editId                
            > </addUp-cashbox> 
        </div>


        <!-- botones y listado -->
        <div v-if="formStatus === 0">
            <h3><b>MOVIMIENTOS DE CAJA</b></h3>

            <button-form
                @addf = "addFormStatus"
                :buttonType = 0
                :btn4 = 0
            ></button-form>

            <table-cashbox  
                :transactionList  = transactionList
                :transactionYear = transactionYear
                @editData = "editData"
                @showlist = "showlist">
            </table-cashbox>
        </div>  

    </div>         
</template>

<script>
    export default {
        mounted() {

            axios.get('/cashbox/transactions').then((response) => {
                this.transactionList = response.data.transaction
                this.transactionYear = response.data.year
            })
        
        },
        data() {
            return{
                transactionList: [],
                transactionYear:'',

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
                    this.transactionYear  = response.data.year
                })
            },
        }
    }

</script>