<?php

namespace App\Http\Controllers\Web;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Invoice;
use App\InvoiceDetail;
use App\Contract;
use App\Configuration;
use Auth;

class InvoiceDetailController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->oInvoice        = new Invoice;
        $this->oInvoiceDetail        = new InvoiceDetail;
        $this->oContract             = new Contract;
        $this->oConfiguration        = new Configuration;
    }

    public function index(Request $request)
    {
        $invoice = $this->oInvoice->findById($request->id,session('countryId'),session('officeId'));
        $contract = $this->oContract->findById($invoice[0]->contractId,session('countryId'),session('officeId'));

        //EVITA QUE ENTREN POR URL SI ESTA CERRADA LA FACTURA
        if ($invoice[0]->status == 'CERRADO' || $invoice[0]->status == 'CLOSED') {
             return back()->withInput();
        }
        return view('invoices.details.index', compact('invoice','contract'));
    }

    public function create(Request $request)
    {

        $invoiceNumberFormat = $this->oConfiguration->generateInvoiceNumberFormat(session('countryId'),session('officeId'));

        // $projects = $this->oProjectType->getAll();
        // $services = $this->oServiceType->getAll();

        return view('invoices.create', compact('invoiceNumberFormat'));
    }

    public function store(Request $request)
    {

       $result = $this->oInvoiceDetail->insert(
            $request->invoiceId,
            $request->serviceId,
            $request->serviceName,
            $request->unit,
            $request->unitCost,
            $request->quantity,
            $request->amount);

      $notification = array(
            'message'    => $result['message'],
            'alertType' => $result['alertType'],
        );
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
        return view('invoices.details', compact('invoicesDetails'));
    }


    public function update(ContractRequest $request, $id)
    {

        $this->oContract->updateContract(
            $id,
            // $request->countryId,
            // $request->officeId,
            $request->contractDate,
            $request->clientId,
            $request->siteAddress,
            $request->projectTypeId,
            $request->serviceTypeId,
            $request->registryNumber,
            $request->startDate,
            $request->scheduledFinishDate,
            $request->actualFinishDate,
            $request->deliveryDate,
            $request->initialComment,
            $request->intermediateComment,
            $request->finalComment,
            $request->currencyName
        );

        $notification = array(
            'message'    => 'Contrato Modificado Exitosamente',
            'alert-type' => 'info',
        );
        return redirect()->route('contracts.index')
            ->with($notification);
    }

    public function destroy($id)
    {
        $result = $this->oInvoiceDetail->deleteInv($id);

           $notification = array(
            'message'    => $result['message'],
            'alertType' => $result['alertType'],
        );
         return $notification;

    }
}
