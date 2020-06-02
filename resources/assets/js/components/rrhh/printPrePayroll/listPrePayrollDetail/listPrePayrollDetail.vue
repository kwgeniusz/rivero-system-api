<template>

    <div class="col-md-8 col-md-offset-2">
        <!-- <div class="panel panel-default"> -->
            <!-- <div class="panel-heading"> -->
                <!-- <div v-if="condition">
                </div> -->
                <div class="row">
                    <div class="form-group col-md-7">
                        <h4><b>PAÍS:</b> {{this.objprePayrollDetail[0].countryName}} </h4>
                    </div>
                    <div class="form-group col-md-5">
                        <h4><b>EMPRESA:</b> {{this.objprePayrollDetail[0].companyName}}</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-7">
                        <h4><b>PRE-NOMINA:</b> {{this.objprePayrollDetail[0].payrollName}}</h4>
                    </div>
                    <div class="form-group col-md-5">
                        <h4><b>AÑO:</b> {{this.objprePayrollDetail[0].year}}</h4>
                    </div>
                </div>
            <!-- </div> -->

            <div class="table-responsive text-center">
                <table class="table table-striped table-bordered text-center">
                    <thead>
                        <tr>
                            <th>N.</th>
                            <th>CODIGO</th>
                            <th>NOMBRE</th>
                            <th>MONTO</th>
                            <th>ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody  v-if="this.objprePayrollDetail.length > 0" >
    
                        <tr  v-for="(detail, index) in objprePayrollDetail" :key="detail.index">
                            <td >{{index + 1}}</td>
                            <td class="form-inline">
                                <p>
                                    {{detail.staffCode}}
                                </p>
                            </td>
                            <td>
                                <p class="text-left">
                                    {{detail.staffName}}
                                </p>
                            </td>
                            <td>
                                <p class="text-right">
                                    {{detail.total}}
                                </p>
                            </td>
                            <td> 
                                <button v-on:click="detailPayrollStaff(detail.countryId, detail.companyId, detail.year, detail.payrollNumber, detail.staffCode)" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-th-list"></i> </button> 
                                <!-- <button v-on:click="editDetailRow(index, detail.hrpdId)" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-edit"></i> </button>  
                                <button v-on:click="deleteDetailrow(index, detail.hrpdId)" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></button>   -->
                            </td>
                        </tr>
                    </tbody>
                    <tbody  v-else >
                        <tr>
                            <td v-if="this.lengths === 0" colspan="5">
                                No hay datos registrados
                            </td>
                            <td v-else colspan="5">
                                <loading></loading>
                            </td>
                        </tr>
                    </tbody>
                </table> 
            </div><!-- table-responsive text-center -->
        <!-- </div> -->
    </div>
    
</template>

<script>
    export default {
        
        mounted() {
            // setTimeout(() => {
            //     axios.get(`process-detail/${this.objProcessDetail.hrprocessId}`).then( response => {
            //     this.objprePayrollDetail = response.data.processDetail
            //     this.lengths = this.objprePayrollDetail.length
                
            // })
            // },1000)
            
            
            console.log('Component mounted.')
        },
        data(){
            return{
                
                lengths: '',
            }
            // lengths se utiliza para identificar si el objeto viene vacio y asi mostrar msj, si no hay datos
        },
        props: {
            objprePayrollDetail: {},
            namePanelList: {
                type: String,
                default: 'Name defauld',
            },
            objProcess:{},
            objProcessDetail:{},
        },
        methods: {
            detailPayrollStaff(countryId, companyId, year, payrollNumber, staffCode){
                const URL = `pre-payroll-all/detail/${countryId}/${companyId}/${year}/${payrollNumber}/${staffCode}`
                axios.get(URL).then((res)=>{
                    console.log(res.data.print)
                    const objListDetail = res.data.print
                    this.$emit("prePayrollListDetail",objListDetail)
                })
                // console.log('objeto')
                // console.log(this.objprePayrollDetail[index])
                // paso solamente el index para enviar al formulario el objeto del indice seleccionado,
                // de esta manera no tengo que buscar los datos en la DB nuevamente
              
            }
        }
    }
</script>
