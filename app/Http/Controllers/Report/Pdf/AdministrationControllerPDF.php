<?php

namespace App\Http\Controllers\Report\Pdf;

use App\Receivable;
use App\Client;
use App\Proposal;
use App\ProposalDetail;
use App\Invoice;
use App\InvoiceDetail;
use App\Transaction;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use Barryvdh\DomPDF\Facade as PDF;

class AdministrationControllerPDF extends Controller
{
    private $oReceivable;
    private $oClient;
    private $oInvoice;
    private $oInvoiceDetail;  
    private $oProposal;
    private $oProposalDetail;

    public function __construct()
    {
        $this->middleware('auth');
        $this->oReceivable      = new Receivable;
        $this->oClient          = new Client;
        $this->oProposal        = new Proposal;
        $this->oProposalDetail  = new ProposalDetail;
        $this->oInvoice         = new Invoice;
        $this->oInvoiceDetail   = new InvoiceDetail;
        $this->oTransaction   = new Transaction;
    }


  public function printProposal(Request $request)
{
   $pdf = app('dompdf.wrapper');

        $date             = Carbon::now();
        $company           = DB::table('company')->where('companyId', session('companyId'))->get();
        $proposal         = $this->oProposal->findById($request->id,session('countryId'),session('companyId'));
        $proposalsDetails = $this->oProposalDetail->getAllByProposal($request->id);
        $client           = $this->oClient->findById($proposal[0]->clientId,session('countryId'));
        
        if($proposal[0]->precontract){
           $moneySymbol = $proposal[0]->precontract->currency->currencySymbol;
           $modelId = $proposal[0]->precontract->preId;
           $modelType = 'precontract';
           $modelTypeView = 'Precontract';
        }else{
           $moneySymbol = $proposal[0]->contract->currency->currencySymbol;
           $modelId = $proposal[0]->contract->contractNumber;
           $modelType = 'contract';
           $modelTypeView = 'Contract';

        }

      //dispara error si cuotas son mayores que el monto neto de la propuesta para que el usuario ajuste cuotas.
       $paymentSum = 0;
        foreach ($proposal[0]->paymentProposal as $paymentProposal) {
            $paymentSum += $paymentProposal->amount;
        }

       if($paymentSum > $proposal[0]->netTotal){
                $notification = array(
                    'message'    => 'Error: Las cuotas no corresponden con el precio de la propuesta, debe ajustar cuotas.',
                    'alert-type' => 'error',
                );
             return redirect()->back()->with($notification);
         }
        //si no tiene renglones la propuesta disparar error
        elseif ($proposalsDetails->isEmpty()) {
            // return view('module_administration.reportincomeexpenses.error');
                 $notification = array(
                    'message'    => 'Error: Debe llenar renglones de Propuesta',
                    'alert-type' => 'error',
                );
             return redirect()->back()->with($notification);
        } else {

            $data = [
                 'date'  => $date,
                 'company'  => $company,
                 'proposal'  => $proposal,
                 'proposalsDetails'  => $proposalsDetails,
                 'client'  => $client,
                 'moneySymbol'  => $moneySymbol,
                 'modelId' => $modelId,
                 'modelType' => $modelType,
                 'modelTypeView' => $modelTypeView,
                 'pdf' => $pdf,
                      ];


       return PDF::loadView('module_administration.reports.printProposal', $data)->stream('P - '.$proposal[0]->$modelType->siteAddress.'.pdf');
        } //end else
    } //end printProposal 

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
        'pdf' => $pdf,
        'status'  => $status,
         ];

       return PDF::loadView('module_administration.reports.printInvoice', $data)->stream('I - '.$invoice[0]->contract->siteAddress.'.pdf');
        } // end else
   } //end printInvoice


public function printReceipt(Request $request)
    {
      $pdf = app('dompdf.wrapper');

       $receivables = $this->oReceivable->findById($request->receivableId);
       $company     = DB::table('company')->where('companyId', session('companyId'))->get();
       $invoice     = $this->oInvoice->findById($receivables[0]->invoiceId,session('countryId'),session('companyId'));
       $symbol      = $invoice[0]->contract->currency->currencySymbol;
      
       $data = [
        'company'  => $company,
        'invoice'  => $invoice,
        'receivables'  => $receivables,
        'symbol'  => $symbol,
        'pdf'  => $pdf,
         ];

       return PDF::loadView('module_administration.reports.printReceipt', $data)->stream('Receipt.pdf');

            // return view('layouts.reports', compact('outputPdfName'));
    }


//------------------INVOICE STATEMENT-----------------------------//
     public function printStatement(Request $request)
    {
      $pdf = app('dompdf.wrapper');

 //reporte trae de transaction
        $date         = Carbon::now();
        $company       = DB::table('company')->where('companyId', session('companyId'))->get();

        $invoice        = $this->oInvoice->findById($request->id,session('countryId'),session('companyId'));
        $client         = $this->oClient->findById($invoice[0]->clientId,session('countryId'));
        $transactions   = $this->oTransaction->getAllByInvoice($request->id,session('countryId'),session('companyId'));
        $share          = $this->oReceivable->sharePending($request->id);

         if($share->isEmpty()){
            $nextShare = '0.00';
         }else{
            $nextShare = $share[0]->amountDue;
         }

        $symbol = $invoice[0]->contract->currency->currencySymbol;

        if ($invoice->isEmpty()) {
             $notification = array(
                    'message'    => 'Error: Esta vacia la Factura',
                    'alert-type' => 'error',
                );
             return redirect()->back()->with($notification);
        } else {

        $data = [
          'date'=> $date,
          'company'  => $company,
          'client'  => $client,
          'invoice'  => $invoice,
          'transactions'  => $transactions,
          'nextShare'  => $nextShare,
          'symbol'  => $symbol,
          'pdf'  => $pdf,
         ];

       return PDF::loadView('module_administration.reports.printStatement', $data)->stream('Statement - '.$invoice[0]->contract->siteAddress.'.pdf');
      }
    }

public function printReceivables(Request $request)
    {
      $pdf = app('dompdf.wrapper');

       $date         = Carbon::now();
       $invoices = $this->oInvoice->getAllByTwoStatus(INVOICE::OPEN,INVOICE::CLOSED,session('companyId'));
       foreach ($invoices as $invoice) {
           $invoice->balance = $this->oInvoice->getBalance($invoice->invoiceId);
        }
       $company     = DB::table('company')->where('companyId', session('companyId'))->get();
       $symbol      = $invoices[0]->contract->currency->currencySymbol;
      
       $data = [
        'date' => $date,
        'company'  => $company,
        'invoices'  => $invoices,
        'symbol'  => $symbol,
        'pdf'  => $pdf,
         ];

       return PDF::loadView('module_administration.reports.printReceivables', $data)->stream('Receivables.pdf');

            // return view('layouts.reports', compact('outputPdfName'));
    }


public function printPaymentRequest(Request $request)
    {
      $pdf = app('dompdf.wrapper');
      
       $receivable = $this->oReceivable->findById($request->receivableId);
       $invoice    = $receivable[0]->invoice;
       $symbol      = $invoice->contract->currency->currencySymbol;

       $company     = DB::table('company')->where('companyId', session('companyId'))->get();
      
      
       $data = [
        'receivable'  => $receivable,
        'invoice'  => $invoice,
        'symbol'  => $symbol,
        'company'  => $company,
        'pdf'  => $pdf,
         ];

       return PDF::loadView('module_administration.reports.printPaymentRequest', $data)->stream('PaymentRequest.pdf');
    }

}//end class

