<template>
    
    <div>
            <!-- botones y listado -->
            <div v-if="formStatus === 0">
                <button-form
                @addf = "addFormStatus"
                :buttonType = 0
               
                 ></button-form>

                <list-periods
                    :objPeriods = objPeriods
                    :namePanelList = namePanelList
                    @indexEdit = "indexEdit"
                    @delrow = "delrow"
                >
                </list-periods>
            </div>

            <!-- agregar -->
        <div v-if="formStatus === 1">
            <addUp-periods
                :namePanel = namePanel
                :nameField1 = nameField1
                :nameField2 = nameField2
                :nameField3 = nameField3
                :nameField4 = nameField4
                :nameField5 = nameField5
                :nameField6 = nameField6
                :nameField7 = nameField7
                :nameField8 = nameField8
                @showlist = "showlist"
                @newObj = "newObj"
               
            >
            </addUp-periods>
        </div>


        <!-- Actualizar -->
        <div v-if="formStatus === 2">
            <addUp-periods
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
                :objEdit = objEdit
                :editId = 1
            >
            </addUp-periods>
        </div>

    </div>
   
</template>

<script>
    export default {
        mounted() {
            axios.get('periods/list').then( response => {
                this.objPeriods = response.data.periods
                // console.log(this.objPeriods)
                // debugger
            })

           
            console.log('Component mounted.')
        },
        data(){
            return{
                objPeriods:[],
                objEdit:[],
                formStatus: 0,
                namePanelList: "Periodos",
                namePanel: "Agregar Periodo",
                namePanel2: "Editar Periodo",
                nameField1: "Seleccione el pais",
                nameField2: "Empresa",
                nameField3: "Tipo de Nomina",
                nameField4: "Nombre del Periodo",
                nameField5: "Año",
                nameField6: "Desde",
                nameField7: "Hasta",
                nameField8: "",
                
            }
        },
        methods: {
            addFormStatus(){
                this.formStatus = 1
            },
            showlist(){
                this.formStatus = 0
                axios.get('periods/list').then( response => {
                    this.objPeriods = response.data.periods
                
                })
            },
            newObj(payrollType){
                console.log(payrollType)
                this.objPeriods.push(payrollType)
            },
            indexEdit(index){
                this.formStatus = 2
                // console.log('recibido')
                this.objEdit = this.objPeriods[index]
                // console.log( this.objEdit)
            },
            delrow(indexId){
                // console.log(indexId)
                this.objPeriods.splice(indexId[0],1)
                
            }

        }
    }
</script>