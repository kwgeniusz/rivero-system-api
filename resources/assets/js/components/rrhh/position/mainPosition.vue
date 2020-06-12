<template>
    <div>
        
        <!-- botones y listado -->
        <div v-if="formStatus === 0">
            <h3><b>CARGOS</b></h3>
            <button-form
                @addf = "addFormStatus"
                :buttonType = 0
                :btn4 = 0
            ></button-form>
        
            <list-position
            :objHrPosition = objHrPosition
            @indexEdit = "indexEdit"
            @delHrPosition = "delHrPosition"
            >
            </list-position>
        </div>


        <!-- agregar -->
        <div v-if="formStatus === 1">
            <add-position
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
            </add-position>
        </div>


        <!-- Actualizar -->
        <div v-if="formStatus === 2">
            <add-position
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
            </add-position>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            axios.get('hrposition/').then( response => {
                this.objHrPosition = response.data.hrposition
                // console.log(this.objHrPosition)
            })

           
            console.log('Component mounted.')
        },
        data(){
            return{
                objHrPosition:[],
                objEdit:[],
                formStatus: 0,
                namePanel: "AGREGAR CARGO",
                namePanel2: "EDITAR CARGO",
                nameField1: "PAÍS",
                nameField2: "CODIGO CARGO",
                nameField3: "NOMBRE DEL CARGO",
                nameField4: "SALARIO BASE MENSUAL",
                nameField5: "CÓDIGO MONEDA",
                nameField6: "SALARIO LOCAL MENSUAL",
                nameField7: "CÓDIGO MONEDA LOCAL",
                nameField8: "SALARIO DIARIO LOCAL",
                
            }
        },
        methods: {
            addFormStatus(){
                this.formStatus = 1
            },
            showlist(){
                this.formStatus = 0
                axios.get('hrposition/').then( response => {
                    this.objHrPosition = response.data.hrposition
                    // console.log(this.objHrPosition)
            })
            },
            newObj(payrollType){
                // console.log(payrollType)
                this.objHrPosition.push(payrollType)
            },
            indexEdit(index){
                this.formStatus = 2
                // console.log('recibido')
                this.objEdit = this.objHrPosition[index]
                // console.log( this.objEdit)
            },
            delHrPosition(indexId){
                // console.log(indexId)
                this.objHrPosition.splice(indexId[0],1)
                
            }

        }
    }
</script>