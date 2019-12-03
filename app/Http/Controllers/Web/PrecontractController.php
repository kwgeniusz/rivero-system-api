<?php

namespace App\Http\Controllers\Web;

// use App\Client;
use App\Contract;
use App\Currency;
use App\PaymentInvoice;
use App\PaymentPrecontract;
use App\Precontract;
use App\ProjectDescription;
use App\ProjectUse;
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
    private $oProjectDescription;
    private $oProjectUse;
    private $oPaymentPrecontract;
    private $oPaymentInvoice;
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
        $this->oPaymentInvoice    = new PaymentInvoice;
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
            // if ($precontract[0]->payment) {
            //     foreach ($precontract[0]->payment as $payment) {
            //         $result = $this->oPaymentInvoice->aggPayment(
            //             $contractLastId,
            //             $payment->amount,
            //             $payment->paymentDate
            //         );
            //     }
            // }
            
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

}
