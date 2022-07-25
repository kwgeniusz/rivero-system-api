<template>
    <div class="">
    <!-- agregar -->
        <div v-if="formStatus === 1">
            <accounting-addUp-auxiliary
                @showlist = "showlist"
                :editId=0
            > </accounting-addUp-auxiliary> 
        </div>

    <!-- Vista actualizar -->
        <div v-if="formStatus === 2">
            <accounting-addUp-auxiliary
                @showlist = "showlist"
                :editId=editId                
            > </accounting-addUp-auxiliary> 
        </div>

    <!-- botones y listado -->
        <div v-if="formStatus === 0">
            <h3><b>LISTA DE AUXILIARES DE LA CUENTA</b></h3>

            <button-form
                @addf = "addFormStatus"
                :buttonType = 0
                :btn4 = 0
            ></button-form>

            <accounting-table-auxiliary  
                :auxiliaryList = auxiliaryList
                @editData = "editData"
                @showlist = "showlist">
            </accounting-table-auxiliary>

        </div>  

    </div>         
</template>

<script>
    export default {
        mounted() {
            axios.get(`/accounting/general-ledgers/${this.generalLedgerId}/auxiliaries`).then((response) => {
                this.auxiliaryList = response.data
                console.log(this.auxiliaryList)
            })
        },
        props: {
            generalLedgerId: { type: Number},
        }, 
        data() {
            return{
                auxiliaryList: [],
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
                axios.get('/accounting/auxiliary-books').then((response) => {
                    this.auxiliaryList = response.data
                    // console.log(this.auxiliaryList)
                })
            
            
            },
        }
    }

</script>