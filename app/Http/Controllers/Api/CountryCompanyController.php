<?php

namespace App\Http\Controllers\Api;

use App\Company;
use App\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// use Auth;

class CountryCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function contryCompany()
    {
        $oCountry = Country::all();
        $oCompany = [];

        foreach ($oCountry as $value) {
            $oCompany[] =  array(
                "id" => $value->countryId,
                "country" => $value->countryName,
                "companys" => Company::where('countryId', $value->countryId)->get()
            ); 
        }
        

        return response()->json(['data' => ['oCompany' => $oCompany, 'message' => 'success']], 200);

    }

    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
