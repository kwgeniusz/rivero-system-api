<?php

namespace App\Http\Controllers\Web\Accounting;

use Auth; 
use App\Models\Accounting\Transaction;
use App\Models\Accounting\GeneralLedger;
use App\Helpers\DateHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    private $oTransaction;
    private $oGeneralLedger;

    public function __construct()
    {
        $this->middleware('auth');
        $this->oTransaction      = new Transaction;
        $this->oGeneralLedger      = new GeneralLedger;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
     //$clients = $this->oTransaction->getClientByGroupAndPagination(session('countryId'),session('companyId'),session('parentCompanyId'),$request->filteredOut);
        $Transactions = $this->oTransaction->getAllByCompany(session('companyId'));
         
        if($request->ajax()) {
              return $Transactions;
               }

        return view('module_accounting.transaction.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $chartOfAccount              = $this->oGeneralLedger->getAllByType(session('companyId'), GeneralLedger::TRANSACTION);
     
        if($request->ajax()) {
         return $chartOfAccount;
        }
        // return view('module_contracts.clients.create', compact('contactTypes','clientNumberFormat'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
 
        $rs = $this->oTransaction->insertT(
            session('countryId'),
            session('companyId'),
            $request->all()
        );

        if($request->ajax()){
                return $rs;
            }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {

    //     $client       = $this->oTransaction->findById($id, session('companyId'));
    //     $contactTypes = $this->oContactType->getAllByOffice(session('companyId'));

    //     return view('module_contracts.clients.edit', compact('client','contactTypes'));
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$transactionId)
    {
        
             $rs = $this->oTransaction->updateT(
               session('companyId'),
               $transactionId,
               $request->all()
              );

              if($request->ajax()){
                return $rs;
            }

        // $notification = array('alert-type' => $rs['alert'],'message' => $rs['message']);
        // return redirect()->route('clients.index')->with($notification);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $Transactions = $this->oTransaction->findById($id,session('companyId'));

           if($request->ajax()){
              return $Transactions;
            }
        // return view('module_contracts.clients.show', compact('client'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rs = $this->oTransaction->deleteT(session('companyId'),$id);
          
         $notification = array(
            'message'    => $rs['message'],
            'alert-type' => $rs['alert'],
        );
        
        return $notification;
        // return redirect()->route('clients.index')->with($notification);
    }
   /**
     * Update all the balance of the table.
     *
     * @param 
     * @return \Illuminate\Http\Response
     */
//    public function updateBalance() {

//     $rs = $this->oTransaction->updateBalance();

//     $notification = array('message'    => $rs['message'],'alert-type' => $rs['alert-type']);
    
//     return $notification;
//    }//end function

}//class end

