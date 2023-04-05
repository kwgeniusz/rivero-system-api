<?php

namespace App\Http\Controllers\Report\Pdf;

use App\Models\Inventory\ServiceCategory;
use App\Receivable;
use App\Client;
use App\Proposal;
use App\ProposalDetail;
use App\Invoice;
use App\InvoiceDetail;
use App\Transaction;
use App\SaleNote;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use Barryvdh\DomPDF\Facade as PDF;

class AdministrationControllerPDF extends Controller
{
    private $oServiceCategory;
    private $oReceivable;
    private $oClient;
    private $oInvoice;
    private $oInvoiceDetail;  
    private $oProposal;
    private $oProposalDetail;
    private $oSaleNote;

    public function __construct()
    {
        $this->middleware('auth');
        $this->oServiceCategory = new ServiceCategory;
        $this->oReceivable      = new Receivable;
        $this->oClient          = new Client;
        $this->oProposal        = new Proposal;
        $this->oProposalDetail  = new ProposalDetail;
        $this->oInvoice         = new Invoice;
        $this->oInvoiceDetail   = new InvoiceDetail;
        $this->oTransaction     = new Transaction;
        $this->oSaleNote        = new SaleNote;
    }


  public function printProposal(Request $request)
{
   $pdf = app('dompdf.wrapper');

   $company           = DB::table('company')->where('companyId', session('companyId'))->get();
   $proposal          = $this->oProposal->findById($request->id,session('countryId'),session('companyId'));
   $proposalDetails   = $this->oProposalDetail->showAllCompanyCategoriesHierarchicalMode(session('companyId'), $proposal[0]->proposalId);
   if($proposalDetails->isEmpty()){
      $proposalDetails   = $proposal[0]->proposalDetail;
   }
   $client            = $proposal[0]->client;
   $date              = Carbon::parse($proposal[0]->proposalDate)->format('F jS, Y');  
  
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
        elseif ($proposalDetails->isEmpty()) {
            // return view('module_administration.reportincomeexpenses.error');
                 $notification = array(
                    'message'    => 'Error: Debe llenar renglones de Propuesta',
                    'alert-type' => 'error',
                );
             return redirect()->back()->with($notification);
        } else {
   //   dd($proposalDetails);
   //   exit();
            $data = [
                 'date'  => $date,
                 'company'  => $company,
                 'proposal'  => $proposal,
                 'proposalDetails'  => $proposalDetails,
                 'client'  => $client,
                 'moneySymbol'  => $moneySymbol,
                 'modelId' => $modelId,
                 'modelType' => $modelType,
                 'modelTypeView' => $modelTypeView,
                 'pdf' => $pdf,
                ];
               //  dd($data);
               //  dd($proposal[0]->$modelType->siteAddress);

       if ($proposalDetails[0] instanceof ProposalDetail ) {
          return PDF::loadView('module_administration.reports.printProposal_2022', $data)->stream('P - '.$proposal[0]->$modelType->siteAddress.'.pdf');
       } else {
          return PDF::loadView('module_administration.reports.printProposal', $data)->stream('P - '.$proposal[0]->$modelType->siteAddress.'.pdf');
       }
       
      
      
      } //end else
    } //end printProposal 

 public function printInvoice(Request $request)
  {
      $pdf = app('dompdf.wrapper');

        $date            = Carbon::now();
        $company         = DB::table('company')->where('companyId', session('companyId'))->get();
        $invoice         = $this->oInvoice->findById($request->id,session('countryId'),session('companyId'));
        $invoiceDetails  = $this->oInvoiceDetail->showAllCompanyCategoriesHierarchicalMode(session('companyId'), $invoice[0]->invoiceId);
         
        if($invoiceDetails->isEmpty()){
            $invoiceDetails   = $invoice[0]->invoiceDetails;
          }

        $client          = $invoice[0]->client;
        $payments        = $invoice[0]->shareSucceed;

        $symbol          = $invoice[0]->contract->currency->currencySymbol;

        // \PHPQRCode\QRcode::png($client[0]->clientCode, public_path('img/codeqr.png'), 'L', 4, 2);

  if($invoice[0]->invStatusCode == Invoice::OPEN      ||
     $invoice[0]->invStatusCode == Invoice::CLOSED    || 
     $invoice[0]->invStatusCode == Invoice::CANCELLED || 
     $invoice[0]->invStatusCode == Invoice::COLLECTION) {

     $status = '- COPY';

  }elseif($invoice[0]->invStatusCode == Invoice::PAID) {
     $status = '';
  }

        if ($invoiceDetails->isEmpty()) {
                 $notification = array(
                    'message'    => 'Error: Debe agregar renglones a la Factura',
                    'alert-type' => 'error',
                );
             return redirect()->back()->with($notification);
        }else {

       $data = [
        'date'        => $date,
        'client'      => $client,
        'company'     => $company,
        'invoice'     => $invoice,
        'invoiceDetails'  => $invoiceDetails,
        'payments'    => $payments,
        'symbol'      => $symbol,
        'pdf'         => $pdf,
        'status'      => $status,
         ];
          
          
        if($invoiceDetails[0] instanceof InvoiceDetail ) {
           return PDF::loadView('module_administration.reports.printInvoice_2022', $data)->stream('I - '.$invoice[0]->contract->siteAddress.'.pdf');
        } else {
           return PDF::loadView('module_administration.reports.printInvoice', $data)->stream('I - '.$invoice[0]->contract->siteAddress.'.pdf');
        }

      } // end else
   } //end printInvoice


public function printReceipt(Request $request)
    {
      $pdf = app('dompdf.wrapper');

      //  $receivables = $this->oReceivable->findById($request->receivableId);
       $company     = DB::table('company')->where('companyId', session('companyId'))->get();
       $receivables = $this->oReceivable->findById($request->receivableId);
       $invoice     = $this->oInvoice->findById($receivables[0]->invoiceId,session('countryId'),session('companyId'));
       $symbol      = $invoice[0]->contract->currency->currencySymbol;
      
       $data = [
        'company'  => $company,
        'invoice'  => $invoice,
        'receivables'  => $receivables,
        'symbol'  => $symbol,
        'pdf'     => $pdf,
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
        $client         = $this->oClient->findById($invoice[0]->clientId,session('companyId'));
        $transactions   = $this->oTransaction->getAllWithSaleNotesByInvoice($request->id,session('countryId'),session('companyId'));

        $share          = $invoice[0]->sharePending;

         if($share->isEmpty()){
            $nextShare = '0.00';
         }else{
              $nextShare = $share->first()->amountDue;
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
       // foreach ($invoices as $invoice) {
       //     $invoice->balance = $this->oInvoice->getBalance($invoice->invoiceId);
       //  }
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


// ----------------SALE NOTES---------------
     public function printCreditNote(Request $request)
  {
      $pdf = app('dompdf.wrapper');

        $date              = Carbon::now();
        $company           = DB::table('company')->where('companyId', session('companyId'))->get();
        $creditNote        = $this->oSaleNote->findById($request->id);
        $creditNoteDetails = $creditNote[0]->saleNoteDetails;
        $client            = $creditNote[0]->client;

        $symbol = $creditNote[0]->invoice->contract->currency->currencySymbol;

        // \PHPQRCode\QRcode::png($client[0]->clientCode, public_path('img/codeqr.png'), 'L', 4, 2);
          $data = [
           'date'  => $date,
           'company'  => $company,
           'creditNote'  => $creditNote,
           'client'  => $client,
           'creditNoteDetails'  => $creditNoteDetails,
           'symbol'  => $symbol,
          // 'status'  => $status
           ];

      return PDF::loadView('module_administration.reports.printCreditNote', $data)->stream('CreditNote.pdf');

   } //end printInvoice

     public function printDebitNote(Request $request)
  {
      $pdf = app('dompdf.wrapper');

        $date              = Carbon::now();
        $company           = DB::table('company')->where('companyId', session('companyId'))->get();
        $debitNote        = $this->oSaleNote->findById($request->id);
        $debitNoteDetails = $debitNote[0]->saleNoteDetails;
        $client            = $debitNote[0]->client;
        $symbol = $debitNote[0]->invoice->contract->currency->currencySymbol;
             
          $data = [
           'date'         => $date,
           'company'      => $company,
           'debitNote'   => $debitNote,
           'client'  => $client,
           'debitNoteDetails'  => $debitNoteDetails,
           'symbol'  => $symbol,
          // 'status'  => $status
           ];

      if($debitNote[0]->concept == SALENOTE::DEBIT_APPEND_SERVICES) {
         return PDF::loadView('module_administration.reports.printDebitNote', $data)->stream('DebitNote.pdf');
      }elseif($debitNote[0]->concept == SALENOTE::DEBIT_COMMISSIONS){
         return PDF::loadView('module_administration.reports.printDebitNoteShort', $data)->stream('DebitNote.pdf');
      }
    
  
   } //end printInvoice

   public function printExpenses(Request $request)
   {
      $pdf         = app('dompdf.wrapper');
      $date        = Carbon::now();
      $company     = DB::table('company')->where('companyId', session('companyId'))->get();
       
 
      $data = [
       'date'         => $date,
       'company'      => $company,
       'transactions' => $request->transactions,
       'dateRange'    => $request->dateRange,
       'pdf'          => $pdf,
        ];
      //   dd($data);
      //   exit();
        
      return PDF::loadView('module_administration.reports.printExpenses', $data)->stream('Expenses.pdf');
   }  
   public function printIncomes(Request $request)
   {
      $pdf         = app('dompdf.wrapper');
      $date        = Carbon::now();
      $company     = DB::table('company')->where('companyId', session('companyId'))->get();
       
 
      $data = [
       'date'         => $date,
       'company'      => $company,
       'transactions' => $request->transactions,
       'dateRange'    => $request->dateRange,
       'pdf'          => $pdf,
        ];

      return PDF::loadView('module_administration.reports.printIncomes', $data)->stream('Incomes.pdf');
   }  
//REPORTE QUE SUMA LA CANTIDAD DE CONTRATOS POR STATUS Y SU MONTO CONTRATADO, MONTO POR COBRADO, Y POR COBRAR.

   public function printTotalContracts(Request $request)
 {
   $pdf         = app('dompdf.wrapper');
   $date        = Carbon::now();
   $company     = DB::table('company')->where('companyId', session('companyId'))->get();
    
   $data = [
    'date'         => $date,
    'company'      => $company,
    'transactions' => $request->transactions,
    'dateRange'    => $request->dateRange,
    'pdf'          => $pdf,
     ];
     
   return PDF::loadView('module_administration.reports.printTotalContracts', $data)->stream('Total Contracts.pdf');
 }  

}//end class

