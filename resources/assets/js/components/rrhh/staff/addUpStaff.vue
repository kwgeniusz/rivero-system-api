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
                                    <label for="shortName" class="form-group" v-text="nameField1"></label>
                                    <input type="text" v-model="shortName" class="form-control" id="shortName" v-bind:placeholder="nameField1" required="required">
                                    
                                </div>
                            
                                <div class="form-group col-md-9">
                                    <label for="firstName" class="form-group" v-text="nameField2"></label>
                                    <input type="text" v-model="firstName" class="form-control" id="firstName" v-bind:placeholder="nameField2" required="required">
                
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-9">
                                    <label for="lastName" class="form-group" v-text="nameField3"></label>
                                    <input type="text" v-model="lastName" class="form-control" id="lastName" v-bind:placeholder="nameField3" required="required">
                                    <!-- <select class="form-control" v-model="firstName" id="firstName" required="required">
                                        <option v-for="item in selectPayrollType" :key="item.id" :value="item.id">{{item.vText}}</option>
                                        
                                    </select> -->
                                </div>

                                <div class="form-group col-md-5 ">
                                    <label for="idDocument" class="form-group" v-text="nameField4"></label>
                                    <input type="text" v-model="idDocument" class="form-control" id="idDocument" v-bind:placeholder="nameField4">
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="form-group col-md-5"> 
                                    <label for="passportNumber" class="form-group" v-text="nameField5"> </label> 
                                    <input type="text" v-model="passportNumber" class="form-control" id="passportNumber" v-bind:placeholder="nameField5">
                                       
                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-5">
                            
                                    <label for="legalNumber" class="form-group" v-text="nameField6"></label>
                                    <input type="text" v-model="legalNumber" class="form-control" id="legalNumber" v-bind:placeholder="nameField6" >
                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-5">
                                    <label for="staffCode" class="form-group" v-text="nameField7"></label>
                                    <input type="text" v-model="staffCode" class="form-control" id="staffCode" v-bind:placeholder="nameField7" required="required">
                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-5">
                                    <label for="selectCountry" class="form-group" v-text="nameField8"></label>
                                    <select class="form-control" v-model="selectCountry" id="selectCountry" required="required">
                                        <option v-for="item in selectCountrys" :key="item.id" :value="item.id">{{item.vText}}</option>
                                        
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-5">
                                    <label for="selectCompany" class="form-group" v-text="nameField9"></label>
                                    <select class="form-control" v-model="selectCompany" id="selectCompany"  @change="change($event)" required="required">
                                        <option v-for="item in selectCompanys" :key="item.id" :value="item.id">{{item.vText}}</option>
                                        
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-7">
                                    <label for="departmentId" class="form-group" v-text="nameField10"></label>
                                    <select class="form-control" v-model="departmentId" id="departmentId" required="required">
                                        <option v-for="item in selectDepartments" :key="item.departmentId" :value="item.departmentId">{{item.departmentName}}</option>
                                        
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

            axios.get('staff/list/combox/').then(res => {
                // const eeeee = res.data
                this.selectCountrys = res.data.countrys.map(item => {
                    return {id: item.countryId, vText: item.countryName}
                    
                })
                this.selectCompanys = res.data.companys.map(item => {
                    return {id: item.companyId, vText: item.companyName}
                    
                })
                // this.selectPayrollType = res.data.payrollType.map( item => {
                //     return {id: item.firstName, vText: item.payrollTypeName}
                // })
                // console.log(eeeee)
                // debugger
            })
            
           

            if (this.editId > 0) {
                this.selectCountry = document.querySelector("#selectCountry").value = this.objEdit.countryId
                this.shortName = document.querySelector("#shortName").value = this.objEdit.shortName
                this.firstName = document.querySelector("#firstName").value = this.objEdit.firstName
                this.lastName = document.querySelector("#lastName").value = this.objEdit.lastName
                this.idDocument = document.querySelector("#idDocument").value = this.objEdit.idDocument
                this.passportNumber = document.querySelector("#passportNumber").value = this.objEdit.passportNumber
                this.legalNumber = document.querySelector("#legalNumber").value = this.objEdit.legalNumber
                this.staffCode = document.querySelector("#staffCode").value = this.objEdit.staffCode
                this.selectCompany = document.querySelector("#selectCompany").value = this.objEdit.companyId
                this.departmentId = document.querySelector("#departmentId").value = this.objEdit.departmentId
               
            }
        
           
                // console.log(this.lastNames)
            console.log('Component mounted.')
        },
        data(){
            return{
                selectCountry:'',
                selectCompany:'',
                departmentId:'',
                shortName: '',
                firstName: '',
                idDocument: '',
                lastName: '',
                lastNames: 0,
                passportNumber: '',
                legalNumber: '',
                staffCode: '',
                selectCountrys:{},
                selectCompanys:{},
                selectDepartments:{},
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
            nameField9:{
                type: String,
                default: 'Name Defauld'
            },
            nameField10:{
                type: String,
                default: 'Name Defauld'
            },
            nameField11:{
                type: String,
                default: 'Name Defauld'
            },
            nameField12:{
                type: String,
                default: 'Name Defauld'
            },
            nameField13:{
                type: String,
                default: 'Name Defauld'
            },
            nameField14:{
                type: String,
                default: 'Name Defauld'
            },
            nameField15:{
                type: String,
                default: 'Name Defauld'
            },
            nameField16:{
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
                        companyId: this.selectCompany,
                        shortName: this.shortName,
                        firstName: this.firstName,
                        idDocument: this.idDocument,
                        lastName: this.lastName,
                        passportNumber: this.passportNumber,
                        legalNumber: this.legalNumber,
                        staffCode: this.staffCode,
                        departmentId: this.departmentId,
                        
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
                        companyId: this.selectCompany,
                        shortName: this.shortName,
                        firstName: this.firstName,
                        idDocument: this.idDocument,
                        lastName: this.lastName,
                        passportNumber: this.passportNumber,
                        legalNumber: this.legalNumber,
                        staffCode: this.staffCode,
                        departmentId: this.departmentId,
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
            change(event){
                // console.log(event)
                const cb=event.target.value
                axios.get(`/staff/list/comboxDepartment/${cb}`).then( response => {
                this.selectDepartments = response.data.departments
                console.log(this.selectDepartments)
                // debugger
            })
                
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