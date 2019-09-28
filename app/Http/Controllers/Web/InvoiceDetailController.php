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
        
        return view('invoices.details.index', compact('invoice'));
    }

    public function create(Request $request)
    {

        $invoiceNumberFormat = $this->oConfiguration->generateInvoiceNumberFormat(session('countryId'),session('officeId'));

        // $projects = $this->oProjectType->getAll();
        // $services = $this->oServiceType->getAll();

        return view('invoices.create', compact('invoiceNumberFormat'));
    }

    public function store(ContractRequest $request)
    {

        $this->oContract->insertContract(
            session('countryId'),
            session('officeId'),
            $request->contractType,
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
            $request->currencyName);

        $notification = array(
            'message'    => 'Contrato Creado Exitosamente',
            'alert-type' => 'success',
        );

        return redirect()->route('contracts.index')
            ->with($notification);
    }

     public function show(Request $request,$id)
    {
        $invoicesDetails = $this->oInvoiceDetail->getAllByInvoice($id);

          if($request->ajax()){
                return $invoicesDetails;
            }
        return view('invoices.details', compact('invoicesDetails'));
    }

    public function edit($id)
    {
      
      $blockEdit = false;

         if($this->oReceivable->verificarPagoCuota($id)){
             $blockEdit = true;
         }
          
        // $clients  = $this->oClient->getAll();
        $projects = $this->oProjectType->getAll();
        $services = $this->oServiceType->getAll();
        $contract = $this->oContract->FindById($id,session('countryId'),session('officeId'));

        return view('invoices.edit', compact('contract', 'projects', 'services','blockEdit'));
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


}
