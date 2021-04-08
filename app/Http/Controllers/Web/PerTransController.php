<?php

namespace App\Http\Controllers\web;

use App\PerTrans;
use App\Comment;
use App\HrTransactionType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PerTransController extends Controller
{
    private $oPerTrans;
    private $oComment;

    public function __construct()
    {
        // $this->middleware('auth');
        $this->oPerTrans  = new PerTrans;
        $this->oTType     = new HrTransactionType;
        $this->oComment   = new Comment;
  
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
        try {
            $result = '';
            $PerTrans = new PerTrans();
            $PerTrans->countryId = $request->countryId;
            $PerTrans->companyId = $request->companyId;
            $PerTrans->staffCode = $request->staffCode;
            $PerTrans->transactionTypeCode = $request->transactionTypeCode;
            $PerTrans->quantity = $request->quantity;
            $PerTrans->amount = $request->amount;
            $PerTrans->balance = $request->balance;
            $PerTrans->initialBalance = $request->initialBalance;
            $PerTrans->cuotas = $request->cuotas;
            
            $PerTrans->save();

            if ($request->commentContent != null) {
                $result = $this->oComment->insertC($PerTrans,$request->all());
            }
            return response()->json(['data' =>["message" => 'success',"PerTrans"=> $PerTrans,"result" => $result]],200);

        } catch (\Throwable $th) {
            throw $th;
        }
        
        
        
        
     
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
        $PerTrans->balance = $request->balance;
        
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
        $PerTrans->deleted_at = now();
        $PerTrans->save();
        return $PerTrans;
    
    }
}
