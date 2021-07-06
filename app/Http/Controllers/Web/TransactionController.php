<?php

namespace App\Http\Controllers\Web;

use Carbon\Carbon;
use Auth;
use App\Helpers\DateHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use Illuminate\Http\Request;
use App\Bank;
use App\Subcontractor;
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
        
    $dateNow = Carbon::now(session('companyTimeZone'));
    $year    = $dateNow->format('Y');

    $transactions   = $this->oTransaction->getAllByYear($sign,$year);
    
    if($request->ajax()) {
       if ($sign == '+') {
               $income_invoice = $this->oTransactionType->findByOfficeAndCode(session('companyId'),'INCOME_INVOICE');
               $fee            = $this->oTransactionType->findByOfficeAndCode(session('companyId'),'FEE');

         return ['transaction'    => $transactions, 
                 'year'           => $year,
                 'income_invoice' => $income_invoice,
                 'fee'            => $fee];
        }
       else{
        return ['transaction'    => $transactions, 
                'year'           => $year];
       }
    }

        if ($sign == '+') {
            return view('module_administration.transactions.incomes.index');
        } else {
            return view('module_administration.transactions.expenses.index');
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
    
         if($request->file != null){ 
             $this->validate($request, ['file' => 'mimes:jpeg,jpg,bmp,png,gif,svg,pdf']);
         }


         //aplica para gecontrac
        if(session('companyId') == 8){
            $subcontractor = Subcontractor::find($request->subcontId);

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
                $subcontractor,
                Auth::user()->userId,
                $request->file,
                $request->contractId,
                $request->costCategoryId,
                $request->costSubcategoryId,
                $request->costSubcategoryDetailId);
        }else{
        // //insert transaction and Update BANK...
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
        }

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
                         ->where('companyId', '=', session('companyId'))
                         ->orderBy('transactionDate', 'DESC')
                         ->get();
                         
            if($rs->isEmpty()) {
                $returnData = array('alert' => 'error', 'message' => 'No existen Registros para Este Rango de Fecha, escoja otro.');
                return \Response::json($returnData, 500);
            }

        return $rs;
    }
    public function searchByYear(Request $request,$sign)
    { 
        $rs = $this->oTransaction->getAllByYear($sign,$request->year);
         
            if($rs->isEmpty()) {
                $returnData = array('alert' => 'error', 'message' => 'No existen Registros para Este Año, escoja otro.');
                return \Response::json($returnData, 500);
            }

        return $rs;
    }

}
