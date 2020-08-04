<?php

namespace App\Http\Controllers\web;

use App\PerTrans;
use App\HrTransactionType;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PerTransController extends Controller
{
    private $oPerTrans;
    private $oTType;
    public function __construct()
    {
        // $this->middleware('auth');
        $this->oPerTrans = new PerTrans;
        $this->oTType = new HrTransactionType;
  
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pTransaction = $this->oPerTrans->getPeTransaction();
        return $pTransaction;
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        $PerTrans = new PerTrans();
        $PerTrans->countryId = $request->countryId;
        $PerTrans->companyId = $request->companyId;
        $PerTrans->staffCode = $request->staffCode;
        $PerTrans->transactionTypeCode = $request->transactionTypeCode;
        $PerTrans->quantity = $request->quantity;
        $PerTrans->amount = $request->amount;
        
        $PerTrans->save();
        return $PerTrans;
     
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

        $PerTrans = PerTrans::find($id);
        $PerTrans->quantity = $request->quantity;
        $PerTrans->amount = $request->amount;
        
        $PerTrans->save();
        return $PerTrans;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // return $id;
        $PerTrans = PerTrans::findOrFail($id);
        $PerTrans->delete();
    
    }
}
