<?php

namespace App\Http\Controllers\web;

use App\Periods;
use App\PayrollControl;
use App\Payroll;
use App\Currency;
use App\PerTrans;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PayrollControlController extends Controller
{
    
    private $oCurrency;
    private $oParamsTransaction;
    

    public function __construct()
    {
        $this->oCurrency = new Currency; 
        $this->oParamsTransaction = new PerTrans; 
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
        $payrollControl = DB::select("SELECT hrpayroll_control.hrpayrollControlId, country.countryId, country.countryName, company.companyId, company.companyName,
                        payroll_type.payrollTypeId, payroll_type.payrollTypeName, hrpayroll_control.year, hrpayroll_control.payrollNumber,
                        hrpayroll_control.payrollName, hrpayroll_control.processCode, hrpayroll_control.periodId
                        FROM `hrpayroll_control`
                    INNER JOIN country ON hrpayroll_control.countryId = country.countryId
                    INNER JOIN company ON hrpayroll_control.companyId = company.companyId
                    INNER JOIN payroll_type ON hrpayroll_control.payrollTypeId = payroll_type.payrollTypeId
                    WHERE hrpayroll_control.countryId = $countryId
                    AND hrpayroll_control.companyId = $companyId
                    AND hrpayroll_control.payrollCategory = 'payroll'
                    ORDER BY hrpayroll_control.companyId");

        return compact('payrollControl');
    }
    
    
    /** FUNCION PARA OBTENER TIPO DE NOMINA */
    
    function getPayrollType($idcountry)
    {
        $payrollType = DB::table('payroll_type')->select('payrollTypeId', 'payrollTypeName')
                        ->where('countryId','=', $idcountry)
                        ->get();

        return $payrollType;
    }

    function getPayrollNumber($payrollType, $year, $countryId="", $companyId="")
    {
        if ($countryId=="" && $companyId=="") {
            $countryId = session('countryId');
            $companyId = session('companyId');
        }else {
            $countryId;
            $companyId;
        }

        $payrollTypeMax = DB::select("SELECT * FROM `hrperiod` 
            WHERE `countryId`= $countryId 
            AND `companyId`= $companyId 
            AND `year`= $year
            AND `payrollTypeId` = $payrollType 
            AND`payrollCategory` = 'payroll'
            AND `updated` = 0");

        return $payrollTypeMax;
    }
    function getPayrollNumberVacation($payrollType, $year, $countryId="", $companyId="")
    {
        if ($countryId=="" && $companyId=="") {
            $countryId = session('countryId');
            $companyId = session('companyId');
        }else {
            $countryId;
            $companyId;
        }

        $payrollTypeMax = DB::select("SELECT * FROM `hrperiod` 
            WHERE `countryId`= $countryId 
                AND `companyId`= $companyId 
                AND `year`= $year
                AND `payrollTypeId` = $payrollType 
                AND `payrollCategory` = 'vacation' 
                AND `updated` = 0");

        return $payrollTypeMax;
    }

    function getPorcess($countryId=0, $companyId=0)
    {
        if ($countryId==0 && $companyId == 0) {
            $countryId = session('countryId');
            $companyId = session('companyId');
        }else {
            $countryId;
            $companyId;
        }
        $process = DB::select("SELECT hrprocess.processCode, hrprocess.processName   FROM `hrprocess`  
            WHERE `countryId`= $countryId AND `companyId`= $companyId");

        return $process;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $countryId = session('countryId');
        $companyId = session('companyId');
        $hrpayrollControl = new PayrollControl();
        $hrpayrollControl->countryId = $countryId;
        $hrpayrollControl->companyId = $companyId;
        $hrpayrollControl->payrollTypeId = $request->payrollTypeId;
        $hrpayrollControl->year = $request->year;
        $hrpayrollControl->payrollNumber = $request->payrollNumber;
        $hrpayrollControl->periodId = $request->periodId;
        $hrpayrollControl->payrollName = $request->payrollName;
        $hrpayrollControl->processCode = $request->processCode;
        $hrpayrollControl->payrollCategory = 'payroll';
        $hrpayrollControl->save();
        return $hrpayrollControl;
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
        $periods->year = $request->year;
        $periods->payrollTypeId = $request->payrollTypeId;
        $periods->payrollNumber = $request->payrollNumber;
        $periods->periodName = $request->periodName;
        $periods->periodFrom = $request->periodFrom;
        $periods->periodTo = $request->periodTo;
        $periods->updated = $request->updated;
        
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
        $hrpayrollControl = PayrollControl::find($id);
        $hrpayrollControl->delete();
    
    }
    ##########################
    // process of pre-payroll
    ##########################

    public function processPrePayroll($id, $periodId, $exchangeRate)
    {    
    $transactionTypeCode = 0;
    $processCode = 0;
    $isIncome  = 1;
    $quantity   = 1;
    $amount   =  0; 
    $userProcess = Auth::user()->fullName;

    
    $rsPeriod = Periods::findOrFail($periodId);
    
    // cantidad de lunes en un periodo determinado
    $startDaysWeekQuantity = $rsPeriod->start_days_week_quantity;

        // PARTE 1. 
    /*
        1. leer tabla hrprepayroll_control.
        2. leer tabla hrstaff
        2. Por cada registro de hrstaff  
            2.1 leer hrprocess_detail
            2.2 calcular transacciones
            2.3 guardar registro calculado en hrpayroll
    */
        // get currency 
        $oExchangeRate = $this->oCurrency->getExchangeRate();
        // $exchangeRate = floatval($oExchangeRate[0]->exchangeRate); //convierto el string a numeros reales
        $exchangeRate = str_replace(",",".",$exchangeRate); //reemplazo , a .
        $exchangeRate = floatval($exchangeRate); //convierto el string a numeros reales

        // get data form table hrpayroll_control
        $rs0 = DB::select("SELECT * FROM hrpayroll_control
            WHERE hrpayrollControlId = " . $id);
        
        foreach ($rs0 as $rs) {
            $countryId        = $rs->countryId;   
            $companyId        = $rs->companyId;  
            $year             = $rs->year;  
            $payrollNumber    = $rs->payrollNumber;
            $payrollTypeId    = $rs->payrollTypeId;
            $payrollName      = $rs->payrollName;
            $processCode      = $rs->processCode;
        }

        // verifico si los datos recividos existen en la tabla hrpayroll
        $rsDel0 = DB::select("SELECT COUNT(*) AS cant
                            FROM hrpayroll 
                                WHERE hrpayroll.countryId = $countryId 
                                AND hrpayroll.companyId = $companyId 
                                AND hrpayroll.year = $year
                                AND hrpayroll.payrollNumber = $payrollNumber ");
        // si los datos ya existen, los elimino para posteriormente agregar los nuevos datos
        if ($rsDel0[0]->cant > 0) {
            // dd($rsDel0[0]->cant);
            DB::table('hrpayroll')
            ->where('hrpayroll.countryId', '=', $countryId)
            ->where('hrpayroll.companyId', '=', $companyId)
            ->where('hrpayroll.year', '=', $year)
            ->where('hrpayroll.payrollNumber', '=',  $payrollNumber)
            ->delete();
        } 
        


        // get data from table hrstaff
        $rs1  = DB::select("SELECT hrstaff.*
        FROM hrstaff 
            INNER JOIN hrposition ON hrstaff.positionCode = hrposition.positionCode
            WHERE hrstaff.countryId = $countryId 
                AND hrstaff.companyId  = $companyId 
                    AND hrstaff.payrollTypeId = $payrollTypeId
                    AND hrstaff.status = 'A'");
        // dd($rs1);

        foreach ($rs1 as $key => $rs) {

            
            $staffCode         = $rs->staffCode;
            $idDocument        = $rs->idDocument;
            // $firstName         = $rs->firstName;
            // $lastName          = $rs->lastName;
            $staffName         = $rs->shortName;
            $probationSalary   = $rs->probationSalary;
            $baseSalaryPosition= $rs->baseSalary;
            $retentionSalary   = $rs->retentionSalary;
            $probationPeriod   = $rs->probationPeriod;
            $employmentDate    = $rs->employmentDate;
            $probationPeriodEnd= $rs->probationPeriodEnd;
            $stopSS            = $rs->stopSS; //debenga SSO, FAOV, caso de personas nuevas
            $staffBlockSS      = $rs->blockSS; //debenga SSO, FAOV, caso de personas tercera edad
            $excTTCode1        = $rs->excTranTypeCode1;
            $excTTCode2        = $rs->excTranTypeCode2;
            $excTTCode3        = $rs->excTranTypeCode3;
            
            // **** Para el caso de los periodos de prueba ****
            //     Si probationPeriod == 1 {
            //        Si fecha inicio de periodo > probationPeriodEnd 
            //           Salario de calculo = baseSalary
            //        }De lo contario{
            //          Salario de calculo = probationSalary 
            //        }
            //     } De lo contario {
            //           Salario de calculo = baseSalary
            //     }
                
                
            // parte 1
            // parametrizo el salario base a usar, si es en base al salario de prueba o salario del cargo/posision
            date_default_timezone_set('America/Caracas');
            $hoy = date("Y-m-d");
            if ($probationPeriod == 1) { // $probationPeriod == 1 la persona es en periodo de prueba
                if ($hoy >= $probationPeriodEnd) {
                    $baseSalary = $baseSalaryPosition;
                } else {
                    $baseSalary = $probationSalary;
                }
            } else {
                $baseSalary = $baseSalaryPosition;
            }
            
            // get hrprocess data
            $rs2  = DB::select("SELECT * 
                            FROM hrprocess
                            LEFT JOIN hrprocess_detail 
                                ON hrprocess.hrprocessId = hrprocess_detail.hrprocessId       
                            WHERE hrprocess.countryId = $countryId  and 
                                    hrprocess.companyId = $companyId and 
                                    hrprocess.processCode = $processCode");
            
            foreach ($rs2 as $rs3) {
                $transactionTypeCode  = $rs3->transactionTypeCode;     
                $quantity             = $rs3->quantity;  
                $amount               = $rs3->amount;  
                $params               = $rs3->params;  //asigno a una variable si la transaccion tiene parametros

                //obtengo los datos para Verificar si el usuario tiene alguna transaccion bloqueada
                $TransBlocked = $this->oParamsTransaction->getBlockedTransaction($countryId, $companyId, $transactionTypeCode, $staffCode);
                
                $Blocked = 0;
                $TransBlocked = collect($TransBlocked);
                
                if (!$TransBlocked->isEmpty()) {
                    $TransBlocked = $TransBlocked->first();
                    $Blocked = $TransBlocked->blocked;
                }

                if( $Blocked == 0 ){  // si pasa. ejecuto la operacion
                    
                    $rs0 = DB::select("SELECT * FROM hrtransaction_type 
                            WHERE countryId = $countryId AND  
                            companyId  = $companyId AND 
                            transactionTypeCode = $transactionTypeCode ");
                    $isSalaryBased        = 0;
                    $isIncome             = 0;
                    $localAmount          = 0;
                
                    
                    foreach($rs0 as $rs) {
                        $transactionTypeName    = $rs->transactionTypeName;
                        $isSalaryBased        = $rs->salaryBased;
                        $isIncome             = $rs->isIncome;
                        $transTypeBlockSS     = $rs->blockSS;
                        $displayPayroll       = $rs->display; 
                    } 
                    // print_r($rs0);
                    $addTransaction = 0;         // add transaction control
                    // Si la transaccion es basada en salario
                    if ($isSalaryBased == 1) {  
                        
                        // verifico si el parametro que viene es una deducciones como SSO, FAOV, etc.
                        if ($isSalaryBased == 1 && $isIncome == 0) {
                            // verificacion si a la persona, se le aplican esta deduccion como SSO, FAOV, etc.
                            if ($stopSS == 0) {
                                /* si el tipo de transaccion es bloqueable y el usuario tiene esa transaccion 
                                especifica bloqueada, no se inserta la transaccion */
                                if ($staffBlockSS == 1 && $transTypeBlockSS == 1) {
                                    $addTransaction = 0;
                                } else {
                                    if ($retentionSalary > 0) { //si existe un salario para retencion, aplico nueva formula
                                        // echo $retentionSalary . '<br>';
                                        $retentionSalary2 = ($retentionSalary * 12) / 52;
                                        // echo $retentionSalary . '<br>';
                                        $retentionSalary2 = $quantity *  $retentionSalary2;
                                        // echo $retentionSalary . '<br>';
                                        $amount =  $retentionSalary2 * $startDaysWeekQuantity;
                                        // echo "entro: " . $transactionTypeName . "amount: " . $amount . " = retentionSalary: ". $retentionSalary ." * startDaysWeekQuantity: " .$startDaysWeekQuantity ."  <br>";
                                    }else {
                                        // echo 'no entro: ' . $transactionTypeName . '<br>';
                                        $amount = $quantity * $baseSalary;
                                        $amount = round($amount, 2);
                                    }
                                    // dd($amount);
                                    if ($amount > 0) {
                                        $addTransaction = 1;             
                                    }
                                }
                            } else {
                                $addTransaction = 0;
                            }
    
                        } else {
                            $amount = $quantity * $baseSalary;
                            $amount = round($amount, 2);
                            if ($amount > 0) {
                                $addTransaction = 1;             
                            }
                        }
    
                    } else { 
                        if ($quantity > 0 and $amount > 0) {
                            $addTransaction = 1; 
                        } 
                            
                    }
                    
                    // check for valid transacction
                    if (($transactionTypeCode == $excTTCode1) or ($transactionTypeCode == $excTTCode2) or 
                        ($transactionTypeCode == $excTTCode3) )  {
                        $amount = 0;
                        $addTransaction = 0;        
                    }
    
                    if ($quantity == 0 or $amount == 0) {
                        $addTransaction = 0;
                    }

                    /******** zona de parametrizacion de campo params de la tabla hrprocess_detail *********/

                    // Parametro para transacciones que hagan referencia a hijos del personal
                    // params = 1: El valor 1 es para verificacion de cantidad de hijos
                    if ($params == 1) { 
                        // obtengo los datos para verificar la cantidad de hijos
                        $childrenCount = $this->oParamsTransaction->getChildrenCount($countryId, $companyId, $staffCode);

                        $childrenCount = collect($childrenCount); //lo convierto a coleccion para poder manipularlo
                        
                        if (!$childrenCount->isEmpty()) {
                            $childrenCount = $childrenCount->first(); //obtengo la cantidad de hijos en la primera posicion
                            $quantity = $childrenCount->childrenCount; //asigno la cantidad de hijos a una variable
                            $amount = $amount * $quantity; // hago la operacion entre el monto de la transaccion '*' cantidad de hijos
                            $amount = round($amount, 2); //redondeo a 2 dijitos

                            if ($amount > 0) {
                                $addTransaction = 1;             
                            }
                        }
                    } 
    
                    // insert record in hrpayroll
                    if ($addTransaction == 1) {
                        // $oPayroll->insert($countryId, $companyId, $year, $payrollNumber, $payrollName, 
                        // $staffCode, $staffName, $transactionTypeCode, $isIncome, $quantity, $amount );
                        // localAmount = amount * exchangeRate
                        // echo $staffName . ' '.$localAmount  = $amount * $exchangeRate .' = '. $amount .' * '. $exchangeRate .'<br>';
                        $localAmount = $amount * $exchangeRate;
                        
                        $hrpayroll = new Payroll();
                        $hrpayroll->countryId = $countryId;
                        $hrpayroll->companyId = $companyId;
                        $hrpayroll->year = $year;
                        $hrpayroll->payrollNumber = $payrollNumber;
                        $hrpayroll->payrollTypeId = $payrollTypeId;
                        $hrpayroll->payrollName = $payrollName;
                        $hrpayroll->userProcess = $userProcess;
                        $hrpayroll->staffCode = $staffCode;
                        $hrpayroll->idDocument = $idDocument;
                        $hrpayroll->staffName = $staffName;
                        $hrpayroll->transactionTypeCode = $transactionTypeCode;
                        $hrpayroll->transactionTypeName = $transactionTypeName;
                        $hrpayroll->isIncome = $isIncome;
                        $hrpayroll->quantity = $quantity;
                        $hrpayroll->amount = $amount;
                        $hrpayroll->localCurrency = $oExchangeRate[0]->localCurrency;
                        $hrpayroll->localAmount = $localAmount;
                        $hrpayroll->exchangeRate = $exchangeRate;
                        $hrpayroll->display = $displayPayroll;
                        $hrpayroll->save();
                    }
                } //if(!$TransBlocked->isEmpty()){
                
            
            }//foreach ($rs2 as $rs3)

            // PARTE 2.
            // procesar transacciones permanentes
            //   $countryId,$companyId,$staffCode,$transactionTypeCode
            // $rs4  = DB::table('hrpermanent_transaction')
            // ->join('hrtransaction_type', 'hrpermanent_transaction.transactionTypeCode', '=', 'hrtransaction_type.transactionTypeCode')
            // ->where('hrpermanent_transaction.countryId', '=', $countryId)
            // ->where('hrpermanent_transaction.companyId', '=', $companyId)
            // ->where('hrpermanent_transaction.staffCode', '=', $staffCode)
            // ->where('hrpermanent_transaction.transactionTypeCode', '=', $transactionTypeCode)
            // ->whereNull('hrpermanent_transaction.deleted_at')
            // ->get();
            // $addTransaction = 0; 
            // // dd($rs4);
            
            // // print_r($rs4);
            
            // foreach ($rs4 as $rs5) {
            //         $stCode            = $rs5->staffCode;   
            //         $ttCode            = $rs5->transactionTypeCode; 
            //         $tTyName           = $rs5->transactionTypeName; 
            //         $transactionQty    = $rs5->quantity;  
            //         $transactionAmount = $rs5->amount;  
            //         $display           = $rs5->display; 


            //         if ($isSalaryBased == 1) {   // transaccion basada en salario
                
            //             $amount = $transactionQty * $baseSalary;
            //             $amount = round($amount, 2);

            //         } else {
            //             $amount   =   $transactionQty * $transactionAmount; 
            //             $amount = round($amount, 2);              	
            //         }
                    
            //         // localAmount = amount * exchangeRate
            //         $localAmount = $amount * $exchangeRate;

            //         $hrpayroll = new Payroll();
            //         $hrpayroll->countryId = $countryId;
            //         $hrpayroll->companyId = $companyId;
            //         $hrpayroll->year = $year;
            //         $hrpayroll->payrollNumber = $payrollNumber;
            //         $hrpayroll->payrollTypeId = $payrollTypeId;
            //         $hrpayroll->payrollName = $payrollName;
            //         $hrpayroll->userProcess = $userProcess;
            //         $hrpayroll->staffCode = $staffCode;
            //         $hrpayroll->idDocument = $idDocument;
            //         $hrpayroll->staffName = $staffName;
            //         $hrpayroll->transactionTypeCode = $transactionTypeCode;
            //         $hrpayroll->transactionTypeName = $tTyName;
            //         $hrpayroll->isIncome = $isIncome;
            //         $hrpayroll->quantity = $quantity;
            //         $hrpayroll->amount = $amount;
            //         $hrpayroll->localCurrency = $oExchangeRate[0]->localCurrency;
            //         $hrpayroll->localAmount = $localAmount;
            //         $hrpayroll->exchangeRate = $exchangeRate;
            //         $hrpayroll->display = $display;
            //         $hrpayroll->save();
            //         // $oPayroll->insert($countryId, $companyId, $year, $payrollNumber, $payrollName, 
            //         //     $staffCode, $staffName, $transactionTypeCode, $isIncome, $quantity, $amount );            	 	

            // }
            // PARTE 3.
            // procesar transacciones permanentes

            // get permanent transactions for this person and transaction code
            foreach ( $rs2 as $key => $val) {
                $transactionTypeCode  = $val->transactionTypeCode;

                $rs6 = DB::select("SELECT hrpermanent_transaction.hrpermanentTransactionId, hrpermanent_transaction.transactionTypeCode, hrpermanent_transaction.quantity, 
                                hrpermanent_transaction.amount,hrpermanent_transaction.balance,
                                hrtransaction_type.isIncome, hrtransaction_type.hasBalance, hrtransaction_type.salaryBased, 
                                hrtransaction_type.transactionTypeName, hrtransaction_type.display
                        FROM `hrpermanent_transaction`
                        INNER JOIN hrtransaction_type ON hrpermanent_transaction.transactionTypeCode = hrtransaction_type.transactionTypeCode
                        WHERE hrtransaction_type.countryId = $countryId
                            AND hrtransaction_type.companyId = $companyId
                            AND hrpermanent_transaction.deleted_at IS NULL
                            AND hrpermanent_transaction.transactionTypeCode = $transactionTypeCode
                            AND hrpermanent_transaction.staffCode = '$staffCode'");
                // $rs6  = $oVariable->joinTransactionType($countryId,$companyId,$staffCode);
                // dd($rs6);
            
                //obtengo los datos para Verificar si el usuario tiene alguna transaccion bloqueada
                $TransBlocked = $this->oParamsTransaction->getBlockedTransaction($countryId, $companyId, $transactionTypeCode, $staffCode);
                
                // echo isset($TransBlocked[0]->blocked). ' - '
                $Blocked = 0;
                $TransBlocked = collect($TransBlocked);
                
                if (!$TransBlocked->isEmpty()) {
                    $TransBlocked = $TransBlocked->first();
                    $Blocked = $TransBlocked->blocked;
                }
                if( $Blocked == 0 ){
                    foreach ($rs6 as $rs7) { 
                        $idTransType         = $rs7->hrpermanentTransactionId;
                        $transactionTypeCode = $rs7->transactionTypeCode; 
                        $transactionTypeName = $rs7->transactionTypeName; 
                        $quantity            = $rs7->quantity;  
                        $transAmount         = $rs7->amount;  
                        $transBalance        = $rs7->balance;  
                        $isIncome            = $rs7->isIncome;
                        $transHasBalance     = $rs7->hasBalance;
                        $salaryBased         = $rs7->salaryBased;    
                        $displayPayroll      = $rs7->display;   //indica si la transaccion se debe agragar a reportes de nomina o no 
                        $addTransaction = 0;
                        
                        //si hasBalance = 1  ? balance = balance - amount (condición: balance debe ser igual o mayor que amount)
                        
                        // dd($transactionTypeCode,$quantity,$transAmount,$isIncome,$salaryBased);
                        if ($salaryBased == 1) { //si es basado en salario se aplica como una deduccion normal, ej: SSO FAOV, etc
                            $amount   =   $quantity * $baseSalary; 
                            $amount = round($amount, 2);       	
                        } else {
                            if ($isIncome == 0) { //si es 0, es una deduccion, si no, es una asignacion
                                if ($transHasBalance == 1) { //si la deduccion es con saldo, hago el proceso de reduccion del balance en la deduccion
                                    $amount   =   $quantity * $transAmount; 
                                    if ($transBalance <= $amount) { //pregunto, si el balance o saldo de la deduccion es menor o igual, al monto a descontar
                                        // si el monto a descontar es mayor al balance de la transaccion, lo igualo al balance para evitar saldos negativos
                                        $amount = $transBalance;
                                    }
                                    //este proceso se aplica solo cuando se actualiza la prenomina
                                    // echo $transBalance .' - '.  $amount.' ';
                                    $transBalance = $transBalance -  $amount; //se activa solo al actualizar la prenomina
                                    // echo $staffName.' balance: ' . $balance.' => '; 
                                }else{
                                    $amount   =   $quantity * $transAmount;
        
                                    //este proceso se aplica solo cuando se actualiza la prenomina
                                    $transBalance = $transBalance +  $amount; //se activa solo en actualizacion de nomina
                                    // echo $staffName. ' ahorro sumado en:' . $balance . ' => ';
                                }
                            }else { 
                                // si no, la transaccion permanete es una asignacion
                                $amount   =   $quantity * $transAmount;  
                                $amount = round($amount, 2);
                            }
                        }
                            
                        if ($amount > 0) {
                            $addTransaction = 1;    
                        }
                        
                        // check for valid transacction
                        if (($transactionTypeCode == $excTTCode1) or ($transactionTypeCode == $excTTCode2) or 
                            ($transactionTypeCode == $excTTCode3) )  {
                            $amount = 0;
                            $addTransaction = 0;        
                        }
        
                        if ($quantity == 0 or $amount == 0) {
                            $addTransaction = 0;
                        }
        
                        // localAmount = amount * exchangeRate
                        $localAmount = $amount * $exchangeRate;
                        // insert record in hrpayroll
                        if ($addTransaction == 1) {
                            $hrpayroll = new Payroll();
                            $hrpayroll->countryId = $countryId;
                            $hrpayroll->companyId = $companyId;
                            $hrpayroll->year = $year;
                            $hrpayroll->payrollNumber = $payrollNumber;
                            $hrpayroll->payrollTypeId = $payrollTypeId;
                            $hrpayroll->payrollName = $payrollName;
                            $hrpayroll->userProcess = $userProcess;
                            $hrpayroll->staffCode = $staffCode;
                            $hrpayroll->idDocument = $idDocument;
                            $hrpayroll->staffName = $staffName;
                            $hrpayroll->idTransType = $idTransType;
                            $hrpayroll->transactionTypeCode = $transactionTypeCode;
                            $hrpayroll->transactionTypeName = $transactionTypeName;
                            $hrpayroll->isIncome = $isIncome;
                            $hrpayroll->hasBalance = $transHasBalance;
                            $hrpayroll->balance = $transBalance;
                            $hrpayroll->quantity = $quantity;
                            $hrpayroll->amount = $amount;
                            $hrpayroll->localCurrency = $oExchangeRate[0]->localCurrency;
                            $hrpayroll->localAmount = $localAmount;
                            $hrpayroll->exchangeRate = $exchangeRate;
                            $hrpayroll->display = $displayPayroll;
                            $hrpayroll->save();
                            // $oPayroll->insert($countryId, $companyId, $year, $payrollNumber, $payrollName, 
                            // $staffCode, $staffName, $transactionTypeCode, $isIncome, $quantity, $amount );
                        }
                    } //foreach ($rs4 as $rs5)
                } // if($TransBlocked->isEmpty() AND $Blocked == 0 ){  
            } //end foreach ( $rs2 as $key => $val)
            
        } /* end foreach ($rs1 as $key => $rs) */

        

        return $hrpayroll;

    }


}
