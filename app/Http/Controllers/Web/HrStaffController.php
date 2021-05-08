<?php

namespace App\Http\Controllers\web;

use App\Company;
use App\hrStaff;
use App\PayRollType;
use App\HrPosition;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class HrStaffController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countryId = session('countryId');
        $companyId = session('companyId');
        $hrstaff = DB::select("SELECT country.countryId, country.countryName,company.companyId, company.companyName, company.companyShortName,
                                department.departmentId, department.departmentName, hrstaff.payrollTypeId, payroll_type.payrollTypeName,
                                hrposition.positionCode,hrposition.positionName,
                                hrstaff.hrstaffId, hrstaff.countryId, hrstaff.companyId, hrstaff.staffCode, hrstaff.firstName, 
                                hrstaff.lastName,
                                hrstaff.shortName,
                                hrstaff.idDocument, hrstaff.passportNumber, hrstaff.legalNumber, hrstaff.departmentId, 
                                hrstaff.employmentDate, hrstaff.probationPeriod, hrstaff.probationPeriodEnd,
                                hrstaff.baseSalary,hrstaff.probationSalary, hrstaff.baseCurrencyId, currencyStaff1.currencyName, currencyStaff1.currencySymbol, 
                                hrstaff.localSalary, hrstaff.localCurrencyId, currencyStaff2.currencyName, currencyStaff2.currencySymbol, 
                                hrstaff.localDailySalary, hrstaff.excTranTypeCode1, hrstaff.excTranTypeCode2, hrstaff.excTranTypeCode3, hrstaff.stopSS, hrstaff.blockSS, hrstaff.status,
                                hrstaff.deleted_at
                            FROM `hrstaff` 
                            INNER JOIN country ON hrstaff.countryId = country.countryId
                            INNER JOIN company ON hrstaff.companyId = company.companyId
                            INNER JOIN payroll_type ON hrstaff.payrollTypeId = payroll_type.payrollTypeId
                            INNER JOIN department ON hrstaff.departmentId = department.departmentId
                            INNER JOIN hrposition ON hrstaff.positionCode = hrposition.positionCode
                        --  INNER JOIN currency ON hrposition.baseCurrencyId = currency.currencyId
                            
                        --  INNER JOIN currency AS currency2 ON hrposition.localCurrencyId = currency2.currencyId
                            LEFT JOIN currency AS currencyStaff1 ON hrstaff.baseCurrencyId = currencyStaff1.currencyId
                            LEFT JOIN currency AS currencyStaff2 ON hrstaff.localCurrencyId = currencyStaff2.currencyId
                            WHERE hrstaff.countryId = $countryId
                            AND hrstaff.companyId = $companyId
                            AND hrstaff.deleted_at is NULL
                            ORDER BY hrstaff.staffCode");

                            return compact('hrstaff');
                        }
                        
                        /**
     * funcion para ortener los valores de los comboBox
     */
    public function comboBoxMult(){
        
        $countrys = DB::table('country')->select('countryId', 'countryName')->get();
        $companys = DB::table('company')->select('companyId', 'companyName')->get();
        $hrpositions = DB::table('hrposition')
            ->join('currency', 'hrposition.baseCurrencyId', '=', 'currency.currencyId')
            ->select('hrposition.hrpositionId', 'hrposition.positionName', 'hrposition.baseSalary','currency.currencyName','currency.currencySymbol')->get();
        $currencys = DB::table('currency')->select('currencyId', 'currencyName', 'currencySymbol')->get();

        return compact('countrys','companys','hrpositions','currencys');
    }
    public function comboBoxDeparmet($id){
        $companyId = session('companyId');
        $idVal = ($id == 0) ? $companyId : $id;
        $departments = DB::select("SELECT department.departmentId, department.departmentName, department.companyId 
            FROM `department`
            WHERE department.companyId = $idVal");

        return compact('departments');
    }

    public function comboTypePayroll($idCountry)
    {
        $countryId = session('countryId');
        $idVal = ($idCountry == 0) ? $countryId : $idCountry;
        return PayRollType::orderBy('payrollTypeName', 'ASC')
        ->where('countryId', '=', $idVal)
        ->get();
    }
    public function comboPositions()
    {
        $idCountry = session('countryId');
        return HrPosition::select('positionCode', 'positionName', 'baseSalary')
        ->where('countryId', '=', $idCountry)
        ->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        // return Auth::user()->serie;

        $userSerie = Company::where('companyId',session('companyId'))->first();
        
        $numberMax = hrStaff::where('companyId',session('companyId'))
                            ->where('countryId',session('countryId'))
                            ->max('number');
        $number = $numberMax + 1;
        $padded = str_pad($number, 6, "0", STR_PAD_LEFT);
        $codigo = "$userSerie->serie-$padded";

        $staff = new hrStaff();
        $staff->countryId = session('countryId');
        $staff->companyId = session('companyId');
        $staff->shortName = $request->shortName;
        $staff->firstName = $request->firstName;
        $staff->idDocument = $request->idDocument;
        $staff->lastName = $request->lastName;
        $staff->passportNumber = $request->passportNumber;
        $staff->legalNumber = $request->legalNumber;
        $staff->staffCode = $codigo;
        $staff->departmentId = $request->departmentId;
        $staff->payrollTypeId = $request->payrollTypeId;
        $staff->positionCode = $request->positionCode;
        $staff->employmentDate = $request->employmentDate;
        $staff->probationPeriod = (int)$request->probationPeriod;
        $staff->probationPeriodEnd = $request->probationPeriodEnd;
        $staff->baseSalary = (float)$request->baseSalary;
        $staff->probationSalary = (float)$request->probationSalary;
        $staff->baseCurrencyId = $request->baseCurrencyId;
        $staff->localSalary = $request->localSalary;
        $staff->localCurrencyId = $request->localCurrencyId;
        $staff->localDailySalary = $request->localDailySalary;
        $staff->excTranTypeCode1 = $request->excTranTypeCode1;
        $staff->excTranTypeCode2 = $request->excTranTypeCode2;
        $staff->excTranTypeCode3 = $request->excTranTypeCode3;
        $staff->stopSS = $request->stopSS;
        $staff->blockSS = $request->blockSS;
        $staff->status = $request->status;
        $staff->number = $number;
       
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
        
        $staff = hrStaff::findOrFail($id);
        $staff->countryId = session('countryId');
        $staff->companyId = session('companyId');
        $staff->shortName = $request->shortName;
        $staff->firstName = $request->firstName;
        $staff->idDocument = $request->idDocument;
        $staff->lastName = $request->lastName;
        $staff->passportNumber = $request->passportNumber;
        $staff->legalNumber = $request->legalNumber;
        $staff->departmentId = $request->departmentId;
        $staff->payrollTypeId = $request->payrollTypeId;
        $staff->positionCode = $request->positionCode;
        $staff->employmentDate = $request->employmentDate;
        $staff->probationPeriod = (int)$request->probationPeriod;
        $staff->probationPeriodEnd = $request->probationPeriodEnd;
        $staff->baseSalary = (float)$request->baseSalary;
        $staff->probationSalary = (float)$request->probationSalary;
        $staff->baseCurrencyId = $request->baseCurrencyId;
        $staff->localSalary = $request->localSalary;
        $staff->localCurrencyId = $request->localCurrencyId;
        $staff->localDailySalary = $request->localDailySalary;
        $staff->excTranTypeCode1 = $request->excTranTypeCode1;
        $staff->excTranTypeCode2 = $request->excTranTypeCode2;
        $staff->excTranTypeCode3 = $request->excTranTypeCode3;
        $staff->stopSS = $request->stopSS;
        $staff->blockSS = $request->blockSS;
        $staff->status = $request->status;
   
        
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
        // return $id;
        $staff = hrStaff::findOrFail($id);
        $staff->delete();

    
    }
}
