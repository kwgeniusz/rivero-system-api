<template>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div v-if="editId === 0" class="panel-heading" :style="addSuccess"><h4 class="text-uppercase">{{namePanel}}</h4></div>
                    <div v-else class="panel-heading" :style="ediPrimary"><h4 class="text-uppercase">{{namePanel2}}</h4></div>
                    <!-- <div class="panel-heading">Agregar tipo de nomina</div> -->
                    <div class="panel-body">
                        <form  class="form" role="form" v-on:submit.prevent="newPayrollType()"  id="form-payroll-type" >
                            <div class="form-group col-md-8">
                                <label for="payrollTypeName" class="form-group" v-text="nameField2"></label>
                                <input type="text" v-model="payrollTypeName" class="form-control" id="payrollTypeName" v-bind:placeholder="nameField2" required="required">
                            </div>
                            <div class="form-group col-md-9">
                                <label for="payrollTypeDescription" class="form-group" v-text="nameField3"></label><br>
                                <textarea class="form-control" rows="1" v-model="payrollTypeDescription" id="payrollTypeDescription" required="required"></textarea>
                            </div>
                            <div v-if="editId === 0">
                                <button-form 
                                    :buttonType = 1
                                    @cancf = "cancf"
                                ></button-form>
                            </div>
                            <div v-if="editId > 0">
                                <button-form 
                                    :buttonType = 2
                                    @cancf = "cancf"
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
            if (this.editId > 0) {
                this.payrollTypeName = this.objEdit.payrollTypeName
                this.payrollTypeDescription = this.objEdit.payrollTypeDescription
                this.payrollCategory = this.objEdit.payrollCategory
            }
            
            console.log('Component mounted.')
        },
        data(){
            return{
                payrollTypeName:'',
                payrollTypeDescription:'',
                payrollCategory:'payroll',
            }
        },
        props:{
            namePanel:{
                type: String,
                default: 'Name Defauld'
            },
            namePanel2:{
                type: String,
                default: 'Name Defauld'
            },
            editId:{
                type: Number,
                default: 0
            },
            nameField1:{
                type: String,
                default: 'Name Defauld'
            },
            nameField2:{
                type: String,
                default: 'Name Defauld'
            },
            nameField3:{
                type: String,
                default: 'Name Defauld'
            },
            nameField4:{
                type: String,
                default: 'Usado Para calcular'
            },
            objEdit:{}
            
        },
        methods:{
            newPayrollType(){

                if (this.editId === 0) {
                    
                    const params = {
                        payrollTypeName: this.payrollTypeName,
                        payrollTypeDescription: this.payrollTypeDescription,
                        payrollCategory: this.payrollCategory,
                    }
                    // document.querySelector("#form-payroll-type").reset()
    
                    axios.post('payrolltypes/post',params)
                        .then((response) => {
                            if (response.statusText == "OK") {
                                alert("Success")
                            } else {
                                alert("Error")
                            }
                            
                        })
                        .catch(function (error) {
                            // alert("Faile")
                            console.log(error);
                        });
                }else{
                    const params = {    
                        payrollTypeName: this.payrollTypeName,
                        payrollTypeDescription: this.payrollTypeDescription,
                        payrollCategory: this.payrollCategory,
                    }
                    // document.querySelector("#form-payroll-type").reset()

                    let url = `payrolltypes/put/${this.objEdit.payrollTypeId}`
                    axios.put(url,params)
                        .then((response) => {
                            if (response.statusText == "OK") {
                                alert("Success")
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
            cancf(){
                this.$emit('showlist', 0)
                
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