<?php

namespace App\Http\Controllers\Web;

use Auth;
use App\Bank;
use App\Payable;
use App\PaymentMethod;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PayableController extends Controller
{
    private $oPayable;

    public function __construct()
    {
        $this->middleware('auth');
        $this->oPayable = new Payable;
        $this->oPaymentMethod = new PaymentMethod;
    }


     public function pay(Request $request)
      {
            $rs = $this->oPayable->addPay(
                        $request->checked,
                        $request->payMethodId,
                        $request->payMethodDetails,
                        $request->cashboxId,
                        $request->accountId
                       );
               
               return $rs;
        // return view('module_administration.payables.index', compact('payables'));
      }

    // public function index(Request $request)
    // {
    //         $payables = '';
    //         $payables = $this->oPayable->clientsPending(session('companyId'));

    //         $payables->map(function($payable){
    //                   $paymentsMissing = $this->oPayable->getAllByClient($payable->clientId);
    //                   $payable->balanceTotal = number_format((float)$paymentsMissing->sum('amountDue'), 2, '.', '');
    //          });

    //     return view('module_administration.payables.index', compact('payables'));
    // }
    // public function details($clientId)
    // {
    //     $payable           = $this->oPayable->clientPendingInfo($clientId);
    //     $payablesInvoices  = $this->oPayable->invoicesPendingAll($clientId);

    //     $payable->map(function($payable){
    //                   $paymentsMissing = $this->oPayable->getAllByClient($payable->clientId);
    //                   $payable->balanceTotal = number_format((float)$paymentsMissing->sum('amountDue'), 2, '.', '');
    //          });
 
    //       // dd($payablesInvoices);
    //       // exit();
    //     //verifica si hay registros sino redirigeme a "ver todos los clientes con cuentas por cobrar"
    //     if (count($payable) == 0) {
    //         return redirect()->route('payables.index');
    //     }

    //     return view('module_administration.payables.details', compact('payable','payablesInvoices'));
    // }
    // public function share(Request $request)
    // {

    //     $rs = $this->oPayable->updateReceivable(
    //         $request->receivableId,
    //         $request->amountPaid,
    //         $request->collectMethod,
    //         $request->sourceBank,
    //         $request->sourceBankAccount,
    //         $request->checkNumber,
    //         $request->cashboxId,
    //         $request->accountId,
    //         $request->percent,
    //         $request->amountPercent,
    //         $request->datePaid,
    //         Auth::user()->userId
    //     );

    //     return $rs;
    // }

}
