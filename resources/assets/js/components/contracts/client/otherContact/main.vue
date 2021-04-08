<template>
    <div >
        <!-- vista agregar -->
        <div v-if="formStatus === 1">
            <addUp-other-contact
                @showlist = "showlist"
                :editId=0
                :clientId= clientId
            > </addUp-other-contact> 
        </div>

        <!-- Vista actualizar -->
        <div v-if="formStatus === 2">
            <addUp-other-contact
                @showlist = "showlist"
                :editId=editId  
                :clientId= clientId
            > </addUp-other-contact> 
        </div>


        <!-- botones y listado -->
        <div v-if="formStatus === 0">
            <h3><b>Informacion de Otros Contactos</b></h3>

            <button-form
                @addf = "addFormStatus"
                :buttonType = 0
                :btn4 = 0
            ></button-form>

            <table-other-contact  
                :otherContacts = otherContacts
                @editData = "editData"
                @showlist = "showlist">
            </table-other-contact>
        </div>  

    </div>         
</template>

<script>
    export default {
        mounted() {

            axios.get(`/clients/${this.clientId}/other-contacts`).then((response) => {
                this.otherContacts = response.data
            // console.log(this.otherContacts)
            })
        
        },
        data() {
            return{
                otherContacts: [],
                // parents: [],
                formStatus: 0,
                editId: '',
            }
        },
         props: {
            clientId: '',
        },  
        methods: {
            addFormStatus(){
                this.formStatus = 1
            },
            editData(id){
                this.editId = id
                this.formStatus = 2
            }, 
            // carga(){
            //     XMLHttpRequest.onprogress = function (event) {
            //     event.loaded;
            //     event.total;
            //     };
            // },
            showlist(n){
                this.formStatus = 0

                axios.get(`/clients/${this.clientId}/other-contacts`).then((response) => {
                    this.otherContacts = response.data
                    // console.log(this.otherContacts)
                })
            },
        }
    }

</script>