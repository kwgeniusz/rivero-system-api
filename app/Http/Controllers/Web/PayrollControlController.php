<?php

namespace App\Http\Controllers\web;

use App\Periods;
use App\Country;
use App\Company;
use App\PayrollControl;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PayrollControlController extends Controller
{
    
    // private $oCountry;
    

    // public function __construct()
    // {
    //     $this->oCountry        = new Country; 
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payrollControl = DB::select("SELECT hrpayroll_control.hrpayrollControlId, country.countryId, country.countryName, company.companyId, company.companyName,
                        payroll_type.payrollTypeId, payroll_type.payrollTypeName, hrpayroll_control.year, hrpayroll_control.payrollNumber,
                        hrpayroll_control.payrollName, hrpayroll_control.processCode
                        FROM `hrpayroll_control`
                    INNER JOIN country ON hrpayroll_control.countryId = country.countryId
                    INNER JOIN company ON hrpayroll_control.companyId = company.companyId
                    INNER JOIN payroll_type ON hrpayroll_control.payrollTypeId = payroll_type.payrollTypeId");

        // $companys =  Company::select('companyShortName', 'companyId')->get();
       
        // $countrys = DB::table('country')->select('countryId', 'countryName')->get();
        // $payrollType = DB::table('payroll_type')->select('payrollTypeId', 'payrollTypeName')->get();
       
        // $countrys   = $this->oCountry->getAll();
        return compact('payrollControl');
    }
    
    
    /** FUNCION PARA OBTENER TIPO DE NOMINA */
    
    function getPayrollType($idcountry)
    {
        $payrollType = DB::table('payroll_type')->select('payrollTypeId', 'payrollTypeName')
                        ->where('countryId','=', $idcountry)
                        ->get();

        return $payrollType;
    }

    function getPayrollNumber($country, $company, $payrollType, $year)
    {
        // return $country . ' ' . $company. ' '. $payrollType .' '. $year;

        $payrollTypeMax = DB::select("SELECT hrperiod.payrollNumber, hrperiod.periodName FROM `hrperiod` 
                            WHERE `countryId`= $country AND `companyId`= $company AND `year`= $year AND`payrollTypeId` = $payrollType");

        return $payrollTypeMax;
    }
    function getPorcess($country, $company)
    {
        // return $country . ' ' . $company. ' '. $payrollType .' '. $year;

        $process = DB::select("SELECT hrprocess.processCode, hrprocess.processName   FROM `hrprocess`  
                            WHERE `countryId`= $country AND `companyId`= $company");

        return $process;
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
        $hrpayrollControl = new PayrollControl();
        $hrpayrollControl->countryId = $request->countryId;
        $hrpayrollControl->companyId = $request->companyId;
        $hrpayrollControl->payrollTypeId = $request->payrollTypeId;
        $hrpayrollControl->year = $request->year;
        $hrpayrollControl->payrollNumber = $request->payrollNumber;
        $hrpayrollControl->payrollName = $request->payrollName;
        $hrpayrollControl->processCode = $request->processCode;
        $hrpayrollControl->save();
        return $hrpayrollControl;
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
        
        $periods = Periods::find($id);
        $periods->countryId = $request->countryId;
        $periods->companyId = $request->companyId;
        $periods->year = $request->year;
        $periods->payrollTypeId = $request->payrollTypeId;
        $periods->payrollNumber = $request->payrollNumber;
        $periods->periodName = $request->periodName;
        $periods->periodFrom = $request->periodFrom;
        $periods->periodTo = $request->periodTo;
        $periods->updated = $request->updated;
        
        $periods->save();
        return $periods;
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // return 'entro '.$id;
        $hrpayrollControl = PayrollControl::find($id);
        $hrpayrollControl->delete();
    
    }
}
