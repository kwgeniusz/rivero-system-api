<template>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div v-if="editId === 0" class="panel-heading" :style="addSuccess"><h4 class="text-uppercase">{{namePanel}}</h4></div>
                    <div v-else class="panel-heading" :style="ediPrimary"><h4 class="text-uppercase">{{namePanel2}}</h4></div>
                    <!-- <div class="panel-heading">Agregar tipo de nomina</div> -->

                    <div class="panel-body">
                        <form  class="form" role="form" v-on:submit.prevent="newPayrollType()"  id="form-payroll-type" >
                    
                            <div class="form-group col-md-7">
                                <label for="selectCountry" class="form-group" v-text="nameField1"></label>
                                <select class="form-control" v-model="selectCountry" id="selectCountry" required="required">
                                    <option v-for="item in selectCountrys" :key="item.id" :value="item.id">{{item.vText}}</option>
                                    
                                </select>
                            </div>
                            <div class="form-group col-md-8">
                                <label for="payrollTypeName" class="form-group" v-text="nameField2"></label>
                                <input type="text" v-model="payrollTypeName" class="form-control" id="payrollTypeName" v-bind:placeholder="nameField2" required="required">
                            </div>
                            <div class="form-group col-md-9">
                                <label for="payrollTypeDescription" class="form-group" v-text="nameField3"></label><br>
                                <textarea class="form-control" rows="1" v-model="payrollTypeDescription" id="payrollTypeDescription" required="required"></textarea>
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
            if (this.editId > 0) {
                this.selectCountry = document.querySelector("#selectCountry").value = this.objEdit.countryId
                this.payrollTypeName = document.querySelector("#payrollTypeName").value = this.objEdit.payrollTypeName
                this.payrollTypeDescription = document.querySelector("#payrollTypeDescription").value = this.objEdit.payrollTypeDescription
            }
            
            console.log('Component mounted.')
        },
        data(){
            return{
                selectCountry:'',
                payrollTypeName:'',
                payrollTypeDescription:'',
                selectCountrys:{}
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
            objEdit:{}
            
        },
        methods:{
            newPayrollType(){

                if (this.editId === 0) {
                    
                    const params = {
                        countryId: this.selectCountry,
                        payrollTypeName: this.payrollTypeName,
                        payrollTypeDescription: this.payrollTypeDescription,
                    }
                    document.querySelector("#form-payroll-type").reset()
    
                    axios.post('payrolltypes/post',params)
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
                }else{
                    const params = {    
                        countryId: this.selectCountry,
                        payrollTypeName: this.payrollTypeName,
                        payrollTypeDescription: this.payrollTypeDescription,
                    }
                    // document.querySelector("#form-payroll-type").reset()

                    let url = `payrolltypes/put/${this.objEdit.payrollTypeId}`
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