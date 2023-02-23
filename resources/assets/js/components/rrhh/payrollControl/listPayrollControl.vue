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
                            <th>TIPO DE NOMINA</th>
                            <th>AÑO</th>
                            <th>PEROÍDO</th>
                            <th>TAX</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody v-if="objPayrollCOntrol.length > 0">
                        <tr v-for="(payrollcontro, index) in objPayrollCOntrol" :key="payrollcontro.hrpayrollControlId">
                            <td >{{index + 1}}</td>
                            <td class="form-inline">
                                <p class="text-left">
                                    {{payrollcontro.countryName}}
                                </p>
                            </td>
                            <td > 
                                <p class="text-left">
                                    {{payrollcontro.companyName}} 
                                </p>
                            </td>
                            <td>
                                <p class="text-left">
                                    {{payrollcontro.payrollTypeName}}
                                </p>
                            </td>
                            <td>
                                {{payrollcontro.year}}
                            </td>
                            <td>
                                <p class="text-left">
                                    {{payrollcontro.payrollName}} 
                                </p>
                            </td>
                            <td>
                                <p class="text-left">
                                    <input type="number" class="form-control" v-model="exchangeRate" >
                                    <!-- {{payrollcontro.periodId}} -->
                                </p>
                            </td>
                            <td>
                                <!-- <loading v-if="loading == 1"></loading> -->
                                <button v-if="loading == 0" v-on:click="process(index,payrollcontro.hrpayrollControlId, payrollcontro.periodId)" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Procesar</button>  
                                <button v-else disabled="disabled" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Procesar</button>  
                                <button v-on:click="deleterow(index, payrollcontro.hrpayrollControlId)" class="btn btn-sm btn-danger"><i class="fa fa-times-circle"></i> Eliminar</button>  
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
            // console.log('Component mounted.')
        },
        data(){
            return{
                loading: 0,
                exchangeRate: 300000.53
            }
        },
        props: {
            namePanelList: {
                type: String,
                default: 'Name defauld',
            },
            objPayrollCOntrol:{},
            lengths:'',
        },
        methods: {
            process(index, id, periodId){
                // console.log( this.loading)
                    this.loading = 1
                console.log(id)
                const URL = `payrollcontrol/list/${id}/${periodId}/${this.exchangeRate}`
                axios.get(URL).then((res) => {
                        console.log(res)
                        if (res.statusText === 'OK') {
                            alert('Exito..')
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
                const indexIs = this.objPayrollCOntrol[index]
            
                if (confirm("Delete?") ){
                    
                    axios.delete(`payrollcontrol/${id}`).then((res)=>{
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