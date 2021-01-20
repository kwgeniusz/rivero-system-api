<?php

namespace App\Http\Controllers\web;

use App\RrhhDepartment;
use App\PerTrans;
use App\HrTransactionType;
use App\hrStaff;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class getCombosRrhhController extends Controller
{
  
    private $oPerTrans;
    private $oTType;
    private $oStaff;
    public function __construct()
    {
        // $this->middleware('auth');
        $this->oPerTrans = new PerTrans;
        $this->oTType = new HrTransactionType;
        $this->oStaff = new hrStaff;
        // $this->oContactType = new ContactType;
        // $this->oCountryConfiguration = new CountryConfiguration();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function comboStaff()
    {
        $comboStaff = $this->oStaff->getComboStaff();
        return $comboStaff;
    }
    public function comboTransactionType( $country,$company)
    {
        
        $tType = $this->oTType->getComboTransactionType($country,$company);
        return $tType;
    }
    
    
}