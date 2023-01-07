<?php

namespace App\Http\Controllers\Web\Intercompany\Equivalence;

use Auth;
// use App\CompanyConfiguration;
use App\TimeFrame;
use App\Models\Intercompany\TimeFrameEquivalence;
use App\Helpers\DateHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 

class TimeFrameEquivalenceController extends Controller
{
    private $oTimeFrame;
    private $oTimeFrameEquivalence;

    public function __construct()
    {
        $this->middleware('auth');
        $this->oTimeFrame              = new TimeFrame;
        $this->oTimeFrameEquivalence   = new TimeFrameEquivalence;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
  
        $TimeFrameEquivalences = $this->oTimeFrame->getAllByCompanyWithLinkedTime(session('companyId'), $request->companyToLinkId);
        
        if($request->ajax()) {
            return $TimeFrameEquivalences;
        }

        return view('module_intercompany.equivalence.proposal.time_frame.index');
    }
    
        /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        
        // Servicios de JD RIVERO ORIGEN, VALIDACION: NO DEBEN TENER EQUIVALENCIA PARA SER MOSTRADOS
        $localTimeFrameList         = $this->oTimeFrame->getAllByCompanyWithLinkedTime(session('companyId'), $request->companyToLinkId);
        $filtered = $localTimeFrameList->filter(function ($item) {
            return $item->TimeFrameEquivalence == [];
        })->values();

        // Servicios de JD RIVERO INC, VALIDACION: NO DEBEN TENER EQUIVALENCIA CON ESTA EMPRESA PARA MOSTRARSE...
        $destinationTimeFrameList   = $this->oTimeFrame->destinationTimeWithOriginLink($request->companyToLinkId, session('companyId'));
        $filtered2 = $destinationTimeFrameList->filter(function ($item) {
            return  $item->TimeFrameEquivId == '';
        })->values();


        if($request->ajax()) {
         return [
                 'localTimeFrameList'       => $filtered->toArray(),
                 'destinationTimeFrameList' => $filtered2->toArray(),
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

        $localTime       = $request->localTime;
        $destinationTime = $request->destinationTime;
      
        $rs = $this->oTimeFrameEquivalence->insertTime($localTime, $destinationTime);

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
    //     $contactTypes = $this->oContactType->getAllByCompany(session('companyId'));

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
    
}
