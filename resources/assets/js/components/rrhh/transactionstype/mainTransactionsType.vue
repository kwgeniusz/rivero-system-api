<template>
    
    <div>
            <!-- botones y listado -->
            <div v-if="formStatus === 0">
                <h3><b>TIPO DE TRANSACCIONES</b></h3>
                <button-form
                @addf = "addFormStatus"
                :buttonType = 0
               
                 ></button-form>

                <list-transaction-type
                    :objHrTansType = objHrTansType
                    :namePanelList = namePanelList
                    @indexEdit = "indexEdit"
                    @delrow = "delrow"
                >
                </list-transaction-type>
            </div>

            <!-- agregar -->
        <div v-if="formStatus === 1">
            <addUp-transactions-type
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
                @showlist = "showlist"
                @newObj = "newObj"
               
            >
            </addUp-transactions-type>
        </div>


        <!-- Actualizar -->
        <div v-if="formStatus === 2">
            <addUp-transactions-type
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
                :objEdit = objEdit
                :editId = 1
            >
            </addUp-transactions-type>
        </div>

    </div>
   
</template>

<script>
    export default {
        mounted() {
            axios.get('transactionstypes/').then( response => {
                this.objHrTansType = response.data.hrtransaction_type
                // console.log(this.objHrTansType)
                // debugger
            })

           
            console.log('Component mounted.')
        },
        data(){
            return{
                objHrTansType:[],
                objEdit:[],
                formStatus: 0,
                namePanelList: "TIPOS DE TRANSACCIONES",
                namePanel: "AGREGAR TIPO DE TRANSACCIÓN",
                namePanel2: "EDITAR TIPO DE TRANSACCIÓN",
                nameField1: "PAÍS",
                nameField2: "EMPRESA",
                nameField3: "CODIGO",
                nameField4: "NOMBRE DEL TIPO DE TRANSACCIÓN",
                nameField5: "CALCULO EN SALARIO BASE:   ",
                nameField6: "TRANSACCIÓN DE INGRESO:   ",
                nameField7: "TRANSACCIÓN CON SALDO:   ",
                nameField8: "accTax",
                nameField9: "accChristmas",
                nameField10: "accSeniority",
                
            }
        },
        methods: {
            addFormStatus(){
                this.formStatus = 1
            },
            showlist(){
                this.formStatus = 0
               axios.get('transactionstypes/').then( response => {
                this.objHrTansType = response.data.hrtransaction_type
                    // console.log(this.objHrTansType)
            })
            },
            newObj(payrollType){
                console.log(payrollType)
                this.objHrTansType.push(payrollType)
            },
            indexEdit(index){
                this.formStatus = 2
                // console.log('recibido')
                this.objEdit = this.objHrTansType[index]
                // console.log( this.objEdit)
            },
            delrow(indexId){
                // console.log(indexId)
                this.objHrTansType.splice(indexId[0],1)
                
            }

        }
    }
</script>