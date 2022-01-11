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
    private $oPosition;

    public function __construct()
    {
        $this->oPosition = new HrPosition; 
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countryId = session('countryId');
        $companyId = session('companyId');
        $hrstaff = DB::select("SELECT hrstaff.*,country.countryId, country.countryName,company.companyId, company.companyName, company.companyShortName,
                                department.departmentId, department.departmentName, payroll_type.payrollTypeName,
                                hrposition.positionCode,hrposition.positionName
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
        // return $request;

        $userSerie = Company::where('companyId',session('companyId'))->first();
        // dd($userSerie);
        // if ($userSerie->serie == null) {
        //     // return response()->json(['department' => $staff, 'message' => 'success'], 200);
        //     # code...
        // }
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
        $staff->birthdayDate = $request->birthdayDate;
        $staff->childrenCount = (int)$request->childrenCount;
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
        $staff->birthdayDate = $request->birthdayDate;
        $staff->childrenCount = (int)$request->childrenCount;
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

    // obtener todos los departamentos, mediante api externa
    public function apiStaffAll($companyId){
        $staff = DB::table('hrstaff')
            ->join('hrposition', 'hrstaff.positionCode', '=', 'hrposition.positionCode')
            ->join('department', 'hrstaff.departmentId', '=', 'department.departmentId')
            ->where('hrstaff.companyId', $companyId)
            ->select('hrstaff.companyId', 'hrstaff.staffCode', 'hrstaff.firstName', 'hrstaff.lastName', 'hrstaff.shortName',
                'hrstaff.idDocument', 'hrposition.positionName','department.departmentName','department.departmentId')
            ->get();
        
        return response()->json(['staff' => $staff, 'message' => 'success'], 200);
    }

    public function apiByStaff($companyId, $staffCode){
        // return $staffCode;
        $staff = DB::table('hrstaff')
            ->join('hrposition', 'hrstaff.positionCode', '=', 'hrposition.positionCode')
            ->join('department', 'hrstaff.departmentId', '=', 'department.departmentId')
            ->where('hrstaff.companyId', $companyId)
            ->where('hrstaff.staffCode', $staffCode)
            ->select('hrstaff.companyId', 'hrstaff.staffCode', 'hrstaff.firstName', 'hrstaff.lastName', 'hrstaff.shortName',
                'hrstaff.idDocument', 'hrposition.positionName','department.departmentName','department.departmentId')
            ->get();
        return response()->json(['department' => $staff, 'message' => 'success'], 200);
    }
}
