<template>
    
    <div>
            <!-- botones y listado -->
            <div v-if="formStatus === 0">
                 <h3><b>RECIBO DE PAGO POR EMPLEADO</b></h3>
                <button-form
                @addf = "addFormStatus"
                :buttonType = 0
                :btn4 = 0
                 ></button-form>

                <list-paycheck
                    :objRecipt = objRecipt
                    :namePanelList = namePanelList
                    @indexEdit = "indexEdit"
                    @delrow = "delrow"
                    @processDetail = "processDetail"
                    :lengths = lengths
                >
                </list-paycheck>
            </div>

            <!-- agregar -->
        <div v-if="formStatus === 1">
            <addUp-process
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
               
            >
            </addUp-process>
        </div>


        <!-- Actualizar -->
        <div v-if="formStatus === 2">
            <addUp-process
                @showlist = "showlist"
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
            </addUp-process>
        </div>

        <!-- processDetail -->
        <div v-if="formStatus === 3">
            <h3><b>LISTA DE RECIBO DE PAGO POR EMPLEADO</b></h3>
            <button-form
                @addf = "addProcessDetail"
                @cancDetail = "cancDetail"
                :buttonType = 0
               
                 ></button-form>
            <list-recipt-detail
                :objReciptDetail = objReciptDetail
                @indexEditDetail = "indexEditDetail"
              
            >
            </list-recipt-detail>
        </div>

            <!-- add Process Detail -->
        <div v-if="formStatus === 4">
            <add-up-process-detail
                :objReciptDetails = objReciptDetail
                @showlistDetail = "showlistDetail"
            >
            </add-up-process-detail>
        </div>

            <!-- Update Process Detail -->
        <div v-if="formStatus === 5">
            <add-up-process-detail
                :objReciptDetails = objReciptDetail
                @showlistDetail = "showlistDetail"
                :objEditDetail = objEditDetail
                :editId = 1
            >
            </add-up-process-detail>
        </div>

    </div>
   
</template>

<script>
    export default {
        mounted() {
            axios.get('staff-receipt').then( response => {
                this.lengths = response.data
                this.objRecipt = response.data
                // console.log(this.objRecipt)
                // debugger
            })

           
            console.log('Component mounted.')
        },
        data(){
            return{
                objRecipt:[],
                objEdit:[],
                objEditDetail:[],
                objReciptDetail:{},
                formStatus: 0,
                lengths:0,
                namePanelList: "TIPOS DE PROCESOS",
                namePanel: "AGREGAR TIPO DE PROCESO",
                namePanel2: "EDITAR TIPO DE PROCESO",
                nameField1: "CÓDIGO",
                nameField2: "PAÍS",
                nameField3: "EMPRESA",
                nameField4: "NOMBRE DEL PROCESO",
                nameField5: "",
                nameField6: "",
                nameField7: "",
                nameField8: "",
                
            }
        },
        methods: {
            addFormStatus(){
                this.formStatus = 1
            },
            addProcessDetail(){
                this.formStatus = 4
            },
            showlist(){
                this.formStatus = 0
                axios.get('process/list').then( response => {
                this.objRecipt = response.data.process
                
                })
            },
            showlistDetail(){
                // console.log(this.objReciptDetail)
                this.formStatus = 3
                
                // axios.get('process/list').then( response => {
                // this.objRecipt = response.data.process
                
                // })
            },
            indexEdit(index){
                this.formStatus = 2
                // console.log('recibido')
                this.objEdit = this.objRecipt[index]
                // console.log( this.objEdit)
            },
            delrow(indexId){
                // console.log(indexId)
                this.objRecipt.splice(indexId[0],1)
                
            },
            processDetail(obj){
                // console.log('entro objeto')
                // console.log(obj)
                // return
                this.formStatus = 3
                this.objReciptDetail = obj
            },
            cancDetail(){
                this.formStatus = 0
                axios.get('process/list').then( response => {
                    this.objRecipt = response.data.process
                
                })
            },
            indexEditDetail(params){
                
                // console.log('params')
                // console.log(params)
                this.formStatus = 5
                this.objEditDetail = params
            }

        }
    }
</script>