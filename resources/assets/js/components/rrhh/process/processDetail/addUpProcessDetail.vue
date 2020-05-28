<template>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div v-if="editId === 0" class="panel-heading" :style="addSuccess"><h4 class="text-uppercase">{{namePanel}}</h4></div>
                    <div v-else class="panel-heading" :style="ediPrimary"><h4 class="text-uppercase">{{namePanel2}}</h4></div>
                    <!-- <div class="panel-heading">Agregar tipo de nomina</div> -->

                    <div class="panel-body">
                        <form  class="form" role="form" v-on:submit.prevent="newUpForm()"  id="newUpForm" >
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="amount" class="form-group" v-text="nameField1"></label>
                                    <!-- <input v-if="editId === 0 " type="text" v-model="amount" class="form-control" id="amount" v-bind:placeholder="nameField1" required="required"> -->
                                    <input disabled="disabled" type="text" v-model="objProcessDetails.processName" class="form-control" id="amount" v-bind:placeholder="nameField1" required="required">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-5 ">
                                    <label for="selecTrType" class="form-group" v-text="nameField2"></label>
                                    <select class="form-control" v-model="selecTrType" id="selecTrType" required="required">
                                        <option v-for="item in selecTrTypes" :key="item.transactionTypeCode" :value="item.transactionTypeCode">{{item.transactionTypeName}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="quantity" class="form-group" v-text="nameField3"></label>
                                    <input type="text" v-model="quantity" class="form-control" id="quantity" v-bind:placeholder="nameField3" required="required">
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="amount" class="form-group" v-text="nameField4"></label>
                                    <input type="text" v-model="amount" class="form-control" id="amount" v-bind:placeholder="nameField4" required="required">
                                </div>
                                
                            </div>
                            
                            <div v-if="editId === 0">
                                <button-form 
                                    :buttonType = 1
                                    @cancf = "cancDetailadd"
                                ></button-form>

                            </div>

                            <div v-if="editId > 0">
                                <button-form 
                                    :buttonType = 2
                                    @cancf = "cancDetailadd"
                                ></button-form>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            // console.log('company:')
            // console.log(this.objProcessDetails)
            axios.get(`process-detail-ttype/${this.objProcessDetails.companyId}`).then(res => {
                
                // console.log(res.data.hrTType)
                this.selecTrTypes = res.data.hrTType
                    
                })
                
                // console.log(eeeee)
                // debugger
            
            
           

            if (this.editId > 0) {
                this.selecTrType = document.querySelector("#selecTrType").value = this.objEditDetail.transactionTypeCode
                this.quantity = document.querySelector("#quantity").value = this.objEditDetail.quantity
                this.amount = document.querySelector("#amount").value = this.objEditDetail.amount
                // this.processName = document.querySelector("#processName").value = this.objEditDetail.processName
               
            }
            
            console.log('Component mounted.')
        },
        data(){
            return{
                selecTrType:'',
                quantity: '',
                amount: '',
                processName: '',
                selecTrTypes:{},
                selectCompanys:{},
                selectPayrollType:{},
            }
        },
        props:{
            namePanel:{
                type: String,
                default: 'AGREGAR DETALLE DEL PROCESO'
            },
            namePanel2:{
                type: String,
                default: 'ACTUALIZAR DETALLE DEL PROCESO'
            },
            editId:{
                type: Number,
                default: 0
            },
            nameField1:{
                type: String,
                default: 'PROCESO: '
            },
            nameField2:{
                type: String,
                default: 'TIPO TRANSACCION'
            },
            nameField3:{
                type: String,
                default: 'CANTIDAD'
            },
            nameField4:{
                type: String,
                default: 'MONTO'
            },
            nameField5:{
                type: String,
                default: ''
            },
            nameField6:{
                type: String,
                default: 'Name Defauld'
            },
            nameField7:{
                type: String,
                default: 'Name Defauld'
            },
            nameField8:{
                type: String,
                default: 'Name Defauld'
            },
            objEditDetail:{},
            objProcessDetails: {},
            objEditDetail: {},
            
        },
        methods:{
            newUpForm(){

                if (this.editId === 0) {
                    
                    const params = {
                        hrprocessId: this.objProcessDetails.hrprocessId,
                        transactionTypeCode: this.selecTrType,
                        quantity: this.quantity,
                        amount: this.amount,
                        
                    }

                    // console.log(params)
                    // debugger
                    
    
                    axios.post('process-detail/post',params)
                        .then((response) => {
                            // console.log(response)
                            if (response.statusText == "OK") {
                                alert("Success")
                                document.querySelector("#newUpForm").reset()
                            } else {
                                // console.log(response)
                                alert("Error")
                            }
                            
                        })
                        .catch(function (error) {
                            // alert("Faile")
                            console.log(error);
                        });
                }else{
                    const params = {    
                        transactionTypeCode: this.selecTrType,
                        quantity: this.quantity,
                        amount: this.amount,
                    }
                    

                    let url = `process-detail/${this.objEditDetail.hrpdId}`
                    axios.put(url,params)
                        .then((response) => {
                            // console.log(response);
                            if (response.statusText == "OK") {
                                alert("Success")
                                // document.querySelector("#newUpForm").reset()
                            } else {
                                alert("Error")
                            }
                            
                        })
                        .catch(function (error) {
                            // alert("Faile")
                            console.log(error);
                        });
                }
            },
            cancDetailadd(){
                // console.log('cancDetailadd')
                this.$emit('showlistDetail', 0)
                
            }
        },
        computed: {
            addSuccess: function () {
                return { 
                    background: '#dff0d8', 
                    
                    };  
            },
            ediPrimary: function () {
                return { 
                    background: '#d9edf7', 
                    
                    };  
            },
            
        },
    }
</script>