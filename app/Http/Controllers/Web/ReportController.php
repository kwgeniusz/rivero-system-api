<?php

namespace App\Http\Controllers\Web;

use App\Contract;
use App\Http\Controllers\Controller;
use App\Receivable;
use App\Transaction;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use PDF;

class ReportController extends Controller
{
    private $oContract;

    public function __construct()
    {
        $this->middleware('auth');
        $this->oContract    = new Contract;
        $this->oTransaction = new Transaction;
        $this->oReceivable  = new Receivable;

    }

    public function printContract(Request $request)
    {
        $date     = Carbon::now();
        $contract = $this->oContract->findById($request->contractNumber);

        $contractNumber = __('contract');

        $tbl = <<<EOD
 <p>
      <table cellspacing="0" cellpadding="0" border="0">
        <tr>
        <th> <img style="float:left;" src="img/RGC_LOGO.jpg" alt="test alt attribute" width="150" height="90"/></th>
        <th> <br><br><br><br><h3 style="text-align:center"> Reporte de Contrato</h3></th>
        <th>
        <p style="text-align:right">
         <b>Fecha:</b> {$date->format('d/m/y')}<br>
         </p>
        </th>
       </tr>
       </table>
         <br><br>

<div style="width:10%">
 <b>  N°{$contractNumber} :</b> {$contract[0]->contractNumber}<br>
 <b>  Pais :</b> {$contract[0]->country->countryName} -
 <b>  Oficina:</b> {$contract[0]->office->officeName}<br />
 <b>  Fecha de Contrato:</b> {$contract[0]->contractDate}<br />
 <b>  Cliente:</b> {$contract[0]->client->clientName}<br />
 <b>  Direccion:</b> {$contract[0]->siteAddress}<br />
 <b>  Descripcion de Proyecto:</b> {$contract[0]->projectType->projectTypeName}<br />
 <b>  Tipo de Proyecto:</b> {$contract[0]->serviceType->serviceTypeName}<br />
 <b>  N° de Registro:</b> {$contract[0]->registryNumber}<br />
 <b>  Fecha de inicio:</b>  {$contract[0]->startDate}<br />
 <b>  Fecha estimada de Finalizacion:</b> {$contract[0]->scheduledFinishDate}<br />
 <b>  Fecha de Finalizacion:</b> {$contract[0]->actualFinishDate}<br />
 <b>  Fecha de Entrega:</b> {$contract[0]->deliveryDate}<br />
 <b>  Comentario Inicial:</b> {$contract[0]->initialComment}<br />
 <b>  Comentario Intermedio:</b> {$contract[0]->intermediateComment}<br />
 <b>  Comentario Final:</b> {$contract[0]->finalComment}<br />
 <b>  Estado del Contrato:</b> {$contract[0]->contractStatus}<br />
</div

EOD;

        $fileName = Auth::user()->userName;
        PDF::SetTitle($fileName);
        PDF::AddPage();
        PDF::writeHTML($tbl, true, false, false, false, '');
        // PDF::Write(0, 'Hello World');
        $outputDestination = "F";
        $outputPdfName     = "pdf\ $fileName.pdf";
        PDF::Output(public_path($outputPdfName), $outputDestination);

        return view('contractprint.result', compact('outputPdfName'));
    }

    public function summaryContract(Request $request)
    {
        $acum       = 0;
        $background = "";
        $date       = Carbon::now();
        $contracts  = $this->oContract->findByOffice($request->officeId);

        $html = <<<EOD
      <p>
        <table cellspacing="0" cellpadding="0" border="0">
        <tr>
        <th> <img style="float:left;" src="img/RGC_LOGO.jpg" alt="test alt attribute" width="150" height="90"/></th>
        <th> <br><br><br><br><h3 style="text-align:center"> Resumen por Oficina</h3></th>
        <th>
        <p style="text-align:right">
         <b>Fecha:</b> {$date->format('d/m/y')}<br>
         <b>Oficina:</b> {$contracts[0]->office->officeName}
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
        $outputPdfName     = "pdf\ $fileName.pdf";
        PDF::Output(public_path($outputPdfName), $outputDestination);

        return view('contractsummary.result', compact('outputPdfName'));
    }

    public function summaryForClient(Request $request)
    {
        $acum       = 0;
        $background = "";
        $date       = Carbon::now();
        $contracts  = $this->oContract->findByClient($request->clientId);

        $html = <<<EOD
        <p>
      <table cellspacing="0" cellpadding="0" border="0">
        <tr>
        <th> <img style="float:left;" src="img/RGC_LOGO.jpg" alt="test alt attribute" width="150" height="90"/></th>
        <th> <br><br><br><br><h3 style="text-align:center"> Resumen por Cliente</h3></th>
        <th>
        <p style="text-align:right">
         <b>Fecha:</b> {$date->format('d/m/y')}<br>
         <b>Cliente:</b> {$contracts[0]->client->clientName}
         </p>
        </th>
       </tr>
       </table>
         <br><br>

        <table cellspacing="0" cellpadding="0" border="0" >
        <thead>
        <tr style="background-color:#3366cc; color:white; font-size:11px;  font-weight: bold;" align="center">
        <th width="15%">CONTRATO</th><th width="10%">FECHA</th><th align="left">OFICINA</th><th align="left">DIRECCION</th><th align="left" width="35%">DESCRIPCION</th>
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
        <td align="left">{$contract->office->officeName}</td>
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
        $outputPdfName     = "pdf\ $fileName.pdf";
        PDF::Output(public_path($outputPdfName), $outputDestination);

        return view('summaryforclient.result', compact('outputPdfName'));
    }

    //REPORT DE TRANSACTION

    public function transactionsSummary(Request $request)
    {
        $acum         = 0;
        $background   = "";
        $date         = Carbon::now();
        $transactions = $this->oTransaction->getAllForTwoDate($request->date1, $request->date2);

        if ($transactions->isEmpty()) {
            return view('reportincomeexpenses.error');
        } else {

            $html = <<<EOD

        <p>
        <table cellspacing="0" cellpadding="0" border="0">
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
         <tr style="background-color:$background">
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
            $outputPdfName     = "pdf\ $fileName.pdf";
            PDF::Output(public_path($outputPdfName), $outputDestination);

            return view('reportincomeexpenses.result', compact('outputPdfName'));
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
        $transactions = $this->oTransaction->getAllForTwoDateAndSign($request->date1, $request->date2, $request->sign);

        if ($transactions->isEmpty()) {
            if ($request->sign == '+') {
                return view('reportincome.error');
            } else {
                return view('reportexpenses.error');
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
        <tr style="background-color:$background">
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
            $outputPdfName     = "pdf\ $fileName.pdf";
            PDF::Output(public_path($outputPdfName), $outputDestination);

            return view('reportincome.result', compact('outputPdfName'));
        }
    }
/////////////////COBRANZAS//////////////////////
    public function collections(Request $request)
    {

        $background = "";

        $collections = $this->oReceivable->collections($request->countryId, $request->date1, $request->date2);
        $country     = DB::table('country')->where('countryId', $request->countryId)->get(['countryName', 'currencyName']);

        $date        = Carbon::now();
        $date1Format = Carbon::parse($request->date1);
        $date2Format = Carbon::parse($request->date2);

        if (!$collections) {
            return view('reportcollections.error');
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
         <b>Moneda:</b> {$country[0]->currencyName}<br>
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
        <th width="25%" align="left">CLIENTE</th>
        <th width="15%">FECHA</th>
        <th width="10%" align="right">MONTO</th>
        <th width="40%" align="center">TIPO DE PAGO</th>
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
                    $receivable->amountPaid += $receivable->amountPercentaje;
                    //colores de filas table

                    $html .= <<<EOD
        <tr style="background-color:$background">
        <td width="5%" align="center">$receivable->receivableId</td>
        <td width="25%" align="left">{$receivable->client[0]->clientName}</td>
        <td width="15%"align="center">$receivable->datePaid</td>
        <td width="10%" align="right">$receivable->amountPaid</td>
        <td width="40%" align="center">$receivable->collectMethod</td>
        </tr>
EOD;
                    $subtotal += $receivable->amountPaid; //sumando cuotas para subtotal

                } //cierre foreach interno
                $html .= <<<EOD
        <tr style="background-color:#B0F0BF">
        <td width="5%" align="center"> </td>
        <td width="25%" align="left"> </td>
        <td width="15%" align="center"><b>Sub-Total</b> </td>
        <td width="10%" align="right"> $subtotal </td>
        <td width="40%" align="center"> </td>
        </tr>
EOD;
                $total += $subtotal;

            } //cierre foreach externo
            $html .= <<<EOD
        <tr>
        <td width="5%" align="center"> </td>
        <td width="25%" align="left"> </td>
        <td width="15%" align="center"> <b>Total:</b></td>
        <td width="10%" align="right">$total </td>
        <td width="40%" align="center"> </td>
        </tr>
</table>
EOD;

            $fileName = Auth::user()->userName;
            PDF::SetTitle($fileName);
            PDF::AddPage();
            PDF::writeHTML($html, true, false, false, false, '');
            // PDF::Write(0, 'Hello World');
            $outputDestination = "F";
            $outputPdfName     = "pdf\ $fileName.pdf";
            PDF::Output(public_path($outputPdfName), $outputDestination);

            return view('reportincome.result', compact('outputPdfName'));
        }
    }

}
