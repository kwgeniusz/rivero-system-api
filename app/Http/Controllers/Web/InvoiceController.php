<?php

namespace App\Http\Controllers\Web;


use Auth;
use App;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Invoice;
use App\Receivable;
use App\Contract;
use App\OfficeConfiguration;
use App\InvoiceDetail;
use App\PaymentInvoice;
use App\PaymentCondition;
use App\Http\Requests\PaymentRequest;

class InvoiceController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->oInvoice        = new Invoice;
        $this->oReceivable        = new Receivable;
        $this->oContract       = new Contract;
        $this->oOfficeConfiguration  = new OfficeConfiguration;
        $this->oInvoiceDetail        = new InvoiceDetail;
        $this->oPaymentInvoice        = new PaymentInvoice;
        $this->oPaymentCondition  = new PaymentCondition;

    }

    public function index(Request $request)
    {
  
        $contract = $this->oContract->findById($request->id,session('countryId'),session('officeId'));
        $invoices = $this->oInvoice->getAllByContract($request->id);
// $invoices[0]->push(5);
        // dd($invoices);

        return view('module_contracts.invoices.index', compact('invoices','contract'));
    }

    public function create(Request $request)
    {
 
        $contract = $this->oContract->findById($request->id,session('countryId'),session('officeId'));
        $paymentConditions = $this->oPaymentCondition->getAllByLanguage(session('countryId'));

        $invId = $this->oOfficeConfiguration->retrieveInvoiceNumber(session('countryId'),session('officeId'));
        $invId++;
        $invoiceTaxPercent   = $this->oOfficeConfiguration->findInvoiceTaxPercent(session('countryId'),session('officeId'));


        return view('module_contracts.invoices.create', compact('contract','paymentConditions','invId','invoiceTaxPercent'));
    }

    public function store(Request $request)
    {
           $this->validate($request, [
                'invoiceDate' => 'required',
                'invoiceTaxPercent' => 'required',
           ]);
 
          $contract = $this->oContract->findById($request->contractId,session('countryId'),session('officeId'));

          $invoiceId  =   $this->oInvoice->insertInv(
                      $contract[0]->countryId,
                      $contract[0]->officeId,
                      $contract[0]->contractId,
                      $contract[0]->clientId,
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

        return redirect()->route('invoicesDetails.index',['id' => $invoiceId])
            ->with($notification);
    }
      public function edit($id)
    {    
        $invoice           = $this->oInvoice->findById($id,session('countryId'),session('officeId'));
        $paymentConditions = $this->oPaymentCondition->getAllByLanguage();

         return view('module_contracts.invoices.edit', compact('invoice','paymentConditions'));
    }
      public function update(Request $request, $id)
    {

        $this->oInvoice->updateInvoice(
            $id,
            $request->paymentConditionId,
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
        $invoice = $this->oInvoice->findById($id,session('countryId'),session('officeId'));

          if($request->ajax()){
                return $invoice;
            }
        return view('module_contracts.invoices.details', compact('invoice'));
    }

    public function closeInvoice(Request $request)
    {
 
        $this->oInvoice->changeStatus($request->invoiceId, Invoice::CLOSED);

        $notification = array(
            'message'    => 'Factura Cerrada, Puede comenzar a crear cuotas',
            'alertType' => 'success',
        );
        return $notification;
    }

//---------------PAYMENTS-----------------------//

    public function payments($id)
    {

        $invoice         = $this->oInvoice->findById($id,session('countryId'),session('officeId'));
        $invoiceDetails  = $this->oInvoiceDetail->getAllByInvoice($id);
        $payments        = $this->oPaymentInvoice->getAllByInvoice($id);

         //saldo de la factura
        $invoiceBalance         = $this->oInvoice->getBalance($id);
         //saber que cuota le corresponde mostrar los botones de cobro y verificación
        $currentShare           = $this->oReceivable->currentShare($id);

        return view('module_contracts.invoices.payment', compact('invoice','invoiceDetails', 'payments','invoiceBalance','currentShare'));

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
        
        return redirect()->route('invoices.payments', ['id' => $request->invoiceId])
            ->with($notification);

    }
    public function paymentsRemove($id, $invoiceId)
    {

        $result = $this->oPaymentInvoice->removePayment($id,$invoiceId);

        $notification = array(
            'message'    => $result['msj'],
            'alert-type' => $result['alert'],
        );

        return redirect()->route('invoices.payments', ['id' => $invoiceId])
            ->with($notification);
    }

}
