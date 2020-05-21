<template>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div v-if="editId === 0" class="panel-heading" :style="addSuccess"><h4 class="text-uppercase">{{namePanel}}</h4></div>
                    <div v-else class="panel-heading" :style="ediPrimary"><h4 class="text-uppercase">{{namePanel2}}</h4></div>
                    <!-- <div class="panel-heading">Agregar tipo de nomina</div> -->

                    <div class="panel-body">
                        <form  class="form" role="form" v-on:submit.prevent="newUpPosition()"  id="form-hrposition-type" >
                            
                            <div class="row">
                                <div class="form-group col-md-5 col-md-offset-0">
                                    <label for="selectCountry" class="form-group" v-text="nameField1"></label>
                                    <select class="form-control" v-model="selectCountry" id="selectCountry" required="required">
                                        <option v-for="item in selectCountrys" :key="item.id" :value="item.id">{{item.vText}}</option>
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="positionCode" class="form-group" v-text="nameField2"></label>
                                    <input type="text" v-model="positionCode" class="form-control" id="positionCode" v-bind:placeholder="nameField2" required="required">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-7">
                                    <label for="positionName" class="form-group" v-text="nameField3"></label>
                                    <input type="text" v-model="positionName" class="form-control" id="positionName" v-bind:placeholder="nameField2" required="required">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-5">
                                    <a href="#" data-toggle="tooltip" title="salario mensual en moneda base (puede ser dolar)"><i class="glyphicon glyphicon-exclamation-sign"></i></a>
                                    <label for="baseSalary" class="form-group" v-text="nameField4"></label>
                                    <input type="text" v-model="baseSalary" class="form-control" id="baseSalary" v-bind:placeholder="nameField4" >
                                </div>
                                <div class="form-group col-md-4"> 
                                    
                                    <label for="baseCurrencyId" class="form-group" v-text="nameField5"> </label> 

                                    <select class="form-control" v-model="baseCurrencyId" id="baseCurrencyId" >
                                        <option v-for="item in selectCurrency" :key="item.id" :value="item.id">{{item.vText}}</option>
                                    </select>   

                                    <!-- <input type="text" v-model="baseCurrencyId" class="form-control" id="baseCurrencyId" v-bind:placeholder="nameField5" required="required"> -->
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-5">
                                    <a href="#" data-toggle="tooltip" title="salario mensual en moneda local"><i class="glyphicon glyphicon-exclamation-sign"></i></a>
                                    <label for="localSalary" class="form-group" v-text="nameField6"></label>
                                    <input type="text" v-model="localSalary" class="form-control" id="localSalary" v-bind:placeholder="nameField">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="localCurrencyId" class="form-group" v-text="nameField7"></label>
                                    <select class="form-control" v-model="localCurrencyId" id="localCurrencyI">
                                        <option v-for="item in selectCurrency" :key="item.id" :value="item.id">{{item.vText}}</option>
                                    </select>
                                    <!-- <input type="text" v-model="localCurrencyId" class="form-control" id="localCurrencyId" v-bind:placeholder="nameField7" required="required"> -->
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-5">
                                    <label for="localDailySalary" class="form-group" v-text="nameField8"></label>
                                    <input type="text" v-model="localDailySalary" class="form-control" id="localDailySalary" v-bind:placeholder="nameField6" >
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

            axios.get('companys/contrys').then(res => {
                this.selectCountrys = res.data.map(item => {
                    return {id: item.countryId, vText: item.countryName}
                    
                })
            })
            axios.get('hrposition/').then(response => {
                this.selectCurrency = response.data.currencies.map(item => {
                    return {id: item.currencyId, vText: item.currencyName}
                    
                })
            })
           

            if (this.editId > 0) {
                this.selectCountry = document.querySelector("#selectCountry").value = this.objEdit.countryId
                this.positionCode = document.querySelector("#positionCode").value = this.objEdit.positionCode
                this.positionName = document.querySelector("#positionName").value = this.objEdit.positionName
                this.baseSalary = document.querySelector("#baseSalary").value = this.objEdit.baseSalary
                this.baseCurrencyId = document.querySelector("#baseCurrencyId").value = this.objEdit.baseCurrencyId
                this.localSalary = document.querySelector("#localSalary").value = this.objEdit.localSalary
                this.localCurrencyId = document.querySelector("#localCurrencyId").value = this.objEdit.localCurrencyId
                this.localDailySalary = document.querySelector("#localDailySalary").value = this.objEdit.localDailySalary
            }
            
            console.log('Component mounted.')
        },
        data(){
            return{
                selectCurrency:'',
                selectCountry:'',
                positionCode: '',
                positionName: '',
                baseSalary: '',
                baseCurrencyId: '',
                localSalary: '',
                localCurrencyId: '',
                localDailySalary: '',
                selectCountrys:{},
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
            newUpPosition(){

                if (this.editId === 0) {
                    
                    const params = {
                        countryId: this.selectCountry,
                        positionCode: this.positionCode,
                        positionName: this.positionName,
                        baseSalary: this.baseSalary,
                        baseCurrencyId: this.baseCurrencyId,
                        localSalary: this.localSalary,
                        localCurrencyId: this.localCurrencyId,
                        localDailySalary: this.localDailySalary,
                        
                    }

                    // console.log(params)
                    // debugger
                    document.querySelector("#form-hrposition-type").reset()
    
                    axios.post('hrposition/post',params)
                        .then((response) => {
                            console.log(response)
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
                        positionCode: this.positionCode,
                        positionName: this.positionName,
                        baseSalary: this.baseSalary,
                        baseCurrencyId: this.baseCurrencyId,
                        localSalary: this.localSalary,
                        localCurrencyId: this.localCurrencyId,
                        localDailySalary: this.localDailySalary,
                    }
                    // document.querySelector("#form-hrposition-type").reset()

                    let url = `hrposition/put/${this.objEdit.hrpositionId}`
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