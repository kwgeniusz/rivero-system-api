<?php

namespace App\Http\Controllers\Web\Intercompany\Export;

use Auth;
use App;
use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\DateHelper;
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
            
            // Crear la Nueva Propuesta
            $newProposalId  =   $this->oProposal->insertProp(
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
             
              $result = $oProposalDetail->insert(
                  $newProposalId,
                  $item->itemNumber,
                  $serviceId,
                  $serviceName,
                  $item->unit,
                  $item->unitCost,
                  $item->quantity,
                  $item->amount);
                }
        }

        //Insercion de Notas de la propuesta
        if($proposal->note->isNotEmpty()) {

            $oProposalNote = new App\ProposalNote;
              foreach ($proposal->note as $key => $item) {
                $noteId   =  $item->note->noteEquivalence->destinationNote->noteId;
                $noteName =  $item->note->noteEquivalence->destinationNote->noteName;
              
                   $result = $oProposalNote->insert(
                    $newProposalId,
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
                    $newProposalId,
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
                    $newProposalId,
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
                  $newProposalId,
                  $timeId,
                  $timeName);
    
                  if($result['alertType'] == 'error'){ throw new \Exception($result['message']); }
            };
         }
    // Insertar Cuotas de la propuesta
         if($proposal->paymentProposal->isNotEmpty()) {

            $oPaymentProposal = new App\PaymentProposal;
            foreach ($proposal->paymentProposal as $key => $item) {
                $result = $oPaymentProposal->addPayment(
                    $newProposalId,
                    $item->amount,
                    $item->paymentDate
                );
                  if($result['alert'] == 'error'){ throw new \Exception($result['message']); }
            };
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

