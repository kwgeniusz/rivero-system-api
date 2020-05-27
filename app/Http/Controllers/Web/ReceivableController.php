<?php

namespace App\Http\Controllers\Web;

use Auth;
use App\Bank;
use App\Receivable;
use App\PaymentMethod;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReceivableController extends Controller
{
    private $oReceivable;

    public function __construct()
    {
        $this->middleware('auth');
        $this->oReceivable = new Receivable;
        $this->oPaymentMethod = new PaymentMethod;
    }
    public function index(Request $request)
    {
            $receivables = '';
            $receivables = $this->oReceivable->clientsPending(session('countryId'));
        
        return view('module_administration.receivables.index', compact('receivables'));
    }
    public function details($clientId)
    {
        $client               = $this->oReceivable->clientPendingInfo($clientId);
        $receivablesInvoices = $this->oReceivable->invoicesPendingAll($clientId);

        //verifica si hay registros sino redirigeme a "ver todos los clientes con cuentas por cobrar"
        if (count($client) == 0) {
            return redirect()->route('receivables.index');
        }

        return view('module_administration.receivables.details', compact('receivablesInvoices', 'client'));
    }
    public function share(Request $request)
    {

        $result = $this->oReceivable->updateReceivable(
            $request->receivableId,
            $request->amountPaid,
            $request->collectMethod,
            $request->sourceBank,
            $request->sourceBankAccount,
            $request->checkNumber,
            $request->cashboxId,
            $request->accountId,
            $request->percent,
            $request->amountPercent,
            $request->datePaid,
            Auth::user()->userId
        );

        return $result;
    }

    public function reportCollections(Request $request)
    {
        $receivables = '';

        if ($request->isMethod('post')) {
            $receivables = $this->oReceivable->clientsPending($request->countryId);
        }
        $countrys = Country::all();

        return view('module_administration.reportcollections.index', compact('receivables', 'countrys'));
    }
//----------------QUERYS ASINCRONIOUS-----------------//
    public function getForId($receivableId)
    {
        $receivable = Receivable::with('paymentMethod','account','invoice')
                                ->where('receivableId', $receivableId)
                                ->get();  
        // $bank = Bank::find($receivable[0]->account->bankId);     
        // $receivable->first()->bank = $bank;

       return $receivable->toJson();

    }
    public function paymentMethod()
    {
        $paymentMethod = $this->oPaymentMethod->getAll();

        return $paymentMethod->toJson();  
    }

   public function confirmPayment(Request $request)
    {

         $rs =  $this->oReceivable->confirmPayment($request->invoiceId,$request->receivableId,$request->status);
        
        return $rs;       
    }
}
