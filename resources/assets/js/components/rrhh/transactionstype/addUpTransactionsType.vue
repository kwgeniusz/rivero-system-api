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
                                <div class="form-group col-md-4">
                                    <label for="transactionTypeCode" class="form-group" v-text="nameField3"></label>
                                    <input type="number" maxlength="4" v-model="transactionTypeCode" class="form-control" id="transactionTypeCode" v-bind:placeholder="nameField3" required="required">
                                </div>

                                <div class="form-group col-md-9">
                                    
                                    <label for="transactionTypeName" class="form-group" v-text="nameField4"></label>
                                    <input type="text" v-model="transactionTypeName" class="form-control" id="transactionTypeName" v-bind:placeholder="nameField4" required="required">
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="form-group col-md-7 form-inline"> 
                                    <label for="salaryBased" class="form-group" v-text="nameField5"> </label> 
                                    <input type="checkbox"  id="salaryBased" v-model="salaryBased" value="1">
                                </div>
                                <div class="form-group col-md-7 form-inline">
                                    <label for="isIncome" class="form-group" v-text="nameField6"></label>
                                    <input type="checkbox" id="isIncome" v-model="isIncome" value="1">
                                </div>
                                <div class="form-group col-md-7 form-inline">
                                    <label for="hasBalance" class="form-group" v-text="nameField7"></label>
                                    <input type="checkbox" id="hasBalance" v-model="hasBalance" value="1">
                                </div>
                                <div class="form-group col-md-7 form-inline">
                                    <label for="blockSS" class="form-group" v-text="nameField11"></label>
                                    <input type="checkbox" id="blockSS" v-model="blockSS" value="1">
                                </div>
                                <div class="form-group col-md-7 form-inline">
                                    <label for="accTax" class="form-group" v-text="nameField8"></label>
                                    <input type="checkbox" id="accTax" v-model="accTax" value="1">
                                    
                                </div>
                                <div class="form-group col-md-7 form-inline">
                                    <label for="accChristmas" class="form-group" v-text="nameField9"></label>
                                    <input type="checkbox" id="accChristmas" v-model="accChristmas" value="1">
                                    
                                </div>
                                <div class="form-group col-md-7 form-inline">
                                    <label for="accSeniority" class="form-group" v-text="nameField10"></label>
                                    <input type="checkbox" id="accSeniority" v-model="accSeniority" value="1">
                                </div>
                                <div class="form-group col-md-7 form-inline">
                                    <label for="display" class="form-group" v-text="nameField12"></label>
                                    <input type="checkbox" id="display" v-model="display" value="1">
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
                this.transactionTypeCode = this.objEdit.transactionTypeCode
                this.transactionTypeName = this.objEdit.transactionTypeName
                this.salaryBased = this.objEdit.salaryBased
                this.isIncome = this.objEdit.isIncome
                this.hasBalance = this.objEdit.hasBalance
                this.accTax = this.objEdit.accTax
                this.accChristmas = this.objEdit.accChristmas
                this.accSeniority = this.objEdit.accSeniority
                this.blockSS = this.objEdit.blockSS
                this.display = this.objEdit.displa
            }
        },
        data(){
            return{
                selectCurrency:'',
                transactionTypeCode: '',
                transactionTypeName: '',
                salaryBased: 0,
                isIncome: 0,
                hasBalance: 0,
                accTax: 0,
                accChristmas: 0,
                accSeniority: 0,
                blockSS: 0,
                display: 0,
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
            objEdit:{}
            
        },
        methods:{
            newUpForm(){

                if (this.editId === 0) {
                    
                    const params = {
                        transactionTypeCode: this.transactionTypeCode,
                        transactionTypeName: this.transactionTypeName,
                        salaryBased: this.salaryBased,
                        isIncome: this.isIncome,
                        hasBalance: this.hasBalance,
                        accTax: this.accTax,
                        accChristmas: this.accChristmas,
                        accSeniority: this.accSeniority,
                        blockSS: this.blockSS,
                        display: this.display,
                        
                    }
                    axios.post('transactionstypes/post',params)
                        .then((response) => {
                            // console.log(response)
                            if (response.statusText == "OK") {
                                // document.querySelector("#newUpForm").reset()
                                alert("Success")
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
                        transactionTypeCode: this.transactionTypeCode,
                        transactionTypeName: this.transactionTypeName,
                        salaryBased: this.salaryBased,
                        isIncome: this.isIncome,
                        hasBalance: this.hasBalance,
                        accTax: this.accTax,
                        accChristmas: this.accChristmas,
                        accSeniority: this.accSeniority,
                        blockSS: this.blockSS,
                        display: this.display,
                    }
                    let url = `transactionstypes/put/${this.objEdit.hrtransactionTypeId}`
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
                
            },
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