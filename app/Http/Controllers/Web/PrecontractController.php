<?php

namespace App\Http\Controllers\Web;

use App\Client;
use App\Contract;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Http\Requests\PrecontractRequest;
use App\PaymentContract;
use App\PaymentPrecontract;
use App\Precontract;
use App\ProjectType;
use App\ServiceType;
use DB;

class PrecontractController extends Controller
{
    private $oPrecontract;
    private $oClient;
    private $oProjectType;
    private $oServiceType;
    private $oPaymentPrecontract;

    public function __construct()
    {
        $this->middleware('auth');
        $this->oPrecontract        = new Precontract;
        $this->oClient             = new Client;
        $this->oPaymentPrecontract = new PaymentPrecontract;
        $this->oPaymentContract    = new PaymentContract;
        $this->oContract           = new Contract;
        $this->oProjectType        = new ProjectType;
        $this->oServiceType        = new ServiceType;

    }

    public function index()
    {
        //GET LIST PrecontractS for type
        $projects = $this->oPrecontract->getAllForType('P');
        $services = $this->oPrecontract->getAllForType('S');

        return view('precontracts.index', compact('projects', 'services'));
    }

    public function create($contractType)
    {

        $projects = $this->oProjectType->getAll();
        $services = $this->oServiceType->getAll();
        $clients  = $this->oClient->getAll();

        return view('precontracts.create', compact('clients', 'projects', 'services', 'contractType'));
    }

    public function store(PrecontractRequest $request)
    {

        $this->oPrecontract->insertPrecontract(
            $request->countryId,
            $request->officeId,
            $request->contractType,
            $request->clientId,
            $request->siteAddress,
            $request->projectTypeId,
            $request->serviceTypeId,
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
        $precontract = $this->oPrecontract->FindById($id);

        return view('precontracts.details', compact('precontract'));
    }

    public function edit($id)
    {

        $clients     = $this->oClient->getAll();
        $projects    = $this->oProjectType->getAll();
        $services    = $this->oServiceType->getAll();
        $precontract = $this->oPrecontract->FindById($id);

        return view('precontracts.edit', compact('precontract', 'projects', 'services', 'clients'));
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

        $precontract = $this->oPrecontract->FindById($id);
        return view('precontracts.show', compact('precontract'));

    }
    public function destroy($id)
    {

        $this->oPrecontract->deletePrecontract($id);

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

        $precontract = $this->oPrecontract->FindById($id);
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
                '',
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

            //eliminar precontrato
            $this->oPrecontract->deletePrecontract($id);

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

        $precontract = $this->oPrecontract->FindById($id);
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

}
