<?php

namespace App\Http\Controllers\Web;

use Auth;
use App;
use App\Invoice;
use App\Transaction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InvoiceTransactionController extends Controller
{
    private $oInvoice;
    private $oTransaction;

    public function __construct()
    {
        $this->middleware('auth');
        $this->oInvoice        = new Invoice;
        $this->oTransaction         = new Transaction;
    }

      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $invoice  = Invoice::findOrfail($request->id);
        $transactions = $invoice->transactions()->with('user')->orderBy('transactionDate', 'DESC')->get();

            if($request->ajax()){
                return $transactions;
            }
        // return view('module_configuration.projectuses.index', compact('transactions'));
    }

        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransactionRequest $request)
    {        
         if($request->sign == '-'){  
             $this->validate($request, ['file' => 'required|image']);
         }

        $invoice  = Invoice::findOrfail($request->invoiceId);

        //insert transaction and Update Bank...
        $result = $this->oTransaction->insertT(
            session('countryId'),
            session('companyId'),
            $request->transactionTypeId,
            $request->description,
            $request->payMethodId,
            $request->payMethodDetails,
            $request->reason,
            $request->transactionDate,
            $request->amount,
            $request->sign,
            $request->cashboxId,
            $request->accountId,
            $invoice,
            Auth::user()->userId,
            $request->file);

         if($request->ajax()) {  
            return $result;
         }

        $notification = array('message' => $result['msj'],'alert-type' => $result['alert']);

        if ($request->sign == '+') {
            return redirect()->route('transactions.index', ['sign' => '+'])->with($notification);
        } else {
            return redirect()->route('transactions.index', ['sign' => '-'])->with($notification);
        }
    }
}
