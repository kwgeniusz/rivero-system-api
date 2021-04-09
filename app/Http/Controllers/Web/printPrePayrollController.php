<?php

namespace App\Http\Controllers\web;

use App\Periods;
use App\Country;
use App\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class printPrePayrollController extends Controller
{
    
  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $countryId = session('countryId');
        $companyId = session('companyId');
        $print = DB::select("SELECT hrpayroll.countryId, country.countryName, 
                                    hrpayroll.companyId, company.companyName, hrpayroll.userProcess,
                                    hrpayroll.year, hrpayroll.payrollNumber, hrpayroll.payrollName, hrpayroll.payrollTypeId,
                                    SUM(hrpayroll.amount) AS total
                            FROM `hrpayroll`
                            INNER JOIN country ON hrpayroll.countryId = country.countryId
                            INNER JOIN company ON hrpayroll.companyId = company.companyId
                            WHERE hrpayroll.countryId = $countryId
                            AND hrpayroll.companyId = $companyId
                            -- AND hrpayroll.display = 1                            
                            GROUP BY hrpayroll.countryId, hrpayroll.companyId, hrpayroll.payrollNumber,hrpayroll.year
                            ORDER BY hrpayroll.companyId, hrpayroll.payrollNumber
                            ");

        // $countrys   = $this->oCountry->getAll();
        return compact('print');
    }
    
    public function getListPrePayroll($countryId, $companyId, $year, $payrollNumber, $payrollTypeId)
    {

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
                                    
                                ) AS payrollTypeName,
                                (
                                    SELECT SUM(amount)  FROM hrpayroll
                                            WHERE hrpayroll.countryId = $countryId
                                        AND hrpayroll.companyId = $companyId
                                        AND hrpayroll.year = $year
                                        AND hrpayroll.payrollNumber = $payrollNumber
                                        AND hrpayroll.payrollTypeId =  $payrollTypeId
                                        AND hrpayroll.isIncome = 1
                                       -- AND hrpayroll.display =  1
                                ) AS totalasignacion,
                                (
                                    SELECT SUM(localAmount)  FROM hrpayroll
                                            WHERE hrpayroll.countryId = $countryId
                                        AND hrpayroll.companyId = $companyId
                                        AND hrpayroll.year = $year
                                        AND hrpayroll.payrollNumber = $payrollNumber
                                        AND hrpayroll.payrollTypeId =  $payrollTypeId
                                        AND hrpayroll.isIncome = 1
                                      --  AND hrpayroll.display =  1
                                ) AS totalasignacionLocal,
                                (
                                    SELECT SUM(amount)  FROM hrpayroll
                                            WHERE hrpayroll.countryId = $countryId
                                        AND hrpayroll.companyId = $companyId
                                        AND hrpayroll.year = $year
                                        AND hrpayroll.payrollNumber = $payrollNumber
                                        AND hrpayroll.payrollTypeId =  $payrollTypeId
                                        AND hrpayroll.isIncome = 0
                                       -- AND hrpayroll.display =  1
                                ) AS totaldeduccion,
                                (
                                    SELECT SUM(localAmount)  FROM hrpayroll
                                            WHERE hrpayroll.countryId = $countryId
                                        AND hrpayroll.companyId = $companyId
                                        AND hrpayroll.year = $year
                                        AND hrpayroll.payrollNumber = $payrollNumber
                                        AND hrpayroll.payrollTypeId =  $payrollTypeId
                                        AND hrpayroll.isIncome = 0
                                       -- AND hrpayroll.display =  1
                                ) AS totaldeduccionLocal
                            FROM hrpayroll 
                            INNER JOIN country ON hrpayroll.countryId = country.countryId
                            INNER JOIN company ON hrpayroll.companyId = company.companyId
                            WHERE hrpayroll.countryId = $countryId
                                AND hrpayroll.companyId = $companyId
                                AND hrpayroll.year = $year
                                AND hrpayroll.payrollNumber = $payrollNumber
                                AND hrpayroll.payrollTypeId =  $payrollTypeId
                               -- AND hrpayroll.display =  1
                            GROUP BY hrpayroll.staffCode
                            ORDER BY hrpayroll.staffCode ASC");
                         
                        //  dd( $res0);
                          // return $res0;
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
        $print[9] = $res0[0]->companyId;
        $print[10] = $res0[0]->color;
        $print[11] = $res0[0]->totalasignacionLocal;
        $print[12] = $res0[0]->totaldeduccionLocal;
        $print[13] = $res0[0]->userProcess;

        foreach($res0 as $res1){
            
            $print[] = DB::select("SELECT hrpayroll.countryId, country.countryName, 
                                            hrpayroll.companyId, company.companyName, 
                                        hrpayroll.year, hrpayroll.payrollNumber, hrpayroll.payrollName, hrpayroll.staffCode,
                                        hrpayroll.staffName,  hrpayroll.transactionTypeCode,
                                        hrtransaction_type.transactionTypeName, 
                                        hrpayroll.isIncome, hrpayroll.quantity, hrpayroll.amount, hrpayroll.localAmount, 
                                            (
                                            SELECT SUM(amount) FROM hrpayroll
                                                WHERE hrpayroll.countryId = $countryId
                                            AND hrpayroll.companyId = $companyId
                                            AND hrpayroll.year = $year
                                            AND hrpayroll.payrollNumber =$payrollNumber
                                                AND hrpayroll.isIncome = 1
                                                AND hrpayroll.staffCode = '$res1->staffCode'
                                                AND hrpayroll.display =  1
                                            ) as asignacion,
                                            (
                                            SELECT SUM(localAmount) FROM hrpayroll
                                                WHERE hrpayroll.countryId = $countryId
                                            AND hrpayroll.companyId = $companyId
                                            AND hrpayroll.year = $year
                                            AND hrpayroll.payrollNumber =$payrollNumber
                                                AND hrpayroll.isIncome = 1
                                                AND hrpayroll.staffCode = '$res1->staffCode'
                                                AND hrpayroll.display =  1
                                            ) as asignacionLocal,
                                            (
                                            SELECT SUM(amount) FROM hrpayroll
                                                WHERE hrpayroll.countryId = $countryId
                                            AND hrpayroll.companyId = $companyId
                                            AND hrpayroll.year =$year
                                            AND hrpayroll.payrollNumber = $payrollNumber
                                                AND hrpayroll.isIncome = 0
                                                AND hrpayroll.staffCode = '$res1->staffCode'
                                                AND hrpayroll.display =  1
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
                                                AND hrpayroll.display =  1
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
                                        AND hrpayroll.display = 1
                                    ORDER BY hrpayroll.transactionTypeCode");
                            // return  $print;
        }                    
        //  dd($print);
        // return $print;
    
        return compact('print');
    }
    public function getListDetail($countryId, $companyId, $year, $payrollNumber,$staffCode)
    {
        $print = DB::select("SELECT country.countryName, company.companyName, hrpayroll.year, hrpayroll.payrollNumber, hrpayroll.payrollName, hrpayroll.staffCode,
                            hrpayroll.staffName, hrpayroll.transactionTypeCode,
                            hrtransaction_type.transactionTypeName, 
                            hrpayroll.isIncome, hrpayroll.quantity, hrpayroll.amount
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
                        AND hrpayroll.staffCode = '$staffCode'
                        AND hrpayroll.display = 1 ");

        // $countrys   = $this->oCountry->getAll();
        return compact('print');
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

        $payrollTypeMax = DB::select("SELECT MAX(`payrollNumber`) AS payrollNumber FROM `hrperiod` 
                            WHERE `countryId`= $country AND `companyId`= $company AND `year`= $year AND`payrollTypeId` = $payrollType");

        return $payrollTypeMax;
    }


   
}
