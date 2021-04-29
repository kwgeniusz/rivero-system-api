<?php

namespace App\Http\Controllers\Web;

// use App\Bank;
use App\GeneralLedger;
use App\AccountType;
use App\AccountClassification;
use App\Helpers\DateHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth; 

class GeneralLedgerController extends Controller
{
    private $oGeneralLedger;
    private $oAccountType;
    private $oAccountClassification;

    public function __construct()
    {
        $this->middleware('auth');
        $this->oGeneralLedger        = new GeneralLedger;
        $this->oAccountType          = new AccountType;
        $this->oAccountClassification = new AccountClassification;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      // $clients = $this->oGeneralLedger->getClientByGroupAndPagination(session('countryId'),session('companyId'),session('parentCompanyId'),$request->filteredOut);
         $generalLedgers = $this->oGeneralLedger->getAllByCompany(session('companyId'));
         
         if($request->ajax()) {
               return $generalLedgers;
                }

        return view('module_accounting.generalledger.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $chartOfAccount              = $this->oGeneralLedger->getAllByCompany(session('companyId'));
        $accountTypeList             = $this->oAccountType->getAllByLanguage(session('countryLanguage'));
        $accountClassificationList   = $this->oAccountClassification->getAllByLanguage(session('countryLanguage'));
        
        if($request->ajax()) {
         return [
                 'chartOfAccount'            => $chartOfAccount,
                 'accountTypeList'           => $accountTypeList,
                 'accountClassificationList' => $accountClassificationList
                ];
        }
        // return view('module_contracts.clients.create', compact('contactTypes','clientNumberFormat'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request)
    {
        // $rs = $this->oGeneralLedger->insertG(
        //     session('countryId'),
        //     session('companyId'),
        //     session('parentCompanyId'),
        //     $request->all()
        // );

        // if($request->ajax()){
        //         return $rs;
        //     }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {

    //     $client       = $this->oGeneralLedger->findById($id, session('companyId'));
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
    public function update(Request $request,$clientId)
    {
            //  $rs = $this->oGeneralLedger->updateG(
            //    session('companyId'),
            //    $clientId,
            //    $request->all()
            //   );

            //   if($request->ajax()){
            //     return $rs;
            // }

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
        // $client = $this->oGeneralLedger->findById($id,session('companyId'));

        //    if($request->ajax()){
        //       return $client;
        //     }
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
        // $result = $this->oGeneralLedger->deleteG(session('countryId'),$id);

        //  $notification = array(
        //     'message'    => $result['message'],
        //     'alert-type' => $result['alert'],
        // );
        // return redirect()->route('clients.index')->with($notification);
    }

}
