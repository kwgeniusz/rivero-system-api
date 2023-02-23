<?php

namespace App\Http\Controllers\Report\Pdf;

use Auth;
use DB;
use Carbon\Carbon;
use App\Country;
use App\Company;
use App\Models\Accounting\GeneralLedger;
use App\Models\Accounting\AccountClassification;
use App\Models\Accounting\Transaction;
use App\Models\Accounting\TransactionHeader;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;

class AccountingControllerPDF extends Controller
{
    private $oTransaction;
    private $oGeneralLedger;

    public function __construct()
    {
        $this->middleware('auth');
        $this->oTransaction     = new Transaction;
        $this->oGeneralLedger     = new GeneralLedger;
    }

   public function printEntries(Request $request)
   {
      $pdf         = app('dompdf.wrapper');
      $dateToday   = Carbon::now();
      $country     = Country::find(session('countryId'));
      $company     = Company::find(session('companyId'));

      $date1 = Carbon::parse($request->receivedData['date1']);
      $date2 = Carbon::parse($request->receivedData['date2']);
      $selectedCurrency = $request->receivedData['currency'];

      if($selectedCurrency == 'primary'){
         $currency =  $country->countryConfiguration->primaryCurrency;
      }else{
         $currency =  $country->countryConfiguration->secondaryCurrency;
      }


      $rs = TransactionHeader::with('transaction.generalLedger')
                              ->where('entryDate', '>=', $request->receivedData['date1'])
                              ->where('entryDate', '<=', $request->receivedData['date2'])
                              ->where('companyId', '=', session('companyId'))
                              ->orderBy('headerId', 'DESC')
                              ->get();

       if($rs->isEmpty()) {
          $returnData = array('alert' => 'error', 'message' => 'No existen Registros para Este Rango de Fecha, escoja otro.');
          return \Response::json($returnData, 500);
        }
      $data = [
       'dateToday'         => $dateToday,
       'company'      => $company,
       'rs'           => $rs,
       'date1'        => $date1,
       'date2'        => $date2,
       'selectedCurrency'   => $selectedCurrency,
       'currency'   => $currency,
       
       'modelReport'  => $request->modelReport,
       'pdf'          => $pdf,
        ];
     
      return PDF::loadView('module_accounting.reports.printAccEntries', $data)->stream('Accounting Entries.pdf');
   }  
   public function printGeneralLedger(Request $request)
   {
      $pdf         = app('dompdf.wrapper');
      $country     = Country::find(session('countryId'));
      $company     = Company::find(session('companyId'));
      $date        = Carbon::now();
      $selectedCurrency = $request->receivedData['currency'];

      $dateFormat = "{$request->receivedData['year']}-{$request->receivedData['month']}-1";
      $lastDayOfTheMonth = Carbon::parse($dateFormat)->endOfMonth();
      
      $generalLedgers = $this->oGeneralLedger->getAllWithBalanceByYear(session('companyId'),$request->receivedData['year']);
      
      if($selectedCurrency == 'primary'){
         $currency =  $country->countryConfiguration->primaryCurrency;
      }else{
         $currency =  $country->countryConfiguration->secondaryCurrency;
      }

       foreach ($generalLedgers as $key => $generalLedger) {
        
         if($selectedCurrency == 'primary'){
            $debitTotal  = $generalLedger->initialDebit;
            $creditTotal = $generalLedger->initialCredit;   
         }else{
            $debitTotal  = $generalLedger->initialDebitSec;
            $creditTotal = $generalLedger->initialCreditSec;    
         }


          for ($i=1; $i <= $request->receivedData['month']; $i++) { 

            if($selectedCurrency == 'primary'){
               
            switch ($i) { 
               case 1:
                  $debitTotal  += $generalLedger->debit01;
                  $creditTotal += $generalLedger->credit01;
               break;
               case 2:
                  $debitTotal  += $generalLedger->debit02;
                  $creditTotal += $generalLedger->credit02;
               break;
               case 3:
                  $debitTotal  += $generalLedger->debit03;
                  $creditTotal += $generalLedger->credit03;
               break;
               case 4:
                  $debitTotal  += $generalLedger->debit04;
                  $creditTotal += $generalLedger->credit04;
               break;
               case 5:
                  $debitTotal  += $generalLedger->debit05;
                  $creditTotal += $generalLedger->credit05;
               break;
                  case 6:
                  $debitTotal  += $generalLedger->debit06;
                  $creditTotal += $generalLedger->credit06;
               break;
                  case 7:
                   $debitTotal  += $generalLedger->debit07;
                   $creditTotal += $generalLedger->credit07;
               break;
                  case 8:
                     $debitTotal  += $generalLedger->debit08;
                     $creditTotal += $generalLedger->credit08;
               break;
                 case 9:
                  $debitTotal  += $generalLedger->debit09;
                  $creditTotal += $generalLedger->credit09;
               break;
                  case 10:
                     $debitTotal  += $generalLedger->debit10;
                     $creditTotal += $generalLedger->credit10;
               break;
                 case 11:
                  $debitTotal  += $generalLedger->debit11;
                  $creditTotal += $generalLedger->credit11;
               break;
                  case 12:
                     $debitTotal  += $generalLedger->debit12;
                     $creditTotal += $generalLedger->credit12;
               break;
             // hasta el mes 12
           } //end of switch
         }else{
            switch ($i) { 
               case 1:
                  $debitTotal  += $generalLedger->debit01Sec;
                  $creditTotal += $generalLedger->credit01Sec;
               break;
               case 2:
                  $debitTotal  += $generalLedger->debit02Sec;
                  $creditTotal += $generalLedger->credit02Sec;
               break;
               case 3:
                  $debitTotal  += $generalLedger->debit03Sec;
                  $creditTotal += $generalLedger->credit03Sec;
               break;
               case 4:
                  $debitTotal  += $generalLedger->debit04Sec;
                  $creditTotal += $generalLedger->credit04Sec;
               break;
               case 5:
                  $debitTotal  += $generalLedger->debit05Sec;
                  $creditTotal += $generalLedger->credit05Sec;
               break;
                  case 6:
                  $debitTotal  += $generalLedger->debit06Sec;
                  $creditTotal += $generalLedger->credit06Sec;
               break;
                  case 7:
                   $debitTotal  += $generalLedger->debit07Sec;
                   $creditTotal += $generalLedger->credit07Sec;
               break;
                  case 8:
                     $debitTotal  += $generalLedger->debit08Sec;
                     $creditTotal += $generalLedger->credit08Sec;
               break;
                 case 9:
                  $debitTotal  += $generalLedger->debit09Sec;
                  $creditTotal += $generalLedger->credit09Sec;
               break;
                  case 10:
                     $debitTotal  += $generalLedger->debit10Sec;
                     $creditTotal += $generalLedger->credit10Sec;
               break;
                 case 11:
                  $debitTotal  += $generalLedger->debit11Sec;
                  $creditTotal += $generalLedger->credit11Sec;
               break;
                  case 12:
                     $debitTotal  += $generalLedger->debit12Sec;
                     $creditTotal += $generalLedger->credit12Sec;
               break;
           } //end of switch
         } // end of else


       } //end of for

         //  LOGICA DE NATURALEZA DE LAS CUENTAS
            if($generalLedger->accountClassificationCode == 1 || $generalLedger->accountClassificationCode == 5 || $generalLedger->accountClassificationCode == 6 ) {
                 $difference = $debitTotal - $creditTotal;
           } else {
                 $difference = $creditTotal - $debitTotal;
           } 

          $generalLedger->debitTotal  = $debitTotal ;
          $generalLedger->creditTotal = $creditTotal ;
          $generalLedger->difference  = $difference ;
       } //end of foreach  
       
      $data = [
       'date'         => $date,
       'lastDayOfTheMonth'         => $lastDayOfTheMonth,
       'country'      => $country,
       'company'      => $company,
       'generalLedgers' => $generalLedgers,
       'dateRange'    => $request->receivedData,
       'selectedCurrency'    => $selectedCurrency,
       'currency'    => $currency,
       'pdf'          => $pdf,
        ];

      return PDF::loadView('module_accounting.reports.printGeneralLedger', $data)->stream('General Ledger.pdf');
   }  

}//end class

