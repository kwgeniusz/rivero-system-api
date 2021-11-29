<?php

namespace App\Http\Controllers\Web;

use Auth;
use DB;
use App\Contract;
use App\Currency;
use App\Document;
use App\CompanyConfiguration;
use App\Precontract;
use App\Proposal;
use App\Invoice;
use App\InvoiceDetail;
use App\InvoiceNote;
use App\InvoiceScope;
use App\PaymentInvoice;
use App\TimeFrame;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Http\Requests\PrecontractRequest;
use Illuminate\Http\Request;

class PrecontractController extends Controller
{
    private $oPrecontract;
    private $oDocument;
    private $oCompanyConfiguration;
    private $oProposal;
    private $oContract;
    private $oCurrency;
    private $oInvoice;
    private $oInvoiceDetail;
    private $oInvoiceNote;
    private $oInvoiceScope;
    private $oPaymentInvoice;
    private $oTimeFrame;


    public function __construct()
    {
        $this->middleware('auth');
        $this->oPrecontract        = new Precontract;
        $this->oDocument             = new Document;
        $this->oCompanyConfiguration         = new CompanyConfiguration;
        $this->oContract           = new Contract;
        $this->oProposal           = new Proposal;
        $this->oCurrency           = new Currency;
        $this->oInvoice           = new Invoice;
        $this->oInvoiceDetail           = new InvoiceDetail;
        $this->oInvoiceNote           = new InvoiceNote;
        $this->oInvoiceScope           = new InvoiceScope;
        $this->oPaymentInvoice           = new PaymentInvoice;
        $this->oTimeFrame               = new TimeFrame;
    }

    public function index(Request $request)
    {
        $filteredOut = $request->filteredOut;
        //GET LIST PrecontractS for type
        $precontracts = $this->oPrecontract->getAll(session('countryId'),session('companyId'), $filteredOut);

        return view('module_contracts.precontracts.index', compact('precontracts'));
    }

    public function create()
    {

     $preId = $this->oCompanyConfiguration->retrievePrecontractNumber(session('countryId'),session('companyId'));
     $preId++;
     $currencies = $this->oCurrency->getAllDisplay();

        return view('module_contracts.precontracts.create', compact('currencies','preId'));
    }

    public function store(PrecontractRequest $request)
    {

        $this->oPrecontract->insertPrecontract(
            session('countryId'),
            session('companyId'),
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
            // $request->buildingCodeId,
            // $request->groupId,
            $request->projectUseId,
            // $request->constructionType,
            $request->comment,
            $request->currencyId);

        $notification = array(
            'message'    => 'Pre-Contrato Creado Exitosamente',
            'alert-type' => 'success',
        );

        return redirect()->route('precontracts.index')
            ->with($notification);
    }

    // public function details($id)
    // {
    //     $precontract = $this->oPrecontract->FindById($id,session('countryId'),session('companyId'));

    //     return view('module_contracts.precontracts.details', compact('precontract'));
    // }

    public function edit($id)
    {

        // $clients     = $this->oClient->getAll();
        $precontract  = $this->oPrecontract->FindById($id,session('countryId'),session('companyId'));
        $currencies = $this->oCurrency->getAllDisplay();


        return view('module_contracts.precontracts.edit', compact('precontract','currencies'));
    }

    public function update(PrecontractRequest $request, $id)
    {
        $this->oPrecontract->updatePrecontract(
            $id,
            $request->all()
        );

        $notification = array(
            'message'    => 'Pre-Contrato Modificado Exitosamente',
            'alert-type' => 'info',
        );
        return redirect()->route('precontracts.index')
            ->with($notification);
    }

    public function updateIbc(Request $request, $id)
    {
        $this->oPrecontract->updatePrecontract(
            $id,
            $request->all()
        );

        $notification = array(
            'message'    => 'Datos IBC del Pre-Contrato Modificados Exitosamente',
            'alert-type' => 'info',
        );
        return redirect()->route('precontracts.index')
            ->with($notification);
    }
    
    public function show(Request $request,$id)
    {

        $precontract = $this->oPrecontract->FindById($id,session('countryId'),session('companyId'));

             if($request->ajax()){
                return $precontract;
            }

        return view('module_contracts.precontracts.show', compact('precontract'));

    }
    public function destroy($id)
    {

        $this->oPrecontract->deletePrecontract($id,session('countryId'),session('companyId'));

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
      $proposal = $this->oProposal->FindById($id,session('countryId'),session('companyId')); 
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
    $proposal     = $this->oProposal->FindById($id,session('countryId'),session('companyId')); 
    $timeFrame     = $this->oTimeFrame->FindById($proposal[0]->timeFrame[0]->timeId); 
    $precontract  = $proposal[0]->precontract;

     if($precontract->contractId != null ){
        throw new \Exception('Error: Ya este precontrato fue convertido');
     }
     
  
           
            //insertar el nuevo contrato
            $contract = $this->oContract->insertContract(
                $precontract->countryId,
                $precontract->companyId,
                $precontract->contractType,
                $precontract->projectName,
                date('Y-m-d'),
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
                $precontract->currencyId,
                $timeFrame[0]->daysRepresented
            );
            // dd($contract);
            // exit();
        //insertar el nuevo Invoice
            $invoice  = $this->oInvoice->insertInv(
                  $contract->countryId,
                  $contract->companyId,
                  $contract->contractId,
                  $contract->clientId,
                  $proposal[0]->projectDescriptionId,
                  date('Y-m-d'),
                  '0.00',
                  $proposal[0]->taxPercent,
                  '0.00',
                  '0.00',
                  $proposal[0]->pCondId,
                  Invoice::OPEN,
                  Auth::user()->userId);

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
               foreach ($proposal[0]->paymentProposal as $payment) {
                    $this->oPaymentInvoice->addPayment(
                            $invoice->invoiceId,
                            $payment->amount,
                            null
                           );
                   }
                //mover archivos de precontrato a contracto nuevo
             
               foreach ($precontract->document as $doc) {
                    $this->oDocument->moveToContract($contract,$doc);
                }
                // dd($precontract->document[0]->docId);
                // dd($contract->contractId);


               
               //eliminar precontrato
            $this->oPrecontract->assignContractId($precontract->precontractId,$contract->contractId);       
            $this->oProposal->assignInvoiceId($proposal[0]->proposalId,$invoice->invoiceId);       
            //$this->oPrecontract->deletePrecontract($id,session('countryId'),session('companyId'));

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
// dd($notification);
// exit();
        return redirect()->route('contracts.index')
            ->with($notification);

    }

}
