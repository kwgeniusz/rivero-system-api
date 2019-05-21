<?php

namespace App\Http\Controllers\Web;

use App\Bank;
use App\Country;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BankController extends Controller
{
    private $oBank;

    public function __construct()
    {

        $this->middleware('auth');
        $this->oBank = new Bank;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banks    = $this->oBank->getAll();
        $countrys = Country::all();
        foreach ($banks as $key => $bank) {
            $saldoActual = $bank['initialBalance']
                 + $bank['balance01']
                 + $bank['balance02']
                 + $bank['balance03']
                 + $bank['balance04']
                 + $bank['balance05']
                 + $bank['balance06']
                 + $bank['balance07']
                 + $bank['balance08']
                 + $bank['balance09']
                 + $bank['balance10']
                 + $bank['balance11']
                 + $bank['balance12'];
            $banks[$key]['saldoActual'] = number_format($saldoActual, 2, ',', '.');
        }

        return view('banks.index', compact('banks', 'countrys'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->oBank->insertB($request->bankName, $request->countryId);
        $notification = array(
            'message'    => "Banco $request->bankName Creado",
            'alert-type' => 'info',
        );
        return redirect()->route('banks.index')
            ->with($notification);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $bank = $this->oBank->findById($id);
        return view('banks.edit', compact('bank'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->oBank->updateB($id, $request->bankName, $request->initialBalance, $request->balance01, $request->balance02, $request->balance03, $request->balance04, $request->balance05,
            $request->balance06, $request->balance07, $request->balance08, $request->balance09, $request->balance10, $request->balance11, $request->balance12);

        $notification = array(
            'message'    => "Banco $request->bankName Actualizado",
            'alert-type' => 'info',
        );
        return redirect()->route('banks.index')
            ->with($notification);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $bank = $this->oBank->findById($id);
        return view('banks.show', compact('bank'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

       $result = $this->oBank->deleteB($id);

        $notification = array(
            'message'    => $result['msj'],
            'alert-type' => $result['alert'],
        );
        return redirect()->route('banks.index')
            ->with($notification);

    }
//-------QUERYS ASINCRONIOUS-----------------//
    public function getForCountry($countryId)
    {
        $banks = Bank::select('bankId', 'bankName', 'bankAccount')
            ->where('countryId', $countryId)
            ->orderBy('bankName', 'ASC')
            ->get();
        return json_encode($banks);
    }
    public function getAccount($bankId)
    {

        $account = Bank::select('bankAccount')
            ->where('bankId', $bankId)
            ->get();
        return json_encode($account);
    }

}
