<?php

namespace App\Http\Controllers\web;

use App\hrStaff;
use App\PerTrans;
use App\VacationHistory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VacationHistoryController extends Controller
{
    
    private $oPayRoll;
    private $oGetPrePayroll;
    private $oStaff;
    private $oPTrans;
    private $oInsertBlockePTrans;
    private $oDelPrePayroll;
    private $oDelPayrollControl;
    private $oUpdatePirod;
    

    public function __construct()
    {
        $this->oPayRoll= new VacationHistory; 
        $this->oGetPrePayroll = new VacationHistory;
        $this->oStaff = new VacationHistory;
        $this->oPTrans = new VacationHistory;
        $this->oInsertBlockePTrans = new VacationHistory;
        $this->oDelPrePayroll = new VacationHistory;
        $this->oDelPayrollControl = new VacationHistory;
        $this->oUpdatePirod = new VacationHistory;
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countryId = session('countryId');
        $companyId = session('companyId');
        $payrollHistory = $this->oPayRoll->listVacationHistory($countryId, $companyId);

    
        return compact('payrollHistory');
    }
    
    ##########################
    // process of payroll history
    ##########################

    public function processVacationHistory($year, $payrollNumber, $payrollTypeId )
    {
        
        $countryId = session('countryId');
        $companyId = session('companyId');
        date_default_timezone_set('America/Caracas');
        try {
            // obtener los datos de la pre-vacacion
            $rs1 = $this->oGetPrePayroll->getPreVacation($countryId, $companyId, $year, $payrollNumber);
            $rs1Validate = collect($rs1);

            if ($rs1Validate->isEmpty()) {
                return response()->json([], 204);
            }
            
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
                $idTransType            = $rs->idTransType;
                $transactionTypeCode    = $rs->transactionTypeCode;
                $transactionTypeName    = $rs->transactionTypeName;
                $isIncome               = $rs->isIncome;
                $hasBalance             = $rs->hasBalance;
                $balance                = floatval($rs->balance);
                $quantity               = floatval($rs->quantity);
                $amount                 = floatval($rs->amount);
                $localCurrency          = $rs->localCurrency;
                $localAmount            = floatval($rs->localAmount);
                $exchangeRate           = floatval($rs->exchangeRate);
                $payrollCategory        = 'vacation';
                $display                = $rs->display;
    
                // parte 2.1
                //se inserta la transaccion permanete como bloqueada, por 2 quincenas. La actual mas la siguiente
                // el rango 20000 se utiliza para las transacciones realizadas mediante vacaciones
                
                $PerTrans = new PerTrans();
                $PerTrans->countryId           = $countryId;
                $PerTrans->companyId           = $companyId;
                $PerTrans->staffCode           = $staffCode;
                $PerTrans->transactionTypeCode = $transactionTypeCode;
                $PerTrans->quantity            = $quantity;
                $PerTrans->amount              = $amount;
                $PerTrans->balance             = 0;
                $PerTrans->amount              = $amount;
                $PerTrans->initialBalance      = 0;
                $PerTrans->blocked             = 20001;
                $PerTrans->save();
                
                $hrpayroll = new VacationHistory();
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
                $hrpayroll->idTransType         = $idTransType;
                $hrpayroll->transactionTypeCode = $transactionTypeCode;
                $hrpayroll->transactionTypeName = $transactionTypeName;
                $hrpayroll->isIncome            = $isIncome;
                $hrpayroll->hasBalance          = $hasBalance;
                $hrpayroll->balance             = $balance;
                $hrpayroll->quantity            = $quantity;
                $hrpayroll->amount              = $amount;
                $hrpayroll->localCurrency       = $localCurrency;
                $hrpayroll->localAmount         = $localAmount;
                $hrpayroll->exchangeRate        = $exchangeRate;
                $hrpayroll->payrollCategory     = 'vacation';
                $hrpayroll->display             = $display;
                $hrpayroll->save();
            }
            
            // return;
            // parte 3 
            // borrar los registro de la pre-vacacion seleccionado hrpayroll
            $this->oDelPrePayroll->delPreVacation($countryId, $companyId, $year, $payrollNumber);
            
            // parte 4 
            // borrar el registro seleccionado en tabla hrpayroll_control
            $this->oDelPayrollControl->delVacationControl($countryId, $companyId, $year, $payrollTypeId, $payrollNumber);

            // parte 5
            // actualizo el estatus de en la tabla hrperiod: update=1 para indicar que el periodo ya fue actualizado
            $this->oUpdatePirod->updateStatusPiriodVacation($countryId, $companyId, $year, $payrollTypeId, $payrollNumber);

        } catch (\Throwable $th) {
            throw $th;
        }
        
    }

    

}
