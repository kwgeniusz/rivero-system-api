<?php

namespace App\Http\Controllers\Web;


use Auth;
use App;
use App\Http\Controllers\Controller;
use App\Helpers\DateHelper;
use Illuminate\Http\Request;
use App\Invoice;
use App\SaleNote;

class InvoiceSaleNoteController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->oInvoice        = new Invoice;
        $this->oSaleNote       = new SaleNote;
    }

    public function getAll($id)
    {
        $invoice    = $this->oInvoice->findById($id,session('countryId'),session('companyId'));
         // dd($invoice[0]->balanceTotal);
         // exit();
        $creditNotes =  $this->oSaleNote->getAllByType($id,SaleNote::CREDIT);
        $debitNotes  =  $this->oSaleNote->getAllByType($id,SaleNote::DEBIT);

        return view('module_administration.invoices.sale_notes.index',compact('invoice','creditNotes','debitNotes'));
    }

    public function create(Request $request)
    {
         $invoiceId    = $request->id;

       switch ($request->noteType) {
         case SaleNote::CREDIT:
            return view('module_administration.invoices.sale_notes.credit_note.create',compact('invoiceId'));
         break;
         case SaleNote::DEBIT:
            return view('module_administration.invoices.sale_notes.debit_note.create',compact('invoiceId'));
         break;
       }
    }

    public function store(Request $request)
    {
        $this->validate($request, ['formReference' => 'required']);

        $rs = $this->oSaleNote->insertS($request->all());

         $notification = array(
          'alert-type' => $rs['alert'],
          'message' => $rs['msj']
         );
            

            return $notification;
        // return redirect()->route('invoiceSaleNotes.getAll',['id' => $request->invoiceId])->with($notification);
    }
//       public function edit($id)
//     {    
//         $invoice           = $this->oInvoice->findById($id,session('countryId'),session('companyId'));
//         $paymentConditions = $this->oPaymentCondition->getAllByLanguage();
//         $projectDescriptions = $this->oProjectDescription->getAll();

//          return view('module_contracts.invoices.edit', compact('invoice','paymentConditions','projectDescriptions'));
//     }
//       public function update(Request $request, $id)
//     {

//         $this->oInvoice->updateInvoice(
//             $id,
//             $request->paymentConditionId,
//             $request->projectDescriptionId,
//             $request->invoiceDate,
//             $request->taxPercent
//         );

//         $notification = array(
//             'message'    => 'Datos Principales de Factura Modificados Exitosamente',
//             'alert-type' => 'info',
//         );
        
//         return redirect()->route('invoices.index',['id' => $request->contractId])
//             ->with($notification);
//     }
//     public function show(Request $request,$id)
//     {
//         $invoice = $this->oInvoice->findById($id,session('countryId'),session('companyId'));

//           if($request->ajax()){
//                 return $invoice;
//             }
//         return view('module_contracts.invoices.show', compact('invoice'));
//     }

//     public function changeStatus(Request $request)
//     {
//          switch ($request->newStatus) {
//            case 'CANCELLED':
//             $this->oInvoice->changeStatus($request->invoiceId, Invoice::CANCELLED);
//               $notification = array('message'    => 'Factura Cancelada', 'alertType' => 'info');
//              break;
//            case 'COLLECTION':
//             $this->oInvoice->changeStatus($request->invoiceId, Invoice::COLLECTION);
//               $notification = array('message'    => 'Factura Enviada a Collection', 'alertType' => 'info');
//              # code...
//              break;
//          }
//       return $notification;
//     }

// // ----------------FUNCTIONS TO MODULE ADMINISTRATIVE-------------------------------//.
//      public function getAllInvoices(Request $request)
//     {
//        $totalMontoFacturas = 0;
//        $totalCobrado = 0;
//        $totalPorCobrar = 0;
//        $totalCollections = 0;

//      $invoices = $this->oInvoice->getAllByFourStatus(Invoice::OPEN,Invoice::CLOSED,Invoice::PAID,Invoice::COLLECTION,session('companyId'));

//          foreach ($invoices as $invoice) {
//            $invoice->shareSucceed = count($this->oReceivable->shareSucceed($invoice->invoiceId));
//            $invoice->balance = $this->oInvoice->getBalance($invoice->invoiceId);

//             $totalMontoFacturas += $invoice->netTotal;
//             $totalCobrado   += ($invoice->netTotal - $invoice->balance);
//           if ($invoice->invStatusCode == Invoice::COLLECTION) {
//             $totalCollections   += $invoice->balance;    
//           }else{
//             $totalPorCobrar    += $invoice->balance;
//            }
//         }

//    if($request->method() == 'POST') {
//        if($request->date1 || $request->date2 || $request->textToFilter) {
  
//         //primer filtrado por el select y texto escrito en el formulario.
//         if($request->textToFilter){
//         $invoices = $invoices->filter(function ($invoice) use($request) {
//                       switch ($request->filterBy) {
//                         case 'invId':
//                                $valorABuscar = $invoice->invId;
//                           break;
//                         case 'contractNumber':
//                               $valorABuscar =  $invoice->contract->contractNumber;
//                           break;
//                         case 'siteAddress':
//                               $valorABuscar =  $invoice->contract->siteAddress;
//                               // echo $valorABuscar;
//                           break;  
//                         case 'clientCode':
//                               $valorABuscar =  $invoice->client->clientCode;
//                           break;
//                         case 'clientName':
//                               $valorABuscar =  $invoice->client->clientName;
//                           break;  
//                         case 'clientPhone':
//                               $valorABuscar =  $invoice->client->clientPhone;
//                           break;
//                       }
//                 $coincidencia = stripos($valorABuscar, $request->textToFilter);

//             if ($coincidencia !== false) { 
//                  return $invoice;
//             } 

//      });
//   } //fin del primer filtrado

//     //segundo filtrado por fechas se aplica si estan llenos los dos campos de fecha
//   if($request->date1 && $request->date2) {
//     $invoices = $invoices->filter(function ($invoice) use($request) {
   
//                $oDateHelper = new DateHelper;
//                $functionRs = $oDateHelper->changeDateForCountry(session('countryId'),'Mutador');
//                $date1                 = $oDateHelper->$functionRs($request->date1);
//                $date2                 = $oDateHelper->$functionRs($request->date2);
//                $invoiceDate       = $oDateHelper->$functionRs($invoice->invoiceDate);

//               $date_inicio = strtotime($date1);
//               $date_fin    = strtotime($date2);
//               $date_nueva  = strtotime($invoiceDate);

//                // esta dentro del rango
//               if (($date_nueva >= $date_inicio) && ($date_nueva <= $date_fin)){
//                  return $invoice;
//               }
//      });
//     }//fin del segundo filtrado

//   } //cierre del filtrado general.
//  }//cierre de request->post

//         return view('module_administration.invoices.index', compact('invoices','totalMontoFacturas','totalCobrado','totalCollections','totalPorCobrar'));
//     }


//     public function InvoicesCancelled(Request $request)
//     {
//        // $totalMontoFacturas = 0;
//        // $totalCobrado = 0;
//        // $totalPorCobrar = 0;
//        // $totalCollections = 0;

//      $invoices = $this->oInvoice->getAllByStatus(Invoice::CANCELLED,session('companyId'));

//          foreach ($invoices as $invoice) {
//            $invoice->shareSucceed = count($this->oReceivable->shareSucceed($invoice->invoiceId));
//            $invoice->balance = $this->oInvoice->getBalance($invoice->invoiceId);

//           //   $totalMontoFacturas += $invoice->netTotal;
//           //   $totalCobrado   += ($invoice->netTotal - $invoice->balance);
//           // if ($invoice->invStatusCode == Invoice::COLLECTION) {
//           //   $totalCollections   += $invoice->balance;    
//           // }else{
//           //   $totalPorCobrar    += $invoice->balance;
//           //  }
//         }


//         return view('module_administration.invoices.cancelled', compact('invoices'));
//     }




}
