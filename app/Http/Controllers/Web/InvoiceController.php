<?php

namespace App\Http\Controllers\Web;

use Auth;
use App;
use Illuminate\Http\Request;
use App\Http\Requests\PaymentRequest;
use App\Http\Controllers\Controller;
use App\Helpers\DateHelper;
use App\Invoice;
use App\Proposal;
use App\Receivable;
use App\Contract;
use App\CompanyConfiguration;
use App\InvoiceDetail;
use App\PaymentInvoice;
use App\PaymentCondition;
use App\ProjectDescription;
use App\SaleNote;


class InvoiceController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->oInvoice               = new Invoice;
        $this->oProposal              = new Proposal;
        $this->oReceivable            = new Receivable;
        $this->oContract              = new Contract;
        $this->oCompanyConfiguration  = new CompanyConfiguration;
        $this->oInvoiceDetail         = new InvoiceDetail;
        $this->oPaymentInvoice        = new PaymentInvoice;
        $this->oPaymentCondition      = new PaymentCondition;
        $this->oProjectDescription    = new Projectdescription;
        $this->oSaleNote              = new SaleNote;
    }

    public function index(Request $request)
    {
  
        $contract = $this->oContract->findById($request->id,session('countryId'),session('companyId'));
        $invoices = $this->oInvoice->getAllByContract($request->id);
        // $invoices->map(function($invoice){
        //       $invoice->shareSucceed = count($this->oReceivable->shareSucceed($invoice->invoiceId));
        //       $invoice->balance = $this->oInvoice->getBalance($invoice->invoiceId);
        //    });

        $proposals = $this->oProposal->getAllByContract($request->id);

       //este fragmento de codigo lo usa (ModalSwitchContract component)
        if($request->ajax()){
                 return $invoices;
            }

        return view('module_contracts.invoices.index', compact('contract','invoices','proposals'));
    }

    public function create(Request $request)
    {
 
        $contract = $this->oContract->findById($request->id,session('countryId'),session('companyId'));
        $paymentConditions = $this->oPaymentCondition->getAllByLanguage(session('countryId'));
        $projectDescriptions = $this->oProjectDescription->getAll();

        $invId = $this->oCompanyConfiguration->retrieveInvoiceNumber(session('countryId'),session('companyId'));
        $invId++;
        $invoiceTaxPercent   = $this->oCompanyConfiguration->findInvoiceTaxPercent(session('countryId'),session('companyId'));


        return view('module_contracts.invoices.create', compact('contract','paymentConditions','invId','invoiceTaxPercent','projectDescriptions'));
    }

    public function store(Request $request)
    {
           $this->validate($request, [
                'invoiceDate' => 'required',
                'invoiceTaxPercent' => 'required',
           ]);
 
          $contract = $this->oContract->findById($request->contractId,session('countryId'),session('companyId'));

          $invoiceId  =   $this->oInvoice->insertInv(
                      $contract[0]->countryId,
                      $contract[0]->companyId,
                      $contract[0]->contractId,
                      $contract[0]->clientId,
                      $request->projectDescriptionId,
                      $request->invoiceDate,
                      '0.00',
                      $request->invoiceTaxPercent,
                      '0.00',
                      '0.00',
                      $request->paymentConditionId, 
                      Invoice::OPEN,
                      Auth::user()->userId);

        $notification = array(
            'message'    => 'Factura Creada, Agrege Renglones',
            'alert-type' => 'success',
        );

        return redirect()->route('invoicesDetails.index',['btnReturn'=> 'mod_cont','id' => $invoiceId])
            ->with($notification);
    }
      public function edit($id)
    {    
        $invoice           = $this->oInvoice->findById($id,session('countryId'),session('companyId'));
        $paymentConditions = $this->oPaymentCondition->getAllByLanguage();
        $projectDescriptions = $this->oProjectDescription->getAll();

         return view('module_contracts.invoices.edit', compact('invoice','paymentConditions','projectDescriptions'));
    }
      public function update(Request $request, $id)
    {

        $this->oInvoice->updateInvoice(
            $id,
            $request->paymentConditionId,
            $request->projectDescriptionId,
            $request->invoiceDate,
            $request->taxPercent
        );

        $notification = array(
            'message'    => 'Datos Principales de Factura Modificados Exitosamente',
            'alert-type' => 'info',
        );
        
        return redirect()->route('invoices.index',['id' => $request->contractId])
            ->with($notification);
    }
    public function show(Request $request,$id)
    {
        $invoice          = $this->oInvoice->findById($id,session('countryId'),session('companyId'));
        // $invoice[0]->balance = $this->oInvoice->getBalance($id);

          if($request->ajax()){
                return $invoice;
            }
        return view('module_contracts.invoices.show', compact('invoice'));
    }

    public function changeStatus(Request $request)
    {
        $invoice = $this->oInvoice->findById($request->invoiceId,session('countryId'),session('companyId'));

         switch ($request->newStatus) {
           case 'CANCELLED':
            $this->oInvoice->changeStatus($request->invoiceId, Invoice::CANCELLED);
                  foreach ($invoice[0]->sharePending as $key => $sharePending) {
                             $sharePending->recStatusCode = Receivable::ANNULLED;                     
                             $sharePending->save();
                       };
            $notification = array('message'    => 'Factura Cancelada', 'alertType' => 'info');
             break;
           case 'COLLECTION':
            $this->oInvoice->changeStatus($request->invoiceId, Invoice::COLLECTION);
            $notification = array('message'    => 'Factura Enviada a Collection', 'alertType' => 'info');
             break;
         }
      return $notification;
    }

// ----------------FUNCTIONS TO MODULE ADMINISTRATIVE-------------------------------//.
     public function getAllInvoices(Request $request)
    {
       $totalMontoFacturas = 0;
       $totalPorCobrar = 0;
       $totalCollections = 0;
       $totalDebitNote = 0;
       $totalCreditNote = 0;
       $totalCobrado = 0;

     $invoices = $this->oInvoice->getAllByFourStatus(Invoice::OPEN,Invoice::CLOSED,Invoice::PAID,Invoice::COLLECTION,session('companyId'));
    
     foreach ($invoices as $invoice) {
           // $invoice->shareSucceed = count($this->oReceivable->shareSucceed($invoice->invoiceId));
           // $invoice->balance = $this->oInvoice->getBalance($invoice->invoiceId);

            $totalMontoFacturas += $invoice->netTotal;
            $totalCobrado       += $invoice->shareSucceed->sum('amountPaid');
            $totalDebitNote     += $invoice->debitNote->sum('netTotal');
            $totalCreditNote    += $invoice->creditNote->sum('netTotal');
     
          if ($invoice->invStatusCode == Invoice::COLLECTION) {
            $totalCollections   +=  $invoice->balanceTotal;    
          }else{
            $totalPorCobrar     +=  $invoice->balanceTotal;
           }
        }    

   if($request->method() == 'POST') {
       if($request->date1 || $request->date2 || $request->textToFilter) {
  
        //primer filtrado por el select y texto escrito en el formulario.
        if($request->textToFilter){
        $invoices = $invoices->filter(function ($invoice) use($request) {
                      switch ($request->filterBy) {
                        case 'invId':
                               $valorABuscar = $invoice->invId;
                          break;
                        case 'contractNumber':
                              $valorABuscar =  $invoice->contract->contractNumber;
                          break;
                        case 'siteAddress':
                              $valorABuscar =  $invoice->contract->siteAddress;
                              // echo $valorABuscar;
                          break;  
                        case 'clientCode':
                              $valorABuscar =  $invoice->client->clientCode;
                          break;
                        case 'clientName':
                              $valorABuscar =  $invoice->client->clientName;
                          break;  
                        case 'clientPhone':
                              $valorABuscar =  $invoice->client->clientPhone;
                          break;
                      }
                $coincidencia = stripos($valorABuscar, $request->textToFilter);

            if ($coincidencia !== false) { 
                 return $invoice;
            } 

     });
  } //fin del primer filtrado

    //segundo filtrado por fechas se aplica si estan llenos los dos campos de fecha
  if($request->date1 && $request->date2) {

    $totalMontoFacturas = 0;
    $totalPorCobrar = 0;
    $totalCollections = 0;
    $totalDebitNote = 0;
    $totalCreditNote = 0;
    $totalCobrado = 0;

  
    $invoices = $invoices->filter(function ($invoice) use($request) {
               //  formatear fechas
              $date_inicio = strtotime($request->date1);
              $date_fin    = strtotime($request->date2);
              $date_nueva  = strtotime($invoice->invoiceDate);
               // esta dentro del rango
              if (($date_nueva >= $date_inicio) && ($date_nueva <= $date_fin)){
                 return $invoice;
              }
     });
  
     foreach ($invoices as $invoice) {
    
       $totalMontoFacturas += $invoice->netTotal;
       $totalCobrado       += $invoice->shareSucceed->sum('amountPaid');
       $totalDebitNote     += $invoice->debitNote->sum('netTotal');
       $totalCreditNote    += $invoice->creditNote->sum('netTotal');

     if ($invoice->invStatusCode == Invoice::COLLECTION) {
       $totalCollections   +=  $invoice->balanceTotal;    
     }else{
       $totalPorCobrar     +=  $invoice->balanceTotal;
      }
   }

//    $debitNotes  =  $this->oSaleNote->getAllByType(session('companyId'),'debit');
//    $creditNotes =  $this->oSaleNote->getAllByType(session('companyId'),'credit');
  
//    $debitNotes = $debitNotes->filter(function ($debit) use($request) {
//             //  formatear fechas
//             $date_inicio = strtotime($request->date1);
//             $date_fin    = strtotime($request->date2);
//             $date_nueva  = strtotime($debit->dateNote);
//      // esta dentro del rango
//     if (($date_nueva >= $date_inicio) && ($date_nueva <= $date_fin)){
//        return $debit;
//     }
// });

//    $creditNotes = $creditNotes->filter(function ($credit) use($request) {
//               //  formatear fechas
//               $date_inicio = strtotime($request->date1);
//               $date_fin    = strtotime($request->date2);
//               $date_nueva  = strtotime($credit->dateNote);
//    // esta dentro del rango
//   if (($date_nueva >= $date_inicio) && ($date_nueva <= $date_fin)){
//        return $credit;
//   }
// });


// $totalDebitNote       =    $debitNotes->sum('netTotal');
// $totalCreditNote       =    $creditNotes->sum('netTotal');

    }//fin del segundo filtrado

  } //cierre del filtrado general.
 }//cierre de request->post

        return view('module_administration.invoices.index', compact('invoices','totalMontoFacturas','totalCobrado','totalCollections','totalPorCobrar','totalDebitNote','totalCreditNote'));
    }


    public function InvoicesCancelled(Request $request)
    {
       // $totalMontoFacturas = 0;
       // $totalCobrado = 0;
       // $totalPorCobrar = 0;
       // $totalCollections = 0;

     $invoices = $this->oInvoice->getAllByStatus(Invoice::CANCELLED,session('companyId'));

         // foreach ($invoices as $invoice) {
           // $invoice->shareSucceed = count($this->oReceivable->shareSucceed($invoice->invoiceId));
           // $invoice->balance = $this->oInvoice->getBalance($invoice->invoiceId);

          //   $totalMontoFacturas += $invoice->netTotal;
          //   $totalCobrado   += ($invoice->netTotal - $invoice->balance);
          // if ($invoice->invStatusCode == Invoice::COLLECTION) {
          //   $totalCollections   += $invoice->balance;    
          // }else{
          //   $totalPorCobrar    += $invoice->balance;
          //  }
        // }


        return view('module_administration.invoices.cancelled', compact('invoices'));
    }
//---------------PAYMENTS-----------------------//

    public function payments(Request $request,$id)
    {

        $invoice         = $this->oInvoice->findById($id,session('countryId'),session('companyId'));
        $invoiceDetails  = $this->oInvoiceDetail->getAllByInvoice($id);
        $payments        = $invoice[0]->receivable;
        // dd($payments);
        // exit();
        // $payments        = $this->oPaymentInvoice->getAllByInvoice($id);

        $currentShare           = $this->oReceivable->currentShare($id);
         //saldo de la factura
        // $invoiceBalance         = $this->oInvoice->getBalance($id);
         //saber que cuota le corresponde mostrar los botones de cobro y verificación

        $btnReturn = $request->btnReturn;
        
        return view('module_contracts.invoices.payment', compact('invoice','invoiceDetails', 'payments','currentShare','btnReturn'));

    }

    public function paymentsAdd(PaymentRequest $request)
    {

        $result = $this->oPaymentInvoice->addPayment(
            $request->invoiceId,
            $request->amount,
            $request->paymentDate
        );

        $notification = array(
            'message'    => $result['msj'],
            'alert-type' => $result['alert'],
        );

      return redirect()->back()->with($notification);

    }
    public function paymentsRemove($id, $invoiceId)
    {

        $result = $this->oPaymentInvoice->removePayment($id,$invoiceId);

        $notification = array(
            'message'    => $result['msj'],
            'alert-type' => $result['alert'],
        );

      return redirect()->back()->with($notification);
    
    }
//---------------SUBCONTRACTOR-----------------------//

  public function subcontractors($invoiceId)
    {
        $invoice         = $this->oInvoice->findById($invoiceId,session('countryId'),session('companyId'));
        return view('module_contracts.invoices.subcontractors', compact('invoice'));
       
    }

//--------------COMUNICATION OF INTERCOMPANY INVOICE----------//

public function generateIntercompanyInvoiceWithCostReduction($originInvoiceId, $precontractId)
{
    $error = null;
    
    DB::beginTransaction();
     try {
      //VALOR QUE SE EXTRAE DE LA ENTIDAD SUBCONTRACTOR...
      $destinationCountry = 1; // ESTADOS UNIDOS - ESTE ES EL PAIS DE DESTINO
      $destinationCompany = 1; // JD RIVERO INC  - ESTA ES LA COMPANIA DESTINO

      //AHORA, YA SABIENDO CUAL ES LA COMPANIA DESTINO NECESITO SABER DENTRO DE SU LISTA DE CLIENTES, CUAL ES LA COMPANIA ORIGEN...
      $client = $oClient->findByIntercompanyId($destinationCompany,session('companyId'));

      //BUSCAR EL CONTRATO Y LA FACTURA A UTILIZAR PARA LA DUPLICACION
      $originInvoice  = $oInvoice->findById($originInvoiceId,session('countryId'),session('companyId'));
      $originContract = $oInvoice->contract;

    // INSERTAR EL NUEVO CONTRATO
      $newContract = $this->oContract->insertContract(
        $destinationCountry,
        $destinationCompany,
        $originContract->contractType,
        $originContract->projectName,
        $originContract->contractDate,
        $client->clientId,
        $originContract->propertyNumber,
        $originContract->streetName,
        $originContract->streetType,
        $originContract->suiteNumber,
        $originContract->city,
        $originContract->state,
        $originContract->zipCode,     
        $originContract->buildingCodeId,
        $originContract->groupId,
        $originContract->projectUseId,
        $originContract->constructionType,
        $originContract->initialComment,
        $originContract->currencyId);

    // CREAR LA NUEVA FACTURA
      $newInvoice  =   $this->insertInv(
        $destinationCountry,
        $destinationCompany,
        $newContract->contractId,
        $client->clientId,
        $originInvoice->projectDescriptionId,
        $originInvoice->invoiceDate,
        $originInvoice->grossTotal,
        $originInvoice->taxPercent,
        $originInvoice->taxAmount,
        $originInvoice->netTotal,
        $originInvoice->paymentConditionId,
        $originInvoice->invStatusCode,
        Auth::user()->userId);

//Insercion de Servicios de la factura
if($originInvoice->invoiceDetails->isNotEmpty()) {
   
      foreach ($originInvoice->invoiceDetails as $key => $item) {
          $result = $oInvoiceDetail->insert(
              $newInvoice->invoiceId,
              $item->itemNumber,
              $item->serviceId,
              $item->serviceName,
              $item->unit,
              $item->unitCost,
              $item->quantity,
              $item->amount);
            }
}

    //Insercion de Notas de la propuesta
    if($proposal[0]->note->isNotEmpty()) {

        $oProposalNote = new App\ProposalNote;
          foreach ($proposal[0]->note as $key => $item) {
               $result = $oProposalNote->insert(
                $newProposalId,
                $item->noteId,
                $item->noteName);
            if($result['alertType'] == 'error'){ throw new \Exception($result['message']); }
          };
         
    }
//Insercion de Alcances
    if($proposal[0]->scope->isNotEmpty()) {
    
        $oProposalScope = new App\ProposalScope;
        foreach ($proposal[0]->scope as $key => $item) {
             $result = $oProposalScope->insert(
                $newProposalId,
                $item->description);

                if($result['alertType'] == 'error'){ throw new \Exception($result['message']); }
              };
    }
//Insercion de Terminos y condiciones
    if($proposal[0]->term->isNotEmpty()) {

        $oProposalTerm = new App\ProposalTerm;
          foreach ($proposal[0]->term as $key => $item) {
               $result = $oProposalTerm->insert(
                $newProposalId,
                $item->termId,
                $item->termName);
  
              if($result['alertType'] == 'error'){ throw new \Exception($result['message']); }
          };   
    }
// Insercion de Times Frames
    if($proposal[0]->timeFrame->isNotEmpty()) {
        
        $oProposalTimeFrame = new App\ProposalTimeFrame;
        foreach ($proposal[0]->timeFrame as $key => $item) {
             $result = $oProposalTimeFrame->insert(
              $newProposalId,
              $item->timeId,
              $item->timeName);

              if($result['alertType'] == 'error'){ throw new \Exception($result['message']); }
        };
     }
// Insertar Cuotas de la propuesta
     if($proposal[0]->paymentProposal->isNotEmpty()) {

        $oPaymentProposal = new App\PaymentProposal;
        foreach ($proposal[0]->paymentProposal as $key => $item) {
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
            return $rs  = ['alert' => 'success', 'message' => "Propuesta Duplicada con Exito"];
       } else {
            return $rs  = ['alert' => 'error', 'message' => $error];
       }

}

}
