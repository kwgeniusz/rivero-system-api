<?php

namespace App\Http\Controllers\Web\Intercompany\Equivalence;

use Auth;
// use App\CompanyConfiguration;
use App\Note;
use App\Models\Intercompany\NoteEquivalence;
use App\Helpers\DateHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 

class NoteEquivalenceController extends Controller
{
    private $oNote;
    private $oNoteEquivalence;

    public function __construct()
    {
        $this->middleware('auth');
        $this->oNote              = new Note;
        $this->oNoteEquivalence   = new NoteEquivalence;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
  
        $NoteEquivalences = $this->oNote->getAllByCompanyWithLinkedNote(session('companyId'), $request->companyToLinkId);
        
        if($request->ajax()) {
            return $NoteEquivalences;
        }

        return view('module_intercompany.equivalence.proposal.note.index');
    }
    
        /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        
        // Servicios de JD RIVERO ORIGEN, VALIDACION: NO DEBEN TENER EQUIVALENCIA PARA SER MOSTRADOS
        $localNoteList         = $this->oNote->getAllByCompanyWithLinkedNote(session('companyId'), $request->companyToLinkId);
        $filtered = $localNoteList->filter(function ($item) {
            return $item->NoteEquivalence == [];
        })->values();

        // Servicios de JD RIVERO INC, VALIDACION: NO DEBEN TENER EQUIVALENCIA CON ESTA EMPRESA PARA MOSTRARSE...
        $destinationNoteList   = $this->oNote->destinationNoteWithOriginLink($request->companyToLinkId, session('companyId'));
        $filtered2 = $destinationNoteList->filter(function ($item) {
            return  $item->NoteEquivId == '';
        })->values();


        if($request->ajax()) {
         return [
                 'localNoteList'       => $filtered->toArray(),
                 'destinationNoteList' => $filtered2->toArray(),
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

        $localNote       = $request->localNote;
        $destinationNote = $request->destinationNote;

        $rs = $this->oNoteEquivalence->insertS($localNote, $destinationNote);

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
