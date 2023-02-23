<template>
    <div>
        <!-- botones y listado -->
        <div v-if="formStatus === 0">
            <h3><b>TRANSACCIONES PERMANENTES</b></h3>
            <button-form
                @addf = "addFormStatus"
                :buttonType = 0
                :btn4 = 0
            ></button-form>
        
            <list-permanent-trans
            :objPermanentTrans = objPermanentTrans
            @indexEdit = "indexEdit"
            @delrow = "delrow"
            >
            </list-permanent-trans>
        </div>

        <!-- agregar -->
        <div v-if="formStatus === 1">
            <addUp-permanent-trans
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
            </addUp-permanent-trans>

        </div>

        <!-- Actualizar -->
        <div v-if="formStatus === 2">
            <addUp-permanent-trans
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
            </addUp-permanent-trans>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            axios.get('list-perm-trans/').then( response => {
                this.objPermanentTrans = response.data
                console.log(this.objPermanentTrans)
            })

           
            console.log('Component mounted.')
        },
        data(){
            return{
                objPermanentTrans:[], //1
                objEdit:[],
                formStatus: 0,
                namePanel: "AGREGAR TRANSACCION PERMANENTE",
                namePanel2: "EDITAR TRANSACCION PERMANENTE",
                nameField1: "PERSONAL/EMPLEADO",
                nameField2: "TIPO DE TRANSACCION",
                nameField3: "CANTIDAD",
                nameField4: "MONTO",
                nameField5: "SALDO",
                nameField6: "CUOTAS",
                nameField7: "SALDO INICIAL",
                nameField8: "CAPACIDAD DE ENDEUDAMIENTO MENSUAL",
                nameField9: "SALARIO NETO",
                nameField10: "SALDO ANTERIOR",
                
            }
        },
        methods: {
            addFormStatus(){
                this.formStatus = 1
            },
            showlist(){
                this.formStatus = 0
                axios.get('list-perm-trans/').then( response => {
                    this.objPermanentTrans = response.data
                // console.log(this.objPermanentTrans)
                })
                    // console.log(this.objPermanentTrans)
            },
            newObj(payrollType){
                // console.log(payrollType)
                this.objPermanentTrans.push(payrollType)
            },
            indexEdit(index){
                this.formStatus = 2
                // console.log('recibido')
                this.objEdit = this.objPermanentTrans[index]
                // console.log( this.objEdit)
            },
            delrow(indexId){
                this.objPermanentTrans.splice(indexId[0],1)
                
                // console.log(indexId)
            }

        }
    }
</script>