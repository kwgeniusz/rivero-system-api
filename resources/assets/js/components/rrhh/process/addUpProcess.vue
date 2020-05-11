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
                                    <input v-if="editId === 0 " type="text" v-model="processCode" class="form-control" id="processCode" v-bind:placeholder="nameField1" required="required">
                                    <input v-else disabled="disabled" type="text" v-model="processCode" class="form-control" id="processCode" v-bind:placeholder="nameField1" required="required">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3 ">
                                    <label for="selectCountry" class="form-group" v-text="nameField2"></label>
                                    <select class="form-control" v-model="selectCountry" id="selectCountry" required="required">
                                        <option v-for="item in selectCountrys" :key="item.id" :value="item.id">{{item.vText}}</option>
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-5 ">
                                    <label for="companyId" class="form-group" v-text="nameField3"></label>
                                    <select class="form-control" v-model="companyId" id="companyId" required="required">
                                        <option v-for="item in selectCompanys" :key="item.id" :value="item.id">{{item.vText}}</option>
                                        
                                    </select>
                
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="form-group col-md-7">
                                    <label for="processName" class="form-group" v-text="nameField4"></label>
                                    <input type="text" v-model="processName" class="form-control" id="processName" v-bind:placeholder="nameField4" required="required">
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

            axios.get('periods/list/').then(res => {
                // const eeeee = res.data
                this.selectCountrys = res.data.countrys.map(item => {
                    return {id: item.countryId, vText: item.countryName}
                    
                })
                this.selectCompanys = res.data.companys.map(item => {
                    return {id: item.companyId, vText: item.companyName}
                    
                })
                // console.log(eeeee)
                // debugger
            })
            
           

            if (this.editId > 0) {
                this.selectCountry = document.querySelector("#selectCountry").value = this.objEdit.countryId
                this.companyId = document.querySelector("#companyId").value = this.objEdit.companyId
                this.processCode = document.querySelector("#processCode").value = this.objEdit.processCode
                this.processName = document.querySelector("#processName").value = this.objEdit.processName
               
            }
            
            console.log('Component mounted.')
        },
        data(){
            return{
                selectCountry:'',
                companyId: '',
                processCode: '',
                processName: '',
                selectCountrys:{},
                selectCompanys:{},
                selectPayrollType:{},
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
                default: 'Name Defauld'
            },
            nameField5:{
                type: String,
                default: 'Name Defauld'
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
            objEdit:{}
            
        },
        methods:{
            newUpForm(){

                if (this.editId === 0) {
                    
                    const params = {
                        countryId: this.selectCountry,
                        companyId: this.companyId,
                        processCode: this.processCode,
                        processName: this.processName,
                    }

                    // console.log(params)
                    // debugger
                    
    
                    axios.post('process/post',params)
                        .then((response) => {
                            console.log(response)
                            if (response.statusText == "OK") {
                                alert("Success")
                                document.querySelector("#newUpForm").reset()
                            } else {
                                console.log(response)
                                alert("Error")
                            }
                            
                        })
                        .catch(function (error) {
                            // alert("Faile")
                            console.log(error);
                        });
                }else{
                    const params = {    
                        countryId: this.selectCountry,
                        companyId: this.companyId,
                        processCode: this.processCode,
                        processName: this.processName,
                    }
                    

                    let url = `process/put/${this.objEdit.hrprocessId}`
                    axios.put(url,params)
                        .then((response) => {
                            console.log(response);
                            if (response.statusText == "OK") {
                                alert("Success")
                                document.querySelector("#newUpForm").reset()
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