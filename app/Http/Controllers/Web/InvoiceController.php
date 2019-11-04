<?php

namespace App\Http\Controllers\Web;


use Auth;
use App;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Invoice;
use App\Contract;
use App\Configuration;
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
        $this->oContract       = new Contract;
        $this->oConfiguration  = new Configuration;
        $this->oInvoiceDetail        = new InvoiceDetail;
        $this->oPaymentInvoice        = new PaymentInvoice;
        $this->oPaymentCondition  = new PaymentCondition;

    }

    public function index(Request $request)
    {
        $contract = $this->oContract->findById($request->id,session('countryId'),session('officeId'));
        $invoices = $this->oInvoice->getAllByContract($request->id);

        return view('module_contracts.invoices.index', compact('invoices','contract'));
    }

    public function create(Request $request)
    {
 
        $contract = $this->oContract->findById($request->id,session('countryId'),session('officeId'));
        $paymentConditions = $this->oPaymentCondition->getAll(App::getLocale());

        $invoiceNumberFormat = $this->oConfiguration->generateInvoiceNumberFormat(session('countryId'),session('officeId'));
        $invoiceTaxPercent   = $this->oConfiguration->findInvoiceTaxPercent(session('countryId'),session('officeId'));


        return view('module_contracts.invoices.create', compact('contract','paymentConditions','invoiceNumberFormat','invoiceTaxPercent'));
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
                      $contract[0]->siteAddress,
                      $request->invoiceDate,
                      $contract[0]->currencyId,
                      $request->invoiceTaxPercent,
                      $request->paymentConditionId, 
                      '1');

        $notification = array(
            'message'    => 'Factura Creada, Agrege Renglones',
            'alert-type' => 'success',
        );

        return redirect()->route('invoicesDetails.index',['id' => $invoiceId])
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
 
        $this->oInvoice->changeStatus($request->invoiceId,'2');

        $notification = array(
            'message'    => 'Factura Cerrada, Puede comenzar a crear cuotas',
            'alertType' => 'success',
        );
        return $notification;
    }


//---------------NOTES-----------------------//
     public function notes(Request $request)
    {
        $invoice = $this->oInvoice->FindById($request->invoiceId,session('countryId'),session('officeId'));
         
           if($request->ajax()){
                return $invoice[0]->note;
            }
        // return view('module_contracts.contracts.staff', compact('contract', 'staffs'));

    }
    public function notesAdd(Request $request)
    {

        $result = $this->oInvoice->addNote(
            $request->invoiceId,
            $request->noteId
        );

        $notification = array(
            'message'    => 'Nota Agregada a factura',
            'alertType' => 'info',
        );

         if($request->ajax()){
                return $notification;
            }
    }

    public function notesRemove(Request $request,$invoiceId,$noteId)
    {
        $this->oInvoice->removeNote($invoiceId,$noteId);

        
        $notification = array(
            'message'    => 'Nota Eliminada de factura',
            'alertType' => 'info',
        );
           if($request->ajax()){
                return $notification;
            }
    }
//---------------PAYMENTS-----------------------//

    public function payments($id)
    {

        $invoice         = $this->oInvoice->findById($id,session('countryId'),session('officeId'));
        $invoiceDetails  = $this->oInvoiceDetail->getAllByInvoice($invoice[0]->invoiceId);
        $payments        = $this->oPaymentInvoice->getAllByInvoice($id);

        return view('module_contracts.invoices.payment', compact('invoice','invoiceDetails', 'payments'));

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

        $result = $this->oPaymentInvoice->removePayment($id, $invoiceId);

        $notification = array(
            'message'    => $result['msj'],
            'alert-type' => $result['alert'],
        );

        return redirect()->route('invoices.payments', ['id' => $invoiceId])
            ->with($notification);
    }

}
