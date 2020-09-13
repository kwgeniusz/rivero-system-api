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
     public function index(Request $request,$id)
    {
        $proposal = $this->oProposal->FindById($id,session('countryId'),session('companyId'));
        $propScopes = $proposal[0]->scope;
   
        if($request->ajax()){
             return $propScopes;
           }
        // return view('module_contracts.proposals.Scopes', compact('proposalScopes'));
    }

    public function store(Request $request,$id)
    {
       //VACIA TODA LA PROPUESTA PARA LLENARLA PARA INSERTAR LAS MODIFICACIONES.
        $this->oProposalScope->deleteAll($id);

    //recorre el arreglo que viene por requeste, del componente ProposalDetails y realiza una insercion de cada uno de sus elementos.
        if(!empty($request->scopesList)) {
        foreach ($request->scopesList as $key => $item) {

             $result = $this->oProposalScope->insert(
              $id,
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


    // public function destroy($id)
    // {
    //     $result = $this->oProposalScope->deleteProp($id);

    //        $notification = array(
    //         'message'    => $result['message'],
    //         'alertType' => $result['alertType'],
    //     );
    //      return $notification;

    // }
}
