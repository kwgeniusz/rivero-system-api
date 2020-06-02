<template>

    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <!-- <div class="panel-heading"><h4>{{namePanelList}}</h4></div> -->

            <div class="table-responsive text-center">
                <table class="table table-striped table-bordered text-center">
                    <thead>
                        <tr>
                            <th>N.</th>
                            <th>PAÍS</th>
                            <th>EMPRESA</th>
                            <th>AÑO</th>
                            <th>PRE-NOMINA</th>
                            <th>MONTO</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody v-if="objPrintPrePayroll.length > 0">
    
                        <tr v-for="(PrePayroll, index) in objPrintPrePayroll" :key="PrePayroll.hrprocessId">
                            <td >{{index + 1}}</td>
                            <td class="text-left">
                                
                                    {{PrePayroll.countryName}}
                                
                            </td>
                            <td > 
                                <p class="text-left">
                                    {{PrePayroll.companyName}}
                                </p> 
                            </td>
                            <td>
                                <p>
                                    {{PrePayroll.year}}
                                </p>
                            </td>
                            <td>
                                <p class="text-left">
                                    {{PrePayroll.payrollName}}
                                </p>
                            </td>
                            <td>
                                <p class="text-right">
                                    {{PrePayroll.total}}
                                </p>
                            </td>
                            <td> 
                                <button v-on:click="detailRow(PrePayroll.countryId, PrePayroll.companyId, PrePayroll.year, PrePayroll.payrollNumber)" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-th-list"></i> </button>  
                                <!-- <button v-on:click="editRow(index, PrePayroll.hrprocessId)" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-edit"></i> </button>  
                                <button v-on:click="deleterow(index, PrePayroll.hrprocessId)" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></button>   -->
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr>
                            <td colspan="7">
                                <loading></loading>
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
            objPrintPrePayroll:{},
        },
        methods: {
            detailRow(countryId, companyId, year, payrollNumber){

                const URL  = `pre-payroll-all/list/${countryId}/${companyId}/${year}/${payrollNumber}`
                // console.log(countryId, companyId, year, payrollNumber)
                axios.get(URL).then((res)=>{
                    console.log(res.data.print)
                    const objPrePayrollDetail = res.data.print
                    this.$emit("prePayrollDetail", objPrePayrollDetail)
                })
                // return
                // console.log(id)
              
            },
            editRow(index, id){
                
                // paso solamente el index para enviar al formulario el objeto del indice seleccionado,
                // de esta manera no tengo que buscar los datos en la DB nuevamente
              
                this.$emit("indexEdit",index)
            },
            deleterow(index, id){
                // console.log('index ' + index)
                // console.log('id ' + id)
                // return
                // const indexIs = this.objPrintPrePayroll[index]
            
                if (confirm("Delete?") ){
                    axios.delete(`process/delete/${id}`).then((res)=>{
                        // console.log(res)
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