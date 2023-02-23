<template>
    <div class="">
    <!-- agregar -->
        <div v-if="formStatus === 1">
            <accounting-addUp-general-ledger
                @showlist = "showlist"
                :editId=0
            > </accounting-addUp-general-ledger> 
        </div>

    <!-- Vista actualizar -->
        <div v-if="formStatus === 2">
            <accounting-addUp-general-ledger
                @showlist = "showlist"
                :editId=editId                
            > </accounting-addUp-general-ledger> 
        </div>

    <!-- botones y listado -->
        <div v-if="formStatus === 0">
            <h3><b>PLAN DE CUENTAS</b></h3>

            <button-form
                @addf = "addFormStatus"
                :buttonType = 0
                :btn4 = 0
            ></button-form>

            <accounting-table-general-ledger  
                :generalLedgerList = generalLedgerList
                @editData = "editData"
                @showlist = "showlist">
            </accounting-table-general-ledger>

        </div>  

    </div>         
</template>

<script>
    export default {
        mounted() {
            axios.get('/accounting/general-ledgers').then((response) => {
                this.generalLedgerList = response.data
                console.log(this.generalLedgerList)
            })
        },
        data() {
            return{
                generalLedgerList: [],
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
                axios.get('/accounting/general-ledgers').then((response) => {
                    this.generalLedgerList = response.data
                    // console.log(this.generalLedgerList)
                })
            
            
            },
        }
    }

</script>