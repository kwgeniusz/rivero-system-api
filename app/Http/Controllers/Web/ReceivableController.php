<?php

namespace App\Http\Controllers\Web;

use App\Country;
use App\Http\Controllers\Controller;
use App\Receivable;
use Illuminate\Http\Request;

class ReceivableController extends Controller
{
    private $oReceivable;

    public function __construct()
    {
        $this->middleware('auth');
        $this->oReceivable = new Receivable;
    }
    public function index(Request $request)
    {
        $receivables = '';
        $countrys = Country::all();
        
        if ($request->isMethod('post')) {
            $receivables = $this->oReceivable->clientsPending($request->countryId);

           
          //  $amounts = $this->oReceivable->getDueTotal(4);
            // dd($amounts);
            // exiT();
            //  $receivables->push(5)
        }

        return view('receivables.index', compact('receivables', 'countrys'));
    }
    public function details($clientId)
    {
        $client               = $this->oReceivable->clientPendingInfo($clientId);
        $receivablesContracts = $this->oReceivable->contractsPendingAll($clientId);

        //verifica si hay registros sino redirigeme a "ver todos los clientes con cuentas por cobrar"
        if (count($client) == 0) {
            return redirect()->route('receivables.index');
        }

        return view('receivables.details', compact('receivablesContracts', 'client'));
    }
    public function share(Request $request)
    {
        $result = $this->oReceivable->updateReceivable(
            $request->receivableId,
            $request->amountPaid,
            $request->collectMethod,
            $request->sourceBank,
            $request->sourceBankAccount,
            $request->checkNumber,
            $request->targetBankId,
            $request->targetBankAccount,
            $request->datePaid
        );

        return $result;
    }

    public function reportCollections(Request $request)
    {
        $receivables = '';

        if ($request->isMethod('post')) {
            $receivables = $this->oReceivable->clientsPending($request->countryId);
        }
        $countrys = Country::all();

        return view('reportcollections.index', compact('receivables', 'countrys'));
    }
//----------------QUERYS ASINCRONIOUS-----------------//
    public function getForId($receivableId)
    {
        $receivable = Receivable::find($receivableId);
       
       return $receivable->toJson();
    }

}
