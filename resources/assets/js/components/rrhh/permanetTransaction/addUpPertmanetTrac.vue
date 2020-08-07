<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div v-if="editId === 0" class="panel-heading" :style="addSuccess"><h4 class="text-uppercase">{{namePanel}}</h4></div>
                    <div v-else class="panel-heading" :style="ediPrimary"><h4 class="text-uppercase">{{namePanel2}}</h4></div>
                    <!-- <div class="panel-heading">Agregar tipo de nomina</div> -->

                    <div class="panel-body">
                        <form  class="form" role="form" v-on:submit.prevent="addUp()"  id="form-add-up" >
                    
                            <div class="form-group col-md-7">
                                <label for="selectStaff" class="form-group" v-text="nameField1"></label>
                                 <select class="form-control" v-model="selectStaff" required="required" id="selectStaff">
                                    <option value=" " selected ></option>
                                    <option v-for="item in objSelectStaffs" :key="item.staffCode"  :countryId="item.countryId" :companyId="item.companyId" :value="item.staffCode">{{item.staffCode}} {{item.shortName}}</option> 
                                </select>
                            </div>
                            <div class="form-group col-md-5">
                                <label for="transactionTypeCode" class="form-group" v-text="nameField2"></label>
                                 <select class="form-control" v-model="transactionTypeCode" required="required" id="transactionTypeCode">
                                    <option value=" " selected ></option>
                                    <option v-for="item in objtransactionTypeCode" :key="item.transactionTypeCode" :value="item.transactionTypeCode">{{item.transactionTypeCode}} {{item.transactionTypeName}}</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-3">
                                <label for="quantity" class="form-group" v-text="nameField3"> </label><br>
                                <input type="number" step="0.0001" v-model="quantity" class="form-control" id="quantity" v-bind:placeholder="'0.5000'" required="required"><a href="#" data-toggle="tooltip" title="Ej: 1.0000 para pagar el monto total cada quincena , 0.5000 pagara la mitad del monto cada quincena"><i class="glyphicon glyphicon-exclamation-sign"></i></a>
                            </div>
                            <div class="form-group col-sm-3">
                                <label for="amount" class="form-group" v-text="nameField4"> </label><br>
                                <input type="number" step="0.01" v-model="amount" class="form-control" id="amount" v-bind:placeholder="'100.00'" required="required">
                            </div>
                            <div class="form-group col-sm-3">
                                <label for="balance" class="form-group" v-text="nameField5"> </label><br>
                                <input type="number" step="0.01" v-model="balance" class="form-control" id="balance" v-bind:placeholder="'100.00'" required="required">
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
            let countryId = 2 //temp
            let companyId = 4 //temp
            const URL1 = `combo-staff/${countryId}/${companyId}`
            const URL2 = `combo-trans-type/${countryId}/${companyId}`
            // obtiene el personal 
            axios.get(URL1).then(res => {
                this.objSelectStaffs = res.data
                // console.log(this.objSelectStaffs)
            })

            // obtiene los tipos de transacciones
            axios.get(URL2).then(res=>{
                this.objtransactionTypeCode = res.data
                // console.log(this.objtransactionTypeCode)
            })

            if (this.editId > 0) {
                console.log(this.objEdit)
                const selectStaffAtrubute = document.querySelector("#selectStaff")
                const transactionTypeAtrubute = document.querySelector("#transactionTypeCode")
                selectStaffAtrubute.setAttribute("disabled", "disabled");
                transactionTypeAtrubute.setAttribute("disabled", "disabled");

                this.selectStaff = document.querySelector("#selectStaff").value = this.objEdit.staffCode
                this.transactionTypeCode = document.querySelector("#transactionTypeCode").value = this.objEdit.transactionTypeCode
                this.quantity = document.querySelector("#quantity").value = this.objEdit.quantity
                this.amount = document.querySelector("#amount").value = this.objEdit.amount
                this.balance = document.querySelector("#balance").value = this.objEdit.balance
                // console.log(this.selectStaff)
            }
            
            console.log('Component mounted.')
            // console.log(this.objEdit)
        },
        data(){
            return{
                selectStaff:'',
                transactionTypeCode:'',
                objtransactionTypeCode:[],
                quantity:'',
                amount:'',
                balance:0,
                objSelectStaffs:[],
                staffCodes:''
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
            objEdit:{}
            
        },
        methods:{
            addUp(){
                if (this.editId === 0) {
                    // obtengo los atrubutos personalizados en el combobox
                    const staffCodess = document.querySelector("#selectStaff")
                    let countryId = staffCodess.options[staffCodess.selectedIndex].getAttribute("countryId")
                    let companyId = staffCodess.options[staffCodess.selectedIndex].getAttribute("companyId")

                    const params = {
                        countryId: parseInt(countryId), //country id
                        companyId: parseInt(companyId), //company id
                        staffCode: this.selectStaff, //codigo
                        transactionTypeCode: this.transactionTypeCode,
                        quantity: parseFloat(this.quantity),
                        amount: parseFloat(this.amount),
                        balance: parseFloat(this.balance),
                    }
                    // console.log(params)
                    // return
                    document.querySelector("#form-add-up").reset()
    
                    axios.post('perm-trans',params)
                        .then((response) => {
                            console.log(response)
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
                        quantity: parseFloat(this.quantity),
                        amount: parseFloat(this.amount),
                        balance: parseFloat(this.balance),
                    }
                    

                    let url = `perm-trans/${this.objEdit.hrpermanentTransactionId}`
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