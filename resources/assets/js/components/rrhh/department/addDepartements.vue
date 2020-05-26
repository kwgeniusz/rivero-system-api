<template>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div v-if="editId === 0" class="panel-heading" :style="addSuccess"><h4 class="text-uppercase">Agregar Departamento</h4></div>
                <div v-else class="panel-heading" :style="ediPrimary"><h4 class="text-uppercase">Actualizar Departamento</h4></div>

                <div class="panel-body " :class="[bgcolor]">
                    <!-- <div v-if="edit === 0">

                    </div> -->
                    <form  class="form" role="form" v-on:submit.prevent="newCompany()"  id="formDepartment" >
                    <!-- <form  class="form" role="form" v-on:submit.prevent="newCompany()" id="formDepartment" > -->
                            <div class="form-group col-md-7">
                                <label for="selectCompani" class="form-group" v-text="nameField1"></label>
                                <select class="form-control" v-model="selectCompany" id="selectCompani">
                                    <option v-for="item in selectCompanys" :key="item.id" :value="item.id">{{item.vText}}</option>
                                    
                                </select>
                            </div>
                            <div class="form-group col-md-9">
                                <label for="department_name" class="form-group" v-text="nameField2"></label>
                                <input type="text" v-model="nameCompany" class="form-control" id="department_name" name = "company" v-bind:placeholder="nameField2">
                            </div>
                            <div class="form-group col-md-7">
                                <label for="selectDepartmen" class="form-group" v-text="nameField3"></label>
                                <select class="form-control" v-model="selectDepartmen" id="selectDepartmen">
                                    <option value="0">No</option>
                                    <option v-for="item in parents" :key="item.departmentId" :value="item.departmentId" > {{item.departmentName}} </option>
                                    
                                </select>
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
</template>

<script>
    export default {
        mounted() {
            axios.get('departments/company').then(response => {
                this.selectCompanys = response.data.map(item => {
                    return { id: item.companyId, vText: item.companyName}
                })

                // console.log(this.selectCompanys)
            })

            axios.get(`departments/parent`).then((response) => {
                this.parents = response.data
                
            // console.log(response.data)
            })

            if (this.editId > 0) {
                // departments
                axios.get(`departments/edit/${this.editId}`).then((response) => {
                    this.parentsData = response.data
                    console.log(this.parentsData)
                    this.selectCompany = document.querySelector("#selectCompani").value = this.parentsData[0].companyId
                    this.nameCompany = document.querySelector("#department_name").value = this.parentsData[0].departmentName
                    this.selectDepartmen =document.querySelector("#selectDepartmen").value = this.parentsData[0].parentDepartmentId
                    this.deparmetIds = this.parentsData[0].departmentId
                    // console.log('deparmetIds ' +this.deparmetIds)
                })
                
            }
            console.log('Component mounted.')
            // console.log(editId)
            // console.log(this.editId)
           
        },
        data(){
            return{
                
                parents: [],
                parentsData: [],
                selectCompanys: [],
                selectCompany: 0,
                nameCompany: '',
                selectDepartmen: 0,
                bgcolor: '',
                selectCompany: '',
                deparmetIds: '',
                nameCompany: '',
                selectDepartmen: '',

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
            editId:'',
            nameField1: '',
            nameField2: '',
            nameField3: '',
        },
        methods: {
            
            newCompany(){
                if (this.editId === 0) {
                    const params = {
                        companyId: this.selectCompany,
                        departmentName: this.nameCompany,
                        parentDepartmentId: this.selectDepartmen
                    }

                    document.querySelector("#formDepartment").reset()

                    axios.post('departments', params)
                    .then((response) => {
                        // console.log(response)
                        // const department = response.data
                        alert("Success")
                        
                        // este emit era utilizado para insertar datos en el array de la vista
                        // this.$emit('new', department)
                    
                        })
                    .catch(function (error) {
                        alert("Faile")
                        console.log(error);
                    });
                }else {
                    const params = {
                        companyId:   this.selectCompany,
                        departmentName:   this.nameCompany,
                        parentDepartmentId: this.selectDepartmen,
                        
                    }
                    // console.log(params)
                    // document.querySelector("#formDepartment").reset()
                    let url = 'departments/update/' + this.deparmetIds
                    // console.log( params)
                    // console.log('la url es: '+ url)
                    axios.put(url, params)
                    .then((response) => {
                        alert('Success')
                        })
                    .catch(function (error) {
                        console.log(error);
                    });
                }
                
                
                
            },
            cancf(n){
                console.log('vista a mostrar: ' + n)
                this.$emit('showlist', 0)
            },

        }
    }

</script>