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
                                <button v-on:click="detailRow(PrePayroll.countryId, PrePayroll.companyId, PrePayroll.year, PrePayroll.payrollNumber)" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-th-list"></i> </button>  
                                <button v-on:click="printDetailRow(PrePayroll.countryId, PrePayroll.companyId, PrePayroll.year, PrePayroll.payrollNumber)" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-print"></i> </button>  
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
                    // console.log(res.data.print)
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
            printDetailRow(countryId, companyId, year, payrollNumber){
                const URL  = `pre-payroll-all/list/${countryId}/${companyId}/${year}/${payrollNumber}`
                // console.log(countryId, companyId, year, payrollNumber)
                
                axios.get(URL).then((res)=>{
                    const objPrePayrollDetail = res.data.print
                    console.log(objPrePayrollDetail)
                    // return
                    let country = objPrePayrollDetail[1]
                    let company = objPrePayrollDetail[2]
                    let period = objPrePayrollDetail[0]
                    // return
    //                     0: "PRIMERA QUINCENA ENERO 2020"
                        // ​
                        // 1: "VENEZUELA"
                        // ​
                        // 2: "JD RIVERO C.A."
                    let doc = new jsPDF('p', 'pt', 'letter');
                     // doc.text( 'izquierda?.', eje X, eje Y );
                     
                    //  Cabeceras
                    doc.setFontType("bold");
                    doc.setFontSize(12);
                    doc.text( 'PRE-NOMINA DE PAGO', 220, 40 );
                    doc.setFontType("courier");
                    doc.setFontSize(7);
                    doc.text( 'Pagina 1', 574, 40 );
                    doc.setFontSize(12);
                    // doc.text( 'This text is\raligned to the\rright.', 140, 400, 'right' );
                    // doc.text( 'This text is\raligned to theAAAAAAA.', 140, 460);
                    doc.text( 'PAIS:', 30, 70 );
                    doc.text( country, 70, 70 );
                    doc.text( 'EMPRESA:', 30, 85 );
                    doc.text( company, 100, 85 );
                    doc.text( 'PERIODO:', 195, 100 );
                    doc.text( period, 255, 100);

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
                    for (let i = 0; i < objPrePayrollDetail.length; i++) {
                        const element = objPrePayrollDetail;
                        //  console.log( element[i]) 
                        //  console.log('i: ' + i) 
                        if (i > 2) {
                            
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
                                if (element2.isIncome === 1) {
                                    doc.text(element2.amount, 436, n, 'right' );
                                }
                                if (element2.isIncome === 0) {
                                    doc.text(element2.amount, 502, n, 'right' );
                                // doc.text( '2.07', 502, 155, 'right' );
                                }
                                // doc.text(element2.staffCode);
                                n += 15
                                if (n > 754) {
                                    page += 1
                                    doc.addPage();
                                    //  Cabeceras
                                    doc.setFontType("bold");
                                    doc.setFontSize(12);
                                    doc.text( 'PRE-NOMINA DE PAGO', 220, 40 );
                                    doc.setFontType("courier");
                                    doc.setFontSize(7);
                                    doc.text( `Pagina ${page}`, 574, 40 );
                                    doc.setFontSize(12);
                                    // doc.text( 'This text is\raligned to the\rright.', 140, 400, 'right' );
                                    // doc.text( 'This text is\raligned to theAAAAAAA.', 140, 460);
                                    doc.text( 'PAIS:', 30, 70 );
                                    doc.text( country, 70, 70 );
                                    doc.text( 'EMPRESA:', 30, 85 );
                                    doc.text( company, 100, 85 );
                                    doc.text( 'PERIODO:', 195, 100 );
                                    doc.text( period, 255, 100);

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
                            doc.setFontType("bold")
                            doc.text( 'TOTALES', 215, n);
                            doc.text( `${n}`, 361, n);
                            // console.log('entro')
                            // console.log(element[i][0].asignacion)
                            doc.text(element[i][0].asignacion, 436, n, 'right' );
                            doc.text(element[i][0].deduccion, 502, n, 'right' );

                            let total = element[i][0].asignacion - element[i][0].deduccion // calculo para el total
                            // console.log('total: ' + total);
                            doc.text(`${total}`, 574, n, 'right' );
                            // doc.text(total, 574, n, 'right' );
                            
                            doc.setFontType("courier");
                            n += 20
                        }
                        
                    
                     }
                    doc.save('Test.pdf');
                    // console.log(res.data.print)
                    // return
                    // this.$emit("prePayrollDetail", objPrePayrollDetail)
                })
                
            }
        }
    }
</script>