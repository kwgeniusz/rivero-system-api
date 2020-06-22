<?php

namespace App\Http\Controllers\web;

use App\Periods;
use App\Country;
use App\Company;
use App\PayrollControl;
use App\Payroll;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PayrollControlController extends Controller
{
    
    // private $oCountry;
    

    // public function __construct()
    // {
    //     $this->oCountry        = new Country; 
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payrollControl = DB::select("SELECT hrpayroll_control.hrpayrollControlId, country.countryId, country.countryName, company.companyId, company.companyName,
                        payroll_type.payrollTypeId, payroll_type.payrollTypeName, hrpayroll_control.year, hrpayroll_control.payrollNumber,
                        hrpayroll_control.payrollName, hrpayroll_control.processCode
                        FROM `hrpayroll_control`
                    INNER JOIN country ON hrpayroll_control.countryId = country.countryId
                    INNER JOIN company ON hrpayroll_control.companyId = company.companyId
                    INNER JOIN payroll_type ON hrpayroll_control.payrollTypeId = payroll_type.payrollTypeId
                    ORDER BY hrpayroll_control.companyId");

        // $companys =  Company::select('companyShortName', 'companyId')->get();
       
        // $countrys = DB::table('country')->select('countryId', 'countryName')->get();
        // $payrollType = DB::table('payroll_type')->select('payrollTypeId', 'payrollTypeName')->get();
       
        // $countrys   = $this->oCountry->getAll();
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

    function getPayrollNumber($country, $company, $payrollType, $year)
    {
        // return $country . ' ' . $company. ' '. $payrollType .' '. $year;

        $payrollTypeMax = DB::select("SELECT hrperiod.payrollNumber, hrperiod.periodName FROM `hrperiod` 
                            WHERE `countryId`= $country AND `companyId`= $company AND `year`= $year AND`payrollTypeId` = $payrollType");

        return $payrollTypeMax;
    }
    function getPorcess($country, $company)
    {
        // return $country . ' ' . $company. ' '. $payrollType .' '. $year;

        $process = DB::select("SELECT hrprocess.processCode, hrprocess.processName   FROM `hrprocess`  
                            WHERE `countryId`= $country AND `companyId`= $company");

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
        // return $request;
        $hrpayrollControl = new PayrollControl();
        $hrpayrollControl->countryId = $request->countryId;
        $hrpayrollControl->companyId = $request->companyId;
        $hrpayrollControl->payrollTypeId = $request->payrollTypeId;
        $hrpayrollControl->year = $request->year;
        $hrpayrollControl->payrollNumber = $request->payrollNumber;
        $hrpayrollControl->payrollName = $request->payrollName;
        $hrpayrollControl->processCode = $request->processCode;
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
        // return 'entro '.$id;
        $hrpayrollControl = PayrollControl::find($id);
        $hrpayrollControl->delete();
    
    }
    ##########################
    // process of pre-payroll
    ##########################

    public function processPrePayroll($id)
    {
        
    
    $transactionTypeCode = 0;
    $processCode = 0;
    $isIncome  = 1;
    $quantity   = 1;
    $amount   =  0; 
        // PARTE 1. 
    /*
       1. leer tabla hrprepayroll_control.
       2. leer tabla hrstaff
       2. Por cada registro de hrstaff  
          2.1 leer hrprocess_detail
          2.2 calcular transacciones
          2.3 guardar registro calculado en hrpayroll
    */


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

        $rsDel0 = DB::select("SELECT COUNT(*) AS cant
                            FROM hrpayroll 
                                WHERE hrpayroll.countryId = $countryId 
                                AND hrpayroll.companyId = $companyId 
                                AND hrpayroll.year = $year
                                AND hrpayroll.payrollNumber = $payrollNumber ");
        // si los datos ya existen, los elimino y ingreso los nuevos datos
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
        $rs1  = DB::select("SELECT * FROM hrstaff 
        WHERE countryId = $countryId 
            AND hrstaff.companyId  = $companyId 
              AND hrstaff.payrollTypeId = $payrollTypeId
              AND hrstaff.status = 'A' ");
        // return $rs1;

        foreach ($rs1 as $key => $rs) {
     
            $staffCode        = $rs->staffCode;
            $firstName        = $rs->firstName;
            $lastName         = $rs->lastName;
            $staffName        = $rs->shortName;
            $baseSalary       = $rs->baseSalary;

            // get hrprocess data
            $rs2  = DB::select("SELECT * 
                            FROM hrprocess
                            LEFT JOIN hrprocess_detail
                            ON hrprocess.hrprocessId = hrprocess_detail.hrprocessId       
                            WHERE hrprocess.countryId = $countryId  and 
                                    hrprocess.companyId = $companyId and 
                                    hrprocess.processCode = $processCode");
            // return $rs2;
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

               
                
                foreach($rs0 as $rs) {
                    $isSalaryBased        = $rs->salaryBased;
                    $isIncome             = $rs->isIncome;
                } 
                // print_r($rs0);
                // return $rs0;
                $addTrasacction = 0;         // add transaction control
                if ($isSalaryBased == 1) {   // transaccion basada en salario
                    // echo " entro ";
                    $amount = $quantity * $baseSalary;
                    if ($amount > 0) {
                    $addTrasacction = 1;             
                    }
                    
                } else { 
                    if ($quantity > 0 and $amount > 0) {

                        $addTrasacction = 1; 
                     } else {                    // trabsaccion no es basada en salario
                        // get permanent transactions for this person and transaction code
                        // echo " ->no entro";
                        // return $countryId . '='.$companyId.'='. $staffCode . '=' . $transactionTypeCode;
                        // $staffCode= strval($staffCode);
                        $rs4 = DB::select("SELECT * FROM hrpermanent_transaction 
                        WHERE countryId = $countryId AND  
                            companyId  = $companyId AND 
                            staffCode  = '$staffCode' AND 
                            transactionTypeCode = $transactionTypeCode");

                        // print_r($rs4);
                        $addTrasacction = 0; 
                        
                        foreach ($rs4 as $rs5) {
                            $stCode            = $rs5->staffCode;   
                            $ttCode            = $rs5->transactionTypeCode; 
                            $transactionQty    = $rs5->quantity;  
                            $transactionAmount = $rs5->amount;  

                            if ( $staffCode == $stCode and $transactionTypeCode == $ttCode ) {

                                $amount   =   $transactionQty * $transactionAmount;
                                if ($amount > 0) {
                                    $addTrasacction = 1;              	 	
                                }
                            
                            }

                        }
                    }
                }
                

                // insert record in hrpayroll
                if ($addTrasacction == 1) {
                    // $oPayroll->insert($countryId, $companyId, $year, $payrollNumber, $payrollName, 
                    // $staffCode, $staffName, $transactionTypeCode, $isIncome, $quantity, $amount );
                
                    $hrpayroll = new Payroll();
                    $hrpayroll->countryId = $countryId;
                    $hrpayroll->companyId = $companyId;
                    $hrpayroll->year = $year;
                    $hrpayroll->payrollNumber = $payrollNumber;
                    $hrpayroll->payrollName = $payrollName;
                    $hrpayroll->staffCode = $staffCode;
                    $hrpayroll->staffName = $staffName;
                    $hrpayroll->transactionTypeCode = $transactionTypeCode;
                    $hrpayroll->isIncome = $isIncome;
                    $hrpayroll->quantity = $quantity;
                    $hrpayroll->amount = $amount;
                    $hrpayroll->save();
                }
            
            }//foreach ($rs2 as $rs3)

            
        } /* end foreach ($rs1 as $key => $rs) */

        return $hrpayroll;

    }


}
