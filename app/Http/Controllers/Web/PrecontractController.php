<?php

namespace App\Http\Controllers\Web;

// use App\Client;
use App\Contract;
use App\Currency;
use App\PaymentContract;
use App\PaymentPrecontract;
use App\Precontract;
use App\ProjectDescription;
use App\ProjectUse;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Http\Requests\PrecontractRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use DB;
use File;
use Auth;

class PrecontractController extends Controller
{
    private $oPrecontract;
    // private $oClient;
    private $oProjectDescription;
    private $oProjectUse;
    private $oPaymentPrecontract;
    private $oPaymentContract;
    private $oContract;
    private $oCurrency;

    public function __construct()
    {
        $this->middleware('auth');
        $this->oPrecontract        = new Precontract;
        // $this->oClient             = new Client;
        $this->oProjectDescription = new ProjectDescription;
        $this->oProjectUse         = new ProjectUse;
        $this->oPaymentPrecontract = new PaymentPrecontract;
        $this->oPaymentContract    = new PaymentContract;
        $this->oContract           = new Contract;
        $this->oCurrency           = new Currency;
    }

    public function index()
    {
        //GET LIST PrecontractS for type
        $projects = $this->oPrecontract->getAllForType('P',session('countryId'),session('officeId'));
        $services = $this->oPrecontract->getAllForType('S',session('countryId'),session('officeId'));

        return view('module_contracts.precontracts.index', compact('projects', 'services'));
    }

    public function create($contractType)
    {

        $projectsD = $this->oProjectDescription->getAll();
        $projectsU = $this->oProjectUse->getAll();
        $currencies = $this->oCurrency->getAll();

        return view('module_contracts.precontracts.create', compact( 'projectsD', 'projectsU','currencies', 'contractType'));
    }

    public function store(PrecontractRequest $request)
    {
        $this->oPrecontract->insertPrecontract(
            session('countryId'),
            session('officeId'),
            $request->contractType,
            $request->clientId,
            $request->siteAddress,
            $request->projectDescriptionId,
            $request->projectUseId,
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
        $projectsD    = $this->oProjectDescription->getAll();
        $projectsU    = $this->oProjectUse->getAll();
        $currencies = $this->oCurrency->getAll();


        return view('module_contracts.precontracts.edit', compact('precontract', 'projectsD', 'projectsU','currencies'));
    }

    public function update(PrecontractRequest $request, $id)
    {

        $this->oPrecontract->updatePrecontract(
            $id,
            $request->countryId,
            $request->officeId,
            $request->clientId,
            $request->siteAddress,
            $request->projectDescriptionId,
            $request->projectUseId,
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

        $precontract = $this->oPrecontract->FindById($id,session('countryId'),session('officeId'));
        return view('module_contracts.precontracts.convert', compact('precontract'));

    }
    public function convertAgg($id)
    {
        $error = null;

        DB::beginTransaction();
        try {
            //traer todos los datos del precontrato
            $precontract = $this->oPrecontract->FindById($id);
            //insertar el nuevo contrato
            $contractLastId = $this->oContract->insertContract(
                $precontract[0]->countryId,
                $precontract[0]->officeId,
                $precontract[0]->contractType,
                date('d/m/Y'),
                $precontract[0]->clientId,
                $precontract[0]->siteAddress,
                $precontract[0]->projectDescriptionId,
                $precontract[0]->projectUseId,
                '',
                '',
                '',
                '',
                '',
                $precontract[0]->comment,
                $precontract[0]->currencyId
            );
            //insertar los pagos correspondientes
            if ($precontract[0]->payment) {
                foreach ($precontract[0]->payment as $payment) {
                    $result = $this->oPaymentContract->aggPayment(
                        $contractLastId,
                        $payment->amount,
                        $payment->paymentDate
                    );
                }
            }
            
            //Mover Documentos de Precontrato a el nuevo contrato
            $contractNumber = Contract::select('contractNumber')->where('contractId', '=', $contractLastId)->get();
            $directoryNameOld = "D" . $precontract[0]->countryId . $precontract[0]->officeId . $id;
            $directoryNameNew = "D" . $precontract[0]->countryId . $precontract[0]->officeId . $contractNumber[0]['contractNumber'];
    
               //obtener todos los archivos del directorio y dejar solo el nombre del archivo con el foreach
                $allFiles = Storage::files("docs/precontracts/" . $directoryNameOld);
                $filesName   = [];
               foreach ($allFiles as $file) {
                   $filePart = explode("/", $file);
                   $filesName[]  = $filePart[3];
                  }
             Storage::makeDirectory("docs/contracts/previous/" . $directoryNameNew);
             $move = Storage::move($allFiles[0], "docs/contracts/previous/$directoryNameNew/$filesName[0]");

            //eliminar precontrato
            $this->oPrecontract->deletePrecontract($id);
            Storage::deleteDirectory("docs/precontracts/" . $directoryNameOld);

            $success = true;
            DB::commit();
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
            DB::rollback();
        }

        if ($success) {
            $result = ['alert' => 'success', 'msj' => "Conversión Exitosa, Contrato N° $contractLastId creado"];
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

    public function payment($id)
    {

        $precontract = $this->oPrecontract->FindById($id,session('countryId'),session('officeId'));
        $payments    = $this->oPaymentPrecontract->getAllForPrecontract($id);

        return view('module_contracts.precontracts.payment', compact('precontract', 'payments'));

    }

    public function paymentAgg(PaymentRequest $request)
    {

        $result = $this->oPaymentPrecontract->aggPayment(
            $request->precontractId,
            $request->amount,
            $request->paymentDate
        );

        $notification = array(
            'message'    => $result['msj'],
            'alert-type' => $result['alert'],
        );

        return redirect()->route('precontracts.payment', ['id' => $request->precontractId])
            ->with($notification);

    }
    public function paymentRemove($id, $amount, $precontractId)
    {

        $result = $this->oPaymentPrecontract->removePayment($id, $amount, $precontractId);

        $notification = array(
            'message'    => $result['msj'],
            'alert-type' => $result['alert'],
        );

        return redirect()->route('precontracts.payment', ['id' => $precontractId])
            ->with($notification);
    }
//---------------FILES-----------------------//
   //  public function files($id)
   //  {

   //      $precontract = $this->oPrecontract->FindById($id);

   //      //crear el directorio si no existe
   //      $directoryName = "D" . $precontract[0]->countryId . $precontract[0]->officeId . $precontract[0]->precontractId;
   
   //      //obtener todos los archivos del directorio y dejar solo el nombre con el foreach
   //      $allFiles = Storage::files("docs/precontracts/" . $directoryName);
   //      $files   = [];
   //      foreach ($allFiles as $file) {
   //          $filePart = explode("/", $file);
   //          $files[]  = $filePart[3];
   //      }

   //      return view('module_contracts.precontracts.files', compact('precontract', 'files', 'directoryName'));
   //  }
   //  public function fileAgg(Request $request)
   //  {
   //      $precontract      = $this->oPrecontract->FindById($request->precontractId);
   //      $directoryName = "D" . $precontract[0]->countryId . $precontract[0]->officeId . $precontract[0]->precontractId;

   //      if ($request->hasFile('archive')) {
   //          $archive = $request->file('archive');
   //          $name    = time() .'-'.$archive->getClientOriginalName();
   //          $archive->move(storage_path("app/public/docs/precontracts/$directoryName"), $name);
           
   //      }

   //      return redirect()->back();
   //  }

   //   public function fileDownload($typeContract,$directoryName, $file)
   //  {
   //    return Storage::download("docs/$typeContract/$directoryName/$file");
   //  }

   //   public function fileDelete($typeContract,$directoryName, $file) {
   //          Storage::delete("docs/$typeContract/$directoryName/$file");
   //     return redirect()->back();
   // }
    public function files($id)
    {

        $precontract = $this->oPrecontract->FindById($id,session('countryId'),session('officeId'));

        return view('module_contracts.precontracts.files', compact('precontract'));
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
}
