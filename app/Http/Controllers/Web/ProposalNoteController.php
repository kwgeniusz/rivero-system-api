<?php

namespace App\Http\Controllers\Web;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Precontract;
use App\Proposal;
use App\ProposalNote;
use Auth;

class ProposalNoteController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->oPrecontract          = new Precontract;
        $this->oProposal             = new Proposal;
        $this->oProposalNote       = new ProposalNote;
    }



    public function store(Request $request)
    {
       //VACIA TODA LA PROPUESTA PARA LLENARLA PARA INSERTAR LAS MODIFICACIONES.
        $this->oProposalNote->deleteProp($request->proposalId);

    //recorre el arreglo que viene por requeste, del componente ProposalDetails y realiza una insercion de cada uno de sus elementos.
        if(!empty($request->notesList)) {
        foreach ($request->notesList as $key => $item) {

             $result = $this->oProposalNote->insert(
              $request->proposalId,
              $item['noteId'],
              $item['noteName']);

         $notification = array(
           'message'    => $result['message'],
           'alertType' => $result['alertType'],
          );
        };
     }else{
          $notification = array(
           'message'    => 'Notas Guardadas',
          'alertType' => 'success',
        );
      };//fin 1 else

      //envia siempre la notificacion para saber que if fue cumplido 
         if($request->ajax()){
                return $notification;
            }
    }

     public function show(Request $request,$id)
    {
        $proposalNotes = $this->oProposalNote->getAllByProposal($id);

          if($request->ajax()){
                return $proposalNotes;
            }
        return view('module_contracts.proposals.Notes', compact('proposalNotes'));
    }

    public function destroy($id)
    {
        $result = $this->oProposalNote->deleteProp($id);

           $notification = array(
            'message'    => $result['message'],
            'alertType' => $result['alertType'],
        );
         return $notification;

    }
}
