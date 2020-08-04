<?php

namespace App\Http\Controllers\Web;


use Auth;
use App;
use App\Http\Controllers\Controller;
use App\Helpers\DateHelper;
use Illuminate\Http\Request;
use App\Invoice;
use App\Proposal;
use App\Receivable;
use App\Contract;
use App\CompanyConfiguration;
use App\InvoiceDetail;
use App\PaymentInvoice;
use App\PaymentCondition;
use App\ProjectDescription;
use App\Http\Requests\PaymentRequest;


class InvoiceController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->oInvoice        = new Invoice;
        $this->oProposal        = new Proposal;
        $this->oReceivable        = new Receivable;
        $this->oContract       = new Contract;
        $this->oCompanyConfiguration  = new CompanyConfiguration;
        $this->oInvoiceDetail        = new InvoiceDetail;
        $this->oPaymentInvoice        = new PaymentInvoice;
        $this->oPaymentCondition  = new PaymentCondition;
        $this->oProjectDescription = new Projectdescription;
    }

    public function index(Request $request)
    {
  
        $contract = $this->oContract->findById($request->id,session('countryId'),session('companyId'));
        $invoices = $this->oInvoice->getAllByContract($request->id);
        $invoices->map(function($invoice){
              $invoice->shareSucceed = count($this->oReceivable->shareSucceed($invoice->invoiceId));
              $invoice->balance = $this->oInvoice->getBalance($invoice->invoiceId);
           });

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
                      Invoice::OPEN);

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
        $invoice = $this->oInvoice->findById($id,session('countryId'),session('companyId'));

          if($request->ajax()){
                return $invoice;
            }
        return view('module_contracts.invoices.show', compact('invoice'));
    }

    public function changeStatus(Request $request)
    {
         switch ($request->newStatus) {
           case 'CANCELLED':
            $this->oInvoice->changeStatus($request->invoiceId, Invoice::CANCELLED);
              $notification = array('message'    => 'Factura Cancelada', 'alertType' => 'info');
             break;
           case 'COLLECTION':
            $this->oInvoice->changeStatus($request->invoiceId, Invoice::COLLECTION);
              $notification = array('message'    => 'Factura Enviada a Collection', 'alertType' => 'info');
             # code...
             break;
         }
      return $notification;
    }

// ----------------FUNCTIONS TO MODULE ADMINISTRATIVE-------------------------------//.
     public function getAllInvoices(Request $request)
    {
       $totalMontoFacturas = 0;
       $totalCobrado = 0;
       $totalPorCobrar = 0;
       $totalCollections = 0;

     $invoices = $this->oInvoice->getAllByFourStatus(Invoice::OPEN,Invoice::CLOSED,Invoice::PAID,Invoice::COLLECTION,session('companyId'));

         foreach ($invoices as $invoice) {
           $invoice->shareSucceed = count($this->oReceivable->shareSucceed($invoice->invoiceId));
           $invoice->balance = $this->oInvoice->getBalance($invoice->invoiceId);

            $totalMontoFacturas += $invoice->netTotal;
            $totalCobrado   += ($invoice->netTotal - $invoice->balance);
          if ($invoice->invStatusCode == Invoice::COLLECTION) {
            $totalCollections   += $invoice->balance;    
          }else{
            $totalPorCobrar    += $invoice->balance;
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
    $invoices = $invoices->filter(function ($invoice) use($request) {
   
               $oDateHelper = new DateHelper;
               $functionRs = $oDateHelper->changeDateForCountry(session('countryId'),'Mutador');
               $date1                 = $oDateHelper->$functionRs($request->date1);
               $date2                 = $oDateHelper->$functionRs($request->date2);
               $invoiceDate       = $oDateHelper->$functionRs($invoice->invoiceDate);

              $date_inicio = strtotime($date1);
              $date_fin    = strtotime($date2);
              $date_nueva  = strtotime($invoiceDate);

               // esta dentro del rango
              if (($date_nueva >= $date_inicio) && ($date_nueva <= $date_fin)){
                 return $invoice;
              }
     });
    }//fin del segundo filtrado

  } //cierre del filtrado general.
 }//cierre de request->post

        return view('module_administration.invoices.index', compact('invoices','totalMontoFacturas','totalCobrado','totalCollections','totalPorCobrar'));
    }


    public function InvoicesCancelled(Request $request)
    {
       // $totalMontoFacturas = 0;
       // $totalCobrado = 0;
       // $totalPorCobrar = 0;
       // $totalCollections = 0;

     $invoices = $this->oInvoice->getAllByStatus(Invoice::CANCELLED,session('companyId'));

         foreach ($invoices as $invoice) {
           $invoice->shareSucceed = count($this->oReceivable->shareSucceed($invoice->invoiceId));
           $invoice->balance = $this->oInvoice->getBalance($invoice->invoiceId);

          //   $totalMontoFacturas += $invoice->netTotal;
          //   $totalCobrado   += ($invoice->netTotal - $invoice->balance);
          // if ($invoice->invStatusCode == Invoice::COLLECTION) {
          //   $totalCollections   += $invoice->balance;    
          // }else{
          //   $totalPorCobrar    += $invoice->balance;
          //  }
        }


        return view('module_administration.invoices.cancelled', compact('invoices'));
    }
//---------------PAYMENTS-----------------------//

    public function payments(Request $request,$id)
    {

        $invoice         = $this->oInvoice->findById($id,session('countryId'),session('companyId'));
        $invoiceDetails  = $this->oInvoiceDetail->getAllByInvoice($id);
        $payments        = $this->oPaymentInvoice->getAllByInvoice($id);

         //saldo de la factura
        $invoiceBalance         = $this->oInvoice->getBalance($id);
         //saber que cuota le corresponde mostrar los botones de cobro y verificación
        $currentShare           = $this->oReceivable->currentShare($id);

        $btnReturn = $request->btnReturn;
        
        return view('module_contracts.invoices.payment', compact('invoice','invoiceDetails', 'payments','invoiceBalance','currentShare','btnReturn'));

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



}
