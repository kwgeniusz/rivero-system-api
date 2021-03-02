<?php

namespace App\Http\Controllers\web;

use App\functionsRrhh;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class functionsRrhhController extends Controller
{
  
    private $oBalance;
    private $oTType;
    private $oStaff;
    private $oStaffRecipt;
    private $oHistoryRecipt;
    public function __construct()
    {
        // $this->middleware('auth');
        
        $this->oStaff = new functionsRrhh;
        $this->oBalance = new functionsRrhh;
        $this->oStaffRecipt = new functionsRrhh;
        $this->oHistoryRecipt = new functionsRrhh;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function netSalary($staff, $countryId, $companyId)
    {
        
        
        $rs = $this->oStaff->getNetSalary($staff, $countryId, $companyId);
        
        $neto = $rs[0][0]->bonos + $rs[0][0]->baseSalary;

        // se usaba para calcular el balance. Se va a reemplazar por obtener el historico de prestamo del empleado
        // $rs1 = $this->oBalance->getPreviousBalance($staff);
        // $balance = floatval($rs1[0]->prestamos);
        return response()->json(['neto' => $neto], 200);
    }
    public function comboTransactionType( $country,$company)
    {
        
        $tType = $this->oTType->getComboTransactionType($country,$company);
        return $tType;
    }
    
    // reportes
    public function paymenSalary(){
        return $this->oStaffRecipt->getStaffReceipt();
    }
    public function historyReceipt($staff){
        return $this->oHistoryRecipt->getHistoryReceipt($staff);
    }
    
}