<?php

namespace App\Http\Controllers\web;

use App\Periods;
use App\Country;
use App\Company;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PeriodsController extends Controller
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
        $periods = DB::select("SELECT  hrperiod.periodId, hrperiod.`countryId`, hrperiod.`companyId`, hrperiod.`year`,
                        hrperiod.`payrollTypeId`, hrperiod.`periodName`, hrperiod.`periodFrom`, hrperiod.`periodTo`, hrperiod.`updated`,
                        country.countryId, country.countryName,
                        company.companyId, company.companyShortName,
                        payroll_type.payrollTypeId, payroll_type.payrollTypeName
                    FROM
                        `hrperiod`
                    INNER JOIN country ON hrperiod.countryId = country.countryId
                    INNER JOIN company ON hrperiod.companyId = company.companyId
                    INNER JOIN payroll_type ON hrperiod.payrollTypeId = payroll_type.payrollTypeId");

        // $companys =  Company::orderBy('companyName', 'ASC')->get();
        $companys = DB::table('company')->select('companyId', 'companyName', 'companyShortName')->get();
        $countrys = DB::table('country')->select('countryId', 'countryName')->get();
        $payrollType = DB::table('payroll_type')->select('payrollTypeId', 'payrollTypeName')->get();
        // $countrys   = $this->oCountry->getAll();
        return compact('countrys','periods', 'companys', 'payrollType');
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
        $periods = new Periods();
        $periods->countryId = $request->countryId;
        $periods->companyId = $request->companyId;
        $periods->payrollTypeId = $request->payrollTypeId;
        $periods->periodName = $request->periodName;
        $periods->year = $request->year;
        $periods->periodFrom = $request->periodFrom;
        $periods->periodTo = $request->periodTo;
        
        $periods->save();
        return $periods;
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
        $periods->payrollTypeId = $request->payrollTypeId;
        $periods->periodName = $request->periodName;
        $periods->year = $request->year;
        $periods->periodFrom = $request->periodFrom;
        $periods->periodTo = $request->periodTo;
        
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
        // return 'entro';
        $periods = Periods::find($id);
        $periods->delete();
    
    }
}
