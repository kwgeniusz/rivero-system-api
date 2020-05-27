<?php

namespace App\Http\Controllers\Web;

use App\Bank;
use App\Account;
use App\Helpers\DateHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth; 

class BankController extends Controller
{
    private $oBank;

    public function __construct()
    {
        $this->middleware('auth');
        $this->oBank = new Bank;
        $this->oAccount = new Account;
    }

    public function index(Request $request)
    {
        $banks    = $this->oBank->getAllByCountry(session('countryId'));
        
            if($request->ajax()){
                 return $banks;
            }

        return view('module_administration.banks.index', compact('banks'));
    }


 public function transactions(Request $request) 
 {

  //esta funcion debe traer las transacciones del año en curso.
  if($request->method() == 'GET') {
     $account      = $this->oAccount->getAllByOffice(session('officeId'));
  }else{
     $account        = $this->oAccount->findById($request->accountId);
  }

     $transactions      = $account[0]->transaction;
     $year              = $account[0]->accountBalance[0]->year;
     $initialBalance    = $account[0]->accountBalance[0]->initialBalance;
     $balance           = $account[0]->accountBalance[0]->initialBalance;

     foreach ($transactions as $transaction) {
         if($transaction->sign == '+'){
            $balance       = $balance + $transaction->amount;
         }elseif($transaction->sign == '-'){
            $balance       = $balance - $transaction->amount;
         }
         $transaction->balance =  number_format((float)$balance, 2, '.', '');
     }
  if($request->method() == 'POST') {
    if($request->date1 || $request->date2 || $request->textToFilter) {
  
        //primer filtrado por el select y texto escrito en el formulario.
      if($request->textToFilter){
      $transactions = $transactions->filter(function ($transaction) use($request) {

                  if($transaction->invoiceId != null){     
                  switch ($request->filterBy) {
                        case 'contractNumber':
                              $valorABuscar =  $transaction->invoice->contract->contractNumber;
                          break;
                        case 'clientCode':
                              $valorABuscar =  $transaction->invoice->client->clientCode;
                          break;
                        case 'invId':
                               $valorABuscar = $transaction->invoice->inv;
                          break;
                        case 'clientName':
                              $valorABuscar =  $transaction->invoice->client->clientName;
                          break;  
                        case 'clientPhone':
                              $valorABuscar =  $transaction->invoice->client->clientPhone;
                          break;
                         case 'amount':
                               $valorABuscar = $transaction->amount;
                              // echo $valorABuscar;
                          break;
                         case 'responsable':
                               $valorABuscar = $transaction->user->fullName;
                          break;   
                      }
                $coincidencia = stripos($valorABuscar, $request->textToFilter);

               if ($coincidencia !== false) { 
                   return $transaction;
              } 
           }
     });
  } //fin del primer filtrado

    //segundo filtrado por fechas se aplica si estan llenos los dos campos de fecha
  if($request->date1 && $request->date2) {
    $transactions = $transactions->filter(function ($transaction) use($request) {
   
               $oDateHelper = new DateHelper;
               $functionRs = $oDateHelper->changeDateForCountry(session('countryId'),'Mutador');
               $date1                 = $oDateHelper->$functionRs($request->date1);
               $date2                 = $oDateHelper->$functionRs($request->date2);
               $transactionDate       = $oDateHelper->$functionRs($transaction->transactionDate);

              $date_inicio = strtotime($date1);
              $date_fin    = strtotime($date2);
              $date_nueva  = strtotime($transactionDate);

               // esta dentro del rango
              if (($date_nueva >= $date_inicio) && ($date_nueva <= $date_fin)){
                 return $transaction;
              }
     });
 }//fin del segundo filtrado
}//fin de toda la cadena de filtrados

}//fin de method post

     return view('module_administration.banks.transactions', compact('transactions','initialBalance','year'));

 }
   

//-------QUERYS ASINCRONIOUS-----------------//

   public function getAllByOffice()
    {
        $banks    = $this->oBank->getAllByOffice(session('officeId'));
        return $banks;
    }
}
