<?php

namespace App\Http\Controllers\web;

use App\PayRollType;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PayRollTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DB::select("SELECT * FROM payroll_type
                    INNER JOIN country ON payroll_type.countryId = country.countryId");
    }
    
    // public function comboContry()
    // {
    //     return Country::orderBy('countryName', 'ASC')->get();
    // }

    public function combOffice($id)
    {
        return Office::where('countryId', $id)->get();
    }

    public function editCompany($id)
    {

        return DB::select("SELECT company.companyId, company.companyName, company.companyShortName, company.companyNumbrer,  company.countryId,company.officeId,
                                    company.companyAddress, country.countryId, country.countryName, office.officeId, office.officeName 
                            FROM `company` 
                            INNER JOIN `country` ON company.countryId = country.countryId

                            INNER JOIN `office` on company.officeId = office.officeId
                            WHERE company.companyId = $id");
        
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
        $payrollType = new PayRollType();
        $payrollType->countryId = $request->countryId;
        $payrollType->payrollTypeName = $request->payrollTypeName;
        $payrollType->payrollTypeDescription = $request->payrollTypeDescription;
        
        $payrollType->save();
        return $payrollType;
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

        $payrollType = PayRollType::find($id);
        $payrollType->countryId = $request->countryId;
        $payrollType->payrollTypeName = $request->payrollTypeName;
        $payrollType->payrollTypeDescription = $request->payrollTypeDescription;
        $payrollType->save();
        return $payrollType;;
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
        $payrollType = PayRollType::find($id);
        $payrollType->delete();
    
    }
}
