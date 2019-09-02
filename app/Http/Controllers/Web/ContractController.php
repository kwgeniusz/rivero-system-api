<?php

namespace App\Http\Controllers\Web;

use App\Client;
use App\Contract;
use App\Country;
use App\Configuration;
use App\Document;
use App\PaymentContract;
use App\ProjectType;
use App\ServiceType;
use App\Staff;
use App\Receivable;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContractRequest;
use App\Http\Requests\PaymentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;

class ContractController extends Controller
{
    private $oContract;
    private $oDocument;
    private $oClient;
    private $oStaff;
    private $oProjectType;
    private $oServiceType;
    private $oPaymentContract;

    public function __construct()
    {
        $this->middleware('auth');
        $this->oContract        = new Contract;
        $this->oClient          = new Client;
        $this->oStaff           = new Staff;
        $this->oPaymentContract = new PaymentContract;
        $this->oReceivable = new Receivable;
        $this->oDocument = new Document;

        $this->oProjectType = new ProjectType;
        $this->oServiceType = new ServiceType;
        $this->oConfiguration = new Configuration;
    }

    public function index(Request $request)
    {
        
        $filteredOut = $request->filteredOut;
        //GET LIST CONTRACTS FOR STATUS VACANT AND STARTED
        $projects = $this->oContract->getAllForTwoStatus(Contract::VACANT, Contract::STARTED, 'P',$filteredOut);
        $services = $this->oContract->getAllForTwoStatus(Contract::VACANT, Contract::STARTED, 'S',$filteredOut);
        
        return view('contractregistration.index', compact('projects', 'services'));
    }

    public function create($contractType)
    {

        $contractNumberFormat = $this->oConfiguration->generateContractNumberFormat(Auth::user()->countryId,Auth::user()->officeId,$contractType);

        $countrys = Country::all();
        $projects = $this->oProjectType->getAll();
        $services = $this->oServiceType->getAll();
        $clients  = $this->oClient->getAll();

        return view('contractregistration.create', compact('clients', 'projects', 'services', 'contractType', 'countrys','contractNumberFormat'));
    }

    public function store(ContractRequest $request)
    {

        $this->oContract->insertContract(
            $request->countryId,
            $request->officeId,
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

    public function details($id)
    {
        $contract = $this->oContract->FindById($id);

        return view('contractregistration.details', compact('contract'));
    }

    public function edit($id)
    {
      
      $blockEdit = false;

         if($this->oReceivable->verificarPagoCuota($id)){
             $blockEdit = true;
         }
          
        $clients  = $this->oClient->getAll();
        $projects = $this->oProjectType->getAll();
        $services = $this->oServiceType->getAll();
        $contract = $this->oContract->FindById($id);

        return view('contractregistration.edit', compact('contract', 'projects', 'services', 'clients','blockEdit'));
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
    public function show($id)
    {

        $contract = $this->oContract->FindById($id);
        return view('contractregistration.show', compact('contract'));

    }
    public function destroy($id)
    {

       $this->oContract->deleteContract($id);

          $notification = array(
            'message'    => 'Contrato Eliminado',
            'alert-type' => 'info',
        );

        return redirect()->route('contracts.index')
            ->with($notification);

    }

/** -----------SEARCH-------------  */

    public function generalSearch(Request $request)
    {
        $contractNumber = $request->contractNumber;
        $clientName     = $request->clientName;
        $clientPhone    = $request->clientPhone;
        $siteAddress    = $request->siteAddress;
        $contractStatus = $request->contractStatus;
        $contractDate   = $request->contractDate;

        $contracts = Contract::orderBy('contractId', 'ASC')
            ->contractNumber($contractNumber)
            ->clientName($clientName)
            ->clientPhone($clientPhone)
            ->siteAddress($siteAddress)
            ->contractStatus($contractStatus)
            ->contractDate($contractDate)
            ->paginate(5);

        return view('generalsearch.index', compact('contracts'));
    }

    public function generalSearchDetails($id)
    {
        $contract = $this->oContract->FindById($id);
        return view('generalsearch.details', compact('contract'));
    }

    public function getForOffice($officeId)
    {

        $listContracts            = $this->oContract->FindByOffice($officeId);
        $listContractsSiteAddress = $this->oContract->findSiteAddressByOffice($officeId);
        $listClientName           = $this->oClient->FindNameByOffice($officeId);
        $listClientPhone          = $this->oClient->FindPhoneByOffice($officeId);

        json_encode($listContracts);
        json_encode($listContractsSiteAddress);
        json_encode($listClientName);
        json_encode($listClientPhone);
        $allList = [$listContracts, $listClientName, $listClientPhone, $listContractsSiteAddress];

        return json_encode($allList);
    }

    public function searchStatus()
    {
        return view('contractstatus.index');
    }

    public function resultStatus(Request $request)
    {

        $contracts = $this->oContract->getAllForStatus($request->contractStatus);
        return view('contractstatus.result', compact('contracts'));
    }

    public function resultStatusDetails($id)
    {
        $contract = $this->oContract->FindById($id);
        return view('contractstatus.details', compact('contract'));
    }

/** ----------------CONTRACS FINISHED  -------------*/

    public function getContractsFinished()
    {
        $contracts = $this->oContract->getAllForStatus(Contract::FINISHED);
        return view('contractsfinished.index', compact('contracts'));
    }
    public function detailsContractsFinished($id)
    {
        $contract = $this->oContract->FindById($id);
        return view('contractsfinished.details', compact('contract'));
    }
    public function showContractsFinished($id)
    {
        $contract = $this->oContract->FindById($id);
        return view('contractsFinished.show', compact('contract'));
    }
    public function DeleteContractsFinished($id)
    {
        $this->oContract->deleteContract($id);
        return redirect()->route('contracts.finished')
            ->with('info', 'Tipo de Proyecto Eliminado');
    }

/**-----------CONTRACTS CANCELLED-------------*/

    public function getContractsCancelled()
    {
        $contracts = $this->oContract->getAllForStatus(Contract::CANCELLED);
        return view('contractscancelled.index', compact('contracts'));
    }
    public function detailsContractsCancelled($id)
    {
        $contract = $this->oContract->FindById($id);
        return view('contractscancelled.details', compact('contract'));
    }
        public function showContractsCancelled($id)
    {
        $contract = $this->oContract->FindById($id);
        return view('contractscancelled.show', compact('contract'));
    }
    public function DeleteContractsCancelled($id)
    {
        $this->oContract->deleteContract($id);
        return redirect()->route('contracts.cancelled')
            ->with('info', 'Tipo de Proyecto Eliminado');
    }

/* -----------OPTIONS------------- */

    public function changeStatus($id)
    {
        $contract = $this->oContract->FindById($id);
        return view('contractregistration.changeStatus', compact('contract'));

    }

    public function updateStatus(Request $request)
    {
        $this->oContract->updateStatus($request->contractId, $request->contractStatus);

        $notification = array(
            'message'    => 'Estado Modificado Exitosamente',
            'alert-type' => 'info',
        );

        if($request->contractStatus == 3)
        return redirect()->route('contracts.finished')->with($notification);
        if($request->contractStatus == 4)
        return redirect()->route('contracts.cancelled')->with($notification);
        else
        return redirect()->route('contracts.index')->with($notification);
    }

    public function staff($id)
    {

        $contract = $this->oContract->FindById($id);
        $staffs   = $this->oStaff->getAvailableStaff($id);

        return view('contractregistration.staff', compact('contract', 'staffs'));

    }

    public function staffAgg(Request $request)
    {

        $result = $this->oContract->aggStaff(
            $request->staffId,
            $request->contractId
        );

        $notification = array(
            'message'    => 'Personal Agregado Al Contrato',
            'alert-type' => 'success',
        );

        return redirect()->route('contracts.staff', ['id' => $request->contractId])
            ->with($notification);

    }
    public function staffRemove($id, $contractId)
    {
        $this->oContract->removeStaff($id);
        return redirect()->route('contracts.staff', ['id' => $contractId])
            ->with('info', 'Tipo de Proyecto Creado');
    }

// ---------PAYMENT -------//

    public function payment($id)
    {

        $contract = $this->oContract->FindById($id);
        $payments = $this->oPaymentContract->getAllForContract($id);

        return view('contractregistration.payment', compact('contract', 'payments'));

    }

    public function paymentAgg(PaymentRequest $request)
    {

        $result = $this->oPaymentContract->aggPayment(
            $request->contractId,
            $request->amount,
            $request->paymentDate
        );

        $notification = array(
            'message'    => $result['msj'],
            'alert-type' => $result['alert'],
        );

        return redirect()->route('contracts.payment', ['id' => $request->contractId])
            ->with($notification);

    }
    public function paymentRemove($id, $amount, $contractId)
    {

        $result = $this->oPaymentContract->removePayment($id, $amount, $contractId);

        $notification = array(
            'message'    => $result['msj'],
            'alert-type' => $result['alert'],
        );

        return redirect()->route('contracts.payment', ['id' => $contractId])
            ->with($notification);
    }
//---------------FILES-----------------------//
    public function files($id)
    {

        $contract = $this->oContract->FindById($id);

        return view('contractregistration.files', compact('contract'));
    }
    public function fileAgg(Request $request)
    {
         $rs = $this->oDocument->insert($request->file,$request->contractId,$request->typeDoc);

       if ($rs->status() == 200) {
          return response('Hello World', 200)
                  ->header('Content-Type', 'text/plain');
        } else {
           return response($rs->content(), 500)
                  ->header('Content-Type', 'text/plain');
        } 
    }

   public function fileDownload($docId)
    {
       $file =  $this->oDocument->findById($docId);
       return Storage::download($file[0]->docUrl,$file[0]->docName);
    }

   public function fileDelete($docId) {
        $file =  $this->oDocument->findById($docId);
        Storage::delete($file[0]->docUrl);

        $this->oDocument->deleteFile($docId);

       return redirect()->back();
   }

//------------FUNCTIONS PRINT----------------
    public function summaryForClient()
    {
        $clients = $this->oClient->getAll();
        return view('summaryforclient.index', compact('clients'));
    }

//-------QUERYS ASINCRONIOUS-----------------//
    public function getFiles($id,$type)
    {
        $rs  = $this->oDocument->getAllForContractAndType($id,$type);
        return json_encode($rs);
    }

}
