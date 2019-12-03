<?php

namespace App\Http\Controllers\Web;

use Auth;
use App\Country;
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
        // $countrys = Country::all();
        
        // if ($request->isMethod('post')) {
            $receivables = $this->oReceivable->clientsPending(session('countryId'));
            
           
          //  $amounts = $this->oReceivable->getDueTotal(4);
            // dd($amounts);
            // exiT();
            //  $receivables->push(5)
        // }

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
            $request->targetBankId,
            $request->targetBankAccount,
            $request->datePaid
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
        $receivable = Receivable::find($receivableId);      
        $receivable->first()->paymentMethod = $receivable->paymentMethod;
        $receivable->first()->bank = $receivable->bank;
 
       return $receivable->toJson();

    }
    public function paymentMethod()
    {
        $paymentMethod = $this->oPaymentMethod->getAllByLanguage(\Session::get('countryId'));

        return $paymentMethod->toJson();  
    }

   public function confirmPayment(Request $request)
    {

         $rs =  $this->oReceivable->confirmPayment($request->invoiceId,$request->receivableId,$request->status);
        
        return $rs;       
    }
}
