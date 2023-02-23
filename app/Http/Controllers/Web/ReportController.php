<?php

namespace App\Http\Controllers\Web;


use App\Receivable;
use App\Transaction;
use App\Client;
use App\Contract;
use App\Invoice;
use App\InvoiceDetail;
use App\Proposal;
use App\ProposalDetail;
use App\PaymentInvoice;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use TCPDF;
use PDF;

class ReportController extends Controller
{
    private $oTransaction;
    private $oReceivable;
    private $oClient;
    private $oContract;
    private $oInvoice;
    private $oInvoiceDetail;  
    private $oProposal;
    private $oProposalDetail;
    private $oPaymentInvoice;

    public function __construct()
    {
        $this->middleware('auth');
        $this->oTransaction = new Transaction;
        $this->oReceivable  = new Receivable;
        $this->oClient      = new Client;
        $this->oContract      = new Contract;
        $this->oInvoice     = new Invoice;
        $this->oInvoiceDetail = new InvoiceDetail;
        $this->oProposal     = new Proposal;
        $this->oProposalDetail = new ProposalDetail;
        $this->oPaymentInvoice = new PaymentInvoice;
    }

//     public function printContract(Request $request)
//     {
//         $date     = Carbon::now();
//         $contract = $this->oContract->findById($request->id,session('countryId'),session('companyId'));

//         $contractNumber = __('contract');//para traducciones

//         $tbl = <<<EOD
//  <p>
//       <table cellspacing="0" cellpadding="0" border="0">
//         <tr>
//         <th> <img style="float:left;" src="img/logo_jd.jpg" alt="test alt attribute" width="110" height="90"/></th>
//         <th > <br><br><br><br><h3 style="background-color:#e5db99;font-size:14px;" colspan="3" align="center"> Reporte de Contrato</h3></th>
//         <th>
//         <p style="text-align:right">
//          <b>Fecha:</b> {$date->format('d/m/y')}<br>
//          </p>
//         </th>
//        </tr>
//        </table>
//          <br><br>

// <div style="width:10%">
//  <b>  Contract Number :</b> {$contract[0]->contractNumber}<br>
//  <b>  Tipo de Contrato :</b> {$contract[0]->contractType}<br>
//  <b>  Pais :</b> {$contract[0]->country->countryName} -
//  <b>  Oficina:</b> {$contract[0]->company->companyName}<br />
//  <b>  Nombre del Proyecto:</b> {$contract[0]->projectName}<br />
//  <b>  Fecha de Contrato:</b> {$contract[0]->contractDate}<br />
//  <b>  Cliente:</b> {$contract[0]->client->clientName}<br />
//  <b>  Direccion:</b> {$contract[0]->siteAddress}<br />
//  <b>  International Building Code:</b> {$contract[0]->buildingCode->buildingCodeName}<br />

//  <b>  Uso de Proyecto:</b> {$contract[0]->projectUse->projectUseName}<br />
//  <b>  Tipo de Construccion:</b> {$contract[0]->construtionType}<br />
//  <b>  Fecha de inicio:</b>  {$contract[0]->startDate}<br />
//  <b>  Comentario Inicial:</b> {$contract[0]->initialComment}<br />
//  <b>  Estado del Contrato:</b> {$contract[0]->contractStatus}<br />
// </div

// EOD;

//         $fileName = Auth::user()->userName;
//         PDF::SetTitle($fileName);
//         PDF::AddPage();
//         PDF::writeHTML($tbl, true, false, false, false, '');
//         // PDF::Write(0, 'Hello World');
//         $outputDestination = "F";
//         $outputPdfName     = "pdf/$fileName.pdf";
//         PDF::Output(public_path($outputPdfName), $outputDestination);

//         return view('layouts.reports', compact('outputPdfName'));
//     }

    public function summaryContractForCompany()
{
        $acum       = 0;
        $background = "";
        $date       = Carbon::now();
        $contracts  = $this->oContract->findBycompany(session('companyId'));

        $html = <<<EOD
      <p>
        <table cellspacing="0" cellpadding="0" border="0">
        <tr>
        <th>    <img style="float:center;" src="img/logo_jd.jpg" alt="test alt attribute" width="130px" height="110px"/></th>
        <th> <br><br><br><br><h3 style="text-align:center"> Resumen por Oficina</h3></th>
        <th>
        <p style="text-align:right">
         <b>Fecha:</b> {$date->format('d/m/y')}<br>
         <b>Oficina:</b> {$contracts[0]->company->companyName}
         </p>
        </th>
       </tr>
       </table>
         <br><br>
        <table cellspacing="0" cellpadding="0" border="0">
        <thead>
       <tr style="background-color:#3366cc; color:white; font-size:11px;  font-weight: bold;" align="center">
        <th width="15%">CONTRATO</th><th width="10%">FECHA</th><th align="left">CLIENTE</th><th align="left">DIRECCION</th><th width="35%" align="left">DESCRIPCION</th>
        </tr>
        </thead>
EOD;
        foreach ($contracts as $contract) {
            $acum = $acum + 1;
            if ($acum % 2 == 0) {
                $background = "#e6e6e6";
            } else {
                $background = "#fbfbfb";
            }
            $html .= <<<EOD
        <tr  style="background-color:$background; font-size:9px">
        <td width="15%" align="center">$contract->contractNumber</td>
        <td width="10%" align="center">$contract->contractDate</td>
        <td align="left">{$contract->client->clientName}</td>
        <td align="left">{$contract->siteAddress}</td>
        <td width="35%" align="left">{$contract->initialComment}</td>
        </tr>

EOD;
        }
        $html .= <<<EOD
</table>

EOD;

        $fileName = Auth::user()->userName;
        PDF::SetTitle($fileName);
        PDF::AddPage();
        PDF::writeHTML($html, true, false, false, false, '');
        // PDF::Write(0, 'Hello World');
        $outputDestination = "F";
        $outputPdfName     = "pdf/$fileName.pdf";
        PDF::Output(public_path($outputPdfName), $outputDestination);

        return view('layouts.reports', compact('outputPdfName'));
    }

    //REPORT DE TRANSACTION
    public function transactionsSummary(Request $request)
    {
        $acum         = 0;
        $background   = "";
        $date         = Carbon::now();
        $transactions = $this->oTransaction->getAllForTwoDate($request->date1, $request->date2,session('countryId'),session('companyId'));

        if ($transactions->isEmpty()) {
            return view('module_administration.reportincomeexpenses.error');
        } else {

            $html = <<<EOD

        <p>
        <table cellspacing="0" cellpadding="0" border="0"  >
       <tr>
        <th> <img style="float:left;" src="img/RGC_LOGO.jpg" alt="test alt attribute" width="150" height="90"/></th>
        <th> <br><br><br><br><h3 style="text-align:center">Reporte de Ingreso y Egreso</h3></th>
       <th>
        <p style="text-align:right">
         <b>Fecha:</b> {$date->format('d/m/y')}<br>
         </p>
        </th>
       </tr>
       </table>

        <br><br>
        <table cellspacing="0" cellpadding="0" border="0">
        <thead>
        <tr style="background-color:#3366cc; color:white; font-size:11px;  font-weight: bold;" align="center">
        <th width="5%">ID</th><th align="left" width="10%">TIPO</th><th  width="15%">FECHA</th><th align="left" width="45%">DESCRIPCION</th><th align="right">MONTO</th><th width="5%">D/C</th>
        </tr>
        </thead>
EOD;
            foreach ($transactions as $transaction) {
                $acum = $acum + 1;
                if ($acum % 2 == 0) {
                    $background = "#e6e6e6";
                } else {
                    $background = "#fbfbfb";
                }
                $html .= <<<EOD
         <tr style="background-color:$background; font-size:10px ">
        <td width="5%" align="center">$transaction->transactionId</td>
        <td width="10%" align="left">{$transaction->transactionType->transactionTypeName}</td>
        <td width="15%"align="center">$transaction->transactionDate</td>
        <td width="45%" align="left">$transaction->description</td>
        <td align="right">$transaction->amount</td>
        <td width="5%" align="center">$transaction->sign</td>
        </tr>

EOD;
            }
            $html .= <<<EOD
</table>
EOD;

            $fileName = Auth::user()->userName;
            PDF::SetTitle($fileName);
            PDF::AddPage();
            PDF::writeHTML($html, true, false, false, false, '');
            // PDF::Write(0, 'Hello World');
            $outputDestination = "F";
            $outputPdfName     = "pdf/$fileName.pdf";
            PDF::Output(public_path($outputPdfName), $outputDestination);

            return view('layouts.reports', compact('outputPdfName'));
        }
    }

    public function transactionSummaryForSign(Request $request)
    {
        $acum       = 0;
        $background = "";
        if ($request->sign == '+') {
            $name = 'INGRESO';
        } else {
            $name = 'Egreso';
        }

        $date         = Carbon::now();
        $transactions = $this->oTransaction->getAllForTwoDateAndSign($request->date1, $request->date2, $request->sign,session('countryId'),session('companyId'));

        if ($transactions->isEmpty()) {
            if ($request->sign == '+') {
                return view('module_administration.reportincome.error');
            } else {
                return view('module_administration.reportexpenses.error');
            }

        } else {

            $html = <<<EOD
        <p>
        <table cellspacing="0" cellpadding="0" border="0">
       <tr>
        <th> <img style="float:left;" src="img/RGC_LOGO.jpg" alt="test alt attribute" width="150" height="90"/></th>
         <th> <br><br><br><br><h3 style="text-align:center">Reporte de $name </h3></th>
        <th>
        <p style="text-align:right">
         <b>Fecha:</b> {$date->format('d/m/y')}<br>
         </p>
        </th>
       </tr>
       </table>

      <br><br>
        <table cellspacing="0" cellpadding="0" border="0">
        <thead>
        <tr style="background-color:#3366cc; color:white; font-size:11px;  font-weight: bold;" align="center">
        <th width="5%">ID</th><th align="left" width="10%">TIPO</th><th  width="15%">FECHA</th><th align="left" width="45%">DESCRIPCION</th><th align="right">MONTO</th><th width="5%">D/C</th>
        </tr>
        </thead>
EOD;
            foreach ($transactions as $transaction) {
                $acum = $acum + 1;
                if ($acum % 2 == 0) {
                    $background = "#e6e6e6";
                } else {
                    $background = "#fbfbfb";
                }
                $html .= <<<EOD
        <tr style="background-color:$background; font-size:10px">
        <td width="5%" align="center">$transaction->transactionId</td>
        <td width="10%" align="left">{$transaction->transactionType->transactionTypeName}</td>
        <td width="15%"align="center">$transaction->transactionDate</td>
        <td width="45%" align="left">$transaction->description</td>
        <td align="right">$transaction->amount</td>
        <td width="5%" align="center">$transaction->sign</td>
        </tr>

EOD;
            }
            $html .= <<<EOD
</table>
EOD;

            $fileName = Auth::user()->userName;
            PDF::SetTitle($fileName);
            PDF::AddPage();
            PDF::writeHTML($html, true, false, false, false, '');
            // PDF::Write(0, 'Hello World');
            $outputDestination = "F";
            $outputPdfName     = "pdf/$fileName.pdf";
            PDF::Output(public_path($outputPdfName), $outputDestination);

            return view('layouts.reports', compact('outputPdfName'));
        }
    }
/////////////////REPORTE DE COBRANZAS//////////////////////
    public function collections(Request $request)
    {

        $background = "";

        $collections = $this->oReceivable->collections(session('countryId'),session('companyId'), $request->date1, $request->date2);
        $country     = DB::table('country')->where('countryId', session('countryId'))->get(['countryName']);

        $date        = Carbon::now();
        $date1Format = Carbon::parse($request->date1);
        $date2Format = Carbon::parse($request->date2);

        if (!$collections) {
            return view('module_administration.reportcollections.error');
        } else {

            $html = <<<EOD
        <p>
        <table cellspacing="0" cellpadding="0" border="0">
       <tr>
        <th> <img style="float:left;" src="img/RGC_LOGO.jpg" alt="test alt attribute" width="150" height="90"/></th>
        <th> <br><br><br><br><h3 style="text-align:center">Reporte de Cobranzas</h3></th>
        <th>
        <p style="text-align:right">
         <b>Fecha:</b> {$date->format('d/m/y')}<br>
         <b>Pais:</b>  {$country[0]->countryName}<br>
       
         </p>
        </th>

       </tr>
       </table>
           <p style="text-align:center"><b>Desde {$date1Format->format('d/m/Y')} - Hasta:{$date2Format->format('d/m/Y')}</b></p>
      <br><br>
        <table cellspacing="0" cellpadding="0" border="0">
        <thead>
        <tr style="background-color:#3366cc; color:white; font-size:11px;  font-weight: bold;" align="center">
        <th width="5%">ID</th>
        <th width="30%" align="left">CLIENTE</th>
        <th width="15%">FECHA</th>
        <th width="20%" align="right">MONTO</th>
        <th width="30%" align="center">TIPO DE PAGO</th>
        </tr>
        </thead>
EOD;
            $total = 0;
            foreach ($collections as $r1) {
                $subtotal = 0; //variable suma subtotal
                $acum     = 0;
                foreach ($r1 as $receivable) {
                    $acum = $acum + 1;
                    if ($acum % 2 == 0) {$background = "#e6e6e6";} else { $background = "#fbfbfb";}
                    $receivable->statement += $receivable->amountPercentaje;
                    $amountPaid = number_format($receivable->amountPaid, 2, ',', '.');
                    //colores de filas table

                    $html .= <<<EOD
        <tr style="background-color:$background; font-size:10px" >
        <td width="5%" align="center">$receivable->receivableId</td>
        <td width="30%" align="left">{$receivable->client->clientName}</td>
        <td width="15%"align="center">$receivable->datePaid</td>
        <td width="20%" align="right">$amountPaid</td>
        <td width="30%" align="center">{$receivable->paymentMethod->payMethodName}</td>
        </tr>
EOD;
                    $subtotal += $receivable->amountPaid; //sumando cuotas para subtotal

                } //cierre foreach interno
                $subtotal2 = number_format($subtotal, 2, ',', '.');
                $html .= <<<EOD
        <tr style="background-color:#B0F0BF; font-size:10px">
        <td width="5%" align="center"> </td>
        <td width="30%" align="left"> </td>
        <td width="15%" align="center"><b>Sub-Total</b> </td>
        <td width="20%" align="right"> $subtotal2 </td>
        <td width="30%" align="center"> </td>
        </tr>
EOD;
                $total += $subtotal;

            } //cierre foreach externo
            $total2 = number_format($total, 2, ',', '.');
            $html .= <<<EOD
        <tr style="font-size:10px">
        <td width="5%" align="center"> </td>
        <td width="30%" align="left"> </td>
        <td width="15%" align="center"> <b>Total:</b></td>
        <td width="20%" align="right">$total2 </td>
        <td width="30%" align="center"> </td>
        </tr>
</table>
EOD;

            $fileName = Auth::user()->userName;
            PDF::SetTitle($fileName);
            PDF::AddPage();
            PDF::writeHTML($html, true, false, false, false, '');
            // PDF::Write(0, 'Hello World');
            $outputDestination = "F";
            $outputPdfName     = "pdf/$fileName.pdf";
            PDF::Output(public_path($outputPdfName), $outputDestination);

            return view('layouts.reports', compact('outputPdfName'));
        }
    }
//------------------INVOICE-----------------------------//
//      public function printInvoice(Request $request)
//     {

//         $date         = Carbon::now();
//         $company       = DB::table('company')->where('companyId', session('companyId'))->get();

//         $invoice    = $this->oInvoice->findById($request->id,session('countryId'),session('companyId'));
//         $client     = $invoice[0]->client;
//         $invoicesDetails = $this->oInvoiceDetail->getAllByInvoice($request->id);
//         $receivables    = $invoice[0]->receivable;
//      // dd($receivables[1]->paymentMethod);
//      // exit();
//         $symbol = $invoice[0]->contract->currency->currencySymbol;

//         // \PHPQRCode\QRcode::png($client[0]->clientCode, public_path('img/codeqr.png'), 'L', 4, 2);

//         if ($invoicesDetails->isEmpty()) {
//                  $notification = array(
//                     'message'    => 'Error: Debe agregar renglones a la Factura',
//                     'alert-type' => 'error',
//                 );
//              return redirect()->back()->with($notification);
//         }else {

//   if($invoice[0]->invStatusCode == Invoice::OPEN || $invoice[0]->invStatusCode == Invoice::CLOSED){
//      $status = '- COPY';
//   }elseif($invoice[0]->invStatusCode == Invoice::PAID){
//      $status = '';
//   }

//   // preparar variables  
//   $line = 100;  
//   $page = 1;              // paigina 1/1;   pagina 1/2  pagina 2/2
//   $linesperpage = 21;    // numero maximo de renglones
//   //calcular total de paginas
//   $quantityInvDetails = count($invoicesDetails);
//   $pageTotal = (intval($quantityInvDetails/$linesperpage));
//   $pageTotal++;
//    //si los registro y el limite de lineas son iguales es una pagina
//    if($quantityInvDetails == $linesperpage){
//     $pageTotal = 1;
//    }

//            $acum          = 0;
//            $acum2         = 0;
//            $acumInvDetail = 0;
//            $subTotalPerPage= 0;
//            $vienen = 0;
//            $moneySymbol = '';

//  //// inicio del ciclo de impresion
// foreach ($invoicesDetails as $invDetail) {
// //invoiceDetail

//   //if de header
//     if ($line > $linesperpage) { //imprimir
//             if($page > 1) {
//                   //FOOTER
// $html .= <<<EOD
// <tr style="font-size:10px">
//  <th colspan="4" align="right">
   
//  </th>
//   <th colspan="1" align="right">
//    Sub-Total:
//  </th>
//  <th style="border-top:2px solid black" colspan="1" align="right">
//    {$invoice[0]->contract->currency->currencySymbol} $subTotalPerPage
//  </th>
// </tr>
// </table>
//  <table cellspacing="0" cellpadding="0" border="0"  >
//        <tr>
//         <th style="background-color:#f2edd1;" colspan="1" align="center"><b>Terms & Conditions</b></th>
//        </tr>

//        <tr style="font-size:10px"> 
//         <th>
//              <div style="text-align:left">
//                   <ul>

// EOD;
// foreach($invoice['0']->note as $note){ 
//  $html .= <<<EOD

//     <li>$note->noteName</li>

// EOD;
// }

//  $html .= <<<EOD
//                   </ul>
//              </div>
//         </th>
//        </tr>
// </table>
// EOD;

//  $html .= <<<EOD
//  <table cellspacing="0" cellpadding="0" border="0"  >
//        <tr>
//         <th style="background-color:#f2edd1;" colspan="1" align="center"><b>Scopes of Work</b></th>
//        </tr>

//        <tr style="font-size:10px"> 
//         <th>
//                   <ul>

// EOD;
// foreach($invoice['0']->scope as $scope){ 
//  $html .= <<<EOD
//     <li>$scope->description</li>
// EOD;
// }
//  $html .= <<<EOD
//                   </ul>
//         </th>
//        </tr>
// </table>
// EOD;
//             PDF::AddPage();
//              if($invoice[0]->invStatusCode == Invoice::PAID){
//               PDF::image('img/paid2.png', 70, 90, 70, '', '', '', '', false, 300);
//              }
//             PDF::writeHTML($html, true, false, false, false, '');

//     }//endif - si la pagina es mayor que uno (1)

//  // imprimir encabezado de factura
//             $html = <<<EOD
//     <table cellspacing="0" cellpadding="1px" border="0"  >
//        <tr >
//         <th style="background-color:#e5db99;font-size:14px;" colspan="3" align="center"><b>ELECTRONIC INVOICE {$status}</b></th>
//        </tr>
 
//        <tr style="font-size:10px"> 
//          <th width="20%" align="left"> 
//           <img style="float:center;" src="img/logo_jd.jpg" alt="test alt attribute" width="170px" height="150px"/>
//          </th>
//         <th width="48%">
//              <div style="text-align:center">
//                <strong style="font-size:17px" sty>{$company[0]->companyName}</strong><br>
//                <img style="float:center;" src="img/icon-point.png" width="10" height="10"/> {$company[0]->companyAddress}<br>
//                <img style="float:center;" src="img/icon-phone.png" width="10" height="10"/> {$company[0]->companyPhone},{$company[0]->companyPhoneOptional}<br>
//                <img style="float:center;" src="img/icon-email.png" width="10" height="10"/> {$company[0]->companyEmail}
//                <img style="float:center;" src="img/icon-location.png" width="10" height="10"/> {$company[0]->companyWebsite}
//              </div>
//         </th>
//     <th width="32%">
//     <br><br>
//         <table border="0">
//              <tr>
//               <td><b>Invoice Number:</b></td>
//               <td align="right">{$invoice[0]->invId}</td>
//             </tr>
//             <tr>
//               <td><b>Invoice Date:</b></td>
//               <td align="right">{$invoice[0]->invoiceDate}</td>
//             </tr>
//             <tr>
//               <td><b>Page:</b> $page/$pageTotal</td>
//               <td align="left"></td>
//             </tr>
//             <tr>
//               <td> </td>
//               <td> </td>
//             </tr>
//             <tr>
//               <td><b>Seller ID:</b></td>
//               <td align="right"></td>
//             </tr>
//          </table>     

//         </th>
//        </tr>
// </table>
       

//  <table cellspacing="0" cellpadding="1px" border="0" style="font-size:10px">
//        <tr>
//         <th colspan="3" style="background-color:#f2edd1;font-size:13px;" align="center"><b>CUSTOMER INFORMATION</b></th>
//        </tr>
//        <tr> 
//             <th colspan="1">
//                <b>ID:</b> {$client->clientCode}
//             </th>
//             <th colspan="1">
//               <b>Name:</b> {$client->clientName}
//             </th>
//             <th colspan="1">
//               <b>Phone:</b> {$client->clientPhone}
//             </th>
//        </tr>

//       <tr> 
//             <th colspan="2">
//               <b>Billing Address:</b> {$client->clientAddress}
//             </th>
//             <th colspan="1">
//                <b>E-mail:</b> {$client->clientEmail}
//             </th>
//        </tr>
// </table>

//  <table cellspacing="0" cellpadding="1px" border="0" style="font-size:10px">
//        <tr>
//         <th colspan="3" style="background-color:#f2edd1;font-size:13px;" align="center"><b>PROJECT INFORMATION</b></th>
//        </tr>
//         <tr> 
//             <th width="35%" >
//              <b>Control Number:</b> {$invoice[0]->contract->contractNumber}
//             </th>
//             <th width="65%" colspan="2">
//              <b>Address:</b> {$invoice[0]->contract->siteAddress}
//             </th>
//             <th> </th>
//        </tr>
//       <tr> 
//             <th width="15%">
//               <b>Type:</b> {$invoice[0]->contract->projectUse->projectUseName} 
//             </th>
//             <th width="35%">
//               <b>Description:</b> {$invoice[0]->projectDescription->projectDescriptionName}
//             </th>
//            <th width="60%"> 
//              <b>Project Name:</b> {$invoice[0]->contract->projectName}
//            </th>
//        </tr>
// </table>   

//  <table stype="border-collapse: collapse;" cellspacing="0" cellpadding="1px" border="0">
//         <thead>
//         <tr style="background-color:#f2edd1; color:black; font-size:13px;  font-weight: bold;" align="center">
//           <th width="5%" align="center">#</th>
//           <th align="center" width="40%">DESCRIPTION</th>
//           <th width="10%" align="center">UNIT</th>
//           <th width="15%" >QTY</th>
//           <th width="15%" align="center">UP</th>
//           <th width="15%" align="center">AMOUNT</th>
//         </tr>
//         </thead>
// EOD;


//        $page++;
//        $acum= 0 ;
//        $subTotalPerPage= 0;
//        $line= 1;// al pasar la pagina reinicia la linea

// } //fin de condicion de header

               
//                $acum = $acum + 1;
//                 if ($acum % 2 == 0) {
//                     $background = "#f2edd1";
//                 } else {
//                     $background = "#fbfbfb";
//                 }
//      //espacios,numeracion,precios, negritas para reglon con precios
//                if ($invDetail->unit == null) {
//                     $acum2 = "";
//                     $space = "   ";
//                     $moneySymbol = '';
//                 } else {
//                     $acumInvDetail = $acumInvDetail + 1;
//                     $acum2=$acumInvDetail;
//                     $space = "";
//                     $moneySymbol = $invoice[0]->contract->currency->currencySymbol;
//                 }
//      if($page > 2 && $line == 1) {  //si es la segunda pagina en la primera linea imprime el viene  
//                 $html .= <<<EOD
//         <tr style="background-color:; font-size:10px;">
//         <td width="5%" align="center"></td>
//         <td width="40%" >CONTINUED</td>
//         <td width="10%" align="center"></td>
//         <td width="15%" align="center"></td>
//         <td width="15%" align="center"></td>
//         <td width="15%" align="right"> {$invoice[0]->contract->currency->currencySymbol} $vienen</td>
//         </tr>
// EOD;
//         if($vienen > 0){ //si viene es mayor que cero sumalo al subtotal de pagina 
//             $subTotalPerPage += $vienen;
//          }
//     }


//                 $html .= <<<EOD
//         <tr style="background-color:$background; font-size:10px;">
//         <td width="5%" align="center">$acum2</td>
//         <td width="40%" >$space$invDetail->serviceName</td>
//         <td width="10%" align="center">{$invDetail->unit}</td>
//         <td width="15%" align="center">$invDetail->quantity</td>
//         <td width="15%" align="center">$moneySymbol  $invDetail->unitCost</td>
//         <td width="15%" align="right">$moneySymbol  $invDetail->amount</td>
//         </tr>
// EOD;

//        $subTotalPerPage += $invDetail->amount;//acumulacion de subtotal de pagina
//        $subTotalPerPage = number_format((float)$subTotalPerPage, 2, '.', '');
//        $vienen =  number_format((float)$subTotalPerPage, 2, '.', '');

//     $line++;
// }// FIN DE FOREACH DE RENGLONES

//    // imprimir footer de factura
//      $html .= <<<EOD
// </table>
// <table cellspacing="0" cellpadding="0" border="0"  >
//        <tr>
//         <th colspan="3" style="background-color:#f2edd1;font-size:13px;" align="center"><b></b>
//         </th>
//        </tr>
//        <tr style="font-size:10px"> 
//         <th width="20%">
//           <img style="float:center;" src="img/codeqr.png" alt="test alt attribute" width="80" height="80"/>
//         </th>
//         <th width="50%">
//              <b>Payment break down:</b><br>
      
// EOD;
//       $acum3        = 0;
//       $acumPaid     = 0;
//     foreach ($receivables as $receivable) {
//      $acum3 = $acum3 + 1;
//      $acumPaid += $receivable->amountPaid;
//      $acumPaid =  number_format((float)$acumPaid, 2, '.', '');

//         if($receivable->paymentMethod == null){ 
//            $paymentMethod  = null;
//         }else{
//            $paymentMethod  =$receivable->paymentMethod->payMethodName;
//         }

//       if($receivable->recStatusCode != 4){ 
//            $recStatusName  = null;
//         }else{
//            $recStatusName  = $receivable->receivableStatus[0]->recStatusName;
//         }
//       $html .= <<<EOD
//       <table cellspacing="0" cellpadding="0" border="0"  >
//                 <tr>
//                  <td width="10%">$acum3)</td>
//                  <td width="20%">$moneySymbol $receivable->amountDue</td>
//                  <td width="20%">$paymentMethod</td>
//                  <td width="20%">$recStatusName</td>
//                  <td width="30%">$receivable->datePaid</td>
//                  <td width="45%"></td>
//                 </tr>
//               </table>
// EOD;

//   }
//    $amountRs =  $invoice[0]->netTotal-$acumPaid;
//    $amountRs =  number_format((float)$amountRs, 2, '.', '');

//  $html .= <<<EOD
               
//         </th>
//         <th width="30%">
//              <table cellspacing="0" cellpadding="0" border="0"  >
//                <tr>
//                 <th><b>Subtotal</b></th><th style="border-top:1px solid black;"  align="right"> {$symbol}{$invoice[0]->grossTotal}</th>
//                </tr>
//                <tr>
//                 <th><b>Tax Rate</b></th><th align="right">{$invoice[0]->taxPercent}%</th>
//                </tr>
//                <tr>
//                 <th><b>Tax</b></th><th align="right"> {$symbol}{$invoice[0]->taxAmount}</th>
//                </tr>
//                 <tr>
//                 <th><b>Total</b></th><th align="right"> {$symbol}{$invoice[0]->netTotal}</th>
//                </tr>
//                 <tr>
//                 <th><b>Amount PAID</b></th><th align="right" style="color:red"> {$symbol} $acumPaid </th>
//                </tr>
//                 <tr>
//                 <th><b>Balance Due</b></th><th align="right"> {$symbol} $amountRs </th>
//                </tr>
//              </table>
//         </th>
//        </tr>
// </table>
// EOD;


//  $html .= <<<EOD
//  <table cellspacing="0" cellpadding="0" border="0"  >
//        <tr>
//         <th style="background-color:#f2edd1;" colspan="1" align="center"><b>Terms & Conditions</b></th>
//        </tr>

//        <tr style="font-size:10px"> 
//         <th>
//                   <ul>

// EOD;
// foreach($invoice['0']->note as $note){ 
//  $html .= <<<EOD
//     <li>$note->noteName</li>
// EOD;
// }
//  $html .= <<<EOD
//                   </ul>
//         </th>
//        </tr>
// </table>
// EOD;



//  $html .= <<<EOD
//  <table cellspacing="0" cellpadding="0" border="0"  >
//        <tr>
//         <th style="background-color:#f2edd1;" colspan="1" align="center"><b>Scope of Work</b></th>
//        </tr>

//        <tr style="font-size:10px"> 
//         <th>
//                   <ul>

// EOD;
// foreach($invoice['0']->scope as $scope){ 
//  $html .= <<<EOD
//     <li>$scope->description</li>
// EOD;
// }
//  $html .= <<<EOD
//                   </ul>
//         </th>
//        </tr>
// </table>
// EOD;
//           PDF::setFooterCallback(function($pdf) {
//             // Position at 15 mm from bottom
//             $pdf->SetY(-15);
//             // Set font
//             $pdf->SetFont('helvetica', 'I', 8);
//             $pdf->Cell(0, 9, '© Copyright 2020 JD Rivero Global - All rights reserved ', 0, false, 'C', 0, '', 0, false, 'T', 'M');
//             $pdf->Ln(4);
            
//             $pdf->Cell(0, 9, 'Designed By Rivero Visual Group', 0, false, 'C', 0, '', 0, false, 'T', 'M');
//             // Page number
//             $pdf->Cell(0, 10, 'Page '.$pdf->getAliasNumPage().'/'.$pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
//             //  $pdf->setImageScale(5);
//             // if($status=='paid'){
//             // $pdf->Image('img/paid2.png', 70, 90, 70, '', '', '', '', false, 300);
//             // }
//          });



//             PDF::AddPage();
//             if($invoice[0]->invStatusCode == Invoice::PAID){
//               PDF::image('img/paid2.png', 70, 90, 70, '', '', '', '', false, 300);
//              }
//             PDF::writeHTML($html, true, false, false, false, '');

//             $fileName = Auth::user()->userName;
//             PDF::SetTitle($fileName);
//             $outputDestination = "F";
//             $outputPdfName     = "pdf/$fileName.pdf";
//             PDF::Output(public_path($outputPdfName), $outputDestination);
    

//             return view('layouts.reports', compact('outputPdfName'));
//         }
//     }
//----------------------------------RECIBO DE PAGO DE CUOTAS EN PDF------------------------//
//  public function printReceipt(Request $request)
//     {

//        $receivables = $this->oReceivable->findById($request->receivableId);
//        $company       = DB::table('company')->where('companyId', session('companyId'))->get();
//        $invoice    = $this->oInvoice->findById($receivables[0]->invoiceId,session('countryId'),session('companyId'));
//        $symbol = $invoice[0]->contract->currency->currencySymbol;
//             $html = <<<EOD
// <table cellspacing="0" cellpadding="1px" border="0">
//        <tr >
//         <th style="background-color:#efcb44;font-size:15px;color:white" colspan="3" align="center"><b>PAYMENT RECEIPT</b></th>
//        </tr>
//         <br><br>
//     <tr style="font-size:11px"> 
//          <th width="20%" align="left"> 
//           <img style="float:center;" src="img/logo_jd.jpg" alt="test alt attribute" width="170px" height="150px"/>
//          </th>
//         <th width="57%">
//              <div style="text-align:center">
//                <strong style="font-size:17px" sty>{$company[0]->companyName}</strong><br>
//                <img style="float:center;" src="img/icon-point.png" width="10" height="10"/> {$company[0]->companyAddress}<br>
//                <img style="float:center;" src="img/icon-phone.png" width="10" height="10"/> {$company[0]->companyPhone},{$company[0]->companyPhoneOptional}<br>
//                <img style="float:center;" src="img/icon-email.png" width="10" height="10"/> {$company[0]->companyEmail}
//                <img style="float:center;" src="img/icon-location.png" width="10" height="10"/> {$company[0]->companyWebsite}
//              </div>
//         </th>
//       <th width="23%" align="center">
//       <br>
//         <img style="float:center;" src="img/codeqr.png" alt="test alt attribute" width="80" height="80"/>
//       </th>
//     </tr>
// </table>

// <br><br><br>
//  <table cellspacing="0" cellpadding="6px" border="0" style="font-size:11px;background-color:#f4f4f5;border-radius:4px">
//        <tr>
//         <th><b>Dear</b> {$receivables[0]->client->clientName}</th>
//        </tr>
//        <tr> 
//         <th><b>We have received your payment , you can find the receipt below.</b></th>
//        </tr>
// </table>
// EOD;
//             foreach ($receivables as $receivable) {
//                 $html .= <<<EOD
// <br>
//  <div align="center" style="font-size:12px"><b>Payment information</b></div>
//  <br>

// <table>
// <tr>
// <td style="width:20%"></td>
// <td style="width:60%">
//   <table cellspacing="0" cellpadding="6px" border="0" style="font-size:11px; border: 1px solid black;">
//   <tr style="background-color:#f4f4f5;"> 
//             <th>
//                Payment date:
//             </th>
//             <th>
//               {$receivable->datePaid}
//             </th>
//        </tr>

//         <tr style="background-color:#f4f4f5;"> 
//             <th>
//                Amount paid:
//             </th>
//             <th>
//                 $symbol{$receivable->amountPaid}
//             </th>
//        </tr>

//         <tr style="background-color:#f4f4f5;"> 
//             <th>
//              Method:
//             </th>
//             <th>
//                {$receivable->paymentMethod->payMethodName}
//             </th>
//        </tr>
      
//   </table> 
// </td>
// <td style="width:20%"></td>

// </tr>
// </table>

// <br><br>
//  <div align="center" style="font-size:12px"><b>Payment details</b></div>
//  <br>

// <table>
// <tr>
// <td style="width:20%"></td>
// <td style="width:60%">
//   <table  cellspacing="0" cellpadding="6px" border="0" style="font-size:11px; border: 1px solid black;">
//       <tr style="background-color:#f4f4f5;"> 
//             <th>
//                Control Number:
//             </th>
//             <th>
//               {$receivable->invoice->contract->contractNumber}
//             </th>
//        </tr>
//         <tr style="background-color:#f4f4f5;"> 
//             <th>
//                Transaction ID:
//             </th>
//             <th>
//               INVOICE #{$receivable->invoice->invId}
//             </th>
//        </tr>

//         <tr style="background-color:#f4f4f5;"> 
//             <th>
//               Balance Due:
//             </th>
//             <th>
//                $symbol  {$receivable->balance}          </th>
//        </tr>

//          <tr style="background-color:#f4f4f5;"> 
//             <th>
//                Customer ID:
//             </th>
//             <th>
//                {$receivable->client->clientCode}
//             </th>
//        </tr>

//           <tr style="background-color:#f4f4f5;"> 
//             <th>
//                Status:
//             </th>
//             <th>
//                {$receivable->receivableStatus[0]->recStatusName}
//             </th>
//        </tr> 
//   </table> 
// </td>
// <td style="width:20%"></td>

// </tr>
// </table>

// <br>
// <div align="center" style="font-size:12px"><b>Overpayment of <u> $symbol{$receivable->amountPaid}</u> converted to credit</b></div>

// EOD;
//     }
//      $html .= <<<EOD
//  <br><br>    
//  <table cellspacing="0" cellpadding="2px" border="0"  >
//        <tr>
//         <th style="background-color:#f4f4f5;" colspan="1" align="center"><b>Terms & Conditions</b></th>
//        </tr>

//        <tr style="font-size:11px"> 
//         <th>
//               <b>T&C:</b>
//                   <ul>

// EOD;
// foreach($invoice['0']->note as $note){ 
//  $html .= <<<EOD
//     <li>$note->noteName</li>
// EOD;
// }
//  $html .= <<<EOD
//                   </ul>
//         </th>
//        </tr>
// </table>
// EOD;
//         PDF::setFooterCallback(function($pdf) {
//             // Position at 15 mm from bottom
//             $pdf->SetY(-15);
//             // Set font
//             $pdf->SetFont('helvetica', 'I', 8);
//             $pdf->Cell(0, 9, '© Copyright 2020 JD Rivero Global - All rights reserved ', 0, false, 'C', 0, '', 0, false, 'T', 'M');
//             $pdf->Ln(4);
            
//             $pdf->Cell(0, 9, 'Designed By Rivero Visual Group', 0, false, 'C', 0, '', 0, false, 'T', 'M');
//             // Page number
//             // $pdf->Cell(0, 10, 'Page '.$pdf->getAliasNumPage().'/'.$pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
//          });
//             PDF::AddPage();
//             PDF::writeHTML($html, true, false, false, false, '');

//             $fileName = Auth::user()->userName;
//             PDF::SetTitle($fileName);
//             $outputDestination = "F";
//             $outputPdfName     = "pdf/$fileName.pdf";
//             PDF::Output(public_path($outputPdfName), $outputDestination);
    

//             return view('layouts.reports', compact('outputPdfName'));
//         }



//------------------Proposal-----------------------------//
//      public function printProposal(Request $request)
// {

//         $date             = Carbon::now();
//         $company           = DB::table('company')->where('companyId', session('companyId'))->get();
//         $proposal         = $this->oProposal->findById($request->id,session('countryId'),session('companyId'));
//         $proposalsDetails = $this->oProposalDetail->getAllByProposal($request->id);
//         $client           = $this->oClient->findById($proposal[0]->clientId,session('countryId'));
        
//         if($proposal[0]->precontract){
//            $moneySymbol = $proposal[0]->precontract->currency->currencySymbol;
//            $modelId = $proposal[0]->precontract->preId;
//            $modelType = 'precontract';
//            $modelTypeView = 'Precontract';
//         }else{
//            $moneySymbol = $proposal[0]->contract->currency->currencySymbol;
//            $modelId = $proposal[0]->contract->contractNumber;
//            $modelType = 'contract';
//            $modelTypeView = 'Contract';

//         }

//       //dispara error si cuotas son mayores que el monto neto de la propuesta para que el usuario ajuste cuotas.
//        $paymentSum = 0;
//         foreach ($proposal[0]->paymentProposal as $paymentProposal) {
//             $paymentSum += $paymentProposal->amount;
//         }

//        if($paymentSum > $proposal[0]->netTotal){
//          $notification = array(
//                     'message'    => 'Error: Las cuotas no corresponden con el precio de la propuesta, debe ajustar cuotas.',
//                     'alert-type' => 'error',
//                 );
//              return redirect()->back()->with($notification);
//          }
//         //si no tiene renglones la propuesta disparar error
//         if ($proposalsDetails->isEmpty()) {
//             // return view('module_administration.reportincomeexpenses.error');
//                  $notification = array(
//                     'message'    => 'Error: Debe llenar renglones de Propuesta',
//                     'alert-type' => 'error',
//                 );
//              return redirect()->back()->with($notification);
//         } else {

//   // preparar variables  
//   $line = 100;  
//   $page = 1;              // paigina 1/1;   pagina 1/2  pagina 2/2
//   $linesperpage = 30;    // numero maximo de renglones
//   //calcular total de paginas
//   $quantityPropDetails = count($proposalsDetails);
//   $pageTotal = (intval($quantityPropDetails/$linesperpage));
//   $pageTotal++;
//    //si los registro y el limite de lineas son iguales es una pagina
//    if($quantityPropDetails == $linesperpage){
//     $pageTotal = 1;
//    }

//            $acum          = 0;
//            $acum2         = 0;
//            $acumPropDetail = 0;
//            $subTotalPerPage= 0;
//            $vienen = 0;

//  //// inicio del ciclo de impresion
// foreach ($proposalsDetails as $propDetail) {
// //invoiceDetail

//   //if de header
//     if ($line > $linesperpage) { //imprimir
//             if($page > 1) {
//                   //FOOTER
// $html .= <<<EOD
// <tr style="font-size:10px">
//  <th colspan="4" align="right">
   
//  </th>
//   <th colspan="1" align="right">
//    Sub-Total:
//  </th>
//  <th style="border-top:2px solid black" colspan="1" align="right">
//    {$moneySymbol} $subTotalPerPage
//  </th>
// </tr>
// </table>

// EOD;
//             PDF::AddPage();
//             PDF::writeHTML($html, true, false, false, false, '');

//     }//endif - si la pagina es mayor que uno (1)

//  // imprimir encabezado de factura 


//             $html = <<<EOD
// <table cellspacing="0" cellpadding="1px" border="0"  >
//        <tr >
//         <th style="background-color:#e5db99;font-size:14px;" colspan="3" align="center"><b>ELECTRONIC PROPOSAL</b></th>
//        </tr>

//      <tr style="font-size:10px"> 
//         <th width="20%" align="left"> 
//           <img style="float:center;" src="img/logo_jd.jpg" alt="test alt attribute" width="170px" height="150px"/>
//          </th>
//         <th width="46%">
//              <div style="text-align:center">
//                <strong style="font-size:17px" sty>{$company[0]->companyName}</strong><br>
//                <img style="float:center;" src="img/icon-point.png" width="10" height="10"/> {$company[0]->companyAddress}<br>
//                <img style="float:center;" src="img/icon-phone.png" width="10" height="10"/> {$company[0]->companyPhone},{$company[0]->companyPhoneOptional}<br>
//                <img style="float:center;" src="img/icon-email.png" width="10" height="10"/> {$company[0]->companyEmail}
//                <img style="float:center;" src="img/icon-location.png" width="10" height="10"/> {$company[0]->companyWebsite}
//              </div>
//         </th>

//     <th width="34%">
//     <br><br>
//      <table border="0">
//              <tr>
//               <td><b>Proposal Number:</b></td>
//               <td align="right">{$proposal[0]->propId}</td>
//             </tr>
//             <tr>
//               <td><b>Proposal Date:</b></td>
//               <td align="right">{$proposal[0]->proposalDate}</td>
//             </tr>

//             <tr>
//               <td><b>Page:</b> $page/$pageTotal</td>
//               <td align="left"></td>
//             </tr>
//             <tr>
//               <td> </td>
//               <td> </td>
//             </tr>
//             <tr>
//               <td><b>Seller ID:</b></td>
//               <td align="right"></td>
//             </tr>
//         </table>     
//         </th>
//    </tr>
// </table>

//   <table cellspacing="0" cellpadding="0" border="0"  >
//        <tr style="font-size:10px">
//         <th align="center">
//         Dear Mr./Mrs. Gallegos:<br>
//         We are pleased to submit this proposal to provide professional services associated with this project at the reference address in DALLAS TX. Based on our perception of the overall project objectives, we propose to perform the following tasks. 
//          </th>
//        </tr>
// </table>

//  <table cellspacing="0" cellpadding="1px" border="0" style="font-size:10px">
//        <tr>
//         <th colspan="3" style="background-color:#f2edd1;font-size:13px;" align="center"><b>CUSTOMER INFORMATION</b></th>
//        </tr>
//        <tr> 
//             <th colspan="1">
//                <b>ID:</b> {$client[0]->clientCode}
//             </th>
//             <th colspan="1">
//               <b>Name:</b> {$client[0]->clientName}
//             </th>
//              <th colspan="1">
//                    <b>Phone:</b> {$client[0]->clientPhone}
//             </th>
//        </tr>
//       <tr> 
//             <th colspan="2">
//               <b>Billing Address:</b> {$client[0]->clientAddress}
//             </th>
//              <th colspan="1">
//                <b>E-mail:</b> {$client[0]->clientEmail}
//             </th>
//        </tr>
// </table>

//  <table cellspacing="0" cellpadding="1px" border="0" style="font-size:10px">
//        <tr>
//         <th colspan="3" style="background-color:#f2edd1;font-size:13px;" align="center"><b>PROJECT INFORMATION</b>
//         </th>
//        </tr>
//         <tr> 
//             <th>
//              <b>$modelTypeView ID:</b> $modelId
//             </th>
//             <th colspan="2">
//              <b>Address:</b> {$proposal[0]->$modelType->siteAddress}
//             </th>
//             <th> </th>
//        </tr>
//        <tr> 
//             <th width="15%">
//               <b>Type:</b> {$proposal[0]->$modelType->projectUse->projectUseName} 
//             </th>
//             <th width="35%">
//               <b>Description:</b> {$proposal[0]->projectDescription->projectDescriptionName}
//             </th>
//            <th width="50%"> 
//              <b>Project Name:</b> {$proposal[0]->$modelType->projectName}
//            </th>
//        </tr>
// </table>   

//  <table stype="border-collapse: collapse;" cellspacing="0" cellpadding="1px" border="0">
//         <thead>
//         <tr style="background-color:#f2edd1; color:black; font-size:13px;  font-weight: bold;" align="center">
//           <th width="5%" align="center">#</th>
//           <th align="center" width="40%">DESCRIPTION</th>
//           <th width="10%" align="center">UNIT</th>
//           <th width="15%" >QTY</th>
//           <th width="15%" align="center">UP</th>
//           <th width="15%" align="center">AMOUNT</th>
//         </tr>
//         </thead>
// EOD;


//        $page++;
//        $acum= 0 ;
//        $subTotalPerPage= 0;
//        $line= 1;// al pasar la pagina reinicia la linea

// } //fin de condicion de header

               
//                $acum = $acum + 1;
//                 if ($acum % 2 == 0) {
//                     $background = "#f2edd1";
//                 } else {
//                     $background = "#fbfbfb";
//                 }
//      //espacios,numeracion,precios, negritas para reglon con precios
//                if ($propDetail->unit == null) {
//                     $acum2 = "";
//                     $space = "   ";
//                     $symbol = '';
//                 } else {
//                     $acumPropDetail = $acumPropDetail + 1;
//                     $acum2=$acumPropDetail;
//                     $space = "";
//                     $symbol = $moneySymbol;
//                 }
//      if($page > 2 && $line == 1) {  //si es la segunda pagina en la primera linea imprime el viene  
//                 $html .= <<<EOD
//         <tr style="background-color:; font-size:10px;">
//         <td width="5%" align="center"></td>
//         <td width="40%" >CONTINUED</td>
//         <td width="10%" align="center"></td>
//         <td width="15%" align="center"></td>
//         <td width="15%" align="center"></td>
//         <td width="15%" align="right"> {$moneySymbol} $vienen</td>
//         </tr>
// EOD;
//         if($vienen > 0){ //si viene es mayor que cero sumalo al subtotal de pagina 
//             $subTotalPerPage += $vienen;
//          }
//     }
//                 $html .= <<<EOD
//         <tr style="background-color:$background; font-size:10px;">
//         <td width="5%" align="center">$acum2</td>
//         <td width="40%" >$space$propDetail->serviceName</td>
//         <td width="10%" align="center">{$propDetail->unit}</td>
//         <td width="15%" align="center">$propDetail->quantity</td>
//         <td width="15%" align="center">$symbol  $propDetail->unitCost</td>
//         <td width="15%" align="right">$symbol  $propDetail->amount</td>
//         </tr>
// EOD;

//        $subTotalPerPage += $propDetail->amount;//acumulacion de subtotal de pagina
//        $subTotalPerPage = number_format((float)$subTotalPerPage, 2, '.', '');
//        $vienen =  number_format((float)$subTotalPerPage, 2, '.', '');

//     $line++;
// }// FIN DE FOREACH DE RENGLONES

//    // imprimir footer de factura
//      $html .= <<<EOD
// </table>
// <table cellspacing="0" cellpadding="0" border="0" style= "font-size:10px;"  >
//       <tr>
//         <th colspan="3" style="background-color:#f2edd1;font-size:13px;" align="center"><b></b>
//         </th>
//        </tr>
//        <tr>
//         <th width="70%">
//              <b>Payment break down:</b><br>
      
// EOD;
//       $acum3        = 0;
//     foreach ($proposal[0]->paymentProposal as $receivable) {
      
//       $acum3 = $acum3 + 1;
//       $html .= <<<EOD
//       <table cellspacing="0" cellpadding="0" border="0"  >
//                 <tr>
//                  <td width="10%">$acum3)</td>
//                  <td width="20%">$moneySymbol $receivable->amount</td>
//                  <td width="75%"></td>
//                 </tr>
//       </table>
// EOD;
//   }
   
//  $html .= <<<EOD
               
//         </th>
//         <th width="30%">
//              <table cellspacing="0" cellpadding="0" border="0"  >
//                <tr>
//                 <th><b>Subtotal</b></th><th style="border-top:1px solid black;"  align="right"> {$moneySymbol}{$proposal[0]->grossTotal}</th>
//                </tr>
//                <tr>
//                 <th><b>Tax Rate</b></th><th align="right">{$proposal[0]->taxPercent}%</th>
//                </tr>
//                <tr>
//                 <th><b>Tax</b></th><th align="right"> {$moneySymbol}{$proposal[0]->taxAmount}</th>
//                </tr>
//                 <tr>
//                 <th><b>Total</b></th><th align="right"> {$moneySymbol}{$proposal[0]->netTotal}</th>
//                </tr>
//              </table>
//         </th>
//        </tr>
// </table>
// EOD;


//  $html .= <<<EOD
//  <table cellspacing="0" cellpadding="0" border="0"  >
//        <tr>
//         <th style="background-color:#f2edd1;" colspan="1" align="center"><b>Terms & Conditions</b></th>
//        </tr>

//        <tr style="font-size:10px"> 
//         <th>
//                   <ul>
// EOD;
// foreach($proposal['0']->note as $note){ 
//  $html .= <<<EOD
//       <li>$note->noteName</li>
// EOD;
// }
//  $html .= <<<EOD
//                   </ul>
//         </th>
//        </tr>
// </table>
// EOD;

// $html .= <<<EOD
//  <table cellspacing="0" cellpadding="0" border="0"  >
//        <tr>
//         <th style="background-color:#f2edd1;" colspan="1" align="center"><b>Scope of Work</b></th>
//        </tr>

//        <tr style="font-size:10px"> 
//         <th>
//                   <ul>

// EOD;
// foreach($proposal['0']->scope as $scope){ 
//  $html .= <<<EOD
//       <li>$scope->description</li>
// EOD;
// }
//  $html .= <<<EOD
//                   </ul>
//         </th>
//        </tr>
// </table>
// EOD;

//  $html .= <<<EOD
//  <br>
//   <table cellspacing="0" cellpadding="0" border="0"  >
//        <tr>
//         <th style="background-color:#f2edd1;" colspan="1" align="center"></th>
//        </tr>
//        <br>
//        <tr style="font-size:10px">
//         <th align="center">
//          We are pleased to have the opportunity to submit this proposal and look forward to the prospect of working with you on this project. If the proposal is acceptable as presented, please sign where indicated below and return one copy to our office. If you have any questions, please do not hesitate to call us.
//          </th>
//        </tr>
// </table>

// <br><br><br><br>

//   <table style="font-size:8px" cellspacing="0" cellpadding="0" border="0">
//        <tr>
//         <th align="center">
//         ACCEPTED BY: _____________________________________<br>
//                           Mr./Mrs. {$client[0]->clientName}
//          </th>
//        </tr>
// </table>



// EOD;



//           PDF::setFooterCallback(function($pdf) {
//             // Position at 15 mm from bottom
//             $pdf->SetY(-15);
//             // Set font
//             $pdf->SetFont('helvetica', 'I', 8);
//             $pdf->Cell(0, 9, '© Copyright 2020 JD Rivero Global - All rights reserved ', 0, false, 'C', 0, '', 0, false, 'T', 'M');
//             $pdf->Ln(4);
            
//             $pdf->Cell(0, 9, 'Designed By Rivero Visual Group', 0, false, 'C', 0, '', 0, false, 'T', 'M');
//             // Page number
//             $pdf->Cell(0, 10, 'Page '.$pdf->getAliasNumPage().'/'.$pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
//          });



//             PDF::AddPage();
//             PDF::writeHTML($html, true, false, false, false, '');

//             $fileName = Auth::user()->userName;
//             PDF::SetTitle($fileName);
//             $outputDestination = "F";
//             $outputPdfName     = "pdf/$fileName.pdf";
//             PDF::Output(public_path($outputPdfName), $outputDestination);
    

//             return view('layouts.reports', compact('outputPdfName'));
//         }
//     } 

//------------------SIMPLE STATEMENT-----------------------------//
//      public function printStatement(Request $request)
//     {
//  //reporte traigo de transaction
//         $date         = Carbon::now();
//         $company       = DB::table('company')->where('companyId', session('companyId'))->get();

//         $invoice        = $this->oInvoice->findById($request->id,session('countryId'),session('companyId'));
//         $share          = $this->oReceivable->sharePending($request->id);
//         $client         = $this->oClient->findById($invoice[0]->clientId,session('countryId'));
//         $transactions   = $this->oTransaction->getAllByInvoice($request->id,session('countryId'),session('companyId'));

//          if($share->isEmpty()){
//             $nextShare = '0.00';
//          }else{
//             $nextShare = $share[0]->amountDue;
//          }

//         $symbol = $invoice[0]->contract->currency->currencySymbol;

//         if ($invoice->isEmpty()) {
//             return view('module_administration.reportincomeexpenses.error');
//         } else {

//  // imprimir encabezado de statemen
//             $html = <<<EOD
//     <table cellspacing="0" cellpadding="1px" border="0"  >
//        <tr >
//         <th style="background-color:#e5db99;font-size:14px;" colspan="3" align="center"><b>STATEMENT</b></th>
//        </tr>
 
//        <tr style="font-size:9px"> 
//          <th width="20%" align="left"> 
//           <img style="float:center;" src="img/logo_jd.jpg" alt="test alt attribute" width="170px" height="150px"/>
//          </th>
//         <th width="54%">
//              <div style="text-align:center">
//                <strong style="font-size:17px" sty>{$company[0]->companyName}</strong><br>
//                <img style="float:center;" src="img/icon-point.png" width="10" height="10"/> {$company[0]->companyAddress}<br>
//                <img style="float:center;" src="img/icon-phone.png" width="10" height="10"/> {$company[0]->companyPhone},{$company[0]->companyPhoneOptional}<br>
//                <img style="float:center;" src="img/icon-email.png" width="10" height="10"/> {$company[0]->companyEmail}
//                <img style="float:center;" src="img/icon-location.png" width="10" height="10"/> {$company[0]->companyWebsite}
//              </div>
//         </th>
//     <th width="30%">
//     <br><br>
//         <table border="0">
//             <tr>
//               <td> </td>
//               <td> </td>
//             </tr>
//             <tr>
//               <td><b>Statement Date:</b></td>
//               <td align="left">{$date->format('m/d/Y')}</td>
//             </tr>
//          </table>     

//         </th>
//        </tr>
// </table>
       

//  <table cellspacing="0" cellpadding="1px" border="0" style="font-size:10px">
//        <tr>
//         <th colspan="3" style="background-color:#f2edd1;font-size:13px;" align="center"><b>CUSTOMER INFORMATION</b></th>
//        </tr>
//        <tr> 
//             <th colspan="1">
//                <b>ID:</b> {$client[0]->clientCode}
//             </th>
//             <th colspan="2">
//               <b>Name:</b> {$client[0]->clientName}
//             </th>
//        </tr>

//       <tr> 
//             <th colspan="3">
//               <b>Billing Address:</b> {$client[0]->clientAddress}
//             </th>
//        </tr>

//      <tr> 
//           <th colspan="2">
//                <b>E-mail:</b> {$client[0]->clientEmail}
//             </th>
//             <th colspan="1">
//                    <b>Phone:</b> {$client[0]->clientPhone}
//             </th>
//        </tr>
// </table>

//  <table cellspacing="0" cellpadding="1px" border="0" style="font-size:10px">
//        <tr>
//         <th colspan="3" style="background-color:#f2edd1;font-size:13px;" align="center"><b>PROJECT INFORMATION</b></th>
//        </tr>
//         <tr> 
//             <th>
//              <b>Control Number:</b> {$invoice[0]->contract->contractNumber}
//             </th>
//             <th colspan="2">
//              <b>Address:</b> {$invoice[0]->contract->siteAddress}
//             </th>
//             <th> </th>
//        </tr>
//       <tr> 
//             <th >
//               <b>Type:</b> {$invoice[0]->contract->projectUse->projectUseName} 
//             </th>
//             <th colspan="2">
//               <b>Description:</b> {$invoice[0]->projectDescription->projectDescriptionName}
//             </th>
//            <th> </th>
//        </tr>
// </table>   

//  <table stype="border-collapse: collapse;" cellspacing="0" cellpadding="1px" border="0">
//         <thead>
//         <tr style="background-color:#f2edd1; color:black; font-size:13px;  font-weight: bold;" align="center">
//           <th width="20%" align="center">DATE</th>
//           <th width="35%" align="center">TRANSACTION</th>
//           <th width="22.5%" >AMOUNT</th>
//           <th width="22.5%" align="center">BALANCE</th>
//         </tr>
//         </thead>
//     <tr style="background-color:white; font-size:10px;">
//         <td width="20%" align="center">{$invoice[0]->invoiceDate}</td>
//         <td width="35%" align="left">ORIGINAL AMOUNT - REF. INV. {$invoice[0]->invId}</td>
//         <td width="22.5%" align="center">$symbol 0.00</td>
//         <td width="22.5%" align="center">$symbol {$invoice[0]->netTotal}</td>
//     </tr>
// EOD;


//        $acum = 0 ;
//        $statement = $invoice[0]->netTotal;

//  //// inicio del ciclo de impresion
// foreach ($transactions as $transaction) {
//                $acum = $acum + 1;
//                 if ($acum % 2 != 0) {
//                     $background = "#f2edd1";
//                 } else {
//                     $background = "#fbfbfb";
//                 }

//                    $statement = $statement - $transaction->amount;
//                    $statement = number_format((float)$statement, 2, '.', '');
                   
//                 $html .= <<<EOD
//         <tr style="background-color:$background; font-size:10px;">
//          <td width="20%" align="center">$transaction->transactionDate</td>
//          <td width="35%" align="left"> $transaction->reason</td>
//          <td width="22.5%" align="center">$symbol $transaction->amount</td>
//          <td width="22.5%" align="center">$symbol $statement</td>
//         </tr>
// EOD;
// }// FIN DE FOREACH DE RENGLONES

//    // imprimir footer de factura
//  $html .= <<<EOD
//  </table>
//   <br><br>
//  <table cellspacing="0" cellpadding="1px" border="0" style="font-size:10px">
//        <tr style="background-color:#f2edd1;" align="center">
//         <th ><b>AMOUNT DUE NEXT PAYMENT</b>
//         </th>
//         <th ><b>1-7 DAYS PAST DUE</b>
//         </th>
//         <th ><b>8-15 DAYS PAST DUE</b>
//         </th>
//         <th ><b>OVER 16 DAYS PAST DUE</b>
//         </th>
//        </tr>
//         <tr align="center"> 
//             <th >
//              $symbol {$nextShare}
//             </th>
//             <th>
//              $symbol 0.00
//             </th>   
//               <th>
//              $symbol 0.00
//             </th>  
//                <th>
//              $symbol 0.00
//             </th>     
//        </tr>
// </table>   
//  <br><br>
//  <table cellspacing="0" cellpadding="0" border="0"  >
//        <tr>
//         <th style="background-color:#f2edd1;" colspan="1" align="center"><b>Terms & Conditions</b></th>
//        </tr>

//        <tr style="font-size:10px"> 
//         <th>
//               <b>T&C:</b>
//                   <ul>
// EOD;
// foreach($invoice['0']->note as $note){ 
//  $html .= <<<EOD
//     <li>$note->noteName</li>
// EOD;
// }
//  $html .= <<<EOD
//                   </ul>
//         </th>
//        </tr>
// </table>
// EOD;
//           PDF::setFooterCallback(function($pdf) {
//             // Position at 15 mm from bottom
//             $pdf->SetY(-15);
//             // Set font
//             $pdf->SetFont('helvetica', 'I', 8);
//             $pdf->Cell(0, 9, '© Copyright 2020 JD Rivero Global - All rights reserved ', 0, false, 'C', 0, '', 0, false, 'T', 'M');
//             $pdf->Ln(4);
            
//             $pdf->Cell(0, 9, 'Designed By Rivero Visual Group', 0, false, 'C', 0, '', 0, false, 'T', 'M');
//             // Page number
//             $pdf->Cell(0, 10, 'Page '.$pdf->getAliasNumPage().'/'.$pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
//          });



//             PDF::AddPage();
//             PDF::writeHTML($html, true, false, false, false, '');

//             $fileName = Auth::user()->userName;
//             PDF::SetTitle($fileName);
//             $outputDestination = "F";
//             $outputPdfName     = "pdf/$fileName.pdf";
//             PDF::Output(public_path($outputPdfName), $outputDestination);
    

//             return view('layouts.reports', compact('outputPdfName'));
//         }
//     }


    public function summaryClientForm()
    {
       $clients = $this->oClient->getClientByGroup(session('countryId'),session('companyId'),session('parentCompanyId'),'');
        return view('module_contracts.summaryforclient.index', compact('clients'));
    }
    public function summaryForClient(Request $request)
  {
 //reporte traigo de transaction
        $date            = Carbon::now();
        $company         = DB::table('company')->where('companyId', session('companyId'))->get();
        $invoices        = $this->oInvoice->getAllByClientAndcompany($request->clientId,session('companyId'));
        $client          = $invoices[0]->client;

        if ($invoices->isEmpty()) {
            return view('module_contracts.summaryforclient.error');
        } else {

        $symbol         = $invoices[0]->contract->currency->currencySymbol;

 // imprimir encabezado de statemen
            $html = <<<EOD
    <table cellspacing="0" cellpadding="1px" border="0"  >
       <tr >
        <th style="background-color:#e5db99;font-size:14px;" colspan="3" align="center"><b>STATEMENT</b></th>
       </tr>
 
       <tr style="font-size:9px"> 
         <th width="20%" align="left"> 
          <img style="float:center;" src="img/logo_jd.jpg" alt="test alt attribute" width="170px" height="150px"/>
         </th>
        <th width="54%">
             <div style="text-align:center">
               <strong style="font-size:17px" sty>{$company[0]->companyName}</strong><br>
               <img style="float:center;" src="img/icon-point.png" width="10" height="10"/> {$company[0]->companyAddress}<br>
               <img style="float:center;" src="img/icon-phone.png" width="10" height="10"/> {$company[0]->companyPhone},{$company[0]->companyPhoneOptional}<br>
               <img style="float:center;" src="img/icon-email.png" width="10" height="10"/> {$company[0]->companyEmail}
               <img style="float:center;" src="img/icon-location.png" width="10" height="10"/> {$company[0]->companyWebsite}
             </div>
        </th>
    <th width="30%">
    <br><br>
        <table border="0">
            <tr>
              <td> </td>
              <td> </td>
            </tr>
            <tr>
              <td><b>Statement Date:</b></td>
              <td align="left">{$date->format('m/d/Y')}</td>
            </tr>
         </table>     

        </th>
       </tr>
</table>
       

 <table cellspacing="0" cellpadding="1px" border="0" style="font-size:10px">
       <tr>
        <th colspan="3" style="background-color:#f2edd1;font-size:13px;" align="center"><b>CUSTOMER INFORMATION</b></th>
       </tr>
       <tr> 
            <th colspan="1">
               <b>ID:</b> {$client->clientCode}
            </th>
            <th colspan="2">
              <b>Name:</b> {$client->clientName}
            </th>
       </tr>

      <tr> 
            <th colspan="3">
              <b>Billing Address:</b> {$client->clientAddress}
            </th>
       </tr>

     <tr> 
           <th colspan="2">
               <b>E-mail:</b> {$client->clientEmail}
            </th>
            <th colspan="1">
                   <b>Phone:</b> {$client->clientPhone}
            </th>
       </tr>
</table>
<br><br>
 <table stype="border-collapse: collapse;" cellspacing="0" cellpadding="1px" border="0">
        <thead>
        <tr style="background-color:#f2edd1; color:black; font-size:12px;  font-weight: bold;" align="center">
          <th width="5%" align="center">#</th>
          <th width="25%" align="center">CONTRACT NUMBER</th>
          <th width="10%" align="center">INVOICE</th>
          <th width="15%" align="center">DATE</th>
          <th width="25%" >ORIGINAL AMOUNT</th>
          <th width="20%" align="center">BALANCE DUE</th>
        </tr>
        </thead>
EOD;

       $acum = 0 ;
       $totalOriginalAmount= 0;
       $totalBalance= 0;

 //// inicio del ciclo de impresion
foreach ($invoices as $invoice) {
               $acum = $acum + 1;
                if ($acum % 2 != 0) {
                    $background = "#fbfbfb";
                } else {
                    $background = "#f2edd1";
                }
        $balanceInvoice = $invoice->balanceTotal;

             $totalOriginalAmount += $invoice->netTotal;
             $totalBalance += $balanceInvoice;

                $html .= <<<EOD
        <tr style="background-color:$background; font-size:10px;">
          <td width="5%" align="center">$acum</td>
          <td width="25%" align="center">{$invoice->contract->contractNumber}</td>
          <td width="10%" align="center">#{$invoice->invId}</td>
          <td width="15%" align="center">{$invoice->invoiceDate}</td>
          <td width="25%" align="center">$symbol {$invoice->netTotal}</td>
          <td width="20%" align="center">$symbol {$balanceInvoice}</td>
        </tr>
EOD;
}// FIN DE FOREACH DE RENGLONES
                   $totalOriginalAmount = number_format((float)$totalOriginalAmount, 2, '.', '');
                   $totalBalance = number_format((float)$totalBalance, 2, '.', '');

$html .= <<<EOD
     <tr style="background-color:$background; font-size:10px;">
          <td width="5%" align="center"></td>
          <td width="25%" align="center"></td>
          <td width="10%" align="center"></td>
          <td width="15%" align="center"></td>
          <td width="25%" align="center" style="border-top:2px solid black">$symbol $totalOriginalAmount</td>
          <td width="20%" align="center" style="border-top:2px solid black">$symbol $totalBalance</td>
        </tr>
 </table>
EOD;


          PDF::setFooterCallback(function($pdf) {
            // Position at 15 mm from bottom
            $pdf->SetY(-15);
            // Set font
            $pdf->SetFont('helvetica', 'I', 8);
            $pdf->Cell(0, 9, '© Copyright 2020 JD Rivero Global - All rights reserved ', 0, false, 'C', 0, '', 0, false, 'T', 'M');
            $pdf->Ln(4);
            
            $pdf->Cell(0, 9, 'Designed By Rivero Visual Group', 0, false, 'C', 0, '', 0, false, 'T', 'M');
            // Page number
            $pdf->Cell(0, 10, 'Page '.$pdf->getAliasNumPage().'/'.$pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
         });



            PDF::AddPage();
            PDF::writeHTML($html, true, false, false, false, '');

            $fileName = Auth::user()->userName;
            PDF::SetTitle($fileName);
            $outputDestination = "F";
            $outputPdfName     = "pdf/$fileName.pdf";
            PDF::Output(public_path($outputPdfName), $outputDestination);
    

            return view('layouts.reports', compact('outputPdfName'));
        }
    }

    
}
