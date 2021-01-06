<?php

namespace App\Http\Controllers\Web;

use Auth;
use App\Proposal;
use App\ProposalTerm;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProposalTermController extends Controller
{
    private $oProposal;
    private $oProposalTerm;

    public function __construct()
    {
        $this->middleware('auth');
        $this->oProposal              = new Proposal;
        $this->oProposalTerm     = new ProposalTerm;
    }

    public function index(request $request,$id) {

        $proposal = $this->oProposal->FindById($id,session('countryId'),session('companyId'));
        $propTerm = $proposal[0]->term;
   
        if($request->ajax()){
             return $propTerm;
                }

        // return view('module_contracts.precontracts.files', compact('propTerm'));
    }
    // public function create()
    // {
    // }
    public function store(Request $request,$id) {

     //VACIA TODA LA PROPUESTA PARA LLENARLA PARA INSERTAR LAS MODIFICACIONES.
        $this->oProposalTerm->deleteAll($id);

    //recorre el arreglo que viene por requeste, del componente ProposalDetails y realiza una insercion de cada uno de sus elementos.
        if(!empty($request->termsList)) {
        foreach ($request->termsList as $key => $item) {

             $result = $this->oProposalTerm->insert(
              $id,
              $item['termId'],
              $item['termName']);

         $notification = array(
           'message'    => $result['message'],
           'alertType' => $result['alertType'],
          );
        };
     }else{
          $notification = array(
           'message'    => 'Terminos Agregados Exitosamente',
          'alertType' => 'success',
        );
      };//fin 1 else

      //envia siempre la notificacion para saber que if fue cumplido 
         if($request->ajax()){
                return $notification;
            }
    }

    // public function edit($id)
    // {
       
    // }
    // public function update(ContractRequest $request, $id)
    // {
 
    // }
    // public function show(Request $request,$id)
    // {

    // // }
    // public function destroy($id)
    // {
      
    // }


}
