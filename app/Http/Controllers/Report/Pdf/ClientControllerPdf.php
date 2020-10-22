<?php

namespace App\Http\Controllers\Report\Pdf;

use Auth;
use DB;
use App\Client;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;

class ClientControllerPdf extends Controller
{
    private $oClient;

    public function __construct()
    {
        $this->middleware('auth');
        $this->oClient          = new Client;
    }

   public function printClient(Request $request)
    {
       $date            = Carbon::now();
       $company     = DB::table('company')->where('companyId', session('companyId'))->get();
       $clients     = $this->oClient->getClientByCompany(session('companyId'),'');

       // $invoice     = $this->oInvoice->findById($receivables[0]->invoiceId,session('countryId'),session('companyId'));
       // $symbol      = $invoice[0]->contract->currency->currencySymbol;
      
       $data = [
        'date'  => $date,
        'company'  => $company,
        'clients'  => $clients,
         ];

       return PDF::loadView('module_contracts.reports.printClients', $data)->stream('Client Report.pdf');

    }

}//end class

