<?php

namespace App\Http\Controllers\Web;

use App\Client;
use App\Contract;
use App\Country;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContractRequest;
use App\Http\Requests\PaymentRequest;
use App\PaymentContract;
use App\ProjectType;
use App\ServiceType;
use App\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContractController extends Controller
{
    private $oContract;
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

        $this->oProjectType = new ProjectType;
        $this->oServiceType = new ServiceType;

    }

    public function index()
    {
        //GET LIST CONTRACTS FOR STATUS VACANT AND STARTED
        $projects = $this->oContract->getAllForTwoStatus(Contract::VACANT, Contract::STARTED, 'P');
        $services = $this->oContract->getAllForTwoStatus(Contract::VACANT, Contract::STARTED, 'S');
        return view('contractregistration.index', compact('projects', 'services'));
    }

    public function create($contractType)
    {
        $countrys = Country::all();
        $projects = $this->oProjectType->getAll();
        $services = $this->oServiceType->getAll();
        $clients  = $this->oClient->getAll();

        return view('contractregistration.create', compact('clients', 'projects', 'services', 'contractType', 'countrys'));
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

        $clients  = $this->oClient->getAll();
        $projects = $this->oProjectType->getAll();
        $services = $this->oServiceType->getAll();
        $contract = $this->oContract->FindById($id);

        return view('contractregistration.edit', compact('contract', 'projects', 'services', 'clients'));
    }

    public function update(ContractRequest $request, $id)
    {

        $this->oContract->updateContract(
            $id,
            $request->countryId,
            $request->officeId,
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
            'message'    => 'Contrato Eliminado Exitosamente',
            'alert-type' => 'success',
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
        return view('contractsfinished.show', compact('contract'));
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

        return redirect()->route('contracts.index')
            ->with('info', 'Tipo de Proyecto Creado');

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

    public function files($id)
    {
        $files    = '';
        $contract = $this->oContract->FindById($id);

        //crear el directorio si no existe
        $directoryName = "D" . $contract[0]->countryId . $contract[0]->officeId . $contract[0]->contractNumber;
        Storage::makeDirectory("docs/" . $directoryName);

        //obtener todos los archivos del directorio
        $allFiles = Storage::files("docs/" . $directoryName);

        foreach ($allFiles as $file) {
            $filePart = explode("/", $file);
            $files[]  = $filePart[2];
        }

        return view('contractregistration.files', compact('contract', 'files', 'directoryName'));
    }
    public function fileAgg(Request $request)
    {
        $contract      = $this->oContract->FindById($request->contractId);
        $directoryName = "D" . $contract[0]->countryId . $contract[0]->officeId . $contract[0]->contractNumber;

        if ($request->hasFile('archive')) {
            $archive = $request->file('archive');
            $name    = time() . $archive->getClientOriginalName();
            $archive->move(storage_path("app/public/docs/$directoryName"), $name);

        }

        return redirect()->back();
    }

//------------FUNCTIONS PRINT----------------
    public function summaryForClient()
    {
        $clients = $this->oClient->getAll();
        return view('summaryforclient.index', compact('clients'));
    }

//-------QUERYS ASINCRONIOUS-----------------//

}
