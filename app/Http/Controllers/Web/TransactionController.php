<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Transaction;
use App\TransactionType;
use App\Bank;
use Session;
use App\Http\Requests\TransactionRequest;
use DB;

class TransactionController extends Controller
{
 
   private $oTransaction;
   private $oTransactionType;
   private $oBank;

    public function __construct() {

       $this->middleware('auth');
       $this->oTransaction = new Transaction;
       $this->oTransactionType = new TransactionType;
       $this->oBank = new Bank;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($sign) {

        $transactions = $this->oTransaction->getAllForSign($sign);
        if($sign=='+')
        return view('transactionsincome.index', compact('transactions'));
        else
        return view('transactionsexpenses.index', compact('transactions'));

    }

    public function create($sign)
    {
        $transactionType = $this->oTransactionType->findBySign($sign);
        $banks = $this->oBank->getAll();
        if($sign == '+')
        return view('transactionsincome.create', compact('transactionType','banks'));
        else
        return view('transactionsexpenses.create', compact('transactionType','banks'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransactionRequest $request) {
        
        $month = explode("-", $request->transactionDate);
     //insert transaction and Update BANK...
        $msjResult =  $this->oTransaction->insertT(
        $request->transactionTypeId,
        $request->description,
        $request->transactionDate,
        $request->amount,
        $request->bankId,
        $request->reference,
        $request->sign,
         $month[1]);

         echo $msjResult;
    

        if($request->sign == '+')
        return redirect()->route('transactions.index',['sign'=>'+'])->with('error',$msjResult);
        else
        return redirect()->route('transactions.index',['sign'=>'-'])->with('error','Tipo de Proyecto Creado');
    }
   /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($sign,$id) {

        $transaction = $this->oTransaction->findById($id);
        if($sign == '+')
        return view('transactionsincome.show', compact('transaction'));
        else
        return view('transactionsexpenses.show', compact('transaction'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($sign,$id) {

        $this->oTransaction->deleteT($id);
        if($sign == '+')
        return redirect()->route('transactions.index',['sign'=>'+'])->with('info','Tipo de Proyecto Creado');
        else
        return redirect()->route('transactions.index',['sign'=>'-'])->with('info','Tipo de Proyecto Creado');
    }




    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {

        $transaction = $this->oTransaction->findById($id);
        return view('softransactions.edit', compact('transaction'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
       
        $this->oTransaction->updateTT($id,$request->transactionName);

        return redirect()->route('transactionss.index')
                         ->with('info','Tipo de Proyecto Actualizado');
    }


}
