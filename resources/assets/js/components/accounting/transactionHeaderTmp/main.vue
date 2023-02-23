<template>
    <div class="">
    <!-- agregar -->
        <div v-if="formStatus === 1">
            <accounting-addUp-transaction-header-tmp
                @showlist = "showlist"
                :editId=0
            > </accounting-addUp-transaction-header-tmp> 
        </div>

    <!-- Vista actualizar -->
        <div v-if="formStatus === 2">
            <accounting-addUp-transaction-header-tmp
                @showlist = "showlist"
                :editId=editId                
            > </accounting-addUp-transaction-header-tmp> 
        </div>

    <!-- botones y listado -->
        <div v-if="formStatus === 0">
            <h3><b>ASIENTOS CONTABLES TEMPORALES</b></h3>

            <!-- <button-form
                @addf = "addFormStatus"
                :buttonType = 0
                :btn4 = 0
            ></button-form> -->

            <accounting-table-transaction-header-tmp  
                :headerList = headerList
                :headerYear = year
                @editData = "editData"
                @showlist = "showlist">
            </accounting-table-transaction-header-tmp>

        </div>  

    </div>         
</template>

<script>
    export default {
        mounted() {
            axios.get('/accounting/transaction-headers').then((response) => {
                this.headerList = response.data.headers
                this.year = response.data.year
                // console.log(this.headerList)
            })
        },
        data() {
            return{
                headerList: [],
                year: '',
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
                axios.get('/accounting/transaction-headers').then((response) => {
                    this.headerList = response.data.headers
                    this.year = response.data.year
                    // console.log(this.headerList)
                })
            
            
            },
        }
    }

</script>