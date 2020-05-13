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
                                <div class="form-group col-md-6 ">
                                    <label for="selectCountry" class="form-group" v-text="nameField1"></label>
                                    <select class="form-control" v-model="selectCountry" id="selectCountry" required="required">
                                        <option v-for="item in selectCountrys" :key="item.id" :value="item.id">{{item.vText}}</option>
                                        
                                    </select>
                                </div>
                            
                                <div class="form-group col-md-7 ">
                                    <label for="companyId" class="form-group" v-text="nameField2"></label>
                                    <select class="form-control" v-model="companyId" id="companyId" required="required">
                                        <option v-for="item in selectCompanys" :key="item.id" :value="item.id">{{item.vText}}</option>
                                        
                                    </select>
                
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="payrollTypeId" class="form-group" v-text="nameField3"></label>
                                    <select class="form-control" v-model="payrollTypeId" id="payrollTypeId" required="required">
                                        <option v-for="item in selectPayrollType" :key="item.id" :value="item.id">{{item.vText}}</option>
                                        
                                    </select>
                                </div>

                                <div class="form-group col-md-8 ">
                                    
                                    <label for="periodName" class="form-group" v-text="nameField4"></label>
                                    <input type="text" v-model="periodName" class="form-control" id="periodName" v-bind:placeholder="nameField4" required="required">
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4"> 
                                    <label for="year" class="form-group" v-text="nameField5"> </label> 
                                       
                                    <select class="form-control" v-model="year" id="year" required="required">
                                        <option v-for=" n  in 5" :key="n" :value="n + years">{{n + years}}</option>
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                            
                                    <label for="periodFrom" class="form-group" v-text="nameField6"></label>
                                    <input type="date" v-model="periodFrom" class="form-control" id="periodFrom" v-bind:placeholder="nameField6" required="required">
                                    <!-- <select class="form-control" v-model="periodFrom" id="periodFrom" required="required">
                                        <option value="0">No</option>
                                        <option value="1">Si</option>
                                    </select> -->
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="periodTo" class="form-group" v-text="nameField7"></label>
                                    <input type="date" v-model="periodTo" class="form-control" id="periodTo" v-bind:placeholder="nameField7" required="required">
                                    <!-- <select class="form-control" v-model="periodTo" id="periodTo" required="required">
                                        <option value="0">No</option>
                                        <option value="1">Si</option>
                                    </select> -->
                                    <!-- <input type="text" v-model="periodTo" class="form-control" id="periodTo" v-bind:placeholder="nameField7" required="required"> -->
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
                this.selectPayrollType = res.data.payrollType.map( item => {
                    return {id: item.payrollTypeId, vText: item.payrollTypeName}
                })
                // console.log(eeeee)
                // debugger
            })
            
           

            if (this.editId > 0) {
                this.selectCountry = document.querySelector("#selectCountry").value = this.objEdit.countryId
                this.companyId = document.querySelector("#companyId").value = this.objEdit.companyId
                this.payrollTypeId = document.querySelector("#payrollTypeId").value = this.objEdit.payrollTypeId
                this.periodName = document.querySelector("#periodName").value = this.objEdit.periodName
                this.year = document.querySelector("#year").value = this.objEdit.year
                this.periodFrom = document.querySelector("#periodFrom").value = this.objEdit.periodFrom
                this.periodTo = document.querySelector("#periodTo").value = this.objEdit.periodTo
               
            }
            
            const year = new Date()
            this.years= year.getFullYear() - 3
           
                // console.log(this.years)
            console.log('Component mounted.')
        },
        data(){
            return{
                selectCountry:'',
                companyId: '',
                payrollTypeId: '',
                periodName: '',
                year: '',
                years: 0,
                periodFrom: '',
                periodTo: '',
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
                        payrollTypeId: this.payrollTypeId,
                        periodName: this.periodName,
                        year: this.year,
                        periodFrom: this.periodFrom,
                        periodTo: this.periodTo,
                        
                    }

                    // console.log(params)
                    // debugger
                    document.querySelector("#newUpForm").reset()
    
                    axios.post('periods/post',params)
                        .then((response) => {
                            // console.log(response)
                            if (response.statusText == "OK") {
                                alert("Success")
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
                        payrollTypeId: this.payrollTypeId,
                        periodName: this.periodName,
                        year: this.year,
                        periodFrom: this.periodFrom,
                        periodTo: this.periodTo,
                    }
                    document.querySelector("#newUpForm").reset()

                    let url = `periods/put/${this.objEdit.periodId}`
                    axios.put(url,params)
                        .then((response) => {
                            console.log(response);
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