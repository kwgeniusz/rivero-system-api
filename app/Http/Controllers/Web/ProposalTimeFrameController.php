<?php

namespace App\Http\Controllers\Web;

use Auth;
use App\Proposal;
use App\ProposalTimeFrame;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProposalTimeFrameController extends Controller
{
    private $oProposal;
    private $oProposalTimeFrame;

    public function __construct()
    {
        $this->middleware('auth');
        $this->oProposal              = new Proposal;
        $this->oProposalTimeFrame     = new ProposalTimeFrame;
    }

    public function index(request $request,$id) {

        $proposal = $this->oProposal->FindById($id,session('countryId'),session('companyId'));
        $propTimeFrames = $proposal[0]->timeFrame;
   
        if($request->ajax()){
             return $propTimeFrames;
                }

        // return view('module_contracts.precontracts.files', compact('propTimeFrames'));
    }
    // public function create()
    // {
    // }
    public function store(Request $request,$id) {

     //VACIA TODA LA PROPUESTA PARA LLENARLA PARA INSERTAR LAS MODIFICACIONES.
        $this->oProposalTimeFrame->deleteAll($id);

    //recorre el arreglo que viene por requeste, del componente ProposalDetails y realiza una insercion de cada uno de sus elementos.
        if(!empty($request->timesList)) {
        foreach ($request->timesList as $key => $item) {

             $result = $this->oProposalTimeFrame->insert(
              $id,
              $item['timeId'],
              $item['timeName']);

         $notification = array(
           'message'    => $result['message'],
           'alertType' => $result['alertType'],
          );
        };
     }else{
          $notification = array(
           'message'    => 'Time Frame Guardadas',
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
