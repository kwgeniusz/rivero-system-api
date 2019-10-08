<?php

namespace App\Http\Controllers\Web;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Invoice;
use App\Contract;
use App\Configuration;
use Auth;

class InvoiceController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->oInvoice        = new Invoice;
        $this->oContract        = new Contract;
        $this->oConfiguration        = new Configuration;
    }

    public function index(Request $request)
    {
        $contract = $this->oContract->findById($request->id,session('countryId'),session('officeId'));
        $invoices = $this->oInvoice->getAllByContract($request->id);

        return view('invoices.index', compact('invoices','contract'));
    }

    public function create(Request $request)
    {
        $contract = $this->oContract->findById($request->id,session('countryId'),session('officeId'));
        $invoiceNumberFormat = $this->oConfiguration->generateInvoiceNumberFormat(session('countryId'),session('officeId'));
        $invoiceTaxPercent   = $this->oConfiguration->findInvoiceTaxPercent(session('countryId'),session('officeId'));


        return view('invoices.create', compact('contract','invoiceNumberFormat','invoiceTaxPercent'));
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
        return view('invoices.details', compact('invoice'));
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
    public function edit($id)
    {
      
      // $blockEdit = false;

        //  if($this->oReceivable->verificarPagoCuota($id)){
        //      $blockEdit = true;
        //  }
          
        // // $clients  = $this->oClient->getAll();
        // $projects = $this->oProjectType->getAll();
        // $services = $this->oServiceType->getAll();
        // $contract = $this->oContract->FindById($id,session('countryId'),session('officeId'));

        // return view('invoices.edit', compact('contract', 'projects', 'services','blockEdit'));
    }

    public function update(ContractRequest $request, $id)
    {

        // $this->oContract->updateContract(
        //     $id,
        //     // $request->countryId,
        //     // $request->officeId,
        //     $request->contractDate,
        //     $request->clientId,
        //     $request->siteAddress,
        //     $request->projectTypeId,
        //     $request->serviceTypeId,
        //     $request->registryNumber,
        //     $request->startDate,
        //     $request->scheduledFinishDate,
        //     $request->actualFinishDate,
        //     $request->deliveryDate,
        //     $request->initialComment,
        //     $request->intermediateComment,
        //     $request->finalComment,
        //     $request->currencyName
        // );

        // $notification = array(
        //     'message'    => 'Contrato Modificado Exitosamente',
        //     'alert-type' => 'info',
        // );
        // return redirect()->route('contracts.index')
        //     ->with($notification);
    }


}
