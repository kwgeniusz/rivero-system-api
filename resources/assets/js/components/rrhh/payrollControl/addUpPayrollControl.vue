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
                                <div class="form-group col-md-6 ">
                                    <label for="selectCountry" class="form-group" v-text="nameField1"></label>
                                    <select v-if="editId === 0" class="form-control" v-model="selectCountry" id="selectCountry" @change="changeCompany($event)" autocomplete="off" required="required">
                                        <option v-for="item in selectCountrys" :key="item.id" :value="item.id">{{item.vText}}</option>
                                        
                                    </select>
                                    <select v-else class="form-control" v-model="selectCountry" id="selectCountry" @change="changeCompany($event)" disabled="disabled" autocomplete="off" required="required">
                                        <option v-for="item in selectCountrys" :key="item.id" :value="item.id">{{item.vText}}</option>
                                        
                                    </select>
                                </div>
                            
                                <div class="form-group col-md-7 ">
                                    <label for="companyId" class="form-group" v-text="nameField2"></label>
                                    <select  v-if="editId === 0" class="form-control" v-model="companyId" id="companyId" @change="payrollType()" disabled="disabled" autocomplete="off" required="required">
                                        <option v-for="item in selectCompanys" :key="item.id" :value="item.id">{{item.vText}}</option>
                                        
                                    </select>
                                    <select v-else class="form-control" v-model="companyId" id="companyId" @change="payrollType()" disabled="disabled" autocomplete="off" required="required">
                                        <option v-for="item in selectCompanys" :key="item.id" :value="item.id">{{item.vText}}</option>
                                        
                                    </select>
                
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="payrollTypeId" class="form-group" v-text="nameField3"></label>
                                    <select v-if="editId === 0" class="form-control" v-model="payrollTypeId" @change="payrollType()" id="payrollTypeId" autocomplete="off"  disabled="disabled" required="required">
                                        <option v-for="item in selectPayrollType" :key="item.id" :value="item.id">{{item.vText}}</option>
                                        
                                    </select>
                                    <select v-else class="form-control" v-model="payrollTypeId" id="payrollTypeId" @change="payrollType()" disabled="disabled" autocomplete="off" required="required">
                                        <option v-for="item in selectPayrollType" :key="item.id" :value="item.id">{{item.vText}}</option>
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-8 form-inline"> 
                                    <label for="year" class="form-group" v-text="nameField5"> </label> 
                                    <div class="form-inline">
                                        <select v-if="editId === 0" class="form-control" v-model="year" id="year"  disabled="disabled" autocomplete="off" required="required">
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
                                        <option v-for="item in selectPayrollNumber" :key="item.id" :value="item.id+'-'+item.vText">{{item.vText}}</option>
                                        
                                    </select>
                                    <!-- <select v-else class="form-control" v-model="payrollTypeId" id="payrollTypeId" disabled="disabled" autocomplete="off" required="required">
                                        <option v-for="item in selectPayrollNumber" :key="item.id" :value="item.id+'-'+item.vText">{{item.vText}}</option>
                                        
                                    </select> -->
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="processCode" class="form-group" v-text="nameField6"></label>
                                    <select v-if="editId === 0" class="form-control" v-model="processCode" id="processCode" autocomplete="off"  disabled="disabled" required="required">
                                        <option v-for="item in selectProcessCode" :key="item.id" :value="item.id">{{item.vText}}</option>
                                        
                                    </select>
                                    <span v-if="thereIs === false"> No hay procesos para el pais y empresa seleccionado</span>
                                    <!-- <select v-else class="form-control" v-model="payrollTypeId" id="payrollTypeId" disabled="disabled" autocomplete="off" required="required">
                                        <option v-for="item in selectPayrollNumber" :key="item.id" :value="item.id+'-'+item.vText">{{item.vText}}</option>
                                        
                                    </select> -->
                                </div>
                            </div>
                            <!-- <div class="row">
                                <div class="form-group col-md-5 ">
                                    
                                    <label for="payrollNumber" class="form-group" v-text="nameField8"></label>
                                    <button v-if="editId === 0" v-on:click="getPayrollNumber()" type="button" title="Obtener Numero de periodo" class="btn btn-sm btn-success"><i class="glyphicon glyphicon-search"></i></button>
                                    <input type="number" v-model="payrollNumber" class="form-control" id="payrollNumber" disabled="disabled" v-bind:placeholder="nameField8" autocomplete="off" required="required">
                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-8 ">
                                    
                                    <label for="periodName" class="form-group" v-text="nameField4"></label>
                                    <input type="text" v-model="periodName" class="form-control" id="periodName" v-bind:placeholder="nameField4" required="required">
                                </div>
                                
                            </div>
                            
                            <div class="row">
                                <div class="form-group col-md-4">
                            
                                    <label for="periodFrom" class="form-group" v-text="nameField6"></label>
                                    <input type="date" v-model="periodFrom" class="form-control" id="periodFrom" v-bind:placeholder="nameField6" autocomplete="off" required="required">
                                   
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="periodTo" class="form-group" v-text="nameField7"></label>
                                    <input type="date" v-model="periodTo" class="form-control" id="periodTo" v-bind:placeholder="nameField7" autocomplete="off" required="required">
                                </div>
                            </div> -->
                            
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
            // const numero = document.querySelector("#payrollNumber")
            // numero.addEventListener("keyup", (event) => {
            // // console.log(numero.value)
            // // if (numero.value  === 0) {
            // //     numero.value = 1
            // // console.log('numero 1')
            // // }
            // numero.value = numero.value.replace(/\D/g, "")
            //     .replace(/([0-9])$/, '$1')
               
            // })
            axios.get('periods/list/').then(res => {
                // const eeeee = res.data
                this.selectCountrys = res.data.countrys.map(item => {
                    return {id: item.countryId, vText: item.countryName}
                    
                })
                
                // this.selectPayrollType = res.data.payrollType.map( item => {
                //     return {id: item.payrollTypeId, vText: item.payrollTypeName}
                // })
                // console.log(this.selectPayrollType)
                // debugger
            })
            
           

            if (this.editId > 0) {
                this.selectCountry = document.querySelector("#selectCountry").value = this.objEdit.countryId
                 axios.get('periods/list/').then(res => {
                // const eeeee = res.data
                    this.selectCompanys = res.data.companys.map(item => {
                        return {id: item.companyId, vText: item.companyShortName}
                    })
                   this.companyId = document.querySelector("#companyId").value = this.objEdit.companyId 

                    this.selectPayrollType = res.data.payrollType.map(item => {
                        return {id: item.payrollTypeId, vText: item.payrollTypeName}
                    })
                   this.payrollTypeId = document.querySelector("#payrollTypeId").value = this.objEdit.payrollTypeId
                })  

            
                
                
                this.periodName = document.querySelector("#periodName").value = this.objEdit.periodName
                this.payrollNumber = document.querySelector("#payrollNumber").value = this.objEdit.payrollNumber
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
                processCode: '',
                selectProcessCode: {},
                payrollNumber: '',
                thereIs: false,
                selectCountrys:{},
                selectCompanys:{},
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
                    data[0] = parseInt(data[0])
                    const params = {
                        countryId: this.selectCountry,
                        companyId: this.companyId,
                        payrollTypeId: this.payrollTypeId,
                        payrollNumber: data[0],
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
            changeCompany(event){
                let cb = event.target.value
                const payrollTypeId = document.querySelector("#payrollTypeId")
                const companyId = document.querySelector("#companyId")
                    companyId.disabled = false
                
                
                axios.get(`companys/contrys/${cb}`).then(res => {
                // const eeeee = res.data
                
                    // console.log(res)
                    this.selectCompanys = res.data.map(item => {
                        return {id: item.companyId, vText: item.companyName}
                        
                    })
                    this.payrollNumber = document.querySelector("#payrollNumber").value = ''
                })

                axios.get(`periods/list/${cb}`).then(res => {

                    this.selectPayrollType = res.data.map( item => {
                        return {id: item.payrollTypeId, vText: item.payrollTypeName}
                    })
                    this.payrollNumber = document.querySelector("#payrollNumber").value = ''
                })
            },
            payrollType(){
                
                const payrollTypeId = document.querySelector("#payrollTypeId")
                const year = document.querySelector("#year")
                const selectCountry = document.querySelector("#selectCountry").value
                const companyId = document.querySelector("#companyId").value
                    payrollTypeId.disabled = false

                if (payrollTypeId.value !== "") {
                    year.disabled = false
                }
                this.payrollNumber = document.querySelector("#payrollNumber").value = ''
        
                //obtener proceso
                axios.get(`payrollcontrol/process/${selectCountry}/${companyId}`).then(res => {
                        console.log(res.data)
                        // return
                        if (res.data.length > 0) {
                            // console.log('entr0o')
                //             processCode: '',
                // selectProcessCode:
                            processCode.disabled = false
                            this.selectProcessCode = res.data.map(item =>{
                                return {id: item.processCode, vText: item.processName}
                            })
                            this.thereIs = true
                            
                            // let num = res.data[0].payrollNumber + 1
                           
                            // this.payrollNumber = parseInt(num)
                        }else{
                            this.thereIs = false
                            processCode.disabled = true

                        }
                    })
                
            },
            getPayrollNumber(){

                const selectCountry = document.querySelector("#selectCountry").value
                const companyId = document.querySelector("#companyId").value
                const payrollType = document.querySelector("#payrollTypeId").value
                const year = document.querySelector("#year").value
                const payrollNumber = document.querySelector("#payrollNumber")
                // this.payrollNumber = document.querySelector("#payrollNumber").value
                

                // console.log(payrollNumber)
                
                if (selectCountry !== "" && companyId !== "" && payrollType !== "" && year !== "") {
                    // payrollNumber.disabled = false
                    axios.get(`payrollcontrol/payrollNumber/${selectCountry}/${companyId}/${payrollType}/${year}`).then(res => {
                        // console.log(res.data)
                        // return
                        if (res.data.length > 0) {
                            // console.log('entr0o')
                            payrollNumber.disabled = false
                            this.selectPayrollNumber = res.data.map(item =>{
                                return {id: item.payrollNumber, vText: item.periodName}
                            })
                            // let num = res.data[0].payrollNumber + 1
                           
                            // this.payrollNumber = parseInt(num)
                        }else{
                            alert('No hay registros')
                            payrollNumber.disabled = true

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