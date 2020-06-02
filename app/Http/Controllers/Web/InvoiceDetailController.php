<?php

namespace App\Http\Controllers\Web;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Invoice;
use App\InvoiceDetail;
use App\Contract;
use App\OfficeConfiguration;
use Auth;

class InvoiceDetailController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->oInvoice        = new Invoice;
        $this->oInvoiceDetail        = new InvoiceDetail;
        $this->oContract             = new Contract;
        $this->oOfficeConfiguration        = new OfficeConfiguration;
    }

    public function index(Request $request)
    {
        $invoice = $this->oInvoice->findById($request->id,session('countryId'),session('officeId'));
        $contract = $this->oContract->findById($invoice[0]->contractId,session('countryId'),session('officeId'));

        //EVITA QUE ENTREN POR URL SI ESTA CERRADA LA FACTURA
        if ($invoice[0]->status == 'CERRADO' || $invoice[0]->status == 'CLOSED') {
             return back()->withInput();
        }

        $btnReturn = $request->btnReturn;
        return view('module_contracts.invoices.details.index', compact('invoice','contract','btnReturn'));
    }

    public function create(Request $request)
    {

        $invoiceNumberFormat = $this->oOfficeConfiguration->generateInvoiceNumberFormat(session('countryId'),session('officeId'));
        
        return view('module_contracts.invoices.create', compact('invoiceNumberFormat'));
    }

    public function store(Request $request)
    {
//VACIA TODA LA PROPUESTA PARA LLENARLA PARA INSERTAR LAS MODIFICACIONES.
        $this->oInvoiceDetail->deleteInv($request->invoiceId);
    
    //recorre el arreglo que viene por requeste, del componente ProposalDetails y realiza una insercion de cada uno de sus elementos.
     if(!empty($request->itemList)) {
        foreach ($request->itemList as $key => $item) {
           $result = $this->oInvoiceDetail->insert(
                          $request->invoiceId,
                          ++$key,
                          $item['serviceId'],
                          $item['serviceName'],
                          $item['unit'],
                          $item['unitCost'],
                          $item['quantity'],
                          $item['amount']);
             }
        $notification = array(
          'message'    => $result['message'],
          'alertType' => $result['alertType'],
        );
      }else{
        $notification = array(
          'message'    => 'Renglones Guardados',
          'alertType' => 'success',
        );
      };//fin 1 else

      //envia siempre la notificacion para saber que if fue cumplido 
         if($request->ajax()){
                return $notification;
            }

    }

     public function show(Request $request,$id)
    {
        $invoicesDetails = $this->oInvoiceDetail->getAllByInvoice($id);

          if($request->ajax()){
                return $invoicesDetails;
            }
        return view('module_contracts.invoices.details', compact('invoicesDetails'));
    }


   public function getWithPriceByInvoice($invoiceId)
    {
        $result = $this->oInvoiceDetail->getWithPriceByInvoice($invoiceId);

    
         return $result;

    }
}
