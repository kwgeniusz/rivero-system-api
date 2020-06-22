<?php

namespace App\Http\Controllers\web;

use App\Periods;
use App\Country;
use App\Company;
use DB;
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

        $print = DB::select("SELECT hrpayroll.countryId, country.countryName, 
                                    hrpayroll.companyId, company.companyName, 
                                    hrpayroll.year, hrpayroll.payrollNumber, hrpayroll.payrollName, -- hrpayroll.staffCode,
                                    -- hrpayroll.staffName, hrpayroll.transactionTypeCode,
                                    -- hrtransaction_type.transactionTypeName, 
                                -- hrpayroll.isIncome, hrpayroll.quantity, hrpayroll.amount ,
                                    SUM(hrpayroll.amount) AS total
                            FROM `hrpayroll`
                            INNER JOIN country ON hrpayroll.countryId = country.countryId
                            INNER JOIN company ON hrpayroll.companyId = company.companyId
                            -- INNER JOIN `hrtransaction_type` ON `hrpayroll`.`transactionTypeCode` = `hrtransaction_type`.`transactionTypeCode`
                           -- WHERE hrpayroll.countryId = 2 
                               -- AND hrpayroll.companyId = 5
                            --   AND hrtransaction_type.countryId = 2
                            --   AND hrtransaction_type.companyId = 5
                            --    AND hrpayroll.year = 2020
                                GROUP BY hrpayroll.payrollName
                                ORDER BY hrpayroll.companyId");

        // $countrys   = $this->oCountry->getAll();
        return compact('print');
    }
    
    public function getListPrePayroll($countryId, $companyId, $year, $payrollNumber)
    {

        $res0 = DB::select("SELECT hrpayroll.staffCode ,hrpayroll.payrollName, country.countryName, company.companyName, company.logo,
                                hrpayroll.payrollName,(
                                    SELECT payroll_type.payrollTypeName FROM `hrpayroll_control`
                                        INNER JOIN payroll_type ON hrpayroll_control.payrollTypeId = payroll_type.payrollTypeId
                                        WHERE hrpayroll_control.countryId = $countryId
                                        AND hrpayroll_control.companyId = $companyId
                                        AND hrpayroll_control.year = $year
                                    AND hrpayroll_control.payrollNumber = $payrollNumber
                                    
                                ) AS payrollTypeName,
                                (
                                    SELECT SUM(amount)  FROM hrpayroll
                                            WHERE hrpayroll.countryId = $countryId
                                        AND hrpayroll.companyId = $companyId
                                        AND hrpayroll.year = $year
                                        AND hrpayroll.payrollNumber = $payrollNumber
                                        AND hrpayroll.isIncome = 1
                                ) AS totalasignacion,
                                (
                                    SELECT SUM(amount)  FROM hrpayroll
                                            WHERE hrpayroll.countryId = $countryId
                                        AND hrpayroll.companyId = $companyId
                                        AND hrpayroll.year = $year
                                        AND hrpayroll.payrollNumber = $payrollNumber
                                        AND hrpayroll.isIncome = 0
                                ) AS totaldeduccion
                            FROM hrpayroll 
                            INNER JOIN country ON hrpayroll.countryId = country.countryId
                            INNER JOIN company ON hrpayroll.companyId = company.companyId
                            WHERE hrpayroll.countryId = $countryId
                                AND hrpayroll.companyId = $companyId
                                AND hrpayroll.year = $year
                                AND hrpayroll.payrollNumber = $payrollNumber
                            GROUP BY hrpayroll.staffCode");
                         
                        //  dd( $res0);
                          // return $res0;
        $print = array();
        $print[0] = $res0[0]->payrollName;
        $print[1] = $res0[0]->countryName;
        $print[2] = $res0[0]->companyName;
        $print[3] = $res0[0]->logo;
        $print[4] = $res0[0]->payrollTypeName;
        $print[5] = $res0[0]->totalasignacion;
        $print[6] = $res0[0]->totaldeduccion;
        foreach($res0 as $res1){
            
            
            $print[] = DB::select("SELECT hrpayroll.countryId, country.countryName, 
                                        hrpayroll.companyId, company.companyName, 
                                    hrpayroll.year, hrpayroll.payrollNumber, hrpayroll.payrollName, hrpayroll.staffCode,
                                    hrpayroll.staffName,  hrpayroll.transactionTypeCode,
                                    hrtransaction_type.transactionTypeName, 
                                    hrpayroll.isIncome, hrpayroll.quantity, hrpayroll.amount, (
                                        SELECT SUM(amount) FROM hrpayroll
                                            WHERE hrpayroll.countryId = $countryId
                                        AND hrpayroll.companyId = $companyId
                                        AND hrpayroll.year = $year
                                        AND hrpayroll.payrollNumber = $payrollNumber
                                            AND hrpayroll.isIncome = 1
                                            AND hrpayroll.staffCode = '$res1->staffCode'
                                        ) as asignacion,
                                        (
                                        SELECT SUM(amount) FROM hrpayroll
                                            WHERE hrpayroll.countryId = $countryId
                                        AND hrpayroll.companyId = $companyId
                                        AND hrpayroll.year = $year
                                        AND hrpayroll.payrollNumber = $payrollNumber
                                            AND hrpayroll.isIncome = 0
                                            AND hrpayroll.staffCode = '$res1->staffCode'
                                        ) as deduccion
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
                                ORDER BY hrpayroll.transactionTypeCode
                            -- GROUP BY hrpayroll.staffCode");
                            // return  $print;
        }                    
        //  dd($print);
        // return $print;
        // $countrys   = $this->oCountry->getAll();
        //  dd($res0);
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
                        AND hrpayroll.staffCode = '$staffCode'");

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
