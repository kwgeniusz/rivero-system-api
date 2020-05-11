<template>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading"> <h4>{{namePanel}}</h4></div>

                    <div class="table-responsive text-center">
                        <table class="table table-striped table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>N</th>
                                    <th>Nombre Compañia</th>
                                    <th>Nombre Corto</th>
                                    <th>RIF/NIT/ID</th>
                                    <th>Pais</th>
                                    <th>Oficina</th>
                                    <th>Direccion</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- @foreach($contracts as $contract) -->
                                <tr v-for="(company, index) in objCompanys" :key="company.companyId">
                                    
                                    <td >{{index + 1}}</td>
                                    <td class="form-inline">  
                                        {{company.companyName}} 
                                    </td>
                                    <td>
                                        {{company.companyShortName}}
                                    </td>
                                    <td> 
                                        {{company.companyNumbrer}}
                                    </td>
                                    <td> 
                                       {{company.countryName}}                                         
                                    </td>
                                    <td> 
                                       {{company.officeName}} 
                                        
                                    </td>
                                    <td> 
                                       {{company.companyAddress}} 
                                        
                                    </td>
                                    <td> 
                                        <button v-on:click="editCompany(company.companyId)" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-edit"></i></button>  
                                        <button v-on:click="deleteCompany(index,company.companyId)" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></button>  
                                    </td>
                                </tr>
                            </tbody>
                        </table> 
                    </div><!-- table-responsive text-center -->
                    
                </div>
            </div>
        </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.') 
        },
        props: [
            'objCompanys',
            'namePanel'
            ],
        data(){
            return{
                
                num: 1,
            }
        },
        methods: {
            deleteCompany(index, id){
                console.log('index 1: ' + id)
                if (confirm("Delete?") ){
                    axios.delete(`/companys/${id}`).then(()=>{
                        this.$emit('deleted',index)
                    })
                }    
            },
            editCompany(id){
                // console.log('indes es: ',id)
                    // this.editMode = index
                this.$emit('edit',id)
            },
            updateDepartment(index, company){
                // console.log(company) companyId departmentId departmentName parentDepartmentId
                const params = {
                    companyId: company.companyId,
                    departmentName: company.departmentName,
                    parentDepartmentId: company.parentDepartmentId
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