<?php

namespace App\Http\Controllers\Web;

use Carbon\Carbon;
use Auth;
use App\Helpers\DateHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use Illuminate\Http\Request;
use App\Bank;
use App\Transaction;
use App\PaymentMethod;
use App\TransactionType;

class TransactionController extends Controller
{
    private $oTransaction;
    private $oTransactionType;
    private $oPaymentMethod;
    private $oBank;

    public function __construct()
    {

        $this->middleware('auth');
        $this->oTransaction     = new Transaction;
        $this->oTransactionType = new TransactionType;
        $this->oPaymentMethod   = new PaymentMethod;
        $this->oBank            = new Bank;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$sign)
    {

    $transactions   = $this->oTransaction->getAllForSign($sign,session('countryId'),session('companyId'));
    
    if($request->ajax()) {
       if ($sign == '+') {
               $income_invoice = $this->oTransactionType->findByOfficeAndCode(session('companyId'),'INCOME_INVOICE');
               $fee            = $this->oTransactionType->findByOfficeAndCode(session('companyId'),'FEE');

         return ['transaction'    => $transactions, 
                 'income_invoice' => $income_invoice,
                 'fee' => $fee];
        }
       else{
         return $transactions;
       }
    }
        
//     $income_invoice = $this->oTransactionType->findByOfficeAndCode(session('companyId'),'INCOME_INVOICE');
//     $fee            = $this->oTransactionType->findByOfficeAndCode(session('companyId'),'FEE');

//       $totalTransaction = 0;
//       $totalFee = 0;
//       $totalManual = 0;
     
//          foreach ($transactions as $transaction) {
//         if($sign == '+') {

//             if($transaction->transactionTypeId == $income_invoice[0]->transactionTypeId){
//                 if($transaction->transactionable == null){
//                  $totalManual += $transaction->amount;
//                 }
//                 else{
//                  $totalTransaction += $transaction->amount;
//                 }
//             }elseif ($transaction->transactionTypeId == $fee[0]->transactionTypeId) {
//               $totalFee += $transaction->amount;
//             }
//         }else{ //end first if
//              $totalTransaction += $transaction->amount;
//         }//end if
//      } //end foreach

//     if($request->method() == 'POST') {
//      if($request->date1 || $request->date2 || $request->textToFilter) {
  
//         //primer filtrado por el select y texto escrito en el formulario.
//        if($request->textToFilter){
//        $transactions = $transactions->filter(function ($transaction) use($request) {
//                       switch ($request->filterBy) {
//                         case 'contractNumber':
//                             if($transaction->invoiceId != null)
//                               $valorABuscar =  $transaction->transactionable->contract->contractNumber;
//                             else
//                               $valorABuscar = '';
//                           break;
//                         case 'invId':
//                             if($transaction->invoiceId != null)
//                                $valorABuscar = $transaction->transactionable->invId;
//                            else
//                               $valorABuscar = ''; 
//                           break;
//                         case 'clientCode':
//                             if($transaction->invoiceId != null)
//                               $valorABuscar =  $transaction->transactionable->client->clientCode;
//                              else
//                               $valorABuscar = ''; 
//                           break;
//                         case 'clientName':
//                             if($transaction->invoiceId != null)
//                               $valorABuscar =  $transaction->transactionable->client->clientName;
//                                 else
//                               $valorABuscar = ''; 
//                           break;  
//                         case 'clientPhone':
//                             if($transaction->invoiceId != null)
//                               $valorABuscar =  $transaction->transactionable->client->clientPhone;
//                                 else
//                               $valorABuscar = ''; 
//                           break;
//                         case 'amount':
//                                $valorABuscar = $transaction->amount;
//                           break;
//                         case 'transactionType':
//                                $valorABuscar = $transaction->transactionType->transactionTypeName;
//                           break; 
//                          case 'paymentMethod':
//                                $valorABuscar = $transaction->paymentMethod->payMethodName;
//                           break;   
//                         case 'description':
//                                $valorABuscar = $transaction->description;
//                           break; 
//                          case 'reason':
//                                $valorABuscar = $transaction->reason;
//                           break; 
//                         case 'responsable':
//                                $valorABuscar = $transaction->user->fullName;
//                           break;   
//                       }

//                 $coincidencia = stripos($valorABuscar, $request->textToFilter);

//             if ($coincidencia !== false) { 
//                  return $transaction;
//             } 

//      });
//   } //fin del primer filtrado

//     //segundo filtrado por fechas se aplica si estan llenos los dos campos de fecha
//   if($request->date1 && $request->date2) {
//     $transactions = $transactions->filter(function ($transaction) use($request) {
   
//                $oDateHelper = new DateHelper;
//                $functionRs = $oDateHelper->changeDateForCountry(session('countryId'),'Mutador');
//                $date1                 = $oDateHelper->$functionRs($request->date1);
//                $date2                 = $oDateHelper->$functionRs($request->date2);
//                $transactionDate       = $oDateHelper->$functionRs($transaction->transactionDate);

//               $date_inicio = strtotime($date1);
//               $date_fin    = strtotime($date2);
//               $date_nueva  = strtotime($transactionDate);

//                // esta dentro del rango
//               if (($date_nueva >= $date_inicio) && ($date_nueva <= $date_fin)){
//                  return $transaction;
//               }
//      });
//     }//fin del segundo filtrado

//   } //cierre del filtrado general.
// } //cierre de verificacion post

        if ($sign == '+') {
            return view('module_administration.transactions.incomes.index');
        } else {
            return view('module_administration.transactions.expenses.index');
        }

    }

    // public function create($sign)
    // {
    //     $transactionType = $this->oTransactionType->getAllByOfficeAndSign(session('companyId'),$sign);
    //     $paymentsMethod   = $this->oPaymentMethod->getAll();
  
    //     if ($sign == '+') {
    //         return view('module_administration.transactions.incomes.create', compact('paymentsMethod','transactionType'));
    //     }
    //         } else {
    //         return view('module_administration.transactions.expenses.create', compact('paymentsMethod','transactionType'));
    //     }
    // }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransactionRequest $request)
    {        
    
         if($request->file != null){ 
             $this->validate($request, ['file' => 'mimes:jpeg,jpg,bmp,png,gif,svg,pdf']);
         }
  
        //insert transaction and Update BANK...
        $rs1 = $this->oTransaction->insertT(
            session('countryId'),
            session('companyId'),
            $request->transactionTypeId,
            $request->description,
            $request->payMethodId,
            $request->payMethodDetails,
            $request->reason,
            $request->reference,
            $request->transactionDate,
            $request->amount,
            $request->sign,
            $request->cashboxId,
            $request->accountId,
            '',
            Auth::user()->userId,
            $request->file);
         
        return $rs1;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        // dd($request->all());
        // exit();
        $rs = $this->oTransaction->updateT(
            $id,
            $request->all()
         );

 
        return $rs;
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaction = $this->oTransaction->findById($id,session('countryId'),session('companyId'));
         return $transaction;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
         //VALIDAR QUE NO ENTRE SI TIENE FACTURA RELACIONADA EN LA TABLA
       $rs = $this->oTransaction->deleteT($id);
       return $rs;
    }
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchBetweenDates(Request $request,$sign)
    {
        $rs = Transaction::with('payable','paymentMethod','transactionType','account.bank','transactionable','document','user')
                         ->where('transactionDate', '>=', $request->date1)
                         ->where('transactionDate', '<=', $request->date2)
                         ->where('sign', '=', $sign)
                         ->orderBy('transactionDate', 'DESC')
                         ->get();
                         
            if($rs->isEmpty()) {
                $returnData = array('alert' => 'error', 'message' => 'No existen Registros para Este Rango de Fecha, escoja otro.');
                return \Response::json($returnData, 500);
            }

        return $rs;
    }
 

}
