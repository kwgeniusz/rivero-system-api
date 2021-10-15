<template>
	<div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div  class="panel-heading" :style="addSuccess"><h4 class="text-uppercase">Agregar Pre Vacacion</h4></div>
                    <!-- <div class="panel-heading">Agregar tipo de nomina</div> -->
                    <div class="panel-body">
                        <form  class="form" role="form" v-on:submit.prevent="newUpForm()" autocomplete="off" id="newUpForm" >
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="payrollTypeId" class="form-group" v-text="nameField1"></label>
                                    <select class="form-control" v-model="payrollTypeId" id="payrollTypeId" autocomplete="off"  required="required">
                                        <option  value="">{{regData}}</option>
                                        <option v-for="item in selectPayrollType" :key="item.id" :value="item.id">{{item.vText}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-8 form-inline"> 
                                    <label for="year" class="form-group" v-text="nameField2"> </label> 
                                    <div class="form-inline">
                                        <select v-if="editId === 0" class="form-control" v-model="year" id="year"  autocomplete="off" required="required">
                                            <option  value=""> </option>
                                            <option v-for=" n  in 5" :key="n" :value="n + years">{{n + years}}</option>
                                        </select>
                                        
                                    </div> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="payrollNumber" class="form-group" v-text="nameField3"></label> <button v-if="editId === 0" v-on:click="getPayrollNumber()" type="button" title="Obtener periodo" data-original-title="Obtener periodo" class="btn btn-sm btn-success"><i class="glyphicon glyphicon-search"></i></button>
                                    <select v-if="editId === 0" class="form-control" v-model="payrollNumber" id="payrollNumberId" autocomplete="off"  disabled="disabled" required="required">
                                        <option  value=""> </option>
                                        <option v-for="item in selectPayrollNumber" :key="item.id" :value="item.id+'-'+item.vText+'-'+item.periodId">{{item.vText}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="processCode" class="form-group" v-text="nameField4"></label>
                                    <select v-if="editId === 0" class="form-control" v-model="processCode" id="processCodeId" autocomplete="off"  disabled="disabled" required="required">
                                        <option v-for="item in selectProcessCode" :key="item.id" :value="item.id">{{item.vText}}</option>
                                    </select>
                                    <span v-if="thereIs === false"> No hay procesos para esta empresa</span>
                                </div>
                            </div>
                            <div v-if="editId === 0">
                                <div class="form-group col-ms-12 col-md-12 col-lg-12 text-center">
                                    <button type="submit" class="btn btn-success"><span class="fa fa-check"></span> Guardar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
// @ is an alias to /src

export default {
	name: 'AddPreVacation',
	components: {
		
	},
	data() {
		return {
            selectPayrollNumber: {},
			selectPayrollType: {},
            selectProcessCode: {},
            payrollTypeId: "",
            payrollNumber: 0,
            processCode: 0,
            thereIs: false,
            regData: '',
            year: "",
            years: 0,
            editId: 0,
            nameField1: 'Tipo de nomina',
            nameField2: 'Año',
            nameField3: 'Periodo',
            nameField4: 'Proceso',
		}
	},
	mounted() {
		this.getYears()
        this.getPayrollType()
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
	methods: {
        getYears(){
            const year = new Date()
		    this.years = year.getFullYear() - 3
        },
		getPayrollType(){
                axios.get(`payrolltypes/list`).then(res => {
                    res.data.length > 0 
                    ? 
                    this.selectPayrollType = res.data.map( item => {
                        return {id: item.payrollTypeId, vText: item.payrollTypeName}
                    })
                    : this.regData = 'No hay registros para la empresa'
                })
		},
        getPayrollNumber(){
            if (this.payrollTypeId !== "" && this.year !== "" ) {
                axios.get(`payrollcontrol/payrollNumber/vacation/${this.payrollTypeId}/${this.year}`).then(res => {
                    console.log(res)
                    if (res.data.length > 0) {
                        payrollNumberId.disabled = false
                        this.selectPayrollNumber = res.data.map(item =>{
                            return {id: item.payrollNumber, periodId: item.periodId, vText: item.periodName}
                        })
                    }else{
                        alert('No hay registros')
                        payrollNumberId.disabled = true
                    }
                })
                //obtener proceso
                axios.get(`payrollcontrol/process/${0}/${0}`).then(res => {
                    if (res.data.length > 0) {
                        processCodeId.disabled = false
                        this.selectProcessCode = res.data.map(item =>{
                            return {id: item.processCode, vText: item.processName}
                        })
                        this.thereIs = true
                    }else{
                        this.thereIs = false
                        processCodeId.disabled = true
                    }
                })
            }else{
                alert('Debe seleccionar tipo de nomina y año')
            }
        },
        newUpForm(){
            if (this.editId === 0) {
                const data = this.payrollNumber.split('-')
                let payrollNumber = parseInt(data[0])
                let periodId = parseInt(data[2])
                const params = {
                    countryId: this.selectCountry,
                    companyId: this.companyId,
                    payrollTypeId: this.payrollTypeId,
                    payrollNumber,
                    periodId,
                    year: this.year,
                    payrollName: data[1],
                    processCode: this.processCode,
                }
                axios.post('pre-vacations/',params)
                    .then((response) => {
                        if (response.statusText == "OK") {
                            document.querySelector("#newUpForm").reset()
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
	},
}
</script>