<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use Illuminate\Http\Request;
use App\Bank;
use App\Transaction;
use App\PaymentMethod;
use App\TransactionType;
use Auth;

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
    public function index($sign)
    {

        $transactions = $this->oTransaction->getAllForSign($sign,session('countryId'),session('officeId'));
        if ($sign == '+') {
            return view('module_administration.transactionsincome.index', compact('transactions'));
        } else {
            return view('module_administration.transactionsexpenses.index', compact('transactions'));
        }

    }

    public function create($sign)
    {
        $transactionType = $this->oTransactionType->getAllByOfficeAndSign(session('officeId'),$sign);
        $paymentsMethod   = $this->oPaymentMethod->getAll();
        $banks           = $this->oBank->getAllByOffice(session('officeId'));
        if ($sign == '+') {
            return view('module_administration.transactionsincome.create', compact('paymentsMethod','transactionType', 'banks'));
        } else {
            return view('module_administration.transactionsexpenses.create', compact('paymentsMethod','transactionType', 'banks'));
        }

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransactionRequest $request)
    {

        $month = explode("/", $request->transactionDate);
        //   $file=$request->file('file');
        //   dd($file);

        //   exit(); 
        //insert transaction and Update BANK...
        $result = $this->oTransaction->insertT(
            session('countryId'),
            session('officeId'),
            $request->transactionTypeId,
            $request->description,
            $request->payMethodId,
            $request->payMethodDetails,
            $request->reason,
            $request->transactionDate,
            $request->amount,
            $request->sign,
            $request->bankId,
            $request->invoiceId,
            $month[1],
            Auth::user()->userId);


        $notification = array(
            'message'    => $result['msj'],
            'alert-type' => $result['alert'],
        );

        if ($request->sign == '+') {
            return redirect()->route('transactions.index', ['sign' => '+'])->with($notification);
        } else {
            return redirect()->route('transactions.index', ['sign' => '-'])->with($notification);
        }

    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($sign, $id)
    {

        $transaction = $this->oTransaction->findById($id,session('countryId'),session('officeId'));
        if ($sign == '+') {
            return view('module_administration.transactionsincome.show', compact('transaction'));
        } else {
            return view('module_administration.transactionsexpenses.show', compact('transaction'));
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($sign, $id)
    {
         //VALIDAR QUE NO ENTRE SI TIENE FACTURA RELACIONADA EN LA TABLA
       $result = $this->oTransaction->deleteT($id);

            $notification = array(
            'message'    => $result['msj'],
            'alert-type' => $result['alert'],
             );

        if ($sign == '+') {
            return redirect()->route('transactions.index', ['sign' => '+'])->with($notification);
        } else {
            return redirect()->route('transactions.index', ['sign' => '-'])->with($notification);
        }

    }

}
