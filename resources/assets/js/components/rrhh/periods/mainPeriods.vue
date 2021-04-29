<template>
    
    <div>
            <!-- botones y listado -->
            <div v-if="formStatus === 0">
                 <h3><b>PERIODOS</b></h3>
                <button-form
                @addf = "addFormStatus"
                :buttonType = 0
                :btn4 = 0
                 ></button-form>

                <list-periods
                    :objPeriods = objPeriods
                    :namePanelList = namePanelList
                    @indexEdit = "indexEdit"
                    @delrow = "delrow"
                    :vacio = vacio
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
                let res = response.data.periods
                
                console.log(res)
                if (res.length === 0) {
                    this.vacio = 1
                } else {
                    this.objPeriods = res
                }
            })

           
           
        },
        data(){
            return{
                objPeriods:[],
                objEdit:[],
                formStatus: 0,
                vacio: 0,
                namePanelList: "PERÍODOS",
                namePanel: "AGREGAR PERÍODO",
                namePanel2: "EDITAR PERÍODO",
                nameField1: "PAÍS",
                nameField2: "EMPRESA",
                nameField3: "TIPO DE NÓMINA",
                nameField4: "NOMBRE DEL PERÍODO",
                nameField5: "AÑO",
                nameField6: "DESDE",
                nameField7: "HASTA",
                nameField8: "NUMERO DE PERÍODO",
                
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