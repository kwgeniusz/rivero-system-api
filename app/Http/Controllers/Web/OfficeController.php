<?php

namespace App\Http\Controllers\Web;

use App\Office;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OfficeController extends Controller
{
    public function getForCountry($countryId){

     $offices = Office::where('countryId', $countryId)
                              ->orderBy('officeName','ASC')
                              ->get();
        return json_encode($offices);
    }
}
