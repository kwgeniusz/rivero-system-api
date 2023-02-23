<?php

namespace App\Http\Controllers\Web\Intercompany\Equivalence;

use Auth;
// use App\CompanyConfiguration;
use App\Term;
use App\Models\Intercompany\TermEquivalence;
use App\Helpers\DateHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 

class TermEquivalenceController extends Controller
{
    private $oTerm;
    private $oTermEquivalence;

    public function __construct()
    {
        $this->middleware('auth');
        $this->oTerm              = new Term;
        $this->oTermEquivalence   = new TermEquivalence;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
  
        $TermEquivalences = $this->oTerm->getAllByCompanyWithLinkedTerm(session('companyId'), $request->companyToLinkId);
        
        if($request->ajax()) {
            return $TermEquivalences;
        }

        return view('module_intercompany.equivalence.proposal.term.index');
    }
    
        /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        
        // Servicios de JD RIVERO ORIGEN, VALIDACION: NO DEBEN TENER EQUIVALENCIA PARA SER MOSTRADOS
        $localTermList         = $this->oTerm->getAllByCompanyWithLinkedTerm(session('companyId'), $request->companyToLinkId);
        $filtered = $localTermList->filter(function ($item) {
            return $item->TermEquivalence == [];
        })->values();

        // Servicios de JD RIVERO INC, VALIDACION: NO DEBEN TENER EQUIVALENCIA CON ESTA EMPRESA PARA MOSTRARSE...
        $destinationTermList   = $this->oTerm->destinationTermWithOriginLink($request->companyToLinkId, session('companyId'));
        $filtered2 = $destinationTermList->filter(function ($item) {
            return  $item->TermEquivId == '';
        })->values();


        if($request->ajax()) {
         return [
                 'localTermList'       => $filtered->toArray(),
                 'destinationTermList' => $filtered2->toArray(),
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

        $localTerm       = $request->localTerm;
        $destinationTerm = $request->destinationTerm;

        $rs = $this->oTermEquivalence->insertS($localTerm, $destinationTerm);

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
