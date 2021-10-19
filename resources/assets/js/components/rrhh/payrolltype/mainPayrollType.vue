<template>
    <div>
        <!-- botones y listado -->
        <div v-if="formStatus === 0">
            <h3><b>TIPO DE NOMINA</b></h3>
            <button-form
                @addf = "addFormStatus"
                :buttonType = 0
                :btn4 = 0
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
                console.log(this.objPayRollType)
            })

        
            console.log('Component mounted.')
        },
        data(){
            return{
                objPayRollType:[],
                objEdit:[],
                formStatus: 0,
                namePanel: "AGREGAR TIPO DE NÓMINA",
                namePanel2: "EDITAR TIPO DE NÓMINA",
                nameField1: "PAÍS",
                nameField2: "NOMBRE EL TIPO DE NÓMINA",
                nameField3: "DESCRIPCIÓN DEL TIPO DE NÓMINA",
                
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
                // console.log(payrollType)
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