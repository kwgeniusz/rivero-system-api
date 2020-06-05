<?php

namespace App\Http\Controllers\Web;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Proposal;
use App\ProposalScope;
use Auth;

class ProposalScopeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->oProposal             = new Proposal;
        $this->oProposalScope       = new ProposalScope;
    }



    public function store(Request $request)
    {
       //VACIA TODA LA PROPUESTA PARA LLENARLA PARA INSERTAR LAS MODIFICACIONES.
        $this->oProposalScope->deleteProp($request->proposalId);

    //recorre el arreglo que viene por requeste, del componente ProposalDetails y realiza una insercion de cada uno de sus elementos.
        if(!empty($request->scopesList)) {
        foreach ($request->scopesList as $key => $item) {

             $result = $this->oProposalScope->insert(
              $request->proposalId,
              $item['description']);

         $notification = array(
           'message'    => $result['message'],
           'alertType' => $result['alertType'],
          );
        };
     }else{
          $notification = array(
           'message'    => 'Alcances Guardados',
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
        $proposalScopes = $this->oProposalScope->getAllByProposal($id);

          if($request->ajax()){
                return $proposalScopes;
            }
        return view('module_contracts.proposals.Scopes', compact('proposalScopes'));
    }

    public function destroy($id)
    {
        $result = $this->oProposalScope->deleteProp($id);

           $notification = array(
            'message'    => $result['message'],
            'alertType' => $result['alertType'],
        );
         return $notification;

    }
}
