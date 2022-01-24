<template>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div v-if="editId === 0" class="panel-heading" :style="addSuccess"><h4 class="text-uppercase">{{namePanel}}</h4></div>
                    <div v-else class="panel-heading" :style="ediPrimary"><h4 class="text-uppercase">{{namePanel2}}</h4></div>
                    <!-- <div class="panel-heading">Agregar tipo de nomina</div> -->

                    <div class="panel-body">
                        <form  class="form" role="form" v-on:submit.prevent="newUpForm()" autocomplete="off" id="newUpForm" >
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="payrollTypeId" class="form-group" v-text="nameField3"></label>
                                    <select v-if="editId === 0" class="form-control" v-model="payrollTypeId" id="payrollTypeId" autocomplete="off"  required="required">
                                        <option  value=""> </option>
                                        <option v-for="item in selectPayrollType" :key="item.id" :value="item.id">{{item.vText}}</option>
                                        
                                    </select>
                                    <select v-else class="form-control" v-model="payrollTypeId" id="payrollTypeId" disabled="disabled" autocomplete="off" required="required">
                                        <option v-for="item in selectPayrollType" :key="item.id" :value="item.id">{{item.vText}}</option>
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-8 form-inline"> 
                                    <label for="year" class="form-group" v-text="nameField5"> </label> 
                                    <div class="form-inline">
                                        <select v-if="editId === 0" class="form-control" v-model="year" id="year"  autocomplete="off" required="required">
                                            <option  value=""> </option>
                                            <option v-for=" n  in 5" :key="n" :value="n + years">{{n + years}}</option>
                                            
                                        </select>
                                        <select v-else class="form-control" v-model="year" id="year" autocomplete="off" disabled="disabled" required="required">
                                            <option v-for=" n  in 5" :key="n" :value="n + years">{{n + years}}</option>
                                        </select>
                                        
                                    </div> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="payrollNumber" class="form-group" v-text="nameField4"></label> <button v-if="editId === 0" v-on:click="getPayrollNumber()" type="button" title="Obtener periodo" data-original-title="Obtener periodo" class="btn btn-sm btn-success"><i class="glyphicon glyphicon-search"></i></button>
                                    <select v-if="editId === 0" class="form-control" v-model="payrollNumber" id="payrollNumber" autocomplete="off"  disabled="disabled" required="required">
                                        <option  value=""> </option>
                                        <option v-for="item in selectPayrollNumber" :key="item.id" :value="item.id + '-' + item.vText + '-' + item.periodId">{{item.vText}}</option>
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="processCode" class="form-group" v-text="nameField6"></label>
                                    <select v-if="editId === 0" class="form-control" v-model="processCode" id="processCode" autocomplete="off"  disabled="disabled" required="required">
                                        <option v-for="item in selectProcessCode" :key="item.id" :value="item.id">{{item.vText}}</option>
                                        
                                    </select>
                                    <span v-if="thereIs === false"> No hay procesos para el pais y empresa seleccionado</span>
                                    
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
            this.getPayrollType()
            if (this.editId > 0) {
                axios.get('periods/list/').then(res => {
                // const eeeee = res.data
                    this.selectCompanys = res.data.companys.map(item => {
                        return {id: item.companyId, vText: item.companyShortName}
                    })
                    this.companyId = this.objEdit.companyId 

                    this.selectPayrollType = res.data.payrollType.map(item => {
                        return {id: item.payrollTypeId, vText: item.payrollTypeName}
                    })
                    this.payrollTypeId = this.objEdit.payrollTypeId
                })  
                this.periodName = this.objEdit.periodName
                this.payrollNumber = this.objEdit.payrollNumber
                this.year = this.objEdit.year
                this.periodFrom = this.objEdit.periodFrom
                this.periodTo = this.objEdit.periodTo
            }
            const year = new Date()
            this.years= year.getFullYear() - 3
        },
        data(){
            return{
                payrollTypeId: '',
                periodName: '',
                year: '',
                years: 0,
                processCode: '',
                selectProcessCode: {},
                payrollNumber: '',
                periodId: '',
                thereIs: false,
                selectPayrollType:{},
                selectPayrollNumber:{},
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
                    
                    console.log(this.payrollNumber)
                    const data = this.payrollNumber.split('-')
                    console.log(data)
                    // return
                    data[0] = parseInt(data[0])
                    data[2] = parseInt(data[2])
                    const params = {
                        countryId: this.selectCountry,
                        companyId: this.companyId,
                        payrollTypeId: this.payrollTypeId,
                        payrollNumber: data[0],
                        periodId: data[2],
                        year: this.year,
                        payrollName: data[1],
                        processCode: this.processCode,
                        
                    }

                    // console.log(params)
                    // return
    
                    axios.post('payrollcontrol',params)
                        .then((response) => {
                            // console.log(response)
                            if (response.statusText == "OK") {
                                document.querySelector("#newUpForm").reset()
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
                        countryId: this.selectCountry,
                        companyId: this.companyId,
                        payrollTypeId: this.payrollTypeId,
                        periodName: this.periodName,
                        payrollNumber: this.payrollNumber,
                        periodId: this.periodId,
                        year: this.year,
                        updated: this.updated,
                        periodFrom: this.periodFrom,
                        periodTo: this.periodTo,
                    }
                    let url = `periods/put/${this.objEdit.periodId}`
                    axios.put(url,params)
                        .then((response) => {
                            // console.log(response);
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
            getPayrollType(){
                axios.get(`payrolltypes/list`).then(res => {
                    console.log(res)
                    this.selectPayrollType = res.data.map( item => {
                        return {id: item.payrollTypeId, vText: item.payrollTypeName}
                    })
                })
            },
            getPayrollNumber(){
                if (this.payrollTypeId !== "" && this.year !== "") {
                    axios.get(`payrollcontrol/payrollNumber/${this.payrollTypeId}/${this.year}`).then(res => {
                        console.log(res.data)
                        if (res.data.length > 0) {
                            payrollNumber.disabled = false
                            this.selectPayrollNumber = res.data.map(item =>{
                                return {id: item.payrollNumber, vText: item.periodName , periodId: item.periodId}
                            })
                        }else{
                            alert('No hay registros')
                            payrollNumber.disabled = true
                        }
                    })
                    //obtener proceso
                    axios.get(`payrollcontrol/process/${0}/${0}`).then(res => {
                        console.log(res.data)
                        if (res.data.length > 0) {
                            processCode.disabled = false
                            this.selectProcessCode = res.data.map(item =>{
                                return {id: item.processCode, vText: item.processName}
                            })
                            this.thereIs = true
                        }else{
                            this.thereIs = false
                            processCode.disabled = true
                        }
                    })
                }else{
                    alert('Debe seleccionar pais, compañia, tipo de nomina y año')
                }
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