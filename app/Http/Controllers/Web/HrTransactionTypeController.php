<?php

namespace App\Http\Controllers\web;

use App\HrTransactionType;
use App\Country;
use App\Company;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HrTransactionTypeController extends Controller
{
    
    private $oCountry;
    

    public function __construct()
    {
        $this->oCountry        = new Country; 
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hrtransaction_type = DB::select("SELECT * FROM `hrtransaction_type`
        INNER JOIN country ON hrtransaction_type.countryId = country.countryId
        INNER JOIN company ON hrtransaction_type.companyId = company.companyId
        ORDER BY hrtransaction_type.countryId, hrtransaction_type.companyId, hrtransaction_type.transactionTypeCode ASC");

        $companys =  Company::orderBy('companyName', 'ASC')->get();
        $countrys   = $this->oCountry->getAll();
        return compact('countrys','hrtransaction_type', 'companys');
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
        $hrtransType = new HrTransactionType();
        $hrtransType->countryId = $request->countryId;
        $hrtransType->companyId = $request->companyId;
        $hrtransType->transactionTypeCode = $request->transactionTypeCode;
        $hrtransType->transactionTypeName = $request->transactionTypeName;
        $hrtransType->salaryBased = $request->salaryBased;
        $hrtransType->isIncome = $request->isIncome;
        $hrtransType->hasBalance = $request->hasBalance;
        $hrtransType->blockSS = $request->blockSS;
        $hrtransType->accTax = $request->accTax;
        $hrtransType->accChristmas = $request->accChristmas;
        $hrtransType->accSeniority = $request->accSeniority;
        $hrtransType->display = $request->display;
        
        $hrtransType->save();
        return $hrtransType;
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
        
        $hrtransType = HrTransactionType::find($id);
        $hrtransType->countryId = $request->countryId;
        $hrtransType->companyId = $request->companyId;
        $hrtransType->transactionTypeCode = $request->transactionTypeCode;
        $hrtransType->transactionTypeName = $request->transactionTypeName;
        $hrtransType->salaryBased = $request->salaryBased;
        $hrtransType->isIncome = $request->isIncome;
        $hrtransType->hasBalance = $request->hasBalance;
        $hrtransType->blockSS = $request->blockSS;
        $hrtransType->accTax = $request->accTax;
        $hrtransType->accChristmas = $request->accChristmas;
        $hrtransType->accSeniority = $request->accSeniority;
        $hrtransType->display = $request->display;
        
        $hrtransType->save();
        return $hrtransType;
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
        $hrtransType = HrTransactionType::find($id);
        $hrtransType->delete();
    
    }
}
