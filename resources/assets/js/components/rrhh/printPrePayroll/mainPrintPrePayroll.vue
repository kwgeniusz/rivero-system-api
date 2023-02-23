<template>
    
    <div>
        <!-- botones y listado -->
        <div v-if="formStatus === 0">
                <h3><b>LISTADO DE PRE-NOMINA</b></h3>
            <!-- <button-form
            @addf = "addFormStatus"
            :buttonType = 0
            
                ></button-form> -->

            <list-pre-payroll
                :objPrintPrePayroll = objPrintPrePayroll
                :namePanelList = namePanelList
                :namePanel = namePanel
                @indexEdit = "indexEdit"
                @delrow = "delrow"
                @prePayrollDetail = "prePayrollDetail"
                :lengths = lengths
            >
            </list-pre-payroll>
        </div>

        <!-- prePayrollDetail -->
        <div v-if="formStatus === 3">
            <h3><b>DETALLE DE LA PRE-NOMINA</b></h3>
            <button-form
                @addf = "addProcessDetail"
                @cancDetail = "cancDetail"
                :buttonType = 0
                :btn1 = 0
               
                 ></button-form>
            <list-pre-payroll-detail
                :objprePayrollDetail = objprePayrollDetail
                @prePayrollListDetail = "prePayrollListDetail"
              
            >
            </list-pre-payroll-detail>
        </div>

            <!-- add Process Detail -->
        <!-- <div v-if="formStatus === 4">
            <add-up-process-detail
                :objprePayrollDetails = objprePayrollDetail
                @showlistDetail = "showlistDetail"
            >
            </add-up-process-detail>
        </div> -->

            <!-- Detalle de pre nomina por persona -->
        <div v-if="formStatus === 5">
            <list-pre-payroll-detail-staff
                :objListDetailStaff = objListDetailStaff
                
            >
            </list-pre-payroll-detail-staff>
        </div>

    </div>
   
</template>

<script>
    export default {
        mounted() {
            axios.get('pre-payroll-all/').then( response => {
                this.objPrintPrePayroll = response.data.print
                console.log(this.objPrintPrePayroll)
                this.lengths = this.objPrintPrePayroll.length
                // debugger
            })

           
            console.log('Component mounted.')
        },
        data(){
            return{
                objPrintPrePayroll:[],
                objEdit:[],
                objEditDetail:[],
                objprePayrollDetail:{},
                objListDetailStaff:{},
                formStatus: 0,
                namePanelList: " ",
                namePanel: "MONEDA:",
                namePanel2: " ",
                nameField1: " ",
                nameField2: " ",
                nameField3: " ",
                nameField4: " ",
                nameField5: "",
                nameField6: "",
                nameField7: "",
                nameField8: "",
                lengths: '',
                
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
                this.objPrintPrePayroll = response.data.process
                
                })
            },
            showlistDetail(){
                // console.log(this.objprePayrollDetail)
                this.formStatus = 3
                
                // axios.get('process/list').then( response => {
                // this.objProcess = response.data.process
                
                // })
            },
            indexEdit(index){
                this.formStatus = 2
                // console.log('recibido')
                this.objEdit = this.objPrintPrePayroll[index]
                // console.log( this.objEdit)
            },
            delrow(indexId){
                // console.log(indexId)
                this.objPrintPrePayroll.splice(indexId[0],1)
                
            },
            prePayrollDetail(obj){
                // console.log('entro objeto')
                // console.log(obj)
                this.formStatus = 3
                this.objprePayrollDetail = obj
            },
            cancDetail(){
                this.formStatus = 0
                axios.get('pre-payroll-all/').then( response => {
                    this.objPrintPrePayroll = response.data.print
                    console.log(this.objPrintPrePayroll)
                // debugger
                })
            },
            prePayrollListDetail(objListDetail){
                
                // console.log('entro')
                // console.log(objListDetail)
                this.formStatus = 5
                this.objListDetailStaff = objListDetail
                // this.objEditDetail = params
            }

        }
    }
</script>