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
                                <div class="form-group col-md-3">
                                    <label for="processCode" class="form-group" v-text="nameField1"></label>
                                    <input v-if="editId === 0 " type="number" v-model="processCode" class="form-control" id="processCode" v-bind:placeholder="nameField1" required="required">
                                    <input v-else disabled="disabled" type="text" v-model="processCode" class="form-control" id="processCode" v-bind:placeholder="nameField1" required="required">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="form-group col-md-7">
                                    <label for="processName" class="form-group" v-text="nameField4"></label>
                                    <input type="text" v-model="processName" class="form-control" id="processName" v-bind:placeholder="nameField4" required="required">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <select class="form-control" v-model="payrollCategory" id="payrollCategory" autocomplete="off"  required="required">
                                        <option  value="payroll">Nomina</option>
                                        <option  value="vacation">Vacaciones</option>
                                        <option  value="christmas">Navidad</option>
                                    </select>
                                </div>
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
                this.processCode = this.objEdit.processCode
                this.processName = this.objEdit.processName
                this.payrollCategory = this.objEdit.payrollCategory
            }
        },
        data(){
            return{

                processCode: '',
                processName: '',
                payrollCategory: 'payroll',
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
            nameField4:{
                type: String,
                default: 'Name Defauld'
            },
            objEdit:{}
            
        },
        methods:{
            newUpForm(){

                if (this.editId === 0) {
                    
                    const params = {
                        processCode: this.processCode,
                        processName: this.processName,
                        payrollCategory: this.payrollCategory,
                    }

                    // console.log(params)
                    // debugger
                    
    
                    axios.post('process/post',params)
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
                        processCode: this.processCode,
                        processName: this.processName,
                        payrollCategory: this.payrollCategory,
                    }
                    

                    let url = `process/put/${this.objEdit.hrprocessId}`
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
            cancf(){
                this.$emit('showlist', 0)
                
            },
            changeCompany(event){
                let cb = event.target.value
                axios.get(`companys/contrys/${cb}`).then(res => {

                this.selectCompanys = res.data.map(item => {
                    return {id: item.companyId, vText: item.companyName}
                    
                })
                // console.log(eeeee)
                // debugger
            })
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
