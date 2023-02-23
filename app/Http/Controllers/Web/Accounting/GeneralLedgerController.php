<?php

namespace App\Http\Controllers\Web\Accounting;

use Auth;
use App\CompanyConfiguration;
use App\Models\Accounting\GeneralLedger;
use App\Models\Accounting\GeneralLedgerBalance;
use App\Models\Accounting\AccountType;
use App\Models\Accounting\AccountClassification;
use App\Models\Entity;
use App\Helpers\DateHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 

class GeneralLedgerController extends Controller
{
    private $oCompanyConfig;
    private $oGeneralLedger;
    private $oAccountType;
    private $oAccountClassification;
    private $oEntity;

    public function __construct()
    {
        $this->middleware('auth');
        $this->oCompanyConfig         = new CompanyConfiguration;
        $this->oGeneralLedger         = new GeneralLedger;
        $this->oGeneralLedgerBalance  = new GeneralLedgerBalance;
        $this->oAccountType           = new AccountType;
        $this->oAccountClassification = new AccountClassification;
        $this->oEntity                = new Entity;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
     //$clients = $this->oGeneralLedger->getClientByGroupAndPagination(session('countryId'),session('companyId'),session('parentCompanyId'),$request->filteredOut);
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
        $accountTypeList             = $this->oAccountType->getAllByCountry(session('countryId'));
        $accountClassificationList   = $this->oAccountClassification->getAllByCountry(session('countryId'));
        $entitiesList                = $this->oEntity->getAll();
        
        if($request->ajax()) {
         return [
                 'chartOfAccount'            => $chartOfAccount,
                 'accountTypeList'           => $accountTypeList,
                 'accountClassificationList' => $accountClassificationList,
                 'entitiesList'              => $entitiesList
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
    public function store(Request $request)
    {
 
        $rs = $this->oGeneralLedger->insertG(
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
             $rs = $this->oGeneralLedger->updateG(
               session('companyId'),
               $clientId,
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
        $generalLedgers = $this->oGeneralLedger->findById($id,session('companyId'));

           if($request->ajax()){
              return $generalLedgers;
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
        $rs = $this->oGeneralLedger->deleteG(session('companyId'),$id);
          
         $notification = array(
            'message'    => $rs['message'],
            'alert-type' => $rs['alert'],
        );
        
        return $notification;
        // return redirect()->route('clients.index')->with($notification);
    }
    
   public function closeYear()
    {
        $rs = $this->oGeneralLedgerBalance->closeYear();
    
         $notification = array(
            'message'    => $rs['message'],
            'alert-type' => $rs['alert-type'],
        );
        
        return $notification;
  
    }


    // public function balanceUpdate()
    // {
    //     $rs = $this->oGeneralLedger->deleteG(session('companyId'),$id);
          
    //      $notification = array(
    //         'message'    => $rs['message'],
    //         'alert-type' => $rs['alert'],
    //     );
        
    //     return $notification;
    //     // return redirect()->route('clients.index')->with($notification);
    // }
}
