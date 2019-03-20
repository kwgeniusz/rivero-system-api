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

        if ($request->isMethod('post')) {
            $receivables = $this->oReceivable->clientsPending($request->countryId);
        }

        $countrys = Country::all();
        return view('receivables.index', compact('receivables', 'countrys'));
    }
    public function details($clientId)
    {
        $client               = $this->oReceivable->clientPendingById($clientId);
        $receivablesContracts = $this->oReceivable->contractsPending($clientId);
        return view('receivables.details', compact('receivablesContracts', 'client'));
    }
    public function update(Request $request)
    {
        $result = $this->oReceivable->updateReceivable(
            $request->receivableId,
            $request->amountDue,
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
        $receivable = $this->oReceivable->findById($receivableId);
        return json_encode($receivable);
    }

}
