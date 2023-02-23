<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div v-if="editId === 0" class="panel-heading" :style="addSuccess"><h4 class="text-uppercase">{{namePanel}}</h4></div>
                    <div v-else class="panel-heading" :style="ediPrimary"><h4 class="text-uppercase">{{namePanel2}}</h4></div>
                    <!-- <div class="panel-heading">Agregar tipo de nomina</div> -->

                    <div class="panel-body">
                        <form  class="form" role="form" v-on:submit.prevent="addUp()" id="form-add-up" autocomplete="off">
                            <div class="row">
                                <div class="form-group col-md-7">
                                    <label for="selectStaff" class="form-group" v-text="nameField1"></label>
                                    <select class="form-control" v-model="selectStaff" required="required" autocomplete="off" id="selectStaff">
                                        <option value="" selected ></option>
                                        <option v-for="item in objSelectStaffs" :key="item.staffCode"  :countryId="item.countryId" :companyId="item.companyId" :value="item.staffCode">{{item.staffCode}} {{item.shortName}}</option> 
                                    </select>
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="transactionTypeCode" class="form-group" v-text="nameField2"></label>
                                    <select class="form-control" v-model="transactionTypeCode" @change="calcularProceso()" autocomplete="off" required="required" id="transactionTypeCode">
                                        <option value=" " selected ></option>
                                        <option v-for="item in objtransactionTypeCode" :key="item.transactionTypeCode" :isIncome="item.isIncome" :hasBalance="item.hasBalance" :value="item.transactionTypeCode">{{item.transactionTypeCode}} {{item.transactionTypeName}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-3">
                                    <label for="quantity" class="form-group" v-text="nameField3"> </label><br>
                                    <input type="number" step="0.0001" v-model="quantity" @keyup="getCuotas()" class="form-control" autocomplete="off" id="quantity" v-bind:placeholder="'0.5000'" required="required"><a href="#" data-toggle="tooltip" title="Ej: 1.0000 para pagar el monto total cada quincena , 0.5000 pagara la mitad del monto cada quincena"><i class="glyphicon glyphicon-exclamation-sign"></i></a>
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for="amount" class="form-group" v-text="nameField4"> </label><br>
                                    <input type="number" step="0.01" v-model="amount" @keyup="getCuotas()" class="form-control" autocomplete="off" id="amount" v-bind:placeholder="'100.00'" required="required">
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for="balance" class="form-group" v-text="nameField5"> </label><br>
                                    <input type="number" step="0.01" v-model="balance" @keyup="calculaMonto()" class="form-control" autocomplete="off" id="balance" v-bind:placeholder="'100.00'" required="required">
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for="initialBalance" class="form-group" v-text="nameField7"> </label><br>
                                    <input type="text"  v-model="initialBalance" class="form-control" id="initialBalance" autocomplete="off" readonly="readonly">
                                </div>

                            </div>
                            <div class="row">
                                <div class="form-group col-sm-3">
                                    <label for="quantity" class="form-group" v-text="nameField12"> </label>
                                    <input type="checkbox" v-model="blocked" />
                                    <!-- <input type="number" step="0.0001" v-model="quantity" @keyup="getCuotas()" class="form-control" autocomplete="off" id="quantity" v-bind:placeholder="'0.5000'" required="required"><a href="#" data-toggle="tooltip" title="Ej: 1.0000 para pagar el monto total cada quincena , 0.5000 pagara la mitad del monto cada quincena"><i class="glyphicon glyphicon-exclamation-sign"></i></a> -->
                                </div>

                            </div>
                            <div class="row">
                                <div class="form-group col-sm-3">
                                    <label for="netSalary" class="form-group" v-text="nameField9"> </label><br>
                                    <input type="text"  v-model="netSalary" class="form-control" id="netSalary" autocomplete="off" readonly="readonly">
                                </div>
                                <div class="form-group col-sm-3">
                                    <label for="cuotas" class="form-group" v-text="nameField6"> </label><br>
                                    <input type="text"  v-model="cuotas" class="form-control" id="cuotas" autocomplete="off" readonly="readonly">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-12"></div>
                                <div class="form-group col-sm-12">
                                    <label for="cde" class="form-group" v-text="nameField8"> </label><br>
                                </div>
                                <div class="form-group col-sm-3">
                                    <input type="text"  v-model="cde" class="form-control" id="cde" autocomplete="off" readonly="readonly">
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
            let countryId = 0 //temp
            let companyId = 0 //temp
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
                // console.log(this.objEdit)
                const selectStaffAtrubute = document.querySelector("#selectStaff")
                const transactionTypeAtrubute = document.querySelector("#transactionTypeCode")
                selectStaffAtrubute.setAttribute("disabled", "disabled");
                transactionTypeAtrubute.setAttribute("disabled", "disabled");

                this.selectStaff = document.querySelector("#selectStaff").value = this.objEdit.staffCode
                this.transactionTypeCode = document.querySelector("#transactionTypeCode").value = this.objEdit.transactionTypeCode
                this.quantity = document.querySelector("#quantity").value = this.objEdit.quantity
                this.amount = document.querySelector("#amount").value = this.objEdit.amount
                this.balance = document.querySelector("#balance").value = this.objEdit.balance
                this.initialBalance = document.querySelector("#initialBalance").value = this.objEdit.initialBalance
                this.cde = document.querySelector("#cde").value = this.objEdit.cde
                this.blocked = this.objEdit.blocked
                // console.log(this.selectStaff)
                this.getCuotaUpdate(this.quantity, this.amount, this.balance)
            }
            
            // console.log('Component mounted.')
            // console.log(this.objEdit)
        },
        data(){
            return{
                selectStaff:'',
                transactionTypeCode:'',
                objtransactionTypeCode:[],
                quantity:0.5,
                amount:0,
                balance:0,
                objSelectStaffs:[],
                staffCodes:'',
                cuotas:'',
                initialBalance:'',
                netSalary:0,
                blocked:0,
                cde:0
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
                default: 'Bloquear Transaccion'
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
                        blocked: this.blocked, 
                        transactionTypeCode: this.transactionTypeCode,
                        quantity: parseFloat(this.quantity),
                        amount: parseFloat(this.amount),
                        balance: parseFloat(this.balance),
                        initialBalance: parseFloat(this.balance),
                        cde: parseFloat(this.cde),
                    }
                    // console.log(params)
                    // return
                    
    
                    axios.post('perm-trans',params)
                        .then((response) => {
                            // console.log(response)
                            if (response.statusText == "OK") {
                                alert("Success")
                                document.querySelector("#form-add-up").reset()
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
                        blocked: this.blocked, 
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
                
            },
            getCuotas(){
                const vCuota  = document.querySelector('#cuotas')
                let vQuantity = document.querySelector('#quantity').value
                let vAmount   = document.querySelector('#amount').value
                let vBalance  = document.querySelector('#balance').value
                let tCuotas = 0
                
                vQuantity = parseFloat(vQuantity)
                vAmount = parseFloat(vAmount)
                vBalance = parseFloat(vBalance)
                if (vBalance > 0) {
                    if (vQuantity > 0 && vAmount > 0) {
                        tCuotas = (vBalance)/(vQuantity*vAmount)
                        // console.log(tCuotas)
                        tCuotas = Math.ceil(tCuotas)
                        vCuota.value = tCuotas
                    }
                }  
            },
            getCuotaUpdate(c , m, b){
                // console.log(c,m,b)
               
                const vCuota  = document.querySelector('#cuotas')
                let tCuotas
                c = parseFloat(c)
                m = parseFloat(m)
                b = parseFloat(b)
                if (b > 0) {
                    if (c > 0 && m > 0) {
                        tCuotas = (b)/(c*m)
                        console.log(tCuotas)
                        tCuotas = Math.ceil(tCuotas)
                        this.cuotas = document.querySelector('#cuotas').value = tCuotas
                    }
                }  
            },
            month(m){
                // m = mes puede variar entre 0 y 1
                // 0 = mes Actual
                // 1 = meses restantes

                let dataTime = new Date()
                let dd = dataTime.getDate()
                let mm = dataTime.getMonth()+1
                let yyyy = dataTime.getFullYear()
                let month = null

                if (m === 0) {
                    if (dd >= 15) { // si dia es 15 o mas, se calcula fecha para proximo mes
                        mm = mm + 1
                    }
                    month = mm
                }else if(m === 1){
                    if (dd >= 15) {
                        mm = mm + 1
                    }
                    month = 12 - mm
                }
                return month
            },
            calcularProceso(){
                const TTCode = document.querySelector("#transactionTypeCode")
                let   isIncome = TTCode.options[TTCode.selectedIndex].getAttribute("isIncome")
                let   hasBalance = TTCode.options[TTCode.selectedIndex].getAttribute("hasBalance")
                const Staff = document.querySelector("#selectStaff")
                isIncome    = parseInt(isIncome)
                hasBalance  = parseInt(hasBalance)
                // console.log(isIncome)
                if (isIncome === 0 ) {//es una deduccion
                    if (hasBalance === 1) { //contiene saldo
                        if (Staff.value !== '') {// No este vacio el personal 
                            // paso 1
                            // obtener salario neto y saldo anterior
                            const URL1 = `net-salary/${Staff.value}`
                            // console.log(URL1)
                            
                            axios.get(URL1).then(res => {
                                // this.netSalary = res.data
                                
                                let neto = res.data.neto
                                let saldoAnt = res.data.balance
                                let mesRestante = this.month(1)
                                let cdeMM = (((neto*mesRestante)*0.4)-saldoAnt)/mesRestante
                                this.netSalary = res.data.neto
                                cdeMM.toFixed(2)
                                this.cde = cdeMM
                                console.log(neto)
                                console.log(saldoAnt)
                                console.log(cdeMM)
                                this.balance = document.querySelector('#balance').value = 0
                                this.amount = document.querySelector('#amount').value = 0
                                
                            })
                            // console.log(this.month(0))
                            // console.log(this.month(1))
                            // console.log(this.objNetSalary)

                        }else{
                            alert('Debe seleccionar un personal') 
                            this.transactionTypeCode = TTCode.value=''
                            document.querySelector("#form-add-up").reset()
                        }
                    }
                }
            },
            calculaMonto(){
                // monto == (prestamo/mesesRestantes)
                // monto <= CAPACIDAD DE ENDEUDAMIENTO MENSUAL
                // console.log(this.cde)
                let balance = document.querySelector('#balance').value
                let mesRestante = this.month(1)
                let monto = (balance/mesRestante)
                let tCuotas
                let cde = this.cde
                monto = monto.toFixed(2)
                monto = parseFloat(monto)
                cde = parseFloat(cde)
                console.log(monto)
                console.log(cde)
                if (monto > cde) {
                    alert('El Campo Monto no puede ser mayor que la CAPACIDAD DE ENDEUDAMIENTO MENSUAL')
                    this.balance = document.querySelector('#balance').value = 0
                    this.amount = document.querySelector('#amount').value = 0
                    this.initialBalance = document.querySelector('#initialBalance').value = 0
                    this.cuotas = document.querySelector('#cuotas').value = 0
                }else{
                    this.amount = document.querySelector('#amount').value = monto
                    this.initialBalance = document.querySelector('#initialBalance').value = this.balance
                    tCuotas = this.month(1)*2
                    this.cuotas = document.querySelector('#cuotas').value = tCuotas
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