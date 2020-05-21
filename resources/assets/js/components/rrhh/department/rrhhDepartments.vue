<template>
    <div class="container">
        <!-- agregar -->
        <div v-if="formStatus === 1">
            <add-Departements
                @new = "addPepartment"
                :nameField1=nameField1
                :nameField2=nameField2
                :nameField3=nameField3
                @showlist = "showlist"
                :editId=0
            > </add-Departements> 
        </div>

        <!-- Vista actualizar -->
        <div v-if="formStatus === 2">
            <add-Departements
                @new = "addPepartment"
                :nameField1=nameField1
                :nameField2=nameField2
                :nameField3=nameField3
                :editId=editId
                @showlist = "showlist"
                
            > </add-Departements> 
        </div>


        <!-- botones y listado -->
        <div v-if="formStatus === 0">
            <h3><b>DEPARTAMENTOS</b></h3>
            <button-form
                @addf = "addFormStatus"
                :buttonType = 0
            ></button-form>
            <rrhh-table-departments  
                :companys = objCompanys
                :parents = parents
                @update = "upDepartment( ...arguments)"
                @editData = "editData"
                @delete = "delDepartment"
            > </rrhh-table-departments>
        </div>    
    </div>         
</template>

<script>
    export default {
        mounted() {

            axios.get('/departments').then((response) => {
                this.objCompanys = response.data
            // console.log(this.objCompanys)
            })
        
        },
        data() {
            return{
                objCompanys: [],
                parents: [],
                formStatus: 0,
                editId: '',
                nameField1: 'EMPRESA',
                nameField2: 'DEPARTAMENTO',
                nameField3: 'DEPARTAMENTO PADRE',
            }
        },
        methods: {
            addFormStatus(){
                this.formStatus = 1
            },
            addPepartment(department){
                // console.log(department)
                // this.objCompanys.push(department)
            },
            delDepartment(index){
                // console.log(index)
                this.objCompanys.splice(index, 1)
            },
            upDepartment( company){
                // console.log(company)
                // this.objCompanys[company[0]] = company[1]
            },
            carga(){
                XMLHttpRequest.onprogress = function (event) {
                event.loaded;
                event.total;
                };
            },
            editData(id){
                console.log('el id es: ' + id)
                this.editId = id
                this.formStatus = 2
            },
            showlist(n){
                
                this.formStatus = 0
                axios.get('/departments').then((response) => {
                    this.objCompanys = response.data
                    // console.log(this.objCompanys)
                })
            
            
            },
        }
    }

</script>