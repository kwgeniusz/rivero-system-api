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
                </div>
                <div class="row">   
                    <div class="form-group col-md-7">
                        <h4><b>EMPRESA:</b> {{this.objprePayrollDetail[2]}}</h4>
                    </div>
                 </div>
                 
                <div class="row">
                    <div class="form-group col-md-6 col-md-offset-3">
                        <h4><b>PRE-NOMINA:</b> {{this.objprePayrollDetail[0]}}</h4>
                    </div>
                    <div class="form-group col-md-1 col-md-offset-2">
                        <button v-on:click="printDetailRow(objprePayrollDetail[7][0].countryId, objprePayrollDetail[7][0].companyId, objprePayrollDetail[7][0].year, objprePayrollDetail[7][0].payrollNumber)" class="btn btn-sm btn-info"><i class="fa fa-print"></i> </button>  
                    </div>
                </div> 
            </div>

            <div class="table-responsive text-center">
                
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
                            

                            <td v-if="index > 5">
                                <th>CODIGO</th>
                                    <p  class="text-left">
                                        {{detail[0].staffCode }} 
                                       
                                    </p>
                            
                                
                            </td>
                            <td v-if="index > 6" class="form-inline">
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
                                                        <th>CONCEPTOS</th>
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
                                                            <p v-if="item.isIncome == 1" class="text-right">
                                                                    {{ item.amount }} 
                                                            </p>
                                                        </td>
                                                        <td>
                                                            <p v-if="item.isIncome == 0" class="text-right">
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
                                                                <b>{{ formatNumber(detail[0].asignacion - detail[0].deduccion)}}</b>
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
            // console.log(this.objprePayrollDetail)
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
            formatDate(){
                function formatZero(n){
                    if (n < 10 ) {
                        n = '0' + n
                        return n
                    }else{
                        return n
                    }
                }

                let dataTime = new Date()
                let dd = dataTime.getDate()
                let mm = dataTime.getMonth()+1
                let yyyy = dataTime.getFullYear()
                dd = formatZero(dd)
                mm = formatZero(mm)
                return dd+'/'+mm+'/'+yyyy;
             },
            formatNumber(number){
                let num = parseFloat(number).toFixed(2);
                return num
            },
            printDetailRow(countryId, companyId, year, payrollNumber){
                console.log(countryId, companyId, year, payrollNumber)
                const URL  = `pre-payroll-all/list/${countryId}/${companyId}/${year}/${payrollNumber}`
                console.log(countryId, companyId, year, payrollNumber)
                // return
                axios.get(URL).then((res)=>{
                    const objPrePayrollDetail = res.data.print
                    // console.log(objPrePayrollDetail)
                    // return
                    let period = objPrePayrollDetail[0]
                    let country = objPrePayrollDetail[1]
                    let company = objPrePayrollDetail[2]
                    let logo = objPrePayrollDetail[3]
                    let payrollTypeName = objPrePayrollDetail[4]
                    let totalAsignacion = objPrePayrollDetail[5]
                    let totalDeduccion = objPrePayrollDetail[6]
                    let dataTime = this.formatDate()
                    // console.log(window.location)
                    // console.log('totalGeneral')
                    // console.log(totalGeneral)
                    // return
                    let imgLogoURL = window.location.origin + '/' + logo
                    
                    console.log(imgLogoURL)
                    // return
                    function toDataUrl(src, callback) {
                        let xhttp = new XMLHttpRequest()
                        xhttp.onload = function(){
                            let fileReader = new FileReader()
                            fileReader.onloadend = function() {
                                callback(fileReader.result)
                            }
                            fileReader.readAsDataURL(xhttp.response)

                        }
                        xhttp.responseType = 'blob'
                        xhttp.open('GET',src,true)
                        xhttp.send()
                        // console.log(xhttp)
                    }
                    toDataUrl(imgLogoURL,function(dataURL){
                          crearPDF(dataURL)
                            // this.imgBase64 = dataURL
                            // console.log(imgLogoURL)
                    //  console.log(dataURL)
                    })
                    
                    function crearPDF(imgData){
                        
                        let doc = new jsPDF('p', 'pt', 'letter');
                        // doc.text( 'izquierda?.', eje X, eje Y );
                        //  console.log(URLactual + '/' + logo)
                        //  console.log(logo)
                        //  return

                        //  Encabezado
                        doc.addImage(imgData, 'JPEG', 30, 30, 50, 30)
                        doc.setFontType("bold");
                        doc.setFontSize(12);
                        doc.text( 'PRE-NOMINA DE PAGO', 220, 40 );
                        doc.setFontType("courier");
                        doc.setFontSize(7);
                        doc.text( 'Pagina 1', 574, 40 );
                        doc.setFontSize(12);
                        doc.text( 'FECHA: ', 450, 74 );
                        doc.text( dataTime, 500, 74 );
                        doc.text( 'PAIS:', 30, 74 );
                        doc.text( country, 63, 74 );
                        doc.text( 'EMPRESA:', 30, 89 );
                        doc.text( company, 93, 89 );
                        doc.text( 'TIPO DE NOMINA:', 30, 104 );
                        doc.text( payrollTypeName, 134, 104 );
                        doc.text( 'PERIODO:', 238, 104 );
                        doc.text( period, 298, 104);

                        // // titulos tablas
                        doc.line(30, 115, 580, 115);
                        doc.setFontSize(10);
                        doc.text( 'CODIGO', 30, 130 );
                        doc.text( 'NOMBRE', 74, 130 );
                        doc.text( 'CONCEPTO', 195, 130 );
                        doc.text( 'CANTIDAD', 310, 130 );
                        doc.text( 'ASIGNACION', 375, 130 );
                        doc.text( 'DEDUCCION', 445, 130 );
                        doc.text( 'NETO', 550, 130 );
                        doc.line(30, 138, 580, 138);


                        doc.setFontSize(9);
                        let n = 155
                        let cont = 155
                        let page = 1
                        function formatNumber(number){
                                    let num = parseFloat(number).toFixed(2);
                                    return num
                                }
                        for (let i = 0; i < objPrePayrollDetail.length; i++) {
                            const element = objPrePayrollDetail;
                            //  console.log( element[i]) 
                            //  console.log('i: ' + i) 

                            // condiciono que comienze a leer los datos a partir de la posicion 7 del array
                            if (i > 6) {
                                
                                let name = true
                                element[i].forEach(element2 => {
                                    // console.log(element2.staffCode) 
                                    if (name) {
                                        doc.text(element2.staffCode, 30, n );
                                        doc.text( element2.staffName, 74, n );
                                        name = false
                                    }
                                    doc.text(element2.transactionTypeName, 195, n);
                                    doc.text(element2.quantity, 361, n, 'right' );
                                    if (element2.isIncome == 1) {
                                        if (element2.amount == null) {
                                            //  console.log('entro')
                                            // doc.text('0', 436, n, 'right' );
                                        }else {
                                            doc.text(element2.amount, 436, n, 'right' );
                                        }
                                    }
                                    if (element2.isIncome == 0) {
                                        if (element2.amount == null) {
                                            // console.log('entro')
                                            // doc.text('0', 502, n, 'right' );
                                        }else {
                                            doc.text(element2.amount, 502, n, 'right' );
                                        }
                                        
                                    // doc.text( '2.07', 502, 155, 'right' );
                                    }
                                    // doc.text(element2.staffCode);
                                    n += 15
                                    if (n > 754) {
                                        page += 1
                                        doc.addPage();

                                        //  Encabezado
                                        doc.setFontSize(7);
                                        doc.text( `Pagina ${page}`, 574, 40 );
                                        doc.addImage(imgData, 'JPEG', 30, 30, 50, 30)
                                        doc.setFontType("bold");
                                        doc.setFontSize(12);
                                        doc.text( 'PRE-NOMINA DE PAGO', 220, 40 );
                                        doc.setFontType("courier");
                                        
                                        doc.setFontSize(12);
                                        doc.text( 'FECHA: ', 450, 74 );
                                        doc.text( dataTime, 500, 74 );
                                        doc.text( 'PAIS:', 30, 74 );
                                        doc.text( country, 63, 74 );
                                        doc.text( 'EMPRESA:', 30, 89 );
                                        doc.text( company, 93, 89 );
                                        doc.text( 'TIPO DE NOMINA:', 30, 104 );
                                        doc.text( payrollTypeName, 134, 104 );
                                        doc.text( 'PERIODO:', 238, 104 );
                                        doc.text( period, 298, 104);

                                        // // titulos tablas
                                        doc.line(30, 115, 580, 115);
                                        doc.setFontSize(10);
                                        doc.text( 'CODIGO', 30, 130 );
                                        doc.text( 'NOMBRE', 74, 130 );
                                        doc.text( 'CONCEPTO', 195, 130 );
                                        doc.text( 'CANTIDAD', 310, 130 );
                                        doc.text( 'ASIGNACION', 375, 130 );
                                        doc.text( 'DEDUCCION', 445, 130 );
                                        doc.text( 'NETO', 550, 130 );
                                        doc.line(30, 138, 580, 138);
                                        n = 155
                                    }
                                });
                                doc.setFontSize(9);
                                doc.setFontType("bold")
                                doc.text( 'TOTALES', 215, n);
                                // doc.text( `${n}`, 361, n);
                                // console.log('entro')
                                // console.log(element[i][0].asignacion)
                                let asignacion = element[i][0].asignacion
                                let deduccion = element[i][0].deduccion
                                if (asignacion === null) {
                                    asignacion = 0
                                    // doc.text(`${asignacion}`, 436, n, 'right' );
                                }else {
                                    doc.text(`${asignacion}`, 436, n, 'right' );
                                }
                                if (deduccion === null) {
                                    deduccion = 0
                                    // doc.text(`${deduccion}`, 502, n, 'right' );
                                }else{
                                    doc.text(`${deduccion}`, 502, n, 'right' );
                                }
                                

                                let total = formatNumber(asignacion - deduccion) // calculo para el total
                                // console.log('total: ' + total);
                                doc.text(`${total}`, 574, n, 'right' );
                                // doc.text(total, 574, n, 'right' );
                                
                                doc.setFontType("courier");
                                n += 20
                            }
                            
                        
                        }
                        doc.setFontType("bold");
                        doc.setFontSize(10);
                        doc.line(30, n, 580, n);
                        doc.line(30, n+3, 580, n+3);
                        totalAsignacion
                        totalDeduccion
                        let totalNeto = formatNumber(totalAsignacion - totalDeduccion)
                        n = n + 20
                        doc.text( `TOTAL GENERAL:`, 215, n );
                        doc.text(`$ ${totalAsignacion}`, 436, n, 'right' );
                        doc.text(`$ ${totalDeduccion}`, 502, n, 'right' );
                        doc.text(`$ ${totalNeto}`, 574, n, 'right' );
                        // doc.text( `TOTAL GENERAL:  $${totalGeneral}`, 215, n );
                        
                        doc.save(company + '-' + period + '.pdf');
                    // console.log(res.data.print)
                    // return
                    // this.$emit("prePayrollDetail", objPrePayrollDetail)
                    }
                })
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
