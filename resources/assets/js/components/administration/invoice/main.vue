<template>
    <div class="">
        <!-- agregar -->
        <div v-if="formStatus === 1">
            <addUp-invoice
                @showlist = "showlist"
                :editId=0
            > </addUp-invoice> 
        </div>

        <!-- Vista actualizar -->
        <div v-if="formStatus === 2">
            <addUp-invoice
                @showlist = "showlist"
                :editId=editId                
            > </addUp-invoice> 
        </div>


        <!-- botones y listado -->
        <div v-if="formStatus === 0">
            <h3><b>FACTURAS </b></h3>

            <button-form
                @addf = "addFormStatus"
                :buttonType = 0
                :btn4 = 0
            ></button-form>

            <table-invoice  
                :transactionList = transactionList
                :transactionYear = transactionYear
                @editData = "editData"
                @showlist = "showlist">
            </table-invoice>
        </div>  

    </div>         
</template>

<script>
    export default {
        mounted() {

            axios.get('/transactions/-/index').then((response) => {
                this.transactionList = response.data.transaction
                this.transactionYear = response.data.year
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
            showlist(n){
                this.formStatus = 0
                axios.get('/transactions/-/index').then((response) => {
                   this.transactionList = response.data.transaction
                   this.transactionYear = response.data.year
                    // console.log(this.transactionList)
                })
            
            
            },
        }
    }

</script>