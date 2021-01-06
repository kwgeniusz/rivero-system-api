<?php

namespace App\Http\Controllers\Web;


use Auth;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Precontract;
use App\Contract;
use App\Proposal;
use App\ProposalDetail;
use App\ProposalNote;

class ProposalDetailController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->oPrecontract           = new Precontract;
        $this->oContract              = new Contract;
        $this->oProposal              = new Proposal;
        $this->oProposalDetail        = new ProposalDetail;
        $this->oProposalNote          = new ProposalNote;
    }
    public function index(Request $request)
    {
 
        $proposal = $this->oProposal->findById($request->id,session('countryId'),session('companyId'));

       if($request->modelType == 'pre_contract'){
          $oModelType = $this->oPrecontract;
        }else{     
          $oModelType = $this->oContract;
        }
        //sacar nombre del campo Id de esta tabla o modelo
        $modelId = $oModelType->getKeyName();
        $modelRs = $oModelType->findById($proposal[0]->$modelId,session('countryId'),session('companyId'));


        $btnReturn = $request->btnReturn;
          return view('module_contracts.proposals.details.index', compact('proposal','modelRs','btnReturn'));
    }

    public function store(Request $request)
    {
    
     $error = null;

        DB::beginTransaction();
        try {
    
         //VACIA TODA LA PROPUESTA PARA LLENARLA PARA INSERTAR LAS MODIFICACIONES.
       $rs =  $this->oProposalDetail->deleteProp($request->proposalId);

      if($rs['alertType'] == 'error'){ 
         throw new \Exception($rs['message']);
      }
    
    //recorre el arreglo que viene por requeste, del componente ProposalDetails y realiza una insercion de cada uno de sus elementos.
     if(!empty($request->itemList)) {
        foreach ($request->itemList as $key => $item) {
           $result = $this->oProposalDetail->insert(
                          $request->proposalId,
                          ++$key,
                          $item['serviceId'],
                          $item['serviceName'],
                          $item['unit'],
                          $item['unitCost'],
                          $item['quantity'],
                          $item['amount']);
             }
           }
      //envia siempre la notificacion para saber que if fue cumplido 
         // if($request->ajax()){
         //        return $notification;
         //    }
            $success = true;
            DB::commit();
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
            DB::rollback();
        }

        if ($success) {
            return $result = ['alertType' => 'success', 'message' => 'Reglon Guardados Exitosamente'];
        } else {
            return $result = ['alertType' => 'error', 'message' => $error];
        }
    
    }

     public function show(Request $request,$id)
    {
        $proposalDetails = $this->oProposalDetail->getAllByProposal($id);

          if($request->ajax()){
                return $proposalDetails;
            }
        return view('module_contracts.proposals.details', compact('proposalDetails'));
    }

    public function destroy($id)
    {
        $result = $this->oProposalDetail->deleteProp($id);

           $notification = array(
            'message'    => $result['message'],
            'alertType' => $result['alertType'],
        );
         return $notification;

    }
}
