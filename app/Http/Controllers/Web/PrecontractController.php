<?php

namespace App\Http\Controllers\Web;

use App\Contract;
use App\Currency;
use App\OfficeConfiguration;
use App\Precontract;
use App\Proposal;
use App\Invoice;
use App\InvoiceDetail;
use App\InvoiceNote;
use App\PaymentInvoice;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Http\Requests\PrecontractRequest;
use Illuminate\Http\Request;
use DB;
use Auth;

class PrecontractController extends Controller
{
    private $oPrecontract;
    // private $oClient;
    private $oOfficeConfiguration;
    private $oProposal;
    private $oContract;
    private $oCurrency;
    private $oInvoice;
    private $oInvoiceDetail;
    private $oInvoiceNote;
    private $oPaymentInvoice;


    public function __construct()
    {
        $this->middleware('auth');
        $this->oPrecontract        = new Precontract;
        // $this->oClient             = new Client;
        $this->oOfficeConfiguration         = new OfficeConfiguration;
        $this->oContract           = new Contract;
        $this->oProposal           = new Proposal;
        $this->oCurrency           = new Currency;
        $this->oInvoice           = new Invoice;
        $this->oInvoiceDetail           = new InvoiceDetail;
        $this->oInvoiceNote           = new InvoiceNote;
        $this->oPaymentInvoice           = new PaymentInvoice;
    }

    public function index(Request $request)
    {
        $filteredOut = $request->filteredOut;
        //GET LIST PrecontractS for type
        $precontracts = $this->oPrecontract->getAll(session('countryId'),session('officeId'), $filteredOut);

        return view('module_contracts.precontracts.index', compact('precontracts'));
    }

    public function create()
    {

     $preId = $this->oOfficeConfiguration->retrievePrecontractNumber(session('countryId'),session('officeId'));
     $preId++;
     $currencies = $this->oCurrency->getAll();

        return view('module_contracts.precontracts.create', compact('currencies','preId'));
    }

    public function store(PrecontractRequest $request)
    {
        $this->oPrecontract->insertPrecontract(
            session('countryId'),
            session('officeId'),
            $request->contractType,
            $request->projectName,
            $request->precontractDate,
            $request->clientId,
            $request->propertyNumber,
            $request->streetName,
            $request->streetType,
            $request->suiteNumber,
            $request->city,
            $request->state,
            $request->zipCode,
            $request->buildingCodeId,
            $request->groupId,
            $request->projectUseId,
            $request->constructionType,
            // $request->projectDescriptionId,
            $request->comment,
            $request->currencyId);

        $notification = array(
            'message'    => 'Pre-Contrato Creado Exitosamente',
            'alert-type' => 'success',
        );

        return redirect()->route('precontracts.index')
            ->with($notification);
    }

    public function details($id)
    {
        $precontract = $this->oPrecontract->FindById($id,session('countryId'),session('officeId'));

        return view('module_contracts.precontracts.details', compact('precontract'));
    }

    public function edit($id)
    {

        // $clients     = $this->oClient->getAll();
        $precontract  = $this->oPrecontract->FindById($id,session('countryId'),session('officeId'));
        $currencies = $this->oCurrency->getAll();


        return view('module_contracts.precontracts.edit', compact('precontract','currencies'));
    }

    public function update(PrecontractRequest $request, $id)
    {

        $this->oPrecontract->updatePrecontract(
            $id,
            $request->countryId,
            $request->officeId,
            $request->contractType,
            $request->projectName,
            $request->precontractDate,
            $request->clientId,
            $request->propertyNumber,
            $request->streetName,
            $request->streetType,
            $request->suiteNumber,
            $request->city,
            $request->state,
            $request->zipCode,       
            $request->buildingCodeId,
            $request->groupId,
            $request->projectUseId,
            $request->constructionType,
            $request->comment,
            $request->currencyId
        );

        $notification = array(
            'message'    => 'Pre-Contrato Modificado Exitosamente',
            'alert-type' => 'info',
        );
        return redirect()->route('precontracts.index')
            ->with($notification);
    }
    public function show($id)
    {

        $precontract = $this->oPrecontract->FindById($id,session('countryId'),session('officeId'));
        return view('module_contracts.precontracts.show', compact('precontract'));

    }
    public function destroy($id)
    {

        $this->oPrecontract->deletePrecontract($id,session('countryId'),session('officeId'));

        $notification = array(
            'message'    => 'Pre-Contrato Eliminado Exitosamente',
            'alert-type' => 'success',
        );
        return redirect()->route('precontracts.index')
            ->with($notification);

    }

/* -----------OPTIONS------------- */
    public function convert($id)
    {
      $proposal = $this->oProposal->FindById($id,session('countryId'),session('officeId')); 
      $precontract = $proposal[0]->precontract;

            if (count($proposal) == 0) {
                 $notification = array(
                    'message'    => 'Error: Debe Crear una propuesta',
                    'alert-type' => 'error',
                );
             return redirect()->back()->with($notification);
        }
        return view('module_contracts.precontracts.convert', compact('precontract','proposal'));

    }
    public function convertAdd($id)
    {
        $error = null;

        DB::beginTransaction();
        try {
      //traer todos los datos del proposal
    $proposal     = $this->oProposal->FindById($id,session('countryId'),session('officeId')); 
    $precontract  = $proposal[0]->precontract;
           
            //insertar el nuevo contrato
            $contract = $this->oContract->insertContract(
                $precontract->countryId,
                $precontract->officeId,
                $precontract->contractType,
                $precontract->projectName,
                date('m/d/Y'),
                $precontract->clientId,
                $precontract->propertyNumber,
                $precontract->streetName,
                $precontract->streetType,
                $precontract->suiteNumber,
                $precontract->city,
                $precontract->state,
                $precontract->zipCode,     
                $precontract->buildingCodeId,
                $precontract->groupId,
                $precontract->projectUseId,
                $precontract->constructionType,
                $precontract->comment,
                $precontract->currencyId
            );
            // dd($contract);

        //insertar el nuevo Invoice
            $invoice  = $this->oInvoice->insertInv(
                  $contract->countryId,
                  $contract->officeId,
                  $contract->contractId,
                  $contract->clientId,
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
               foreach ($proposal[0]->paymentProposal as $payment) {
                    $this->oPaymentInvoice->addPayment(
                            $invoice->invoiceId,
                            $payment->amount,
                            null
                           );
                   }

               //eliminar precontrato
            $this->oPrecontract->assignContractId($precontract->precontractId,$contract->contractId);       
            $this->oProposal->assignInvoiceId($proposal[0]->proposalId,$invoice->invoiceId);       
            //$this->oPrecontract->deletePrecontract($id,session('countryId'),session('officeId'));

            $success = true;
            DB::commit();
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
            DB::rollback();
        }

        if ($success) {
            $result = ['alert' => 'success', 'msj' => "Conversión Exitosa, Contrato N° $contract->contractNumber creado"];
        } else {
            $result = ['alert' => 'error', 'msj' => $error];
        }

        $notification = array(
            'message'    => $result['msj'],
            'alert-type' => $result['alert'],
        );

        return redirect()->route('contracts.index')
            ->with($notification);

    }
// ---------PAYMENT -------//

}
