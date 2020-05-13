<?php

namespace App\Http\Controllers\web;

use App\HrPosition;
use App\Currency;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HrPositionController extends Controller
{
    
    private $oCurrency;
    

    public function __construct()
    {
        $this->oCurrency        = new Currency; 
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hrposition = DB::select("SELECT hrposition.hrpositionId, hrposition.countryId, hrposition.positioncode, hrposition.positionName, hrposition.baseSalary, 
                                hrposition.baseCurrencyId, hrposition.localSalary, hrposition.localCurrencyId, hrposition.localDailySalary, country.countryId,
                                country.countryName, currency.currencyName AS currencyName, currency.currencySymbol AS currencyNameSymbol,
                                currency2.currencyName AS currencyNameLocal, currency2.currencySymbol AS currencySymbolLocal
                            FROM `hrposition`
                                INNER JOIN country ON hrposition.`countryId`= country.countryId
                                INNER JOIN currency ON hrposition.`baseCurrencyId`= currency.currencyId
                                INNER JOIN currency AS currency2 ON hrposition.`localCurrencyId`= currency2.currencyId");

        $currencies   = $this->oCurrency->getAll();
        return compact('currencies','hrposition');
    }
    
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        $hrposition = new HrPosition();
        $hrposition->countryId = $request->countryId;
        $hrposition->positioncode = $request->positioncode;
        $hrposition->positionName = $request->positionName;
        $hrposition->baseSalary = $request->baseSalary;
        $hrposition->baseCurrencyId = $request->baseCurrencyId;
        $hrposition->localSalary = $request->localSalary;
        $hrposition->localCurrencyId = $request->localCurrencyId;
        $hrposition->localDailySalary = $request->localDailySalary;
        
        $hrposition->save();
        return $hrposition;
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
        
        $hrposition = HrPosition::find($id);
        $hrposition->countryId = $request->countryId;
        $hrposition->positioncode = $request->positioncode;
        $hrposition->positionName = $request->positionName;
        $hrposition->baseSalary = $request->baseSalary;
        $hrposition->baseCurrencyId = $request->baseCurrencyId;
        $hrposition->localSalary = $request->localSalary;
        $hrposition->localCurrencyId = $request->localCurrencyId;
        $hrposition->localDailySalary = $request->localDailySalary;
        
        $hrposition->save();
        return $hrposition;
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // return 'entro';
        $hrposition = HrPosition::find($id);
        $hrposition->delete();
    
    }
}
