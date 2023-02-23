<template>
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <!-- <div class="panel-heading"><h4>Departamentos</h4></div> -->

                    <div class="table-responsive text-center">
                        <table class="table table-striped table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>N.</th>
                                    <th>Empresa</th>
                                    <th>Departamento</th>
                                    <th>Departamento Padre</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(company, index) in companys" :key="company.departmentId">
                                
                                    <td >{{index + 1}}</td>
                                    <td class="form-inline"> 
                                        <p class="text-left"> 
                                            {{company.companyName}}
                                        </p>  
                                    </td>
                                    <td class="form-inline">    
                                        <p class="text-left">
                                            <button v-if="editMode === index" v-on:click="updateDepartment(index, company)" class="btn btn-sm btn-success"><i class="glyphicon glyphicon-ok"></i></button> &nbsp;
                                            <input v-if="editMode === index" type="text" class="form-control" v-model="company.departmentName" >
                                            <a v-else v-on:click="editDepartment(index)">{{company.departmentName}}</a> 
                                        </p>
                                    </td>
                                    <td> 
                                        <p class="text-left">
                                            {{  company.dpParentName}}
                                        </p>
                                    </td>
                                    <td> 
                                        <button v-on:click="editDataDepartment(index,company.departmentId)" class="btn btn-sm btn-primary" title="Editar"><i class="fa fa-edit"></i></button>  
                                        <button v-on:click="deleteDepartment(index,company.departmentId)" class="btn btn-sm btn-danger" title="Eliminar"><i class="fa fa-times-circle"></i></button>  
                                        
                                    </td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        
</template>

<script>
    export default {
        mounted() {

            console.log('Component mounted.') 
        },
        props: {
            companys: {},
            parents:{},
        },  
        data(){
            return{
                editMode: -1,
                num: 1,
                parent:'',
            }
        },
        methods: {
            deleteDepartment(index, id){
                // console.log('index 1: ' + index)
                if (confirm("Delete?") ){
                    axios.delete(`departments/${id}`).then(()=>{
                        this.$emit('delete',index)
                    })
                }    
            },
            editDataDepartment(index, id){
                // console.log('index: '+index + ' id: '+ id)
                this.$emit('editData', id)
            },
            editDepartment(index){
                // console.log(id)
                    this.editMode = index
                // this.$emit('delete',index)
            },
            updateDepartment(index, company){
                // console.log(company) companyId departmentId departmentName parentDepartmentId
                const params = {
                    
                    departmentName: company.departmentName,
                }
                let url = '/departments/' + company.departmentId
        
                axios.put(url, params)
                .then((response) => {
                    // console.log(response)
                        this.editMode = -1
                        // console.log(response)
                        const company = response.data
                        this.$emit('update', [index, company])
                })
                .catch(function (error) {
                    console.log(error);
                });
            }
        }
    }

</script>