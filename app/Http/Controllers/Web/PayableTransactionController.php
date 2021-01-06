<?php

namespace App\Http\Controllers\Web;

use Auth;
use App;
use App\Payable;
use App\Transaction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PayableTransactionController extends Controller
{
    private $oPayable;
    private $oTransaction;

    public function __construct()
    {
        $this->middleware('auth');
        $this->oPayable        = new Payable;
        $this->oTransaction    = new Transaction;
    }

      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $payable      = Payable::findOrfail($request->id);
        $transactions = $payable->transactions()->with('user')->orderBy('transactionDate', 'DESC')->get();

            if($request->ajax()){
                return $transactions;
            }
        // return view('module_configuration.projectuses.index', compact('Transactions'));
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

        $payable  = Payable::findOrfail($request->payableId);

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
            $payable,
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
