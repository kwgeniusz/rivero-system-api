<template>
    <div class="">
        <!-- agregar -->
        <div v-if="formStatus === 1">
            <precontract-addUp-budget
                @showlist = "showlist"
                :editId=0
            > </precontract-addUp-budget> 
        </div>

        <!-- Vista actualizar -->
        <div v-if="formStatus === 2">
            <precontract-addUp-budget
                @showlist = "showlist"
                :editId=editId                
            > </precontract-addUp-budget> 
        </div>


        <!-- botones y listado -->
        <div v-if="formStatus === 0">
            <h3><b>PRESUPUESTOS</b></h3>

            <button-form
                @addf = "addFormStatus"
                :buttonType = 0
                :btn4 = 0
            ></button-form>

            <precontract-table-budget  
                :budgetList = budgetList
                @editData = "editData"
                @showlist = "showlist">
            </precontract-table-budget>
        </div>  

    </div>         
</template>

<script>
    export default {
        mounted() {

            axios.get(`/precontracts/${this.precontractId}/budgets`).then((response) => {
                this.budgetList = response.data
            // console.log(this.budgetList)
            })
        
        },
        data() {
            return{
                budgetList: [],
                formStatus: 0,
                editId: '',
            }
        },
         props: {
           precontractId: { type: [String,Number], default: null}, 
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
                axios.get('/precontracts/{id}/budgets').then((response) => {
                    this.budgetList = response.data
                })
            
            
            },
        }
    }

</script>