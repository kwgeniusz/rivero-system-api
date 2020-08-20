<?php

namespace App\Http\Controllers\Report\Pdf;

use App\Receivable;
use App\Client;
use App\Invoice;
use App\InvoiceDetail;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Barryvdh\DomPDF\Facade as PDF;

class InvoiceControllerPDF extends Controller
{
    private $oReceivable;
    private $oClient;
    private $oInvoice;
    private $oInvoiceDetail;  

    public function __construct()
    {
        $this->middleware('auth');
        $this->oReceivable  = new Receivable;
        $this->oClient      = new Client;
        $this->oInvoice     = new Invoice;
        $this->oInvoiceDetail = new InvoiceDetail;

    }
 
     public function printInvoice(Request $request)
  {
      $pdf = app('dompdf.wrapper');

        $date            = Carbon::now();
        $company         = DB::table('company')->where('companyId', session('companyId'))->get();
        $invoice         = $this->oInvoice->findById($request->id,session('countryId'),session('companyId'));
        $client          = $invoice[0]->client;
        $receivables     = $invoice[0]->receivable;
        $invoicesDetails = $this->oInvoiceDetail->getAllByInvoice($request->id);

        $symbol = $invoice[0]->contract->currency->currencySymbol;

        // \PHPQRCode\QRcode::png($client[0]->clientCode, public_path('img/codeqr.png'), 'L', 4, 2);

  if($invoice[0]->invStatusCode == Invoice::OPEN || $invoice[0]->invStatusCode == Invoice::CLOSED || $invoice[0]->invStatusCode == Invoice::COLLECTION){
     $status = '- COPY';
  }elseif($invoice[0]->invStatusCode == Invoice::PAID){
     $status = '';
  }
        if ($invoicesDetails->isEmpty()) {
                 $notification = array(
                    'message'    => 'Error: Debe agregar renglones a la Factura',
                    'alert-type' => 'error',
                );
             return redirect()->back()->with($notification);
        }else {

       $data = [
        'date'  => $date,
        'company'  => $company,
        'invoice'  => $invoice,
        'client'  => $client,
        'receivables'  => $receivables,
        'invoicesDetails'  => $invoicesDetails,
        'symbol'  => $symbol,
        'status'  => $status
         ];

       return PDF::loadView('module_administration.reports.printInvoice', $data)->stream('I - '.$invoice[0]->contract->siteAddress.'.pdf');
        } // end else
   } //end printInvoice

} //end of class