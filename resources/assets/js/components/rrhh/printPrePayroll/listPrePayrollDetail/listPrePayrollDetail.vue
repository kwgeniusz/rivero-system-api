<template>

    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <!-- <div v-if="condition">
                </div> -->
                <div class="row">
                    <div class="form-group col-md-7">
                        <h4><b>PAÍS:</b> {{ this.objprePayrollDetail[1]}} </h4>
                    </div>
                    <!-- 
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
                    </div> -->
                </div> 
            </div>

            <div class="table-responsive text-center">
                 <button v-on:click="printDetailRow()" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-print"></i> </button>  
                <table class="table table-striped table-bordered text-center" >
                    <!-- <thead>
                        <tr>
                            <th>CODIGO</th>
                            <th>DETALLE</th> -->
                            <!-- <th>NOMBRE</th>
                            <th>MONTO</th>
                            <th>ACCIONES</th> -->
                        <!-- </tr>
                    </thead> -->
                    <tbody id="print" >
    
                        <tr  v-for="(detail, index) in objprePayrollDetail" :key="index" >
                            

                            <td v-if="index > 2">
                                <th>CODIGO</th>
                                    <p  class="text-left">
                                        {{detail[0].staffCode }} 
                                       
                                    </p>
                            
                                
                            </td>
                            <td v-if="index > 2" class="form-inline">
                                <table>
                                    <tr>
                                        <td width="180" class="alingTo">
                                            <th>NOMBRE</th>
                                            <p class="text-left">
                                                {{detail[0].staffName}} &nbsp;&nbsp;&nbsp;
                                            </p>
                                        </td>
                                        <td>
                                           <table >
                                               <thead>
                                                    <tr>
                                                        <th>CONCEPTO</th>
                                                        <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CANTIDAD</th>
                                                        <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ASIGNACION</th>
                                                        <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DEDUCCION</th>
                                                        <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NETO</th>
                                                        <!-- <th>NOMBRE</th>
                                                        <th>MONTO</th>
                                                        <th>ACCIONES</th> -->
                                                    </tr>
                                                </thead>
                                                <tbody >
                                                    <tr  v-for="(item, index) in detail" :key="index">
                                                        <td >
                                                            <p class="text-left" valign="top">
                                                                    {{ item.transactionTypeName }}
                                                            </p>
                                                        </td>
                                                        <td>
                                                            <p class="text-right">
                                                                    {{ item.quantity }}
                                                            </p>
                                                        </td>
                                                        <td>
                                                            <p v-if="item.isIncome === 1" class="text-right">
                                                                    {{ item.amount }}
                                                            </p>
                                                        </td>
                                                        <td>
                                                            <p v-if="item.isIncome === 0" class="text-right">
                                                                    {{ item.amount }}
                                                            </p>
                                                        </td>
                                                        <td>
                                                            <!-- <p v-if="item.isIncome === 0" class="text-right">
                                                                    {{ item.amount }}
                                                            </p> -->
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <p class="text-right">
                                                                <b>TOTALES</b>
                                                            </p>
                                                        </td>
                                                        <td>
                                                            <p class="text-right">
                                                                <b>{{detail[0].asignacion}}</b>
                                                            </p>
                                                        </td>
                                                        <td>
                                                           <p class="text-right">
                                                                <b>{{detail[0].deduccion}}</b>
                                                            </p>
                                                        </td>
                                                        <td>
                                                            <p class="text-right">
                                                                <b>{{detail[0].asignacion - detail[0].deduccion}}</b>
                                                            </p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                           </table>
                                        </td>
                                    </tr>
                                </table>
                                    
                                
                            </td>
                          
                            
                            <!-- <td>
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
                                <button v-on:click="editDetailRow(index, detail.hrpdId)" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-edit"></i> </button>  
                                <button v-on:click="deleteDetailrow(index, detail.hrpdId)" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></button>  
                            </td> -->
                        </tr>
                    </tbody>
                    <!-- <tbody  v-else >
                        <tr>
                            <td v-if="this.lengths === 0" colspan="5">
                                No hay datos registrados
                            </td>
                            <td v-else colspan="5">
                                <loading></loading>
                            </td>
                        </tr>
                    </tbody> -->
                </table> 
            </div><!-- table-responsive text-center -->
        </div>
    </div>
    
</template>

<script>
    export default {
        
        mounted() {
            console.log(this.objprePayrollDetail)
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
                num : 0,
            }
            // lengths se utiliza para identificar si el objeto viene vacio y asi mostrar msj, si no hay datos
        },
        props: {
            objprePayrollDetail: {},
            objprePayrollDescrition: {},
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
              
            },
            printDetailRow(){
                var pdf = new jsPDF('p', 'pt', 'letter')

	// source can be HTML-formatted string, or a reference
	// to an actual DOM element from which the text will be scraped.
	// , source = $('#fromHTMLtestdiv')[0]
	, source = document.querySelector("#print").innerHTML

	// we support special element handlers. Register them with jQuery-style 
	// ID selector for either ID or node name. ("#iAmID", "div", "span" etc.)
	// There is no support for any other type of selectors 
	// (class, of compound) at this time.
	, specialElementHandlers = {
		// element with id of "bypass" - jQuery style selector
		'#bypassme': function(element, renderer){
			// true = "handled elsewhere, bypass text extraction"
			return true
		}
	}

	var margins = {
      top: 80,
      bottom: 60,
      left: 40,
      width: 522
    };
    // all coords and widths are in jsPDF instance's declared units
    // 'inches' in this case
    pdf.fromHTML(
    	source // HTML string or DOM elem ref.
    	, margins.left // x coord
    	, margins.top // y coord
    	, {
    		'width': margins.width // max width of content on PDF
    		// , 'elementHandlers': specialElementHandlers
    	},
    	function (dispose) {
    	  // dispose: object with X, Y of the last line add to the PDF 
    	  //          this allow the insertion of new lines after html
          pdf.save('Test.pdf');
        },
    	margins
    )
            }
        }
    }
</script>
<style>
.alingTo{

    position: relative;
    float: left;
}
</style>
