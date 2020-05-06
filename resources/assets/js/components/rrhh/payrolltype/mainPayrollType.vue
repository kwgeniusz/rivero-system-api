<template>
    <div>
        <!-- botones y listado -->
        <div v-if="formStatus === 0">
            <button-form
                @addf = "addFormStatus"
                :buttonType = 0
               
            ></button-form>
        
            <listpayroll-type
            :objPayRollType = objPayRollType
            @indexEdit = "indexEdit"
            @delPayrollType = "delPayrollType"
            >
            </listpayroll-type>
        </div>

        <!-- agregar -->
        <div v-if="formStatus === 1">
            <AddUp-Payroll-Type
                :namePanel = namePanel
                :nameField1 = nameField1
                :nameField2 = nameField2
                :nameField3 = nameField3
                @showlist = "showlist"
                @newObj = "newObj"
               
            >
            </AddUp-Payroll-Type>

        </div>

        <!-- Actualizar -->
        <div v-if="formStatus === 2">
            <AddUp-Payroll-Type
                @showlist = "showlist"
                @newObj = "newObj"
                :namePanel2 = namePanel2
                :nameField1 = nameField1
                :nameField2 = nameField2
                :nameField3 = nameField3
                :objEdit = objEdit
                :editId = 1
            >
            </AddUp-Payroll-Type>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            axios.get('payrolltypes/').then( response => {
                this.objPayRollType = response.data
                // console.log(this.objPayRollType)
            })

           
            console.log('Component mounted.')
        },
        data(){
            return{
                objPayRollType:[],
                objEdit:[],
                formStatus: 0,
                namePanel: "Agregar tipo de nomina",
                namePanel2: "Editar tipo de nomina",
                nameField1: "Seleccione el pais",
                nameField2: "Nombre del tipo de nomina",
                nameField3: "Descripcion del tipo de nomina",
                
            }
        },
        methods: {
            addFormStatus(){
                this.formStatus = 1
            },
            showlist(){
                this.formStatus = 0
                axios.get('payrolltypes/').then( response => {
                    this.objPayRollType = response.data
                    // console.log(this.objPayRollType)
            })
            },
            newObj(payrollType){
                console.log(payrollType)
                this.objPayRollType.push(payrollType)
            },
            indexEdit(index){
                this.formStatus = 2
                // console.log('recibido')
                this.objEdit = this.objPayRollType[index]
                // console.log( this.objEdit)
            },
            delPayrollType(indexId){
                this.objPayRollType.splice(indexId[0],1)
                
                // console.log(indexId)
            }

        }
    }
</script>