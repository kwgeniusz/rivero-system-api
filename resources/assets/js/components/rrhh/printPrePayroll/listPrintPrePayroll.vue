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
                            <th>ACCIONES</th>
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
                                <button v-on:click="detailRow(PrePayroll.countryId, PrePayroll.companyId, PrePayroll.year, PrePayroll.payrollNumber)" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Personal"><i class="fa fa-list"></i> </button>  
                                <button v-on:click="printDetailRow(PrePayroll.countryId, PrePayroll.companyId, PrePayroll.year, PrePayroll.payrollNumber)" class="btn btn-sm btn-info"><i class="fa fa-print"></i> </button>  
                                <!-- <button v-on:click="editRow(index, PrePayroll.hrprocessId)" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-edit"></i> </button>  
                                <button v-on:click="deleterow(index, PrePayroll.hrprocessId)" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></button>   -->
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr>
                            <td v-if="this.lengths === 0" colspan="7">
                                No hay datos registrados
                            </td>
                            <td v-else colspan="7">
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
                imgBase64:[]
            }
        },
        props: {
            namePanelList: {
                type: String,
                default: 'Name defauld',
            },
            lengths: '',
            objPrintPrePayroll:{},
        },
        methods: {
            detailRow(countryId, companyId, year, payrollNumber){

                const URL  = `pre-payroll-all/list/${countryId}/${companyId}/${year}/${payrollNumber}`
                // console.log(countryId, companyId, year, payrollNumber)
                axios.get(URL).then((res)=>{
                    console.log(res.data.print)
                    // return
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
            printDetailRow(countryId, companyId, year, payrollNumber){
                console.log(countryId, companyId, year, payrollNumber)
                // return
                const URL  = `pre-payroll-all/list/${countryId}/${companyId}/${year}/${payrollNumber}`
                
                axios.get(URL).then((res)=>{
                    const objPrePayrollDetail = res.data.print
                    // console.log(objPrePayrollDetail)
                    // return
                    // let dataTime = new Date().toLocaleString("en-US", {timeZone: "America/Caracas"});
                    // dataTime = new Date(dataTime);
                    // dataTime = dataTime.toString().
                    // console.log(this.formatDate())
                    // console.log('time: '+dataTime.toLocaleString())

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