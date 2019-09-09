<?php

namespace App\Http\Controllers\Web;

// use App\Client;
use App\Contract;
use App\PaymentContract;
use App\PaymentPrecontract;
use App\Precontract;
use App\ProjectType;
use App\ServiceType;
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
    private $oProjectType;
    private $oServiceType;
    private $oPaymentPrecontract;
    private $oPaymentContract;
    private $oContract;

    public function __construct()
    {
        $this->middleware('auth');
        $this->oPrecontract        = new Precontract;
        // $this->oClient             = new Client;
        $this->oProjectType        = new ProjectType;
        $this->oServiceType        = new ServiceType;
        $this->oPaymentPrecontract = new PaymentPrecontract;
        $this->oPaymentContract    = new PaymentContract;
        $this->oContract           = new Contract;
    }

    public function index()
    {
        //GET LIST PrecontractS for type
        $projects = $this->oPrecontract->getAllForType('P',Auth::user()->countryId,Auth::user()->officeId);
        $services = $this->oPrecontract->getAllForType('S',Auth::user()->countryId,Auth::user()->officeId);

        return view('precontracts.index', compact('projects', 'services'));
    }

    public function create($contractType)
    {

        $projects = $this->oProjectType->getAll();
        $services = $this->oServiceType->getAll();
        // $clients  = $this->oClient->getAll();

        return view('precontracts.create', compact( 'projects', 'services', 'contractType'));
    }

    public function store(PrecontractRequest $request)
    {
        $this->oPrecontract->insertPrecontract(
            Auth::user()->countryId,
            Auth::user()->officeId,
            $request->contractType,
            $request->clientId,
            $request->siteAddress,
            $request->projectTypeId,
            $request->serviceTypeId,
            $request->comment,
            $request->currencyName);

        $notification = array(
            'message'    => 'Pre-Contrato Creado Exitosamente',
            'alert-type' => 'success',
        );

        return redirect()->route('precontracts.index')
            ->with($notification);
    }

    public function details($id)
    {
        $precontract = $this->oPrecontract->FindById($id,Auth::user()->countryId,Auth::user()->officeId);

        return view('precontracts.details', compact('precontract'));
    }

    public function edit($id)
    {

        // $clients     = $this->oClient->getAll();
        $projects    = $this->oProjectType->getAll();
        $services    = $this->oServiceType->getAll();
        $precontract = $this->oPrecontract->FindById($id,Auth::user()->countryId,Auth::user()->officeId);

        return view('precontracts.edit', compact('precontract', 'projects', 'services'));
    }

    public function update(PrecontractRequest $request, $id)
    {

        $this->oPrecontract->updatePrecontract(
            $id,
            $request->countryId,
            $request->officeId,
            $request->clientId,
            $request->siteAddress,
            $request->projectTypeId,
            $request->serviceTypeId,
            $request->comment,
            $request->currencyName
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

        $precontract = $this->oPrecontract->FindById($id,Auth::user()->countryId,Auth::user()->officeId);
        return view('precontracts.show', compact('precontract'));

    }
    public function destroy($id)
    {

        $this->oPrecontract->deletePrecontract($id,Auth::user()->countryId,Auth::user()->officeId);

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

        $precontract = $this->oPrecontract->FindById($id,Auth::user()->countryId,Auth::user()->officeId);
        return view('precontracts.convert', compact('precontract'));

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
                $precontract[0]->projectTypeId,
                $precontract[0]->serviceTypeId,
                '',
                '',
                '',
                '',
                '',
                $precontract[0]->comment,
                $precontract[0]->currencyName
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

        $precontract = $this->oPrecontract->FindById($id,Auth::user()->countryId,Auth::user()->officeId);
        $payments    = $this->oPaymentPrecontract->getAllForPrecontract($id);

        return view('precontracts.payment', compact('precontract', 'payments'));

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
    public function files($id)
    {

        $precontract = $this->oPrecontract->FindById($id);

        //crear el directorio si no existe
        $directoryName = "D" . $precontract[0]->countryId . $precontract[0]->officeId . $precontract[0]->precontractId;
   
        //obtener todos los archivos del directorio y dejar solo el nombre con el foreach
        $allFiles = Storage::files("docs/precontracts/" . $directoryName);
        $files   = [];
        foreach ($allFiles as $file) {
            $filePart = explode("/", $file);
            $files[]  = $filePart[3];
        }

        return view('precontracts.files', compact('precontract', 'files', 'directoryName'));
    }
    public function fileAgg(Request $request)
    {
        $precontract      = $this->oPrecontract->FindById($request->precontractId);
        $directoryName = "D" . $precontract[0]->countryId . $precontract[0]->officeId . $precontract[0]->precontractId;

        if ($request->hasFile('archive')) {
            $archive = $request->file('archive');
            $name    = time() .'-'.$archive->getClientOriginalName();
            $archive->move(storage_path("app/public/docs/precontracts/$directoryName"), $name);
           
        }

        return redirect()->back();
    }

     public function fileDownload($typeContract,$directoryName, $file)
    {
      return Storage::download("docs/$typeContract/$directoryName/$file");
    }

     public function fileDelete($typeContract,$directoryName, $file) {
            Storage::delete("docs/$typeContract/$directoryName/$file");
       return redirect()->back();
   }

}
