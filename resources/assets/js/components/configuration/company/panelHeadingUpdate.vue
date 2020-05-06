<template>
        <div class="row">
            <div class="col-lg-6 col-md-offset-3  col-md-6 col-sm-12">
                <div class="panel panel-default">
                    <div v-if="bgColor === 'success'" class="panel-heading" :style="addSuccess"><h4 class="text-uppercase">{{namePanel}}</h4></div>
                    <div v-else class="panel-heading" :style="ediPrimary"><h4 class="text-uppercase">{{namePanel}}</h4></div>
                    
                    <div class="panel-body" >
                        <form role="form" v-on:submit.prevent="newValueOfSixField()" id="formSixField" >
                            <div class="form-group col-md-12">
                                <label for="field1" class="form-group" v-text="nameField1"></label>
                                <input type="text" v-model="varFieldOne" class="form-control " id="field1" name = "field1" v-bind:placeholder="nameField1">

                            </div>
                            <div class="form-group col-md-7">
                                <label for="field2" class="form-group" v-text="nameField2"></label>
                                <input  type="text" v-model="varFieldTwo" class="form-control " id="field2" name = "field2" v-bind:placeholder="nameField2">
                                
                            </div>
                            <div class="form-group col-md-5">
                                <label for="field3" class="form-group" v-text="nameField3"></label>
                                <input type="text" v-model="varFieldThree" class="form-control " id="field3" name = "field3" v-bind:placeholder="nameField3">
                                
                            </div>
                            <div class="form-group col-md-7">
                                <label for="field4" class="form-group" v-text="nameField4"></label>
                                <select class="form-control " v-model="varFieldFour" @change="change4($event)" id="field4">
                                    <option v-for="cbox in objContrys" :key="cbox.id" :value="cbox.id" >{{cbox.vText}}</option>
                                </select>
                            </div>
                            <div class="form-group col-md-7">
                                <label for="field5" class="form-group" v-text="nameField5"></label>
                                <select class="form-control " v-model="varFieldFive" id="field5">
                                    <option v-for="cbox in objOffices" :key="cbox.id" :value="cbox.id">{{cbox.vText}}</option>
                                </select>
                                
                            </div>
                            <div class="form-group col-md-12">
                                <label for="field6" class="form-group " v-text="nameField6"></label>
                                <textarea class="form-control" rows="1" v-model="varFieldSix" id="field6" ></textarea>
                                
                            </div>
                            <button-form
                                :buttonType = buttonType
                                
                                @cancf = "cancf"
                            ></button-form>
                        </form>     
                    </div>
                </div>
            </div>
        </div>
</template>

<script>
    export default {
        mounted() {
            // data for combobox
            axios.get('/companys/contrys').then((response) => {
                this.objContrys = response.data.map( item => {
                    return { id: item.countryId, vText: item.countryName}
                    })
                // console.log(this.objCompanys)

            })

                axios.get(`/companys/show/${this.objEdi}`).then((response) => {
                this.parameters = response.data
                    
                // console.log(this.parameters)
                    this.varFieldId = this.parameters[0].companyId
                    this.varFieldOne = document.getElementById("field1").value = this.parameters[0].companyName
                    this.varFieldTwo = document.getElementById("field2").value = this.parameters[0].companyShortName
                    this.varFieldThree = document.getElementById("field3").value = this.parameters[0].companyNumbrer
                    this.varFieldFour = document.getElementById("field4").value = this.parameters[0].countryId
                    // console.log('office: ' + this.parameters[0].officeId)
                    
                        axios.get(`/companys/offices/${this.parameters[0].countryId}`).then((response) => {
                            this.objOffices = response.data.map( item => {
                                return { id: item.officeId, vText: item.officeName}
                                })

                            const found = this.objOffices.find( item => item.id == this.parameters[0].officeId);
                            this.varFieldFive = document.getElementById("field5").value = found.id


                        })
                        
                    this.varFieldSix = document.getElementById("field6").value = this.parameters[0].companyAddress
                    
                })
                
            

            
            console.log('Component mounted.')
        },
        data() {
            return{
        
                objContrys: [],
                parameters:[],
                objOffices: [],
                varFieldId: '',
                varFieldOne: '',
                varFieldTwo: '',
                varFieldThree: '',
                varFieldFour: '',
                varFieldFive: '',
                varFieldSix: '',
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
            } 
        },
        props: {
            
            objEdi:{
                
            },
            nameField1: {
            type: String,
            default: 'Name Defaul',
            },
            nameField2: {
                type: String,
                default: 'Name Defaul',
            },
            nameField3: {
                type: String,
                default: 'Name Defaul',
            },
            nameField4: {
                type: String,
                default: 'Name Defaul',
            },
            nameField5: {
                type: String,
                default: 'Name Defaul',
            },
            nameField6: {
                type: String,
                default: 'Name Defaul',
            },
            namePanel: {

            },
            bgColor: {

            },
            buttonType: {  

            },
        },
        methods: {
        
            newValueOfSixField(){
                const params = {
                    varFieldOne:   this.varFieldOne,
                    varFieldTwo:   this.varFieldTwo,
                    varFieldThree: this.varFieldThree,
                    varFieldFour:  this.varFieldFour,
                    varFieldFive:  this.varFieldFive,
                    varFieldSix:  this.varFieldSix,
                }
                // console.log(params)
                document.querySelector("#formSixField").reset()
                let url = '/companys/' + this.varFieldId
                // console.log('la url es: '+ url)
                axios.put(url, params)
                .then((response) => {
                    alert('Success')
                    })
                .catch(function (error) {
                    console.log(error);
                });

            },
            cancf(n){
                // console.log('vista a mostrar: ' + n)
                this.$emit('showlist', 0)
            },
            change4(event){

                const cb4=event.target.value
                // console.log(cb4)
                axios.get(`/companys/offices/${cb4}`).then((response) => {
                    this.objOffices = response.data.map( item => {
                    return { id: item.officeId, vText: item.officeName}
                    })
                // console.log(this.objOffices)

                })
                // this.$emit('new4', cb4)
            },
            
        } 
    }
</script>