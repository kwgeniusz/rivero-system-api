<?php

namespace App\Http\Controllers\Web;


use Auth;
use DB;
use PDO;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Precontract;
use App\Contract;
use App\Proposal;
use App\ProposalDetail;
use App\ProposalNote;
use App\Models\Inventory\Service;


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
    public function storeOneByOne(Request $request)
    {
        // inicializacion de datos
        $msg = [];
        $rs  = [];

        DB::beginTransaction();
        try {
              
    //  EN ESTE PRIMER RECORRIDO SE COMIENZA DESDE EL NODO PADRE HASTA EL HIJO DEL ULTIMO NIVEL 
        // Busqueda de los ancestros del servicio seleccionado
            $serviceWithAncestors = Service::find($request->selectedService['serviceId'])->ancestors;
            //revertir el orden de los ancestros
            $serviceWithAncestors = $serviceWithAncestors->reverse()->values();
            //insertar el servicio seleccionado, en la ultima posicion de la coleccion de ancestros
            $serviceWithAncestors->push($request->selectedService);

            
       // Insertando valores en la tabla ProposalDetail, se agrega los ancestros y el servicio seleccionado.
            if(!empty($serviceWithAncestors)) {
              foreach ($serviceWithAncestors as $key => $item) {
             //buscar si existe ese servicio dentro de la propuesta, para que no me lo inserte.
               $serviceFound  = ProposalDetail::where('serviceId',$item['serviceId'])
                                        ->where('proposalId',$request->proposalId)
                                        ->get();
             
              if($serviceFound->isEmpty()) { 
            // si es una categoria solamente necesito insertar nombre y parentId
                 if($item['isCategory'] == 'Y') { 
                $msg = $this->oProposalDetail->insert(
                    $request->proposalId,
                     ++$key,
                    $item['isCategory'],
                    $item['serviceId'],
                    $item['serviceParentId'],
                    $item['serviceName'],
                    '',
                    '',
                    '',
                    0);
               } else{
                // si no es categoria, quiere decir que es un servicio con precio del ultimo nivel.
                $msg = $this->oProposalDetail->insert(
                    $request->proposalId,
                     ++$key,
                    $item['isCategory'],
                    $item['serviceId'],
                    $item['serviceParentId'],
                    $item['serviceName'],
                    $item['unitSelected'],
                    $item['unitCost'],
                    $item['quantity'],
                    $item['sumTotal']);
               } //if(!$serviceFound)
            } //if($item['isCategory'] == 'Y') 

          } //foreach ($request->itemList as $key => $item)
        } //if(!empty($serviceWithAncestors)) 
        //  dd($msg);
        //  exit();
        if(empty($msg)) {
            throw new \Exception('Ya Existe este servicio');
           };
          
        // Ejecutar funcion de actualizacion de monto en cascada hacia arriba.
         $oProposalDetail = new ProposalDetail;
         $msg = $this->oProposalDetail->cascadeBalanceUpdate($request->proposalId, $msg['entity'], $item['sumTotal']);
      
            $success = true;
            DB::commit();
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
            DB::rollback();
        }

        if ($success) {
            return ['alertType' => 'success', 'message' => 'Reglon Guardado Exitosamente'];
        } else {
            return ['alertType' => 'error', 'message' => $error];
        }
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
