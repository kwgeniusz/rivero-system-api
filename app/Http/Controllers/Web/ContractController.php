<?php

namespace App\Http\Controllers\Web;

use App\Contract;
use App\Document;
use App\Currency;
use App\Client;
use App\Staff;
use App\ProjectDescription;
use App\ProjectUse;
use App\Country; //OJO
use App\Receivable;
use App\Configuration;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContractRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;

class ContractController extends Controller
{
    private $oContract;
    private $oDocument;
    private $oCurrency;
    private $oClient;
    private $oStaff;
    private $oProjectDescription;
    private $oProjectUse;
    private $oReceivable;
    private $oConfiguration;
    private $oCountry;
    private $module;

    public function __construct()
    {

        $this->middleware('auth');
        $this->middleware("permission:BC");
        $this->middleware("permission:BCA")->only("create", "store");
        $this->middleware("permission:BCB")->only("show","destroy");
        $this->middleware("permission:BCC")->only("edit","update");
        $this->middleware("permission:BCD")->only("details");
        $this->middleware("permission:BCE")->only("changeStatus","updateStatus");
        $this->middleware("permission:BCF")->only("staff");
        // $this->middleware("permission:BCG")->only("files", "filesAgg");
        $this->middleware("permission:BCH")->only("payment");
        $this->middleware("permission:BCI")->only("destroy");

        $this->oContract        = new Contract;
        $this->oDocument        = new Document;
        $this->oCurrency        = new Currency; 
        $this->oClient          = new Client;
        $this->oStaff           = new Staff;
        $this->oProjectDescription = new ProjectDescription;
        $this->oProjectUse     = new ProjectUse;
        $this->oReceivable      = new Receivable;
        $this->oConfiguration   = new Configuration;
        $this->oCountry         = new Country;
    }

    public function index(Request $request)
    {
        
        $filteredOut = $request->filteredOut;
        //GET LIST CONTRACTS FOR STATUS VACANT AND STARTED
        $projects = $this->oContract->getAllForTwoStatus(Contract::VACANT, Contract::STARTED, 'P',$filteredOut,session('countryId'),session('officeId'));
        $services = $this->oContract->getAllForTwoStatus(Contract::VACANT, Contract::STARTED, 'S',$filteredOut,session('countryId'),session('officeId'));


        return view('module_contracts.contracts.index', compact('projects', 'services'));
    }

    public function create($contractType)
    {

       $contractNumberFormat = $this->oConfiguration->generateContractNumberFormat(session('countryId'),session('officeId'),$contractType);
 
        $projectsD = $this->oProjectDescription->getAll();
        $projectsU = $this->oProjectUse->getAll();
        $currencies = $this->oCurrency->getAll();

        return view('module_contracts.contracts.create', compact('projectsD', 'projectsU','currencies','contractType','contractNumberFormat'));
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
            $request->projectDescriptionId,
            $request->projectUseId,
            $request->registryNumber,
            $request->startDate,
            $request->scheduledFinishDate,
            $request->actualFinishDate,
            $request->deliveryDate,
            $request->initialComment,
            $request->currencyId);

        $notification = array(
            'message'    => 'Contrato Creado Exitosamente',
            'alert-type' => 'success',
        );

        return redirect()->route('contracts.index')
            ->with($notification);
    }

    public function details($id)
    {
        $contract = $this->oContract->FindById($id,session('countryId'),session('officeId'));

        return view('module_contracts.contracts.details', compact('contract'));
    }

    public function edit($id)
    {
      
      $blockEdit = false;

         if($this->oReceivable->verificarPagoCuota($id)){
             $blockEdit = true;
         }
          
        $contract = $this->oContract->FindById($id,session('countryId'),session('officeId'));
        $projectsD = $this->oProjectDescription->getAll();
        $projectsU = $this->oProjectUse->getAll();
        $currencies = $this->oCurrency->getAll();

        return view('module_contracts.contracts.edit', compact('contract', 'projectsD', 'projectsU','currencies','blockEdit'));
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
            $request->projectDescriptionId,
            $request->projectUseId,
            $request->registryNumber,
            $request->startDate,
            $request->scheduledFinishDate,
            $request->actualFinishDate,
            $request->deliveryDate,
            $request->initialComment,
            $request->intermediateComment,
            $request->finalComment,
            $request->currencyId
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

        $contract = $this->oContract->FindById($id,session('countryId'),session('officeId'));
        return view('module_contracts.contracts.show', compact('contract'));

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
            ->where('countryId', session('countryId'))
            ->where('officeId', session('officeId')) 
            ->paginate(5);

        return view('module_contracts.generalsearch.index', compact('contracts'));
    }

    public function generalSearchDetails($id)
    {
        $contract = $this->oContract->FindById($id,session('countryId'),session('officeId'));
        return view('module_contracts.generalsearch.details', compact('contract'));
    }

    public function resultStatus(Request $request)
    {

        $contracts = $this->oContract->getAllForStatus($request->contractStatus,session('countryId'),session('officeId'));
        return view('module_contracts.contractstatus.result', compact('contracts'));
    }

    public function resultStatusDetails($id)
    {
        $contract = $this->oContract->FindById($id,session('countryId'),session('officeId'));
        return view('module_contracts.contractstatus.details', compact('contract'));
    }

/** ----------------CONTRACS FINISHED  -------------*/

    public function getContractsFinished()
    {
        $contracts = $this->oContract->getAllForStatus(Contract::FINISHED,session('countryId'),session('officeId'));
        return view('module_contracts.contractsfinished.index', compact('contracts'));
    }
    public function detailsContractsFinished($id)
    {
        $contract = $this->oContract->FindById($id,session('countryId'),session('officeId'));
        return view('module_contracts.contractsfinished.details', compact('contract'));
    }
    public function showContractsFinished($id)
    {
        $contract = $this->oContract->FindById($id,session('countryId'),session('officeId'));
        return view('module_contracts.contractsFinished.show', compact('contract'));
    }
    public function DeleteContractsFinished($id)
    {
        $this->oContract->deleteContract($id,session('countryId'),session('officeId'));
        return redirect()->route('contracts.finished')
            ->with('info', 'Tipo de Proyecto Eliminado');
    }

/**-----------CONTRACTS CANCELLED-------------*/

    public function getContractsCancelled()
    {
        $contracts = $this->oContract->getAllForStatus(Contract::CANCELLED,session('countryId'),session('officeId'));
        return view('module_contracts.contractscancelled.index', compact('contracts'));
    }
    public function detailsContractsCancelled($id)
    {
        $contract = $this->oContract->FindById($id,session('countryId'),session('officeId'));
        return view('module_contracts.contractscancelled.details', compact('contract'));
    }
        public function showContractsCancelled($id)
    {
        $contract = $this->oContract->FindById($id,session('countryId'),session('officeId'));
        return view('module_contracts.contractscancelled.show', compact('contract'));
    }
    public function DeleteContractsCancelled($id)
    {
        $this->oContract->deleteContract($id,session('countryId'),session('officeId'));
        return redirect()->route('contracts.cancelled')
            ->with('info', 'Tipo de Proyecto Eliminado');
    }

/* -----------OPTIONS------------- */

    public function changeStatus($id)
    {
        $contract = $this->oContract->FindById($id,session('countryId'),session('officeId'));
        return view('module_contracts.contracts.changeStatus', compact('contract'));
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

        $contract = $this->oContract->FindById($id,session('countryId'),session('officeId'));
        $staffs   = $this->oStaff->getAvailableStaff($id);

        return view('module_contracts.contracts.staff', compact('contract', 'staffs'));

    }

    public function staffAdd(Request $request)
    {

        $result = $this->oContract->addStaff(
            $request->contractId,
            $request->staffId
        );

        $notification = array(
            'message'    => 'Personal Agregado Al Contrato',
            'alert-type' => 'success',
        );

        return redirect()->route('contracts.staff', ['id' => $request->contractId])
            ->with($notification);

    }
    public function staffRemove($contractId,$staffId)
    {
        $this->oContract->removeStaff($contractId,$staffId);

        return redirect()->route('contracts.staff', ['id' => $contractId])
            ->with('info', 'Tipo de Proyecto Creado');
    }

//---------------FILES-----------------------//
    public function files($id)
    {

        $contract = $this->oContract->FindById($id,session('countryId'),session('officeId'));

        return view('module_contracts.contracts.files', compact('contract'));
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
   
//-------QUERYS ASINCRONIOUS-----------------//
    public function getFiles($id,$type)
    {
        $rs  = $this->oDocument->getAllForContractAndType($id,$type);
        return json_encode($rs);
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

}
