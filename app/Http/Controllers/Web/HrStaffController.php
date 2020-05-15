<?php

namespace App\Http\Controllers\web;

use App\hrStaff;
use App\Country;
use App\Company;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HrStaffController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hrstaff = DB::select("SELECT country.countryId, country.countryName,company.companyId, company.companyName, company.companyShortName,
                department.departmentId, department.departmentName, hrposition.hrpositionId, hrposition.positionName, 
                hrposition.baseSalary AS pBaseSalari, hrposition.baseCurrencyId, currency.currencyName as pCurrencyName, 
                currency.currencySymbol as pCurrencySybol, hrposition.localSalary AS pLocalSalary, hrposition.localCurrencyId, 
                currency2.currencyName AS pLocalCurrencyName, currency2.currencySymbol AS pLocalCurrencySymbol, hrposition.localDailySalary AS pLocalDialySalary,
                hrstaff.hrstaffId, hrstaff.countryId, hrstaff.companyId, hrstaff.staffCode, hrstaff.firstName, hrstaff.lastName, hrstaff.shortName,
                hrstaff.idDocument, hrstaff.passportNumber, hrstaff.legalNumber, hrstaff.departmentId, hrstaff.hrpositionId, hrstaff.baseSalary, 
                hrstaff.baseCurrencyId, currencyStaff1.currencyId, currencyStaff1.currencyName, currencyStaff1.currencySymbol, hrstaff.localSalary, 
                hrstaff.localCurrencyId, currencyStaff2.currencyId, currencyStaff2.currencyName, currencyStaff2.currencySymbol, hrstaff.localDailySalary
            FROM `hrstaff` 
            INNER JOIN country ON hrstaff.countryId = country.countryId
            INNER JOIN company ON hrstaff.companyId = company.companyId
            INNER JOIN department ON hrstaff.departmentId = department.departmentId
            INNER JOIN hrposition ON hrstaff.hrpositionId = hrposition.hrpositionId
            INNER JOIN currency ON hrposition.baseCurrencyId = currency.currencyId
            INNER JOIN currency AS currency2 ON hrposition.localCurrencyId = currency2.currencyId
            LEFT JOIN currency AS currencyStaff1 ON hrstaff.baseCurrencyId = currencyStaff1.currencyId
            LEFT JOIN currency AS currencyStaff2 ON hrstaff.localCurrencyId = currencyStaff2.currencyId");

        return compact('hrstaff');
    }
    
    /**
     * funcion para ortener los valores de los comboBox
     */
    public function comboBoxMult(){
        $countrys = DB::table('country')->select('countryId', 'countryName')->get();
        $companys = DB::table('company')->select('companyId', 'companyName')->get();
        $departments = DB::table('department')->select('departmentId', 'departmentName')->get();
        $hrpositions = DB::table('hrposition')
            ->join('currency', 'hrposition.baseCurrencyId', '=', 'currency.currencyId')
            ->select('hrposition.hrpositionId', 'hrposition.positionName', 'hrposition.baseSalary','currency.currencyName','currency.currencySymbol')->get();
        $currencys = DB::table('currency')->select('currencyId', 'currencyName', 'currencySymbol')->get();

        return compact('countrys','companys','departments','hrpositions','currencys');
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
        $staff = new hrStaff();
        $staff->countryId = $request->countryId;
        $staff->companyId = $request->companyId;
        $staff->staffCode = $request->staffCode;
        $staff->firstName = $request->firstName;
        $staff->lastName = $request->lastName;
        $staff->shortName = $request->shortName;
        $staff->idDocument = $request->idDocument;
        $staff->passportNumber = $request->passportNumber;
        $staff->legalNumber = $request->legalNumber;
        $staff->departmentId = $request->departmentId;
        $staff->hrpositionId = $request->hrpositionId;
        $staff->baseSalary = $request->baseSalary;
        $staff->baseCurrencyId = $request->baseCurrencyId;
        $staff->localSalary = $request->localSalary;
        $staff->localCurrencyId = $request->localCurrencyId;
        $staff->localDailySalary = $request->localDailySalary;
        
        $staff->save();
        return $staff;
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
        
        $staff = hrStaff::find($id);
        $staff->countryId = $request->countryId;
        $staff->companyId = $request->companyId;
        $staff->staffCode = $request->staffCode;
        $staff->firstName = $request->firstName;
        $staff->lastName = $request->lastName;
        $staff->shortName = $request->shortName;
        $staff->idDocument = $request->idDocument;
        $staff->passportNumber = $request->passportNumber;
        $staff->legalNumber = $request->legalNumber;
        $staff->departmentId = $request->departmentId;
        $staff->hrpositionId = $request->hrpositionId;
        $staff->baseSalary = $request->baseSalary;
        $staff->baseCurrencyId = $request->baseCurrencyId;
        $staff->localSalary = $request->localSalary;
        $staff->localCurrencyId = $request->localCurrencyId;
        $staff->localDailySalary = $request->localDailySalary;
        
        $staff->save();
        return $staff;
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
        $periods = Periods::find($id);
        $periods->delete();
    
    }
}
