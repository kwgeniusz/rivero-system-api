<?php

namespace App\Http\Controllers\Web;

use App\Country;
use App\Http\Controllers\Controller;

class CountryController extends Controller
{
    public function all()
    {
        $countrys = Country::all();
        return $countrys;
    }
}
