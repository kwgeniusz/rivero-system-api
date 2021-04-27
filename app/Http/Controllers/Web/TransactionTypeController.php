<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\TransactionType;
use Illuminate\Http\Request;

class TransactionTypeController extends Controller
{

    private $oTransactionType;

    public function __construct()
    {

        $this->middleware('auth');
        $this->oTransactionType = new TransactionType;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$sign)
    {
        $transactionType = $this->oTransactionType->getAllByOfficeAndSign(session('companyId'),$sign);

          if($request->ajax()) {
               return $transactionType;
          }
        return view('module_administration.transactions.expenses.types.index', compact('transaction'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

       $rs = $this->oTransactionType->insertTT(
           session('countryId'),
           session('companyId'),
           $request->all()
        );

         if($request->ajax()) {
           return $rs;
        }

        // return redirect()->route('transactionsTypes.index')->with('info', 'Tipo de Proyecto Creado');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $transaction = $this->oTransactionType->findById($id);

        // return view('module_administration.typesoftransactions.edit', compact('transaction'));
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
        $this->oTransactionType->updateTT($id,$request->all());

        // return redirect()->route('transactionsTypes.index')->with('info', 'Tipo de Proyecto Actualizado');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaction = $this->oTransactionType->findById($id);

        // return view('module_administration.typesoftransactions.show', compact('transaction'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->oTransactionType->deleteTT($id);

        // return redirect()->route('transactionsTypes.index')->with('info', 'Tipo de Proyecto Eliminado');
    }
}
