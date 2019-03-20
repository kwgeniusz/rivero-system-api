<?php

namespace App\Http\Controllers\Web;

use App\Bank;
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
        $banks = $this->oBank->getAll();
        return view('banks.index', compact('banks'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->oBank->insertB($request->bankName, 1);
        return redirect()->route('banks.index')
            ->with('info', 'Tipo de Proyecto Creado');
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

        return redirect()->route('banks.index')
            ->with('info', 'Tipo de Proyecto Actualizado');
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

        $this->oBank->deleteB($id);
        return redirect()->route('banks.index')
            ->with('info', 'Tipo de Proyecto Eliminado');
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
