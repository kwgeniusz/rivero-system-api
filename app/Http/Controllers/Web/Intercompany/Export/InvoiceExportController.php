<?php

namespace App\Http\Controllers\Web\Intercompany\Export;

use Auth;
use App;
use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\DateHelper;
use App\Models\Intercompany\ServiceCost;
use App\Company;
use App\Precontract;
use App\Proposal;
use App\ProposalDetail;
use App\Contract;
use App\Invoice;
use App\InvoiceDetail;
use App\CompanyConfiguration;
use App\ProjectDescription;

class InvoiceExportController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->oPrecontract           = new Precontract;
        $this->oProposal              = new Proposal;
        $this->oProposalDetail        = new ProposalDetail;
        $this->oContract              = new Contract;
        $this->oInvoice               = new Invoice;
        $this->oInvoiceDetail         = new InvoiceDetail;
        $this->oCompanyConfiguration  = new CompanyConfiguration;
        $this->oProjectDescription    = new Projectdescription;
        $this->oServiceCost           = new ServiceCost;
    }

    public function sendData(Request $request)
    {
        $error = null;
        
        DB::beginTransaction();
         try {

        // Buscar la Propuesta a utilizar para la duplicacion
        $company     = Company::find(session('companyId'));
        $invoice     = $this->oInvoice->findById($request->invoiceId,session('countryId'),session('companyId'));
        $proposal    = $invoice[0]->proposal;
        $precontract = $proposal->precontract;


        $newPrecontract = $this->oPrecontract->insertPrecontract(
            session('countryId'), 
            $request->companyId,
            $precontract->contractType,
            $precontract->projectName,
            Carbon::now()->format('Y-m-d'), 
            $precontract->clientId,
            $precontract->propertyNumber,
            $precontract->streetName,
            $precontract->streetType,
            $precontract->suiteNumber,
            $precontract->city,
            $precontract->state,
            $precontract->zipCode,
            $precontract->projectUseId,
            $precontract->comment,
            $precontract->currencyId);
            
            // dd($newPrecontract);
            // exit();
            // Crear la Nueva Propuesta
            $newProposal  =   $this->oProposal->insertProp(
                session('countryId'),
                $request->companyId,
                'pre_contract',//esta funcion trae el nombre de la tabla para saber a que campo de la tabla(proposal) insertare el id , en este caso tengo dos opciones precontract y contract
                $newPrecontract->precontractId,//se trae el id de la tabla que halla escogido el usuasio en formulario create .
                $newPrecontract->clientId,
                $proposal->projectDescriptionId,
                Carbon::now()->format('Y-m-d'), //poner funcion de fecha de hoy
                $proposal->taxPercent,
                $proposal->pCondId, 
                $company->paymentMethods,
                '1',
                Auth::user()->userId);
        
    //Insercion de Servicios de la propuesta
    if($proposal->proposalDetail->isNotEmpty()) {
         
          $oProposalDetail = new App\ProposalDetail;
          foreach ($proposal->proposalDetail as $key => $item) {

               $serviceId   =  $item->service->serviceEquivalence->destinationService->serviceId;
               $serviceName =  $item->service->serviceEquivalence->destinationService->serviceName;

       // Si se aplica la formula de costos, hacer esto:
        if(!is_null($item->unit) && $request->costFormula == 'Y'){

                //buscar costo local del producto para saber porcentaje a deducir en la propuesta destino...              
                //   $rs = ServiceCost::where('serviceId', $item->service->serviceId)->get();
  
                //   if($rs->count() > 1){
                      $rs = ServiceCost::where('serviceId', $item->serviceId)
                      ->where('projectUseId', $precontract->projectUseId)
                      ->get();
                      // }
               
                      //  saber el porcentaje a aplicar o el costo por unidad
                      $companyPercent = $rs[0]->targetCompanyPercentage;
                      $companyCost    = $rs[0]->targetCompanyCost;
             
                if($companyPercent > 0 && $item->unit == 'ea'){
                  // Usar porcentaje
                //   var_dump($item->serviceName);
                    $newUP     =   ( $item->unitCost * $companyPercent)/100;
                    $newAmount =   ( $item->amount   * $companyPercent)/100;

                    $result = $oProposalDetail->insert(
                        $newProposal->proposalId,
                        $item->itemNumber,
                        $serviceId,
                        $serviceName,
                        $item->unit,
                        $newUP,
                        $item->quantity,
                        $newAmount);
    
                } elseif($companyCost > 0 && $item->unit == 'sqft'){
                    // Usar monto
                    $newUP  =  $companyCost;
                    $newAmount =  $companyCost * $item->quantity;
                  
                    $result = $oProposalDetail->insert(
                        $newProposal->proposalId,
                        $item->itemNumber,
                        $serviceId,
                        $serviceName,
                        $item->unit,
                        $newUP,
                        $item->quantity,
                        $newAmount );
                }
            // Si NO se aplica la formula de costos, hacer esto:
        }else{
            // var_dump($item->serviceName);

                    $result = $oProposalDetail->insert(
                        $newProposal->proposalId,
                        $item->itemNumber,
                        $serviceId,
                        $serviceName,
                        $item->unit,
                        $item->unitCost,
                        $item->quantity,
                        $item->amount);
        }
        if($result['alertType'] == 'error'){ throw new \Exception($result['message']); }
    } //endforeach
  } //end proposal Detail

        //Insercion de Notas de la propuesta
        if($proposal->note->isNotEmpty()) {

            $oProposalNote = new App\ProposalNote;
              foreach ($proposal->note as $key => $item) {
                $noteId   =  $item->note->noteEquivalence->destinationNote->noteId;
                $noteName =  $item->note->noteEquivalence->destinationNote->noteName;
              
                   $result = $oProposalNote->insert(
                    $newProposal->proposalId,
                    $noteId,
                    $noteName);
                if($result['alertType'] == 'error'){ throw new \Exception($result['message']); }
              };
             
        }
    //Insercion de Alcances
        if($proposal->scope->isNotEmpty()) {
        
            $oProposalScope = new App\ProposalScope;
            foreach ($proposal->scope as $key => $item) {
                 $result = $oProposalScope->insert(
                    $newProposal->proposalId,
                    $item->description);
    
                    if($result['alertType'] == 'error'){ throw new \Exception($result['message']); }
                  };
        }
    //Insercion de Terminos y condiciones
        if($proposal->term->isNotEmpty()) {

            $oProposalTerm = new App\ProposalTerm;
              foreach ($proposal->term as $key => $item) {
                $termId   =  $item->term->termEquivalence->destinationTerm->termId;
                $termName =  $item->term->termEquivalence->destinationTerm->termName;

                   $result = $oProposalTerm->insert(
                    $newProposal->proposalId,
                    $termId,
                    $termName);
      
                  if($result['alertType'] == 'error'){ throw new \Exception($result['message']); }
              };   
        }
    // Insercion de Times Frames
        if($proposal->timeFrame->isNotEmpty()) {
            
            $oProposalTimeFrame = new App\ProposalTimeFrame;
            foreach ($proposal->timeFrame as $key => $item) {
                $timeId   =  $item->timeFrame->timeFrameEquivalence->destinationtime->timeId;
                $timeName =  $item->timeFrame->timeFrameEquivalence->destinationtime->timeName;

                 $result = $oProposalTimeFrame->insert(
                  $newProposal->proposalId,
                  $timeId,
                  $timeName);
    
                  if($result['alertType'] == 'error'){ throw new \Exception($result['message']); }
            };
         }
    // Insertar Cuotas de la propuesta
    if($proposal->paymentProposal->isNotEmpty()) {

        $oPaymentProposal = new App\PaymentProposal;

        if( $request->costFormula == 'Y'){ 
            var_dump($newProposal);
   
            foreach ($proposal->paymentProposal as $key => $item) {
                $result = $oPaymentProposal->addPayment(
                    $newProposal->proposalId,
                    $newProposal->netTotal,
                    $item->paymentDate);
                };
                if($result['alert'] == 'error'){ throw new \Exception($result['message']); }

        }else{
                foreach ($proposal->paymentProposal as $key => $item) {
                    $result = $oPaymentProposal->addPayment(
                        $newProposal->proposalId,
                        $item->amount,
                        $item->paymentDate
                    );
                    if($result['alert'] == 'error'){ throw new \Exception($result['message']); }
                };
            }      
    }
               $success = true;
               DB::commit();
           } catch (\Exception $e) {
               $success = false;
               $error   = $e->getMessage();
               DB::rollback();
           }
   
           if ($success) {
                return $rs  = ['alert' => 'success', 'message' => "Propuesta Exportada a Empresa Destino con Exito"];
           } else {
                return $rs  = ['alert' => 'error', 'message' => $error];
           }
    }

}

