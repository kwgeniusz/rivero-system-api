<template>
    
    <div>
            <!-- botones y listado -->
            <div v-if="formStatus === 0">
                 <h3><b>PERSONAL</b></h3>
                <button-form
                @addf = "addFormStatus"
                :buttonType = 0
               
                 ></button-form>

                <list-staff
                    :objStaff = objStaff
                    :namePanelList = namePanelList
                    @indexEdit = "indexEdit"
                    @delrow = "delrow"
                >
                </list-staff>
            </div>

            <!-- agregar -->
        <div v-if="formStatus === 1">
            <add-up-staff
                :namePanel = namePanel
                :nameField1 = nameField1
                :nameField2 = nameField2
                :nameField3 = nameField3
                :nameField4 = nameField4
                :nameField5 = nameField5
                :nameField6 = nameField6
                :nameField7 = nameField7
                :nameField8 = nameField8
                :nameField9 = nameField9
                :nameField10 = nameField10
                :nameField11 = nameField11
                :nameField12 = nameField12
                :nameField13 = nameField13
                :nameField14 = nameField14
                :nameField15 = nameField15
                :nameField16 = nameField16
                :nameField17 = nameField17
                @showlist = "showlist"
                @newObj = "newObj"
               
            >
            </add-up-staff>
        </div>


        <!-- Actualizar -->
        <div v-if="formStatus === 2">
            <add-up-staff
                @showlist = "showlist"
                @newObj = "newObj"
                :namePanel2 = namePanel2
                :nameField1 = nameField1
                :nameField2 = nameField2
                :nameField3 = nameField3
                :nameField4 = nameField4
                :nameField5 = nameField5
                :nameField6 = nameField6
                :nameField7 = nameField7
                :nameField8 = nameField8
                :nameField9 = nameField9
                :nameField10 = nameField10
                :nameField11 = nameField11
                :nameField12 = nameField12
                :nameField13 = nameField13
                :nameField14 = nameField14
                :nameField15 = nameField15
                :nameField16 = nameField16
                :nameField17 = nameField17
                :objEdit = objEdit
                :editId = 1
            >
            </add-up-staff>
        </div>

    </div>
   
</template>

<script>
    export default {
        mounted() {
            axios.get('staff/list/').then( response => {
                this.objStaff = response.data.hrstaff
                console.log(this.objStaff)
                // debugger
            })

           
            console.log('Component mounted.')
        },
        data(){
            return{
                objStaff:[],
                objEdit:[],
                formStatus: 0,
                namePanelList: "PERSONAL",
                namePanel: "AGREGAR PERSONAL",
                namePanel2: "EDITAR PERSONAL",
                nameField1: "NOMBRE CORTO",
                nameField2: "NOMBRE COMPLETO",
                nameField3: "APELLIDO COMPLETO",
                nameField4: "CEDULA",
                nameField5: "PASAPORTE",
                nameField6: "NUMERO DE IDENTIFICACIÓN TRIBUTARIA (RIF/TIN/NIT/RUC)",
                nameField7: "CODIGO",
                nameField8: "PAÍS",
                nameField9: "EMPRESA",
                nameField10: "DEPARTAMENTO",
                nameField11: "TIPO DE NOMINA",
                nameField12: "CARGO",
                nameField13: "SALARIO BASE",
                nameField14: "MONEDA BASE",
                nameField15: "SALARIO LOCAL",
                nameField16: "MONEDA LOCAL",
                nameField17: "SALARIO LOCAL DIARIO",
                
            }
        },
        methods: {
            addFormStatus(){
                this.formStatus = 1
            },
            showlist(){
                this.formStatus = 0
                axios.get('staff/list/').then( response => {
                this.objStaff = response.data.hrstaff
                console.log(this.objStaff)
                
                })
            },
            newObj(payrollType){
                console.log(payrollType)
                this.objStaff.push(payrollType)
            },
            indexEdit(index){
                this.formStatus = 2
                // console.log('recibido')
                this.objEdit = this.objStaff[index]
                // console.log( this.objEdit)
            },
            delrow(indexId){
                // console.log(indexId)
                this.objStaff.splice(indexId[0],1)
                
            }

        }
    }
</script>