<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use Illuminate\Http\Request;
use App\Bank;
use App\Transaction;
use App\TransactionType;
use Auth;

class TransactionController extends Controller
{

    private $oTransaction;
    private $oTransactionType;
    private $oBank;

    public function __construct()
    {

        $this->middleware('auth');
        $this->oTransaction     = new Transaction;
        $this->oTransactionType = new TransactionType;
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
            return view('transactionsincome.index', compact('transactions'));
        } else {
            return view('transactionsexpenses.index', compact('transactions'));
        }

    }

    public function create($sign)
    {
        $transactionType = $this->oTransactionType->findBySign($sign);
        $banks           = $this->oBank->getAll(session('countryId'));
        if ($sign == '+') {
            return view('transactionsincome.create', compact('transactionType', 'banks'));
        } else {
            return view('transactionsexpenses.create', compact('transactionType', 'banks'));
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

        //insert transaction and Update BANK...
        $result = $this->oTransaction->insertT(
            $request->transactionTypeId,
            $request->description,
            $request->transactionDate,
            $request->amount,
            $request->bankId,
            $request->reference,
            $request->sign,
            $month[1],
            session('countryId'),
            session('officeId'));


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
            return view('transactionsincome.show', compact('transaction'));
        } else {
            return view('transactionsexpenses.show', compact('transaction'));
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
