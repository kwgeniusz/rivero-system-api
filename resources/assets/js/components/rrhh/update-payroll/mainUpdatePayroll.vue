<template>
    
    <div>
            <!-- botones y listado -->
            <div v-if="formStatus === 0">
                 <h3><b>ACTUALIZAR NOMINA</b></h3>
                <!-- <button-form
                @addf = "addFormStatus"
                :buttonType = 0
                :btn4 = 0
                 ></button-form> -->

                <list-payroll-history
                    :objPayrollHistory = objPayrollHistory
                    :namePanelList = namePanelList
                    @indexEdit = "indexEdit"
                    @showlist = "showlist"
                    @delrow = "delrow"
                    :lengths = lengths
                >
                </list-payroll-history>
            </div>

            <!-- agregar -->
        <div v-if="formStatus === 1">
            <add-up-payroll-history
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
            </add-up-payroll-history>
        </div>


        <!-- Actualizar -->
        <div v-if="formStatus === 2">
            <add-up-payroll-history
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
            </add-up-payroll-history>
        </div>

    </div>
   
</template>

<script>
    export default {
        mounted() {
            axios.get('list-payroll-history/').then( response => {
                this.objPayrollHistory = response.data.payrollHistory
                console.log(this.objPayrollHistory)
                this.lengths = this.objPayrollHistory.length
                // debugger
            })

           
            console.log('Component mounted.')
        },
        data(){
            return{
                objPayrollHistory:[],
                objEdit:[],
                formStatus: 0,
                namePanelList: "PRE-NOMINA",
                namePanel: "AGREGAR PRE-NOMINA",
                namePanel2: "EDITAR PRE-NOMINA",
                nameField1: "PAÍS",
                nameField2: "EMPRESA",
                nameField3: "TIPO DE NÓMINA",
                nameField4: "PERIODO",
                nameField5: "AÑO",
                nameField6: "PROCESO",
                nameField7: "",
                nameField8: "",
                lengths: "",
                
            }
        },
        methods: {
            addFormStatus(){
                this.formStatus = 1
            },
            showlist(){
                this.formStatus = 0
                axios.get('list-payroll-history/').then( response => {
                    this.objPayrollHistory = response.data.payrollHistory
                    console.log(this.objPayrollHistory)
                    this.lengths = this.objPayrollHistory.length
                    // debugger
                })
            },
            newObj(payrollType){
                console.log(payrollType)
                this.objPayrollHistory.push(payrollType)
            },
            indexEdit(index){
                this.formStatus = 2
                // console.log('recibido')
                this.objEdit = this.objPayrollHistory[index]
                // console.log( this.objEdit)
            },
            delrow(indexId){
                // console.log(indexId)
                this.objPayrollHistory.splice(indexId[0],1)
                
            }

        }
    }
</script>