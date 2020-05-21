<template>
<div>
    <!-- agregar -->
    <div v-if="formStatus === 1">
        <panel-heading-add
            :namePanel = namePanel
            :bgColor = bgColor
            :fields = fields[0]
            :nameField1= nameField1
            :nameField2= nameField2
            :nameField3= nameField3
            :nameField4= nameField4
            :nameField5= nameField5
            :nameField6= nameField6
            :buttonType = 1
            @showlist = "showlist"
        >
        </panel-heading-add>
    </div>

    <!-- Vista actualizar -->
    <div v-if="formStatus === 2">
        <panel-heading-update
            :namePanel = namePane3
            :bgColor = bgColorEdit
            :fields = fields[0]
            :nameField1= nameField1
            :nameField2= nameField2
            :nameField3= nameField3
            :nameField4= nameField4
            :nameField5= nameField5
            :nameField6= nameField6
            :buttonType= 2
            :objEdi= objEdiCOmpany
            @showlist = "showlist"
        >
        </panel-heading-update>
    </div>

    <!-- botones y listado -->
    <div v-if="formStatus === 0">
        <h3><b>EMPRESAS</b></h3>
        <button-form
            @addf = "addFormStatus"
            :buttonType = 0
        ></button-form>
        <list-company
            @edit = "editFormStatus"
            :namePanel = namePanel2
            :objCompanys = objCompanys
            @deleted = "deleted"
        ></list-company>

    </div>
</div>

</template>

<script>
    export default {
        mounted() {
            
            axios.get('/companys').then((response) => {
                this.objCompanys = response.data
            // console.log(this.objCompanys)
            })

            console.log('Component mounted.')
        },
        data(){
            return{

                namePanel: "Agregar Empresa",
                namePane3: "Editar Empresa",
                bgColor: 'success',
                bgColorEdit: "bg-primary",
                namePanel2: "EMPRESA",
                objCompanys: [],
                objEdiCOmpany:[],
                parameters: [],
                objEdi:'',
                formStatus: 0,
                fields: [
                    {
                        field1: 1,
                        
                    }
                ],
                nameField1: 'NOMBRE EMPRESA',
                nameField2: 'NOMBRE CORTO EMPRESA',
                nameField3: 'DIN',
                nameField4: 'PAÍS',
                nameField5: 'OFICINA',
                nameField6: 'DIRECCION',
            }
        },
        methods: {
            addFormStatus(n){
                // console.log('el parametro es: ' + n)
                this.formStatus = n
            },
            editFormStatus(id){
                this.objEdiCOmpany = id
                this.formStatus = 2

            },
            showlist(n){
                
                this.formStatus = n
                axios.get('/companys').then((response) => {
                    this.objCompanys = response.data
                    console.log(this.objCompanys)
                })
            
            },
            deleted(index){
                // console.log(index)
                this.objCompanys.splice(index, 1)
            },

        }
    }
</script>