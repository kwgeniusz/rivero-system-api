<?php

namespace App\Http\Controllers\web;

use App\PayrollVacation;
use App\PayrollControl;
use App\Payroll;
use App\Currency;
use App\PerTrans;
use App\Periods;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\config_report\ConfigReport;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Auth;

class PayrollVacationController extends Controller
{
    
    private $oCurrency;
    private $oParamsTransaction;
    private $oConfigReport;

    // vacations
    private $oListVacation;
    private $oProcessPreVacation;
    private $oCheckDataDuplicate;
    private $oDelDataDuplicate;
    private $oStaff;
    private $oWeekend;
    

    public function __construct()
    {
        $this->oCurrency = new Currency; 
        $this->oParamsTransaction = new PerTrans; 

        // vacation
        $this->oListVacation = new PayrollVacation; 
        $this->oProcessPreVacation = new PayrollVacation; 
        $this->oCheckDataDuplicate = new PayrollVacation; 
        $this->oDelDataDuplicate = new PayrollVacation; 
        $this->oStaff = new PayrollVacation; 
        $this->oWeekend = new PayrollVacation; 
        $this->oConfigReport = new ConfigReport;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listVacation = $this->oListVacation->getVacationList();
        return $listVacation;
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

        $payrollTypeMax = DB::select("SELECT hrperiod.payrollNumber, hrperiod.periodName FROM `hrperiod` 
            WHERE `countryId`= $countryId AND `companyId`= $companyId AND `year`= $year
            AND`payrollTypeId` = $payrollType AND`updated` = 0");

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
        // return response()->json(['data' => [$request->payrollName]], 201);
        $countryId = session('countryId');
        $companyId = session('companyId');
        $hrpayrollControl = new PayrollControl();
        $hrpayrollControl->countryId = $countryId;
        $hrpayrollControl->companyId = $companyId;
        $hrpayrollControl->payrollTypeId = $request->payrollTypeId;
        $hrpayrollControl->year = $request->year;
        $hrpayrollControl->periodId = $request->periodId;
        $hrpayrollControl->payrollNumber = $request->payrollNumber;
        $hrpayrollControl->payrollName = $request->payrollName;
        $hrpayrollControl->processCode = $request->processCode;
        $hrpayrollControl->payrollCategory = 'vacation';
        $hrpayrollControl->save();
        return response()->json(['data' => [$hrpayrollControl]], 201);
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
        
        
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $preVacation = PayrollVacation::find($id);
        $preVacation->delete();
    
    }
    ##########################
    // process of pre-vacation
    ##########################

    public function processPreVacation($id)
    {    
    $transactionTypeCode = 0;
    $processCode = 0;
    $isIncome  = 1;
    $quantity   = 1;
    $amount   =  0; 
    $userProcess = Auth::user()->fullName;
    $transProcessed = 0;
        // get currency 
        $oExchangeRate = $this->oCurrency->getExchangeRate();
        $exchangeRate = floatval($oExchangeRate[0]->exchangeRate); //convierto el string a numeros reales

        // get data form table hrpayroll_control
        $rs0 = $this->oProcessPreVacation->getProcessPreVacations($id);
        foreach ($rs0 as $rs) {
            $countryId        = $rs->countryId;   
            $companyId        = $rs->companyId;  
            $year             = $rs->year;  
            $periodId         = $rs->periodId;
            $payrollNumber    = $rs->payrollNumber;
            $payrollTypeId    = $rs->payrollTypeId;
            $payrollName      = $rs->payrollName;
            $processCode      = $rs->processCode;
        }

        // verifico si los datos recividos existen en la tabla hrpayroll
        $rsDel0 = $this->oCheckDataDuplicate->checkDataduplicate($rs0[0]);

        // si los datos ya existen, los elimino para posteriormente agregar los nuevos datos
        if ($rsDel0[0]->cant > 0) {
            // dd($rsDel0[0]->cant);
            $this->oDelDataDuplicate->delDataDuplicate($rs0[0]);
        } 

        $period = Periods::findOrFail($periodId);
        // cantidad de lunes en un periodo determinado
        $startDaysWeekQuantity = $period->start_days_week_quantity;
        // dd($startDaysWeekQuantity);
        $period = collect($period);
        // get data from table hrstaff by period
        $rs1  = $this->oStaff->getStaffByEmploymentDate($period,$payrollTypeId);
        // dd($rs1);
        $dayOff = $this->oWeekend->weekend($period); //obtengo la cantidad de dias en fines de semanas
        // dd($dayOff);
        try {
            foreach ($rs1 as $key => $rs) {
            
                $staffCode         = $rs['staffCode'];
                $idDocument        = $rs['idDocument'];
                // $firstName         = $rs['firstName'];
                // $lastName          = $rs['lastName'];
                $staffName         = $rs['shortName'];
                $probationSalary   = $rs['probationSalary'];
                $baseSalaryPosition= $rs['baseSalary'];
                $probationPeriod   = $rs['probationPeriod'];
                $employmentDate    = $rs['employmentDate'];
                $probationPeriodEnd= $rs['probationPeriodEnd'];
                $stopSS            = $rs['stopSS']; //debenga SSO, FAOV, caso de personas nuevas
                $staffBlockSS      = $rs['blockSS']; //debenga SSO, FAOV, caso de personas tercera edad
                $excTTCode1        = $rs['excTranTypeCode1'];
                $excTTCode2        = $rs['excTranTypeCode2'];
                $excTTCode3        = $rs['excTranTypeCode3'];
                $validity          = $rs['validity'];
                $retentionSalary   = $rs['retentionSalary'];
                $additionalDays    = 0;
                if ($validity > 1) {
                    $additionalDays = $validity - 1;
                }
                $baseSalary = $baseSalaryPosition;
                // dd($baseSalary);
                $dailySalary = $baseSalary / 30;
                
                // get hrprocess data
                $rs2  = DB::select("SELECT * 
                                FROM hrprocess
                                LEFT JOIN hrprocess_detail 
                                    ON hrprocess.hrprocessId = hrprocess_detail.hrprocessId       
                                WHERE hrprocess.countryId = $countryId  
                                    AND hrprocess.companyId = $companyId 
                                    AND hrprocess.processCode = $processCode");
                $rs2Validate = collect($rs2);
                if ($rs2Validate[0]->transactionTypeCode == null) {
                    return response()->json([],204);
                }
                foreach ($rs2 as $rs3) {
                    $transactionTypeCode  = $rs3->transactionTypeCode;     
                    $quantity             = $rs3->quantity;  
                    $amount               = $rs3->amount; 
                        
                    $rs0 = DB::select("SELECT * FROM hrtransaction_type 
                            WHERE countryId = $countryId AND  
                            companyId  = $companyId AND 
                            transactionTypeCode = $transactionTypeCode ");
                    $isSalaryBased        = 0;
                    $isIncome             = 0;
                    $localAmount          = 0;
                    $accSeniority         = 0;
                    
                    // dd($rs0);
                    
                    foreach($rs0 as $rs) {
                        $transactionTypeName    = $rs->transactionTypeName;
                        $isSalaryBased        = $rs->salaryBased;
                        $isIncome             = $rs->isIncome;
                        $transTypeBlockSS     = $rs->blockSS;
                        $displayPayroll       = $rs->display;
                        $accSeniority         = $rs->accSeniority; 
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
                            if ($isSalaryBased == 1 && $isIncome == 1){ //si es vasada en salario y es una asignacion, le cambio el nombre a vacaciones
                                $transactionTypeName = 'VACACIONES';
                                // echo  $transactionTypeName;
                                $quantity = (15 + $additionalDays); //15 dias + dias adicionales por año
                                $amount = $dailySalary * $quantity;
                                if ($amount > 0) {
                                    $addTransaction = 1; 
                                }
                            }else{
                                $amount = $quantity * $baseSalary;
                                $amount = round($amount, 2);
                                if ($amount > 0) {
                                    $addTransaction = 1;             
                                }   
                            }
                        }
    
                    } else { 
                        if ($accSeniority == 1 && $isIncome == 1) {
                            $quantity = (15 + $additionalDays); //15 dias + dias adicionales por año
                            $amount = $dailySalary * $quantity;
                            if ($amount > 0) {
                                $addTransaction = 1; 
                            }
                        }else{
                            $quantity = $dayOff; //dias adicionales por fines de semana
                            $amount = $dailySalary * $quantity;
                            $addTransaction = 1;
                        }
                        
                        // if ($quantity > 0 and $amount > 0) {
                        //     $addTransaction = 1; 
                        // } 
                            
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
                        $hrpayroll->payrollCategory = 'vacation';
                        $hrpayroll->display = $displayPayroll;
                        $hrpayroll->save();
                        $transProcessed += 1; //incrementa en 1 cada vez que se inserta una transaccion. Permite saber si se registraron transacciones
                    }
                }
                
            } /* end foreach ($rs1 as $key => $rs) */
            return response()->json(['success' => true, 'transProcessed' => $transProcessed], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
        
    }
    public function getListVacation($year, $payrollNumber, $payrollTypeId)
    {
        $countryId = session('countryId');
        $companyId = session('companyId');
        // obtiener informacion para los encabezados 
        $res0 = DB::select("SELECT hrpayroll.staffCode ,hrpayroll.companyId ,hrpayroll.payrollName, hrpayroll.userProcess,country.countryName, company.companyShortName, 
                                company.companyAddress, company.logo, company.companyNumber,company.color,
                                hrpayroll.payrollName,(
                                    SELECT payroll_type.payrollTypeName FROM `hrpayroll_control`
                                        INNER JOIN payroll_type ON hrpayroll_control.payrollTypeId = payroll_type.payrollTypeId
                                        WHERE hrpayroll_control.countryId = $countryId
                                        AND hrpayroll_control.companyId = $companyId
                                        AND hrpayroll_control.year = $year
                                        AND hrpayroll_control.payrollNumber = $payrollNumber
                                        AND hrpayroll.payrollTypeId =  $payrollTypeId
                                        AND hrpayroll.payrollCategory = 'vacation'
                                    
                                ) AS payrollTypeName,
                                (
                                    SELECT SUM(amount)  FROM hrpayroll
                                            WHERE hrpayroll.countryId = $countryId
                                        AND hrpayroll.companyId = $companyId
                                        AND hrpayroll.year = $year
                                        AND hrpayroll.payrollNumber = $payrollNumber
                                        AND hrpayroll.payrollTypeId =  $payrollTypeId
                                        AND hrpayroll.isIncome = 1
                                        AND hrpayroll.payrollCategory = 'vacation'
                                ) AS totalasignacion,
                                (
                                    SELECT SUM(localAmount)  FROM hrpayroll
                                            WHERE hrpayroll.countryId = $countryId
                                        AND hrpayroll.companyId = $companyId
                                        AND hrpayroll.year = $year
                                        AND hrpayroll.payrollNumber = $payrollNumber
                                        AND hrpayroll.payrollTypeId =  $payrollTypeId
                                        AND hrpayroll.isIncome = 1
                                        
                                        AND hrpayroll.payrollCategory = 'vacation'
                                ) AS totalasignacionLocal,
                                (
                                    SELECT SUM(amount)  FROM hrpayroll
                                            WHERE hrpayroll.countryId = $countryId
                                        AND hrpayroll.companyId = $companyId
                                        AND hrpayroll.year = $year
                                        AND hrpayroll.payrollNumber = $payrollNumber
                                        AND hrpayroll.payrollTypeId =  $payrollTypeId
                                        AND hrpayroll.isIncome = 0
                                        
                                        AND hrpayroll.payrollCategory = 'vacation'
                                ) AS totaldeduccion,
                                (
                                    SELECT SUM(localAmount)  FROM hrpayroll
                                            WHERE hrpayroll.countryId = $countryId
                                        AND hrpayroll.companyId = $companyId
                                        AND hrpayroll.year = $year
                                        AND hrpayroll.payrollNumber = $payrollNumber
                                        AND hrpayroll.payrollTypeId =  $payrollTypeId
                                        AND hrpayroll.isIncome = 0
                                        
                                        AND hrpayroll.payrollCategory = 'vacation'
                                ) AS totaldeduccionLocal
                            FROM hrpayroll 
                            INNER JOIN country ON hrpayroll.countryId = country.countryId
                            INNER JOIN company ON hrpayroll.companyId = company.companyId
                            WHERE hrpayroll.countryId = $countryId
                                AND hrpayroll.companyId = $companyId
                                AND hrpayroll.year = $year
                                AND hrpayroll.payrollNumber = $payrollNumber
                                AND hrpayroll.payrollTypeId =  $payrollTypeId
                                
                                AND hrpayroll.payrollCategory = 'vacation'
                            GROUP BY hrpayroll.staffCode
                            ORDER BY hrpayroll.staffCode ASC");
        
        if (empty($res0)){
            return response()->json(['success' => true], 204);
        }
        // obtengo los datos de configuracion para el reporte
        $configReport = $this->oConfigReport->getConfigReportByCompany($countryId, $companyId,'prevacation');

        $print = array();
        $print[0] = $res0[0]->payrollName;
        $print[1] = $res0[0]->countryName;
        $print[2] = $res0[0]->companyShortName;
        $print[3] = $res0[0]->logo;
        $print[4] = $res0[0]->payrollTypeName;
        $print[5] = $res0[0]->totalasignacion;
        $print[6] = $res0[0]->totaldeduccion;
        $print[7] = $res0[0]->companyAddress;
        $print[8] = $res0[0]->companyNumber;
        $print[9] = $configReport;
        $print[10] = $res0[0]->color;
        $print[11] = $res0[0]->totalasignacionLocal;
        $print[12] = $res0[0]->totaldeduccionLocal;
        $print[13] = $res0[0]->userProcess;

        foreach($res0 as $res1){
            
            $print[] = DB::select("SELECT hrpayroll.countryId, country.countryName, 
                                            hrpayroll.companyId, company.companyName, 
                                        hrpayroll.year, hrpayroll.payrollNumber, hrpayroll.payrollName, hrpayroll.staffCode,
                                        hrpayroll.staffName,  hrpayroll.transactionTypeCode,
                                        hrpayroll.transactionTypeName, 
                                        hrpayroll.isIncome, hrpayroll.quantity, hrpayroll.amount, hrpayroll.localAmount, 
                                            (
                                            SELECT SUM(amount) FROM hrpayroll
                                                WHERE hrpayroll.countryId = $countryId
                                            AND hrpayroll.companyId = $companyId
                                            AND hrpayroll.year = $year
                                            AND hrpayroll.payrollNumber =$payrollNumber
                                                AND hrpayroll.isIncome = 1
                                                AND hrpayroll.staffCode = '$res1->staffCode'
                                                AND hrpayroll.payrollCategory = 'vacation'
                                            ) as asignacion,
                                            (
                                            SELECT SUM(localAmount) FROM hrpayroll
                                                WHERE hrpayroll.countryId = $countryId
                                            AND hrpayroll.companyId = $companyId
                                            AND hrpayroll.year = $year
                                            AND hrpayroll.payrollNumber =$payrollNumber
                                                AND hrpayroll.isIncome = 1
                                                AND hrpayroll.staffCode = '$res1->staffCode'
                                                AND hrpayroll.payrollCategory = 'vacation'
                                            ) as asignacionLocal,
                                            (
                                            SELECT SUM(amount) FROM hrpayroll
                                                WHERE hrpayroll.countryId = $countryId
                                            AND hrpayroll.companyId = $companyId
                                            AND hrpayroll.year =$year
                                            AND hrpayroll.payrollNumber = $payrollNumber
                                                AND hrpayroll.isIncome = 0
                                                AND hrpayroll.staffCode = '$res1->staffCode'
                                                AND hrpayroll.payrollCategory = 'vacation'
                                            ) as deduccion
                                            ,
                                            (
                                            SELECT SUM(localAmount) FROM hrpayroll
                                                WHERE hrpayroll.countryId = $countryId
                                            AND hrpayroll.companyId = $companyId
                                            AND hrpayroll.year =$year
                                            AND hrpayroll.payrollNumber = $payrollNumber
                                                AND hrpayroll.isIncome = 0
                                                AND hrpayroll.staffCode = '$res1->staffCode'
                                                AND hrpayroll.payrollCategory = 'vacation'
                                            ) as deduccionLocal
                                    FROM `hrpayroll`
                                    INNER JOIN country ON hrpayroll.countryId = country.countryId
                                    INNER JOIN company ON hrpayroll.companyId = company.companyId
                                    INNER JOIN `hrtransaction_type` ON `hrpayroll`.`transactionTypeCode` = `hrtransaction_type`.`transactionTypeCode`
                                    WHERE hrpayroll.countryId = $countryId
                                        AND hrpayroll.companyId = $companyId
                                        AND hrtransaction_type.countryId = $countryId
                                        AND hrtransaction_type.companyId = $companyId
                                        AND hrpayroll.year = $year
                                        AND hrpayroll.payrollNumber = $payrollNumber
                                        AND hrpayroll.staffCode = '$res1->staffCode'
                                        AND hrpayroll.payrollCategory = 'vacation'
                                    ORDER BY hrpayroll.transactionTypeCode");
                            // return  $print;
        }                    
        //  dd($print);
        // return $print;
    
        return compact('print');
    }


}
