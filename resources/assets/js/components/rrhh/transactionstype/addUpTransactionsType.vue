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
                                <div class="form-group col-md-4 ">
                                    <label for="selectCountry" class="form-group" v-text="nameField1"></label>
                                    <select class="form-control" v-model="selectCountry" id="selectCountry" required="required">
                                        <option v-for="item in selectCountrys" :key="item.id" :value="item.id">{{item.vText}}</option>
                                        
                                    </select>
                                </div>
                            
                                <div class="form-group col-md-6 col-md-offset-1">
                                    <label for="companyId" class="form-group" v-text="nameField2"></label>
                                    <select class="form-control" v-model="companyId" id="companyId" required="required">
                                        <option v-for="item in selectCompanys" :key="item.id" :value="item.id">{{item.vText}}</option>
                                        
                                    </select>
                
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="transactionTypeCode" class="form-group" v-text="nameField3"></label>
                                    <input type="number" maxlength="4" v-model="transactionTypeCode" class="form-control" id="transactionTypeCode" v-bind:placeholder="nameField2" required="required">
                                </div>

                                <div class="form-group col-md-7 col-md-offset-1">
                                    
                                    <label for="transactionTypeName" class="form-group" v-text="nameField4"></label>
                                    <input type="text" v-model="transactionTypeName" class="form-control" id="transactionTypeName" v-bind:placeholder="nameField4" required="required">
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4"> 
                                    <label for="salaryBased" class="form-group" v-text="nameField5"> </label> 
                                    <select class="form-control" v-model="salaryBased" id="salaryBased" required="required">
                                        <option value="0">No</option>
                                        <option value="1">Si</option>
                                    </select>   

                                    <!-- <input type="text" v-model="salaryBased" class="form-control" id="salaryBased" v-bind:placeholder="nameField5" required="required"> -->
                                </div>
                                <div class="form-group col-md-4">
                            
                                    <label for="isIncome" class="form-group" v-text="nameField6"></label>
                                    <select class="form-control" v-model="isIncome" id="isIncome" required="required">
                                        <option value="0">No</option>
                                        <option value="1">Si</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="hasBalance" class="form-group" v-text="nameField7"></label>
                                    <select class="form-control" v-model="hasBalance" id="hasBalance" required="required">
                                        <option value="0">No</option>
                                        <option value="1">Si</option>
                                    </select>
                                    <!-- <input type="text" v-model="hasBalance" class="form-control" id="hasBalance" v-bind:placeholder="nameField7" required="required"> -->
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

            axios.get('transactionstypes/').then(res => {
                const eeeee = res.data
                this.selectCountrys = res.data.countrys.map(item => {
                    return {id: item.countryId, vText: item.countryName}
                    
                })
                this.selectCompanys = res.data.companys.map(item => {
                    return {id: item.companyId, vText: item.companyName}
                    
                })
                // console.log(eeeee)
                // debugger
            })
            // axios.get('hrposition/').then(response => {
            //     this.selectCurrency = response.data.currencies.map(item => {
            //         return {id: item.currencyId, vText: item.currencyName}
                    
            //     })
            // })
           

            if (this.editId > 0) {
                this.selectCountry = document.querySelector("#selectCountry").value = this.objEdit.countryId
                this.companyId = document.querySelector("#companyId").value = this.objEdit.companyId
                this.transactionTypeCode = document.querySelector("#transactionTypeCode").value = this.objEdit.transactionTypeCode
                this.transactionTypeName = document.querySelector("#transactionTypeName").value = this.objEdit.transactionTypeName
                this.salaryBased = document.querySelector("#salaryBased").value = this.objEdit.salaryBased
                this.isIncome = document.querySelector("#isIncome").value = this.objEdit.isIncome
                this.hasBalance = document.querySelector("#hasBalance").value = this.objEdit.hasBalance
               
            }
            
            console.log('Component mounted.')
        },
        data(){
            return{
                selectCurrency:'',
                selectCountry:'',
                companyId: '',
                transactionTypeCode: '',
                transactionTypeName: '',
                salaryBased: '',
                isIncome: '',
                hasBalance: '',
                selectCountrys:{},
                selectCompanys:{},
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
                        transactionTypeCode: this.transactionTypeCode,
                        transactionTypeName: this.transactionTypeName,
                        salaryBased: this.salaryBased,
                        isIncome: this.isIncome,
                        hasBalance: this.hasBalance,
                        
                    }

                    // console.log(params)
                    // debugger
                    document.querySelector("#newUpForm").reset()
    
                    axios.post('transactionstypes/post',params)
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
                        transactionTypeCode: this.transactionTypeCode,
                        transactionTypeName: this.transactionTypeName,
                        salaryBased: this.salaryBased,
                        isIncome: this.isIncome,
                        hasBalance: this.hasBalance,
                    }
                    document.querySelector("#newUpForm").reset()

                    let url = `transactionstypes/put/${this.objEdit.hrtransactionTypeId}`
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