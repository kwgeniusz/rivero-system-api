<?php

namespace App\Http\Controllers\web;

use App\Company;
use App\Country;
use App\Office;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DB::select("SELECT company.companyId, company.companyName, company.companyShortName, company.companyNumber, company.countryId,company.officeId,
                            company.companyAddress, country.countryId, country.countryName, office.officeId, office.officeName 
                            FROM `company` 
                        INNER JOIN `country` ON company.countryId = country.countryId
                    
                        INNER JOIN `office` on company.officeId = office.officeId");
    }
    public function comboContry()
    {
        return Country::orderBy('countryName', 'ASC')->get();
    }
    public function comboContryId($id)
    {
        return Company::orderBy('companyName', 'ASC')
        ->where('countryId', '=', $id)
        ->get();
    }

    public function combOffice($id)
    {
        return Office::where('countryId', $id)->get();
    }

    public function editCompany($id)
    {

        return DB::select("SELECT company.companyId, company.companyName, company.companyShortName, company.companyNumber,  company.countryId,company.officeId,
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
        $company = new Company();
        $company->companyName = $request->varFieldOne;
        $company->companyShortName = $request->varFieldTwo;
        $company->companyNumber = $request->varFieldThree;
        $company->countryId = $request->varFieldFour;
        $company->officeId = $request->varFieldFive;
        $company->companyAddress = $request->varFieldSix;
        $company->save();
        return $company;
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

        $company = Company::find($id);
        $company->companyName = $request->varFieldOne;
        $company->companyShortName = $request->varFieldTwo;
        $company->companyNumber = $request->varFieldThree;
        $company->countryId = $request->varFieldFour;
        $company->officeId = $request->varFieldFive;
        $company->companyAddress = $request->varFieldSix;
        $company->save();
        return 'success';
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
        $company = Company::find($id);
        $company->delete();
        // $company = Company::find($id);
        // $company->delete();
    }


     public function getForCountry($countryId){

     $companies = Company::where('countryId', $countryId)
                              ->orderBy('companyName','ASC')
                              ->get();
        return json_encode($companies);
    }
}
