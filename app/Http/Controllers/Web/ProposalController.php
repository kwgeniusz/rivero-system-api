<?php

namespace App\Http\Controllers\Web;


use Auth;
use App;
use DB;
use App\OfficeConfiguration;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Precontract;
use App\Contract;
use App\Proposal;
use App\ProposalDetail;
use App\PaymentProposal;
use App\PaymentCondition;
use App\Invoice;
use App\InvoiceDetail;
use App\InvoiceNote;
use App\InvoiceScope;
use App\PaymentInvoice;
use App\ProjectDescription;
use App\Http\Requests\PaymentRequest;
use App\Helpers\DateHelper;

class ProposalController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->oOfficeConfiguration     = new OfficeConfiguration;
        $this->oContract       = new Contract;
        $this->oPrecontract       = new Precontract;
        $this->oProposal          = new Proposal;
        $this->oProposalDetail    = new ProposalDetail;
        $this->oPaymentProposal    = new PaymentProposal;
        $this->oPaymentCondition  = new PaymentCondition;
        $this->oInvoice = new Invoice;
        $this->oInvoiceDetail = new InvoiceDetail;
        $this->oInvoiceNote = new InvoiceNote;
        $this->oInvoiceScope = new InvoiceScope;
        $this->oPaymentInvoice = new PaymentInvoice;
        $this->oProjectDescription = new Projectdescription;

    }

    public function index(Request $request)
    {

        $precontract = $this->oPrecontract->findById($request->id,session('countryId'),session('officeId'));
        $proposals = $this->oProposal->getAllByPrecontract($request->id);

         if($request->ajax()){
                return $proposals;
            }

        return view('module_contracts.proposals.index', compact('precontract','proposals'));
    }

    public function create(Request $request)
    {
        if($request->modelType == 'pre_contract'){
          $oModelType = $this->oPrecontract;
        }else{     
          $oModelType = $this->oContract;
        }

        $projectDescriptions = $this->oProjectDescription->getAll();
        $paymentConditions = $this->oPaymentCondition->getAllByLanguage();
        $invoiceTaxPercent   = $this->oOfficeConfiguration->findInvoiceTaxPercent(session('countryId'),session('officeId'));

        $propId = $this->oOfficeConfiguration->retrieveProposalNumber(session('countryId'),session('officeId'));
        $propId++;

     $modelRs = $oModelType->findById($request->id,session('countryId'),session('officeId'));

     return view('module_contracts.proposals.create', compact('propId','modelRs','paymentConditions','invoiceTaxPercent','projectDescriptions'));
    }

    public function store(Request $request)
    {
           $this->validate($request, [
                'invoiceDate' => 'required',
                'invoiceTaxPercent' => 'required',
           ]);
 
        if($request->modelType == 'pre_contract'){
          $oModelType = $this->oPrecontract;
        }else{     
          $oModelType = $this->oContract;
        }

          $modelRs = $oModelType->findById($request->modelId,session('countryId'),session('officeId'));

          $proposalId  =   $this->oProposal->insertProp(
                      $modelRs[0]->countryId,
                      $modelRs[0]->officeId,
                      $modelRs[0]->getTable(),//esta funcion trae el nombre de la tabla para saber a que campo de la tabla(proposal) insertare el id , en este caso tengo dos opciones precontract y contract
                      $request->modelId,//se trae el id de la tabla que halla escogido el usuasio en formulario create .
                      $modelRs[0]->clientId,
                      $request->projectDescriptionId,
                      $request->invoiceDate,
                      $request->invoiceTaxPercent,
                      $request->paymentConditionId, 
                      '1');

        $notification = array(
                     'message'    => 'Propuesta Creada, Agrege Renglones',
                     'alert-type' => 'success');
 
          return redirect()->route('proposalsDetails.index',['btnReturn'=> 'mod_cont','modelType' => $request->modelType,'id' => $proposalId])
            ->with($notification);


    }

     public function edit($id)
    {    
        $proposal = $this->oProposal->findById($id,session('countryId'),session('officeId'));
        $paymentConditions = $this->oPaymentCondition->getAllByLanguage();
        $projectDescriptions = $this->oProjectDescription->getAll();

         return view('module_contracts.proposals.edit', compact('proposal','paymentConditions','projectDescriptions'));
    }

    public function update(Request $request, $id)
    {

        $proposal = $this->oProposal->updateProposal(
            $id,
            $request->paymentConditionId,
            $request->projectDescriptionId,
            $request->invoiceDate,
            $request->invoiceTaxPercent
        );

        $notification = array(
            'message'    => 'Datos Principales de Propuesta Modificados Exitosamente',
            'alert-type' => 'info',
        );

        if($proposal->contractId ==null){
           return redirect()->route('proposals.index',['id' => $proposal->precontractId])
            ->with($notification);
        } 
        else{
            return redirect()->route('invoices.index',['id' => $proposal->contractId])
            ->with($notification);
        }

    }

    public function show(Request $request,$id)
    {
        $proposal = $this->oProposal->findById($id,session('countryId'),session('officeId'));

          if($request->ajax()){
                return $proposal;
            }
        return view('module_contracts.proposals.show', compact('proposal'));
    }
      public function destroy($id)
    {
        $proposal = $this->oProposal->findById($id,session('countryId'),session('officeId'));
        
        $this->oProposal->deleteProposal($id);

          $notification = array(
            'message'    => 'Propuesta Eliminada',
            'alert-type' => 'info',
        );

         return redirect()->route('proposals.index',['id' => $proposal[0]->precontractId])
            ->with($notification);

    }



  public function convert(Request $request)
    {
      $proposal = $this->oProposal->FindById($request->id,session('countryId'),session('officeId')); 

        return view('module_contracts.proposals.convert', compact('proposal'));

    }
    public function convertAdd($id)
    {
        $error = null;

        DB::beginTransaction();
        try {
      //traer todos los datos del proposal
    $proposal     = $this->oProposal->FindById($id,session('countryId'),session('officeId')); 
  
        //insertar el nuevo Invoice
            $invoice  = $this->oInvoice->insertInv(
                  $proposal[0]->countryId,
                  $proposal[0]->officeId,
                  $proposal[0]->contractId,
                  $proposal[0]->clientId,
                  $proposal[0]->projectDescriptionId,
                  date('m/d/Y'),
                  '0.00',
                  $proposal[0]->taxPercent,
                  '0.00',
                  '0.00',
                  $proposal[0]->pCondId,
                  Invoice::OPEN);
             // dd($invoice);
             // dd($proposal[0]->proposalDetail);
             //      exit();
               foreach ($proposal[0]->proposalDetail as $proposalDetail) {
                      $this->oInvoiceDetail->insert(
                       $invoice->invoiceId,
                       $proposalDetail->itemNumber,
                       $proposalDetail->serviceId,
                       $proposalDetail->serviceName,
                       $proposalDetail->unit,
                       $proposalDetail->unitCost,
                       $proposalDetail->quantity,
                       $proposalDetail->amount);
                    }
           // dd($proposal[0]);
           //       exit();
               foreach ($proposal[0]->note as $note) {
                     $this->oInvoiceNote->insert(
                       $invoice->invoiceId,
                       $note->noteId,
                       $note->noteName);
                   }

            foreach ($proposal[0]->scope as $scope) {
                     $this->oInvoiceScope->insert(
                       $invoice->invoiceId,
                       $scope->description);
                   }      
               foreach ($proposal[0]->paymentProposal as $payment) {
                    $this->oPaymentInvoice->addPayment(
                            $invoice->invoiceId,
                            $payment->amount,
                            null
                           );
                   }

            $this->oProposal->assignInvoiceId($proposal[0]->proposalId,$invoice->invoiceId);       

            $success = true;
            DB::commit();
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
            DB::rollback();
        }

        if ($success) {
            $result = ['alert' => 'success', 'msj' => "Conversión Exitosa, Contrato N° $invoice->invId creada"];
        } else {
            $result = ['alert' => 'error', 'msj' => $error];
        }

        $notification = array(
            'message'    => $result['msj'],
            'alert-type' => $result['alert'],
        );
        return redirect()->route('invoices.index',['id' => $proposal[0]->contractId])->with($notification);

    }

  public function getAllProposals(Request $request)
    {
      $proposals = $this->oProposal->getAllByOffice(session('officeId'));

      if($request->method() == 'POST') {
       if($request->date1 || $request->date2 || $request->textToFilter) {
  
        //primer filtrado por el select y texto escrito en el formulario.
        if($request->textToFilter){
        $proposals = $proposals->filter(function ($proposal) use($request) {
                      switch ($request->filterBy) {
                        case 'invId':
                               $valorABuscar = $proposal->propId;
                          break;
                        case 'siteAddress':
                          if($proposal->precontract == null)
                              $valorABuscar =  $proposal->contract->siteAddress;
                          else
                              $valorABuscar =  $proposal->precontract->siteAddress;
                          break;  
                        case 'clientCode':
                              $valorABuscar =  $proposal->client->clientCode;
                          break;
                        case 'clientName':
                              $valorABuscar =  $proposal->client->clientName;
                          break;  
                        case 'clientPhone':
                              $valorABuscar =  $proposal->client->clientPhone;
                          break;
                      }
                $coincidencia = stripos($valorABuscar, $request->textToFilter);

            if ($coincidencia !== false) { 
                 return $proposal;
            } 

     });
  } //fin del primer filtrado

    //segundo filtrado por fechas se aplica si estan llenos los dos campos de fecha
  if($request->date1 && $request->date2) {
    $proposals = $proposals->filter(function ($proposal) use($request) {
   
               $oDateHelper = new DateHelper;
               $functionRs = $oDateHelper->changeDateForCountry(session('countryId'),'Mutador');
               $date1                 = $oDateHelper->$functionRs($request->date1);
               $date2                 = $oDateHelper->$functionRs($request->date2);
               $proposalDate       = $oDateHelper->$functionRs($proposal->proposalDate);

              $date_inicio = strtotime($date1);
              $date_fin    = strtotime($date2);
              $date_nueva  = strtotime($proposalDate);

               // esta dentro del rango
              if (($date_nueva >= $date_inicio) && ($date_nueva <= $date_fin)){
                 return $proposal;
              }
     });
    }//fin del segundo filtrado



  } //cierre del filtrado general.
 }//cierre de request->post

        return view('module_administration.proposals.index', compact('proposals'));
    }
//---------------PAYMENTS-----------------------//

    public function payments(Request $request,$id)
    {

        $proposal         = $this->oProposal->findById($id,session('countryId'),session('officeId'));
        $proposalDetails  = $this->oProposalDetail->getAllByProposal($id);
        $payments        = $this->oPaymentProposal->getAllByProposal($id);

        $btnReturn = $request->btnReturn;
        return view('module_contracts.proposals.payment', compact('proposal','proposalDetails', 'payments','btnReturn'));

    }

    public function paymentsAdd(PaymentRequest $request)
    {

        $result = $this->oPaymentProposal->addPayment(
            $request->proposalId,
            $request->amount,
            $request->paymentDate
        );

        $notification = array(
            'message'    => $result['msj'],
            'alert-type' => $result['alert'],
        );
        
        return redirect()->route('proposals.payments', ['btnReturn' => 'mod_cont','id' => $request->proposalId])
            ->with($notification);

    }
    public function paymentsRemove($id, $proposalId)
    {

        $result = $this->oPaymentProposal->removePayment($id,$proposalId);

        $notification = array(
            'message'    => $result['msj'],
            'alert-type' => $result['alert'],
        );

        return redirect()->route('proposals.payments', ['btnReturn' => 'mod_cont','id' => $proposalId])
            ->with($notification);
    }
}
