<template>
    
    <div>
            <!-- botones y listado -->
            <div v-if="formStatus === 0">
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
                namePanelList: "Tipos de transacciones",
                namePanel: "Agregar tipo de transaccion",
                namePanel2: "Editar tipo de transaccion",
                nameField1: "Seleccione el pais",
                nameField2: "Empresa",
                nameField3: "Cod. Transaccion",
                nameField4: "Nombre del tipo de transaccion",
                nameField5: "Calculo en base al salario?",
                nameField6: "Transaccion de ingreso?",
                nameField7: "Transacción con saldo?",
                nameField8: "",
                
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