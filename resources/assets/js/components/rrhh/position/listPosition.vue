<template>

    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h4>{{namePanel}}</h4></div>

            <div class="table-responsive text-center">
                <table class="table table-striped table-bordered text-center">
                    <thead>
                        <tr>
                            <th>Pais</th>
                            <th>Codigo del cargo</th>
                            <th>Nombre del cargo</th>
                            <th>Salario base y moneda <a href="#" data-toggle="tooltip" title="salario mensual en moneda base (puede ser dolar) y el codigo de la moneda"><i class="glyphicon glyphicon-exclamation-sign"></i></a></th>
                            <th>Salario mensual y moneda <a href="#" data-toggle="tooltip" title="salario mensual en moneda local y el 	codigo de la moneda local"><i class="glyphicon glyphicon-exclamation-sign"></i></a></th>
                            <th>Salario diario </th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
    
                        <tr v-for="(hrPosition, index) in objHrPosition" :key="hrPosition.hrpositionId">
                            
                            <td class="form-inline">  
                        
                                {{hrPosition.countryName}} 
                            </td>
                            <td>
                                {{hrPosition.positionCode}}
                            </td>
                            <td>
                                {{hrPosition.positionName}}
                            </td>
                            <td>
                                {{hrPosition.baseSalary}} &nbsp; 
                                {{hrPosition.currencyNameSymbol}}
                            </td>
                            <td>
                                {{hrPosition.localSalary}} &nbsp;
                                {{hrPosition.currencySymbolLocal}}
                            </td>
                            <td>
                                {{hrPosition.localDailySalary}} &nbsp;
                                {{hrPosition.currencySymbolLocal}}
                            </td>
                            <td> 
                                <button v-on:click="edithrPosition(index, hrPosition.hrpositionId)" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-edit"></i></button>  
                                <button v-on:click="deletehrPosition(index,hrPosition.hrpositionId)" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></button>  
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
            namePanel: {
                type: String,
                default: 'Cargos',
            },
            objHrPosition:{},
        },
        methods: {
            edithrPosition(index, id){
                // paso solamente el index para enviar al formulario el objeto del indice seleccionado,
                // de esta manera no tengo que buscar los datos en la DB nuevamente
              
                this.$emit("indexEdit",index)
            },
            deletehrPosition(index, id){
                // console.log('index' + index)
                // console.log(id)
                // return
                // const indexIs = this.objHrPosition[index]
            
                if (confirm("Delete?") ){
                    axios.delete(`hrposition/delete/${id}`).then(()=>{

                        this.$emit("delHrPosition",[index,id])
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