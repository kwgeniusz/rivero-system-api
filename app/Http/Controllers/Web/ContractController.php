<?php

namespace App\Http\Controllers\Web;

use Auth;
use App;
use ZipArchive;
use App\Contract;
use App\Document;
use App\Currency;
use App\Client;
use App\Staff;
use App\Receivable;
use App\CompanyConfiguration;
use App\ContractStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContractRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContractController extends Controller
{
    private $oContract;
    private $oDocument;
    private $oCurrency;
    private $oClient;
    private $oStaff;
    private $oReceivable;
    private $oCompanyConfiguration;
    private $oBuildingCode;
    private $oContractStatus;

    public function __construct()
    {

        $this->middleware('auth');
        // $this->middleware("permission:BC");
        // $this->middleware("permission:BCA")->only("create", "store");
        // $this->middleware("permission:BCB")->only("show","destroy");
        // $this->middleware("permission:BCC")->only("edit","update");
        // $this->middleware("permission:BCD")->only("details");
        // $this->middleware("permission:BCE")->only("changeStatus","updateStatus");
        // $this->middleware("permission:BCF")->only("staff");
        // $this->middleware("permission:BCH")->only("payment");
        // $this->middleware("permission:BCI")->only("destroy");

        $this->oContract        = new Contract;
        $this->oDocument        = new Document;
        $this->oCurrency        = new Currency; 
        $this->oClient          = new Client;
        $this->oStaff           = new Staff;
        $this->oReceivable      = new Receivable;
        $this->oCompanyConfiguration   = new CompanyConfiguration;
        $this->oContractStatus   = new ContractStatus;
    }

    public function index(Request $request)
    {
        
        $filteredOut = $request->filteredOut;
        //GET LIST CONTRACTS FOR STATUS VACANT AND STARTED
        $contracts = $this->oContract->getAllForNineStatus(
            Contract::VACANT, 
            Contract::STARTED,
            Contract::READY_BUT_PENDING_PAYABLE,
            Contract::PROCESSING_PERMIT,
            Contract::WAITING_CLIENT,
            Contract::DOWNLOADING_FILES,
            Contract::SENT_TO_OFFICE,
            Contract::IN_PRODUCTION_QUEUE,
            Contract::SENT_TO_ENGINEER,
            $filteredOut,
            session('countryId'),
            session('companyId')
        );
       
        if($request->ajax()){
            return $contracts;
        }

        return view('module_contracts.contracts.index', compact('contracts'));
    }

    public function create()
    {

       $contractNumberFormat = $this->oCompanyConfiguration->generateContractNumberFormat(session('countryId'),session('companyId'));
       $currencies   = $this->oCurrency->getAllDisplay();

        return view('module_contracts.contracts.create', compact('currencies','contractNumberFormat'));
    }

    public function store(ContractRequest $request)
    {

       $newContract = $this->oContract->insertContract(
            session('countryId'),
            session('companyId'),
            $request->contractType,
            $request->projectName,
            $request->contractDate,
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
            // $request->registryNumber,
            // $request->startDate,
            // $request->scheduledFinishDate,
            // $request->actualFinishDate,
            // $request->deliveryDate,
            $request->initialComment,
            $request->currencyId);

        $notification = array(
            'message'    => 'Contrato Creado Exitosamente',
            'alert-type' => 'success',
        );
    
        return redirect()->route('invoices.create', ['id' => $newContract->contractId])->with($notification);
    }

    // public function details(Request $request,$id)
    // {
    //     $contract = $this->oContract->FindById($id,session('countryId'),session('companyId'));
          
    //       if($request->ajax()){
    //             return $contract;
    //         }
    //     return view('module_contracts.contracts.details', compact('contract'));
    // }

    public function edit($id)
    {
      
      $blockEdit = false;

         // if($this->oReceivable->verificarPagoCuota($id)){
         //     $blockEdit = true;
         // }
          
        $contract = $this->oContract->FindById($id,session('countryId'),session('companyId'));
        $currencies = $this->oCurrency->getAllDisplay();

        return view('module_contracts.contracts.edit', compact('contract','currencies','blockEdit'));
    }

    public function update(ContractRequest $request, $id)
    {
        $this->oContract->updateContract(
            $id,
            $request->all());
            
        $notification = array(
            'message'    => 'Contrato Modificado Exitosamente',
            'alert-type' => 'info',
        );
        return redirect()->route('contracts.index')
            ->with($notification);
    }

    public function updateIbc(Request $request, $id)
    {
        $this->oContract->updateContractIbc(
            $id,
            $request->all()
        );

        $notification = array(
            'message'    => 'Datos IBC del Contrato Modificados Exitosamente',
            'alert-type' => 'info',
        );
        return redirect()->route('contracts.index')
            ->with($notification);
    }
    public function show(Request $request,$id)
    {

        $contract = $this->oContract->FindById($id,session('countryId'),session('companyId'));

          if($request->ajax()){
                return $contract;
            }

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

    // public function generalSearch(Request $request)
    // {
    //     $contractNumber = $request->contractNumber;
    //     $clientName     = $request->clientName;
    //     $clientPhone    = $request->clientPhone;
    //     $siteAddress    = $request->siteAddress;
    //     $contractStatus = $request->contractStatus;
    //     $contractDate   = $request->contractDate;

    //     $contracts = Contract::orderBy('contractId', 'ASC')
    //         ->contractNumber($contractNumber)
    //         ->clientName($clientName)
    //         ->clientPhone($clientPhone)
    //         ->siteAddress($siteAddress)
    //         ->contractStatus($contractStatus)
    //         ->contractDate($contractDate)
    //         ->where('countryId', session('countryId'))
    //         ->where('companyId', session('companyId')) 
    //         ->paginate(5);

    //     return view('module_contracts.generalsearch.index', compact('contracts'));
    // }

    // public function generalSearchDetails($id)
    // {
    //     $contract = $this->oContract->FindById($id,session('countryId'),session('companyId'));
    //     return view('module_contracts.generalsearch.details', compact('contract'));
    // }

    // public function resultStatus(Request $request)
    // {

    //     $contracts = $this->oContract->getAllForStatus($request->contractStatus,session('countryId'),session('companyId'));
    //     return view('module_contracts.contractstatus.result', compact('contracts'));
    // }

    // public function resultStatusDetails($id)
    // {
    //     $contract = $this->oContract->FindById($id,session('countryId'),session('companyId'));
    //     return view('module_contracts.contractstatus.details', compact('contract'));
    // }

/** ----------------CONTRACS FINISHED  -------------*/

    public function getContractsFinished(Request $request)
    {
         $filteredOut = $request->filteredOut;

        $contracts = $this->oContract->getAllForStatus(Contract::FINISHED,$filteredOut,session('countryId'),session('companyId'));
        return view('module_contracts.contractsfinished.index', compact('contracts'));
    }
    public function detailsContractsFinished($id)
    {
        $contract = $this->oContract->FindById($id,session('countryId'),session('companyId'));
        return view('module_contracts.contractsfinished.details', compact('contract'));
    }
    public function showContractsFinished($id)
    {
        $contract = $this->oContract->FindById($id,session('countryId'),session('companyId'));
        return view('module_contracts.contractsFinished.show', compact('contract'));
    }
    public function deleteContractsFinished($id)
    {
        $this->oContract->deleteContract($id,session('countryId'),session('companyId'));
        return redirect()->route('contracts.finished')
            ->with('info', 'Tipo de Proyecto Eliminado');
    }

/**-----------CONTRACTS CANCELLED-------------*/

    public function getContractsCancelled(Request $request)
    {
         $filteredOut = $request->filteredOut;

        $contracts = $this->oContract->getAllForStatus(Contract::CANCELLED,$filteredOut,session('countryId'),session('companyId'));
        return view('module_contracts.contractscancelled.index', compact('contracts'));
    }
    public function detailsContractsCancelled($id)
    {
        $contract = $this->oContract->FindById($id,session('countryId'),session('companyId'));
        return view('module_contracts.contractscancelled.details', compact('contract'));
    }
        public function showContractsCancelled($id)
    {
        $contract = $this->oContract->FindById($id,session('countryId'),session('companyId'));
        return view('module_contracts.contractscancelled.show', compact('contract'));
    }
    public function deleteContractsCancelled($id)
    {
        $this->oContract->deleteContract($id,session('countryId'),session('companyId'));
        return redirect()->route('contracts.cancelled')
            ->with('info', 'Tipo de Proyecto Eliminado');
    }

/* -----------OPTIONS------------- */

    public function changeStatus($id)
    {
        $contract = $this->oContract->FindById($id,session('countryId'),session('companyId'));
        $contractStatus = $this->oContractStatus->getAllByLanguage(App::getLocale());

        return view('module_contracts.contracts.changeStatus', compact('contract','contractStatus'));
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

        $contract = $this->oContract->FindById($id,session('countryId'),session('companyId'));
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
        $contract = $this->oContract->FindById($id,session('countryId'),session('companyId'));

        return view('module_contracts.contracts.files', compact('contract'));
    }
    public function fileAdd(Request $request)
    {

         $rs = $this->oDocument->insertF($request->file,'contract',$request->contractId,$request->typeDoc);

       if ($rs->status() == 200) {
          return response('Insercion Exitosa', 200)->header('Content-Type', 'text/plain');
        } else {
           return response($rs->content(), 500)->header('Content-Type', 'text/plain');
        } 
    }
//  public function fileDownloadByUnit(Request $request)
//    {
//         $doc = $this->oDocument->findById($request->docId);
//            return response()->download('storage/'.$doc[0]->docUrl, $doc[0]->docName);
//     }

//  public function fileDownload(Request $request)
//    {
//      $data = json_decode($request->checkedFiles,true);
//       // dd($data);

//         $zipName = Auth::user()->userName.'.zip';
//         $zip = new \ZipArchive;

//         if ($zip->open($zipName, ZipArchive::CREATE) === TRUE) {  

//          foreach ($data as $file) {
//             // dd($data);
//                $zip->addFile('storage/'.$file['docUrl'],$file['docName']);        
//           }        
//                $zip->close();       
//         }
    
//      $headers = array(
//         'content-description: File Transfer',
//         'content-type: application/octet-stream',
//         'content-disposition: attachment; filename="' . $zipName . '"',
//         'content-length: ' . filesize($zipName),
//         'content-encoding: none'
//       );

//         $filetopath=$zipName;

//         if(file_exists($filetopath)){
//            return response()->download($filetopath, $zipName, $headers)->deleteFileAfterSend(true);
//         }

//         return ['status'=>'Esto Da un Error'];
//     }

//    public function fileDelete(Request $request)
//   {
//          foreach ($request->checkedFiles as $key => $file) {
//             Storage::delete($file['docUrl']);
//             $this->oDocument->deleteF($file['docUrl'],$file['docId']);
//           }

//        return response('Archivos Eliminados', 200)->header('Content-Type', 'text/plain');
//    }
   
// //-------QUERYS ASINCRONIOUS-----------------//
    //method to get files by document type in contracts
    public function getFiles($id,$type)
    {
        $rs  = $this->oDocument->getAllForContractAndType($id,$type);
        return json_encode($rs);
    }
    public function getForCompany($companyId)
    {

        $listContracts            = $this->oContract->FindByCompany($companyId);
        $listContractsSiteAddress = $this->oContract->findSiteAddressByCompany($companyId);
        $listClientName           = $this->oClient->FindNameByCompany($companyId);
        $listClientPhone          = $this->oClient->FindPhoneByCompany($companyId);

        json_encode($listContracts);
        json_encode($listContractsSiteAddress);
        json_encode($listClientName);
        json_encode($listClientPhone);
        $allList = [$listContracts, $listClientName, $listClientPhone, $listContractsSiteAddress];

        return json_encode($allList);
    }

}
