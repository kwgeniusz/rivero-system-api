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
                                    <select v-if="editId === 0" class="form-control" v-model="payrollTypeId" @change="payrollType()" id="payrollTypeId" autocomplete="off"  required="required">
                                        <option v-for="item in selectPayrollType" :key="item.id" :value="item.id">{{item.vText}}</option>
                                        
                                    </select>
                                    <select v-else class="form-control" v-model="payrollTypeId" id="payrollTypeId" @change="payrollType()" disabled="disabled" autocomplete="off" required="required">
                                        <option v-for="item in selectPayrollType" :key="item.id" :value="item.id">{{item.vText}}</option>
                                        
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="payrollCategory" class="form-group" >&nbsp;</label>
                                    <select class="form-control" v-model="payrollCategory" id="payrollCategory" autocomplete="off"  required="required">
                                        <option value="payroll">Nomina</option>
                                        <option value="vacation">Vacaciones</option>
                                        <option value="christmas">Navidades</option>
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4"> 
                                    <label for="year" class="form-group" v-text="nameField5"> </label> 

                                    <select v-if="editId === 0" class="form-control" v-model="year" id="year" autocomplete="off" required="required">
                                        <option v-for=" n  in 5" :key="n" :value="n + years">{{n + years}}</option>
                                        
                                    </select>
                                    <select v-else class="form-control" v-model="year" id="year" autocomplete="off" disabled="disabled" required="required">
                                        <option v-for=" n  in 5" :key="n" :value="n + years">{{n + years}}</option>
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="row">
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
                                <div class="form-group col-md-4">
                                    <label for="periodTo" class="form-group" v-text="nameField7"></label>
                                    <input type="date" v-model="periodTo" class="form-control" id="periodTo" v-bind:placeholder="nameField7" autocomplete="off" required="required">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="periodTo" class="form-group" v-text="'Ingrese los dias feriados, entre las dos fechas del periodo'"></label>
                                    
                                </div>
                                <div class="form-group col-md-3 ">
                                    <input type="number" v-model="holiday1" class="form-control" id="holiday1" v-bind:placeholder="'Feriado 1'" >
                                </div>
                                <div class="form-group col-md-3 ">
                                    <input type="number" v-model="holiday2" class="form-control" id="holiday2" v-bind:placeholder="'Feriado 2'" >
                                </div>
                                <div class="form-group col-md-3 ">
                                    <input type="number" v-model="holiday3" class="form-control" id="holiday3" v-bind:placeholder="'Feriado 3'" >
                                </div>
                                <div class="form-group col-md-3 ">
                                    <input type="number" v-model="holiday4" class="form-control" id="holiday4" v-bind:placeholder="'Feriado 4'" >
                                </div>
                                <div class="form-group col-md-3 ">
                                    <input type="number" v-model="holiday5" class="form-control" id="holiday5" v-bind:placeholder="'Feriado 5'" >
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

                    this.selectPayrollType = res.data.payrollType.map(item => {
                        return {id: item.payrollTypeId, vText: item.payrollTypeName}
                    })
                    this.payrollTypeId = this.objEdit.payrollTypeId
                })  
                this.periodName = this.objEdit.periodName
                this.payrollNumber = this.objEdit.payrollNumber
                this.year = this.objEdit.year
                this.periodFrom = this.objEdit.periodFrom
                this.payrollCategory = this.objEdit.payrollCategory
                this.periodTo = this.objEdit.periodTo
                this.holiday1 = this.objEdit.holiday1
                this.holiday2 = this.objEdit.holiday2
                this.holiday3 = this.objEdit.holiday3
                this.holiday4 = this.objEdit.holiday4
                this.holiday5 = this.objEdit.holiday5
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
                updated: 0,
                periodFrom: '',
                periodTo: '',
                payrollCategory:'payroll',
                payrollNumber: '',
                holiday1:'',
                holiday2:'',
                holiday3:'',
                holiday4:'',
                holiday5:'',
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
                        payrollTypeId: this.payrollTypeId,
                        periodName: this.periodName,
                        payrollNumber: this.payrollNumber,
                        year: this.year,
                        updated: this.updated,
                        periodFrom: this.periodFrom,
                        payrollCategory: this.payrollCategory,
                        periodTo: this.periodTo,
                        holiday1: this.holiday1,
                        holiday2: this.holiday2,
                        holiday3: this.holiday3,
                        holiday4: this.holiday4,
                        holiday5: this.holiday5,
                        
                    }

                    // console.log(params)
                    // debugger
    
                    axios.post('periods/post',params)
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
                        payrollTypeId: this.payrollTypeId,
                        periodName: this.periodName,
                        payrollNumber: this.payrollNumber,
                        year: this.year,
                        updated: this.updated,
                        periodFrom: this.periodFrom,
                        payrollCategory: this.payrollCategory,
                        periodTo: this.periodTo,
                        holiday1: this.holiday1,
                        holiday2: this.holiday2,
                        holiday3: this.holiday3,
                        holiday4: this.holiday4,
                        holiday5: this.holiday5,
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
                axios.get(`payrolltypes/`)
                    .then(res => {
                        this.selectPayrollType = res.data.map( item => {
                            return {id: item.payrollTypeId, vText: item.payrollTypeName}
                        })
                        console.log(this.selectPayrollType)
                    })
            },
            payrollType(){
                
                const payrollTypeId = document.querySelector("#payrollTypeId")
                const year = document.querySelector("#year")
                    payrollTypeId.disabled = false

                if (payrollTypeId.value !== "") {
                    year.disabled = false
                }
                this.payrollNumber = document.querySelector("#payrollNumber").value = ''
                
            },
            getPayrollNumber(){
                if (this.payrollType !== "" && this.year !== "") {
                    
                    axios.get(`periods/payrollNumber/${0}/${0}/${this.payrollTypeId}/${this.year}`).then(res => {
                        if (res.data[0].payrollNumber === null || res.data[0].payrollNumber ==="") {
                            // console.log('entr0o')
                            let num = res.data[0].payrollNumber + 1
                            
                            this.payrollNumber = parseInt(num)
                        }else{
                            
                            this.payrollNumber = parseInt(res.data[0].payrollNumber + 1)

                        }
                    })
                }else{
                    alert('Debe seleccionar tipo de nomina y año')
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