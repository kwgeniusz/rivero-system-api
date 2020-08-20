<template>

    <div class="col-md-12">
        <div class="panel panel-default">
            <!-- <div class="panel-heading"><h4>{{namePanelList}}</h4></div> -->

            <div class="table-responsive text-center">
                <table class="table table-striped table-bordered text-center">
                    <thead>
                        <tr>
                            <th>N.</th>
                            <th>PAIS</th>
                            <th>EMPRESA</th>
                            <th>AÑO</th>
                            <th>PEROÍDO</th>
                            <th>MONEDA BASE</th>
                            <th>LOCAL</th>
                            <th>TIPO DE CAMBIO</th>
                            <th>ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody v-if="objPayrollHistory.length > 0">
    
                        <tr v-for="(payrollhistory, index) in objPayrollHistory" :key="payrollhistory.hrpayrollhistoryId">
                            <td >{{index + 1}}</td>
                            <td class="form-inline">
                                <p class="text-left">
                                    {{payrollhistory.countryName}}
                                </p>
                            </td>
                            <td > 
                                <p class="text-left">
                                    {{payrollhistory.companyName}} 
                                </p>
                            </td>
                            <td>
                                {{payrollhistory.year}}
                            </td>
                            <td>
                                <p class="text-left">
                                    {{payrollhistory.payrollName}} 
                                </p>
                            </td>
                            <td>
                                <p>
                                    ${{payrollhistory.total}}
                                </p>
                            </td>
                            <td>
                                <p>
                                    {{payrollhistory.totalLocal}}Bs
                                </p>
                            </td>
                            <td>
                                <p>
                                    {{payrollhistory.exchangeRate}}Bs
                                </p>
                            </td>
                            <td>
                                <loading v-if="loading == 1"></loading>
                                <button v-if="loading == 0" v-on:click="process(payrollhistory.countryId, payrollhistory.companyId,payrollhistory.year,payrollhistory.payrollNumber, payrollhistory.payrollTypeId)" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Actualizar</button>  
                                <button v-else disabled="disabled" v-on:click="process(payrollhistory.countryId, payrollhistory.companyId,payrollhistory.year,payrollhistory.payrollNumber, payrollhistory.payrollTypeId)" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Actualizar</button>  
                                <!-- <button v-on:click="deleterow(payrollhistory.countryId, payrollhistory.companyId,payrollhistory.year,payrollhistory.payrollNumber)" class="btn btn-sm btn-danger"><i class="fa fa-times-circle"></i> Eliminar</button>   -->
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr>
                            <td v-if="this.lengths === 0" colspan="9">
                                No hay datos registrados
                            </td>
                            <td v-else colspan="9">
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
                loading: 0,
            }
        },
        props: {
            namePanelList: {
                type: String,
                default: 'Name defauld',
            },
            objPayrollHistory:{},
            lengths:'',
        },
        methods: {
            process(countryId,companyId,year,payrollNumber, payrollTypeId){
                // console.log( countryId,companyId,year,payrollNumber,payrollTypeId)
                // return
                    this.loading = 1
                const URL = `payrollhistoryl/process/${countryId}/${companyId}/${year}/${payrollNumber}/${payrollTypeId}`
                
                axios.get(URL).then((res) => {
                        console.log(res)
                        if (res.statusText === 'OK') {
                            alert('Excito..')
                            this.$emit("showlist",0)
                            this.loading = 0
                        }else{
                            alert('Error al calcular')
                            this.loading = 0
                        }

                })
              
                // this.$emit("indexEdit",index)
            },
            deleterow(index, id){
                // console.log('index ' + index)
                // console.log('id ' + id)
                // return
                const indexIs = this.objPayrollHistory[index]
            
                if (confirm("Delete?") ){
                    
                    axios.delete(`payrollhistoryl/${id}`).then((res)=>{
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
<style>
    /* loading{
        width: 10px;
        height: 10px;
    } */
</style>