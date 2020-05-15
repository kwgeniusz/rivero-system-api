<template>

    <div class="col-md-12">
        <div class="panel panel-default">
            <!-- <div class="panel-heading"><h4>{{namePanelList}}</h4></div> -->

            <div class="table-responsive text-center">
                <table class="table table-striped table-bordered text-center">
                    <thead>
                        <tr>
                            <th>N.</th>
                            <th>Cod.</th>
                            <th>Nombre </th>
                            <th>Apellido</th>
                            <th>Docuento de Identidad</th>
                            <th>Cargo</th>
                            <th>Departamento</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
    
                        <tr v-for="(staff, index) in objStaff" :key="staff.periodId">
                            <td >{{index + 1}}</td>
                            <td class="form-inline">
                                {{staff.staffCode}}
                            </td>
                            <td > 
                                <p class="text-left">
                                    {{staff.firstName}}
                                </p> 
                            </td>
                            <td>
                                <p class="text-left">
                                    {{staff.lastName}}
                                </p> 
                            </td>
                            <td>
                                <!-- <p class="text-right">     -->
                                    {{staff.idDocument}}
                                <!-- </p>  -->
                            </td>
                            <td>
                                <p class="text-left">
                                    {{staff.positionName}} 
                                </p> 
                            </td>
                            <td>
                                <p class="text-left">
                                    {{staff.departmentName}}
                                </p> 
                            </td>
                            
                            <td> 
                                <button v-on:click="editRow(index, staff.periodId)" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-edit"></i> </button>  
                                <button v-on:click="deleterow(index, staff.periodId)" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></button>  
                            </td>
                        </tr>
                    </tbody>
                </table> 
            </div><!-- table-responsive text-center -->
        </div>
    </div>
        
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        data(){
            return{

            }
        },
        props: {
            namePanelList: {
                type: String,
                default: 'Name defauld',
            },
            objStaff:{},
        },
        methods: {
            editRow(index, id){
                
                // paso solamente el index para enviar al formulario el objeto del indice seleccionado,
                // de esta manera no tengo que buscar los datos en la DB nuevamente
              
                this.$emit("indexEdit",index)
            },
            deleterow(index, id){
                // console.log('index ' + index)
                // console.log('id ' + id)
                // return
                const indexIs = this.objStaff[index]
            
                if (confirm("Delete?") ){
                    axios.delete(`periods/delete/${id}`).then(()=>{

                        this.$emit("delrow",[index,id])
                    })
                    .catch(function (error) {
                        alert("Error")
                        console.log(error);
                    });
                }
                
                // console.log('enviado')
            }
        }
    }
</script>