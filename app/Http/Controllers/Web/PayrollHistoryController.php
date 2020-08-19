<?php

namespace App\Http\Controllers\web;

use App\hrStaff;
use App\PayrollHistory;
use App\Http\Controllers\Controller;

class PayrollHistoryController extends Controller
{
    
    private $oPayRoll;
    private $oGetPrePayroll;
    private $oStaff;
    private $oPTrans;
    private $oUpPTrans;
    private $oDelPrePayroll;
    private $oDelPayrollControl;
    private $oUpdatePirod;
    

    public function __construct()
    {
        $this->oPayRoll= new PayrollHistory; 
        $this->oGetPrePayroll = new PayrollHistory();
        $this->oStaff = new PayrollHistory();
        $this->oPTrans = new PayrollHistory();
        $this->oUpPTrans = new PayrollHistory();
        $this->oDelPrePayroll = new PayrollHistory();
        $this->oDelPayrollControl = new PayrollHistory();
        $this->oUpdatePirod = new PayrollHistory();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payrollHistory = $this->oPayRoll->listPayRollHistory();

      
        return compact('payrollHistory');
    }
    
    ##########################
    // process of payroll history
    ##########################

    public function processPayrollHistory($countryId, $companyId, $year, $payrollNumber, $payrollTypeId)
    {

        date_default_timezone_set('America/Caracas');
        try {
            $hoy = date("Y-m-d");
            // parte 1
            // Actualizar el estado de periodo de prueba (de ser necesario)
    
            // obtengo el personal para esta nomina
            $rs0 = $this->oStaff->getStaff($countryId, $companyId, $payrollTypeId);
            foreach($rs0 as $rs){
                $hrstaffId              = $rs->hrstaffId;
                $probationPeriod        = $rs->probationPeriod;
                $probationPeriodEnd     = $rs->probationPeriodEnd;
                if ($probationPeriod == 1) { //verifico si la persona esta en periodo de prueba
                    if ($hoy >= $probationPeriodEnd) { //si la persona esta en periodo de prueba, verifico si la fecha de ingreso es mayo que la fecha actual
                        // si la fecha actual es mayor o igual a la fecha final de periodo de prueba, cambio el estatus de probationPeriod = 0
                        $hrStaff = hrStaff::find($hrstaffId);
                        $hrStaff->probationPeriod = 0;
                        $hrStaff->save();
                    } 
                } 
    
            }
            
            // parte 2
            // obtener los datos de la prenomina
            $rs1 = $this->oGetPrePayroll->getPrePayRoll($countryId, $companyId, $year, $payrollNumber);
           
            foreach ($rs1 as $rs) {
                $countryId              = $rs->countryId;
                $companyId              = $rs->companyId;  
                $year                   = $rs->year;
                $payrollNumberStaff     = $rs->payrollNumber;
                $payrollTypeId          = $rs->payrollTypeId;
                $payrollName            = $rs->payrollName;
                $userProcess            = $rs->userProcess;
                $staffCode              = $rs->staffCode;
                $idDocument             = $rs->idDocument;
                $staffName              = $rs->staffName;
                $transactionTypeCode    = $rs->transactionTypeCode;
                $isIncome               = $rs->isIncome;
                $hasBalance             = $rs->hasBalance;
                $balance                = floatval($rs->balance);
                $quantity               = floatval($rs->quantity);
                $amount                 = floatval($rs->amount);
                $localCurrency          = $rs->localCurrency;                
                $localAmount            = floatval($rs->localAmount);
                $exchangeRate           = floatval($rs->exchangeRate);
    
                // parte 2.1
                // verificar las transacciones con saldo en la tabla permanet transaction para actualizar el balance
                if ($hasBalance == 1) {
                    if ($balance == 0) { //si el balance de la transaccion llega a 0, se elimina la transaccion permanente
                        $this->oPTrans->delPermanentTracsaction($staffCode, $transactionTypeCode);
                    } else {//se actualiza el balance
                        $this->oUpPTrans->updatePermanentTracsaction($staffCode, $transactionTypeCode, $balance);
                    }
                    
                } 
                
                $hrpayroll = new PayrollHistory();
                $hrpayroll->countryId           = $countryId;
                $hrpayroll->companyId           = $companyId;
                $hrpayroll->year                = $year;
                $hrpayroll->payrollNumber       = $payrollNumberStaff;
                $hrpayroll->payrollTypeId       = $payrollTypeId;
                $hrpayroll->payrollName         = $payrollName;
                $hrpayroll->userProcess         = $userProcess;
                $hrpayroll->staffCode           = $staffCode;
                $hrpayroll->idDocument          = $idDocument;
                $hrpayroll->staffName           = $staffName;
                $hrpayroll->transactionTypeCode = $transactionTypeCode;
                $hrpayroll->isIncome            = $isIncome;
                $hrpayroll->hasBalance          = $hasBalance;
                $hrpayroll->balance             = $balance;
                $hrpayroll->quantity            = $quantity;
                $hrpayroll->amount              = $amount;
                $hrpayroll->localCurrency       = $localCurrency;
                $hrpayroll->localAmount         = $localAmount;
                $hrpayroll->exchangeRate        = $exchangeRate;
                $hrpayroll->save();
            }
    
            // parte 3 
            // borrar los registro de la prenomina seleccionada
            $this->oDelPrePayroll->delPrePayroll($countryId, $companyId, $year, $payrollNumber);
            
            // parte 4 
            // borrar el registro seleccionado en tabla hrpayroll_control
            $this->oDelPayrollControl->delPayrollControl($countryId, $companyId, $year, $payrollTypeId, $payrollNumber);

            // parte 5
            // actualizo el estatus de en la tabla hrperiod: update=1 para indicar que el periodo ya fue actualizado
            $this->oUpdatePirod->updateStatusPiriod($countryId, $companyId, $year, $payrollTypeId, $payrollNumber);

        } catch (\Throwable $th) {
            throw $th;
        }
        
    }

}
