<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class hrPrinPayroll extends Model
{
    
    function getPayrollList(){
        $countryId = session('countryId');
        $companyId = session('companyId');
        return DB::select("SELECT hrpayroll_history.*, country.countryName, payroll_type.payrollTypeName, company.companyName
                        FROM `hrpayroll_history`
                        INNER JOIN country ON hrpayroll_history.countryId = country.countryId
                        INNER JOIN company ON hrpayroll_history.companyId = company.companyId
                        INNER JOIN payroll_type ON hrpayroll_history.payrollTypeId = payroll_type.payrollTypeId
                        WHERE hrpayroll_history.countryId = $countryId
                            AND hrpayroll_history.companyId = $companyId
                            AND hrpayroll_history.payrollCategory =  'payroll'
                        GROUP BY hrpayroll_history.countryId,hrpayroll_history.companyId,hrpayroll_history.payrollNumber,hrpayroll_history.year
                        ORDER BY hrpayroll_history.companyId, hrpayroll_history.payrollNumber");
    }
    function headerPayroll($countryId, $companyId,$year, $payrollNumber, $payrollTypeId, $payrollCategory="payroll"){
        if ($countryId == null && $companyId == null) {
            $countryId = session('countryId');
            $companyId = session('companyId');
        }
        
        return DB::select("SELECT hrpayroll_history.staffCode,hrpayroll_history.companyId ,hrpayroll_history.payrollName, hrpayroll_history.userProcess,country.countryName, company.companyShortName, 
                company.companyAddress, company.logo, company.companyNumber,company.color,
                hrpayroll_history.payrollName, payroll_type.payrollTypeName,
                (
                    SELECT SUM(amount)  FROM hrpayroll_history
                        WHERE hrpayroll_history.countryId = $countryId
                        AND hrpayroll_history.companyId = $companyId
                        AND hrpayroll_history.year =  $year
                        AND hrpayroll_history.payrollNumber =  $payrollNumber
                        AND hrpayroll_history.payrollTypeId =  $payrollTypeId
                        AND hrpayroll_history.isIncome = 1
                        AND hrpayroll_history.display =  1
                        AND hrpayroll_history.payrollCategory =  '$payrollCategory'
                ) AS totalasignacion,
                (
                    SELECT SUM(localAmount)  FROM hrpayroll_history
                        WHERE hrpayroll_history.countryId = $countryId
                        AND hrpayroll_history.companyId = $companyId
                        AND hrpayroll_history.year =  $year
                        AND hrpayroll_history.payrollNumber = $payrollNumber
                        AND hrpayroll_history.payrollTypeId =  $payrollTypeId
                        AND hrpayroll_history.isIncome = 1
                        AND hrpayroll_history.display =  1
                        AND hrpayroll_history.payrollCategory =  '$payrollCategory'
                ) AS totalasignacionLocal,
                (
                    SELECT SUM(amount)  FROM hrpayroll_history
                        WHERE hrpayroll_history.countryId = $countryId
                        AND hrpayroll_history.companyId = $companyId
                        AND hrpayroll_history.year =  $year
                        AND hrpayroll_history.payrollNumber =  $payrollNumber
                        AND hrpayroll_history.payrollTypeId =  $payrollTypeId
                        AND hrpayroll_history.isIncome = 0
                        AND hrpayroll_history.display =  1
                        AND hrpayroll_history.payrollCategory =  '$payrollCategory'
                ) AS totaldeduccion,
                (
                    SELECT SUM(localAmount)  FROM hrpayroll_history
                        WHERE hrpayroll_history.countryId =  $countryId
                        AND hrpayroll_history.companyId =  $companyId
                        AND hrpayroll_history.year =  $year
                        AND hrpayroll_history.payrollNumber = $payrollNumber
                        AND hrpayroll_history.payrollTypeId =  $payrollTypeId
                        AND hrpayroll_history.isIncome = 0
                        AND hrpayroll_history.display =  1
                        AND hrpayroll_history.payrollCategory =  '$payrollCategory'
                ) AS totaldeduccionLocal
            
            FROM hrpayroll_history 
            INNER JOIN country ON hrpayroll_history.countryId = country.countryId
            INNER JOIN company ON hrpayroll_history.companyId = company.companyId
            INNER JOIN payroll_type ON hrpayroll_history.payrollTypeId = payroll_type.payrollTypeId
            WHERE hrpayroll_history.countryId = $countryId
                AND hrpayroll_history.companyId = $companyId
                AND hrpayroll_history.year =  $year
                AND hrpayroll_history.payrollNumber =  $payrollNumber
                AND hrpayroll_history.display =  1
                AND hrpayroll_history.payrollCategory =  '$payrollCategory'
            GROUP BY hrpayroll_history.staffCode
            ORDER BY hrpayroll_history.staffCode ASC");
    }

    function headerPayrollVacation($year, $payrollNumber, $payrollTypeId, $payrollCategory="payroll"){
        $countryId = session('countryId');
        $companyId = session('companyId');
        return DB::select("SELECT hrpayroll_history.staffCode,hrpayroll_history.companyId ,hrpayroll_history.payrollName, hrpayroll_history.userProcess,country.countryName, company.companyShortName, 
                company.companyAddress, company.logo, company.companyNumber,company.color,
                hrpayroll_history.payrollName, payroll_type.payrollTypeName,
                (
                    SELECT SUM(amount)  FROM hrpayroll_history
                        WHERE hrpayroll_history.countryId = $countryId
                        AND hrpayroll_history.companyId = $companyId
                        AND hrpayroll_history.year =  $year
                        AND hrpayroll_history.payrollNumber =  $payrollNumber
                        AND hrpayroll_history.payrollTypeId =  $payrollTypeId
                        AND hrpayroll_history.isIncome = 1                        
                        AND hrpayroll_history.payrollCategory =  '$payrollCategory'
                ) AS totalasignacion,
                (
                    SELECT SUM(localAmount)  FROM hrpayroll_history
                        WHERE hrpayroll_history.countryId = $countryId
                        AND hrpayroll_history.companyId = $companyId
                        AND hrpayroll_history.year =  $year
                        AND hrpayroll_history.payrollNumber = $payrollNumber
                        AND hrpayroll_history.payrollTypeId =  $payrollTypeId
                        AND hrpayroll_history.isIncome = 1                        
                        AND hrpayroll_history.payrollCategory =  '$payrollCategory'
                ) AS totalasignacionLocal,
                (
                    SELECT SUM(amount)  FROM hrpayroll_history
                        WHERE hrpayroll_history.countryId = $countryId
                        AND hrpayroll_history.companyId = $companyId
                        AND hrpayroll_history.year =  $year
                        AND hrpayroll_history.payrollNumber =  $payrollNumber
                        AND hrpayroll_history.payrollTypeId =  $payrollTypeId
                        AND hrpayroll_history.isIncome = 0                        
                        AND hrpayroll_history.payrollCategory =  '$payrollCategory'
                ) AS totaldeduccion,
                (
                    SELECT SUM(localAmount)  FROM hrpayroll_history
                        WHERE hrpayroll_history.countryId =  $countryId
                        AND hrpayroll_history.companyId =  $companyId
                        AND hrpayroll_history.year =  $year
                        AND hrpayroll_history.payrollNumber = $payrollNumber
                        AND hrpayroll_history.payrollTypeId =  $payrollTypeId
                        AND hrpayroll_history.isIncome = 0                        
                        AND hrpayroll_history.payrollCategory =  '$payrollCategory'
                ) AS totaldeduccionLocal
            
            FROM hrpayroll_history 
            INNER JOIN country ON hrpayroll_history.countryId = country.countryId
            INNER JOIN company ON hrpayroll_history.companyId = company.companyId
            INNER JOIN payroll_type ON hrpayroll_history.payrollTypeId = payroll_type.payrollTypeId
            WHERE hrpayroll_history.countryId = $countryId
                AND hrpayroll_history.companyId = $companyId
                AND hrpayroll_history.year =  $year
                AND hrpayroll_history.payrollNumber =  $payrollNumber                
                AND hrpayroll_history.payrollCategory =  '$payrollCategory'
            GROUP BY hrpayroll_history.staffCode
            ORDER BY hrpayroll_history.staffCode ASC");
    }
    function headerPayrollVacationStaff($year, $payrollNumber, $payrollTypeId, $payrollCategory="vacation", $staffCode){
        $countryId = session('countryId');
        $companyId = session('companyId');

        return DB::select("SELECT hrpayroll_history.staffCode,hrpayroll_history.companyId ,hrpayroll_history.payrollName, hrpayroll_history.userProcess,country.countryName, company.companyShortName, 
                company.companyAddress, company.logo, company.companyNumber,company.color,
                hrpayroll_history.payrollName, payroll_type.payrollTypeName,
                (
                    SELECT SUM(amount)  FROM hrpayroll_history
                        WHERE hrpayroll_history.countryId = $countryId
                        AND hrpayroll_history.companyId = $companyId
                        AND hrpayroll_history.year =  $year
                        AND hrpayroll_history.payrollNumber =  $payrollNumber
                        AND hrpayroll_history.payrollTypeId =  $payrollTypeId
                        AND hrpayroll_history.isIncome = 1                        
                        AND hrpayroll_history.payrollCategory =  '$payrollCategory'
                        AND hrpayroll_history.staffCode =  '$staffCode'
                ) AS totalasignacion,
                (
                    SELECT SUM(localAmount)  FROM hrpayroll_history
                        WHERE hrpayroll_history.countryId = $countryId
                        AND hrpayroll_history.companyId = $companyId
                        AND hrpayroll_history.year =  $year
                        AND hrpayroll_history.payrollNumber = $payrollNumber
                        AND hrpayroll_history.payrollTypeId =  $payrollTypeId
                        AND hrpayroll_history.isIncome = 1                        
                        AND hrpayroll_history.payrollCategory =  '$payrollCategory'
                        AND hrpayroll_history.staffCode =  '$staffCode'
                ) AS totalasignacionLocal,
                (
                    SELECT SUM(amount)  FROM hrpayroll_history
                        WHERE hrpayroll_history.countryId = $countryId
                        AND hrpayroll_history.companyId = $companyId
                        AND hrpayroll_history.year =  $year
                        AND hrpayroll_history.payrollNumber =  $payrollNumber
                        AND hrpayroll_history.payrollTypeId =  $payrollTypeId
                        AND hrpayroll_history.isIncome = 0                        
                        AND hrpayroll_history.payrollCategory =  '$payrollCategory'
                        AND hrpayroll_history.staffCode =  '$staffCode'
                ) AS totaldeduccion,
                (
                    SELECT SUM(localAmount)  FROM hrpayroll_history
                        WHERE hrpayroll_history.countryId =  $countryId
                        AND hrpayroll_history.companyId =  $companyId
                        AND hrpayroll_history.year =  $year
                        AND hrpayroll_history.payrollNumber = $payrollNumber
                        AND hrpayroll_history.payrollTypeId =  $payrollTypeId
                        AND hrpayroll_history.isIncome = 0                        
                        AND hrpayroll_history.payrollCategory =  '$payrollCategory'
                        AND hrpayroll_history.staffCode =  '$staffCode'
                ) AS totaldeduccionLocal
            FROM hrpayroll_history 
            INNER JOIN hrstaff ON hrpayroll_history.staffCode = hrstaff.staffCode
            INNER JOIN country ON hrpayroll_history.countryId = country.countryId
            INNER JOIN company ON hrpayroll_history.companyId = company.companyId
            INNER JOIN payroll_type ON hrpayroll_history.payrollTypeId = payroll_type.payrollTypeId
            WHERE hrpayroll_history.countryId = $countryId
                AND hrpayroll_history.companyId = $companyId
                AND hrpayroll_history.year =  $year
                AND hrpayroll_history.payrollNumber =  $payrollNumber                
                AND hrpayroll_history.payrollCategory =  '$payrollCategory'
                AND hrpayroll_history.staffCode =  '$staffCode'
            GROUP BY hrpayroll_history.staffCode
            ORDER BY hrpayroll_history.staffCode ASC");
    }

    function detailPayroll($countryId, $companyId, $year, $payrollNumber, $staffCode, $payrollCategory="payroll") {
        if ($countryId == null && $companyId == null) {
            $countryId = session('countryId');
            $companyId = session('companyId');
        }
        return DB::select("SELECT hrpayroll_history.countryId, country.countryName, 
                    hrpayroll_history.companyId, company.companyName, 
                hrpayroll_history.year, hrpayroll_history.payrollNumber, hrpayroll_history.payrollName, hrpayroll_history.staffCode,
                hrpayroll_history.staffName,  hrpayroll_history.transactionTypeCode,
                hrtransaction_type.transactionTypeName, 
                hrpayroll_history.isIncome, hrpayroll_history.quantity, hrpayroll_history.amount, hrpayroll_history.localAmount, 
                    (
                    SELECT SUM(amount) FROM hrpayroll_history
                        WHERE hrpayroll_history.countryId = $countryId
                            AND hrpayroll_history.companyId = $companyId
                            AND hrpayroll_history.year = $year
                            AND hrpayroll_history.payrollNumber =$payrollNumber
                            AND hrpayroll_history.isIncome = 1
                            AND hrpayroll_history.staffCode = '$staffCode'
                            AND hrpayroll_history.display =  1
                            AND hrpayroll_history.payrollCategory =  '$payrollCategory'
                    ) as asignacion,
                    (
                    SELECT SUM(localAmount) FROM hrpayroll_history
                        WHERE hrpayroll_history.countryId = $countryId
                            AND hrpayroll_history.companyId = $companyId
                            AND hrpayroll_history.year = $year
                            AND hrpayroll_history.payrollNumber =$payrollNumber
                            AND hrpayroll_history.isIncome = 1
                            AND hrpayroll_history.staffCode = '$staffCode'
                            AND hrpayroll_history.display =  1
                            AND hrpayroll_history.payrollCategory =  '$payrollCategory'
                    ) as asignacionLocal,
                    (
                    SELECT SUM(amount) FROM hrpayroll_history
                        WHERE hrpayroll_history.countryId = $countryId
                            AND hrpayroll_history.companyId = $companyId
                            AND hrpayroll_history.year =$year
                            AND hrpayroll_history.payrollNumber = $payrollNumber
                            AND hrpayroll_history.isIncome = 0
                            AND hrpayroll_history.staffCode = '$staffCode'
                            AND hrpayroll_history.display =  1
                            AND hrpayroll_history.payrollCategory =  '$payrollCategory'
                    ) as deduccion
                    ,
                    (
                    SELECT SUM(localAmount) FROM hrpayroll_history
                        WHERE hrpayroll_history.countryId = $countryId
                        AND hrpayroll_history.companyId = $companyId
                        AND hrpayroll_history.year =$year
                        AND hrpayroll_history.payrollNumber = $payrollNumber
                        AND hrpayroll_history.isIncome = 0
                        AND hrpayroll_history.staffCode = '$staffCode'
                        AND hrpayroll_history.display =  1
                        AND hrpayroll_history.payrollCategory =  '$payrollCategory'
                    ) as deduccionLocal
            FROM `hrpayroll_history`
            INNER JOIN country ON hrpayroll_history.countryId = country.countryId
            INNER JOIN company ON hrpayroll_history.companyId = company.companyId
            INNER JOIN `hrtransaction_type` ON `hrpayroll_history`.`transactionTypeCode` = `hrtransaction_type`.`transactionTypeCode`
            WHERE hrpayroll_history.countryId = $countryId
                AND hrpayroll_history.companyId = $companyId
                AND hrtransaction_type.countryId = $countryId
                AND hrtransaction_type.companyId = $companyId
                AND hrpayroll_history.year = $year
                AND hrpayroll_history.payrollNumber = $payrollNumber
                AND hrpayroll_history.staffCode = '$staffCode'
                AND hrpayroll_history.display = 1
                AND hrpayroll_history.payrollCategory =  '$payrollCategory'
            ORDER BY hrpayroll_history.transactionTypeCode");
    }
    function detailPayrollVacation($year, $payrollNumber, $staffCode, $payrollCategory="payroll") {
        $countryId = session('countryId');
        $companyId = session('companyId');
        return DB::select("SELECT hrpayroll_history.countryId, country.countryName, 
                    hrpayroll_history.companyId, company.companyName, 
                hrpayroll_history.year, hrpayroll_history.payrollNumber, hrpayroll_history.payrollName, hrpayroll_history.staffCode,
                hrpayroll_history.staffName, hrstaff.employmentDate, hrstaff.idDocument, hrpayroll_history.transactionTypeCode,
                hrpayroll_history.transactionTypeName, 
                hrpayroll_history.isIncome, hrpayroll_history.quantity, hrpayroll_history.amount, hrpayroll_history.localAmount,
                hrposition.positionName, hrtransaction_type.comment,
                    (
                    SELECT SUM(amount) FROM hrpayroll_history
                        WHERE hrpayroll_history.countryId = $countryId
                            AND hrpayroll_history.companyId = $companyId
                            AND hrpayroll_history.year = $year
                            AND hrpayroll_history.payrollNumber =$payrollNumber
                            AND hrpayroll_history.isIncome = 1
                            AND hrpayroll_history.staffCode = '$staffCode'                                                    
                            AND hrpayroll_history.payrollCategory =  '$payrollCategory'
                    ) as asignacion,
                    (
                    SELECT SUM(localAmount) FROM hrpayroll_history
                        WHERE hrpayroll_history.countryId = $countryId
                            AND hrpayroll_history.companyId = $companyId
                            AND hrpayroll_history.year = $year
                            AND hrpayroll_history.payrollNumber =$payrollNumber
                            AND hrpayroll_history.isIncome = 1
                            AND hrpayroll_history.staffCode = '$staffCode'                                                    
                            AND hrpayroll_history.payrollCategory =  '$payrollCategory'
                    ) as asignacionLocal,
                    (
                    SELECT SUM(amount) FROM hrpayroll_history
                        WHERE hrpayroll_history.countryId = $countryId
                            AND hrpayroll_history.companyId = $companyId
                            AND hrpayroll_history.year =$year
                            AND hrpayroll_history.payrollNumber = $payrollNumber
                            AND hrpayroll_history.isIncome = 0
                            AND hrpayroll_history.staffCode = '$staffCode'                                                    
                            AND hrpayroll_history.payrollCategory =  '$payrollCategory'
                    ) as deduccion,
                    (
                    SELECT SUM(localAmount) FROM hrpayroll_history
                        WHERE hrpayroll_history.countryId = $countryId
                        AND hrpayroll_history.companyId = $companyId
                        AND hrpayroll_history.year =$year
                        AND hrpayroll_history.payrollNumber = $payrollNumber
                        AND hrpayroll_history.isIncome = 0
                        AND hrpayroll_history.staffCode = '$staffCode'                                                
                        AND hrpayroll_history.payrollCategory =  '$payrollCategory'
                    ) as deduccionLocal
            FROM `hrpayroll_history`
            INNER JOIN hrstaff ON hrpayroll_history.staffCode = hrstaff.staffCode
            INNER JOIN hrposition ON hrstaff.positionCode = hrposition.positionCode
            INNER JOIN country ON hrpayroll_history.countryId = country.countryId
            INNER JOIN company ON hrpayroll_history.companyId = company.companyId
            INNER JOIN `hrtransaction_type` ON `hrpayroll_history`.`transactionTypeCode` = `hrtransaction_type`.`transactionTypeCode`
            WHERE hrpayroll_history.countryId = $countryId
                AND hrpayroll_history.companyId = $companyId
                AND hrtransaction_type.countryId = $countryId
                AND hrtransaction_type.companyId = $companyId
                AND hrpayroll_history.year = $year
                AND hrpayroll_history.payrollNumber = $payrollNumber
                AND hrpayroll_history.staffCode = '$staffCode'
                AND hrpayroll_history.payrollCategory =  '$payrollCategory'
            ORDER BY hrpayroll_history.transactionTypeCode");
    }
    
    function reportByTransactionPayroll($countryId, $companyId, $payrollNumber, $oTransaction, $oEmployees, $table){
        
        $strTransaction = "WHERE (";
        foreach ($oTransaction as $key => $val) {
            // return $val['code'];
            $strTransaction  .= ($key > 0) ? ' OR '. $table .'.transactionTypeCode = ' . $val['code'] : '' . ' '. $table .'.transactionTypeCode = ' . $val['code'];
        }
        
        $strTransactionType = $strTransaction . ')';
        $strTransaction .= ') AND (';


        foreach ($oEmployees as $key => $val) {
            // return $val['code'];
            $strTransaction  .= ($key > 0) ? " OR $table.staffCode = " . "'" . $val['code'] . "'" : '' . ' '.$table.'.staffCode = ' . "'" . $val['code'] . "'";
        }
        $strTransaction .= ')';

        
        // echo 'SELECT * FROM `hrpayroll_history` ' . $strTransaction . ' AND hrpayroll_history.countryId =' . $countryId . ' AND hrpayroll_history.companyId =' . $companyId . ' AND hrpayroll_history.payrollNumber =' .$payrollNumber;
        
        // detalle del reporte por staff
        // $res0 =  DB::select('SELECT * FROM `hrpayroll_history` ' . $strTransaction . ' AND hrpayroll_history.countryId =' . $countryId . ' AND hrpayroll_history.companyId =' . $companyId . ' AND hrpayroll_history.payrollNumber =' .$payrollNumber);
        // return
        // echo 'SELECT *, SUM(`amount`) AS total, SUM(`localAmount`) AS totalLocal FROM '. $table .'
        // INNER JOIN country ON '. $table .'.countryId = country.countryId
        // INNER JOIN company ON '. $table .'.companyId = company.companyId
        // INNER JOIN payroll_type ON '. $table .'.payrollTypeId = payroll_type.payrollTypeId
        // ' . $strTransaction . ' AND '. $table .'.countryId =' . $countryId . ' AND '. $table .'.companyId =' . $companyId . ' AND '. $table .'.payrollNumber =' .$payrollNumber. ' GROUP BY  '. $table .'.`isIncome` ORDER BY '. $table .'.`isIncome` DESC';
        
        
        $res3 =  DB::select('SELECT *, SUM(`amount`) AS total, SUM(`localAmount`) AS totalLocal FROM '. $table .'
            INNER JOIN country ON '. $table .'.countryId = country.countryId
            INNER JOIN company ON '. $table .'.companyId = company.companyId
            INNER JOIN payroll_type ON '. $table .'.payrollTypeId = payroll_type.payrollTypeId
            ' . $strTransaction . ' AND '. $table .'.countryId =' . $countryId . ' AND '. $table .'.companyId =' . $companyId . ' AND '. $table .'.payrollNumber =' .$payrollNumber. ' GROUP BY  '. $table .'.`isIncome` ORDER BY '. $table .'.`isIncome` DESC');
        // dd($res3);
        if (!$res3) {
           return "empty";
        }
        // exit();
        $print = array();
        $totalAsignacion     = 0;
        $totalDeduccion     = 0;
        $totalAsignacionLocal = 0;
        $totalDeduccionLocal = 0;
        $rsCountryId = '';
        $rsCompanyId = '';
        $rsPayrollName = '';

        // encabezado en totales generales
        foreach ($res3 as $key => $val) {
            $rsCountryId            = $val->countryName;
            $rsCompanyId            = $val->companyShortName;
            $companyAddress         = $val->companyAddress;
            $companyNumber          = $val->companyNumber;
            $logo                   = $val->logo;
            $color                  = $val->color;
            $total                  = $val->total;
            $rsPayrollName          = $val->payrollName;
            $localAmount            = $val->totalLocal;
            $userProcess            = $val->userProcess;
            $payrollTypeName        = $val->payrollTypeName;
            $isIncome               = $val->isIncome;

            // echo 'key ' .$key;
            if ($isIncome == 1) {
                // if (condition) {
                    
                // }
                $totalAsignacion = $total;
                $totalAsignacionLocal = $localAmount;
                $print[0] = [
                    "countryId" =>  $rsCountryId, "companyId" =>  $rsCompanyId,  "payrollName" =>  $rsPayrollName, 
                    "totalAsignacion" =>  $totalAsignacion, "totalAsignacionLocal" =>  $totalAsignacionLocal,
                    "companyAddress" =>  $companyAddress, "companyNumber" =>  $companyNumber,
                    "logo" =>  $logo, "color" =>  $color,
                    "userProcess" =>  $userProcess,
                    "payrollTypeName" =>  $payrollTypeName,
                ];
                // $print[] = ["totalAsignacion" =>  $total];
            }
            if($isIncome == 0){
                $totalDeduccion = $total;
                $totalDeduccionLocal = $localAmount;
                $print[0] = [
                    "countryId" =>  $rsCountryId, "companyId" =>  $rsCompanyId,  "payrollName" =>  $rsPayrollName,
                    "totalAsignacion" =>  $totalAsignacion, "totalAsignacionLocal" =>  $totalAsignacionLocal,
                    "totalDeduccion" =>  $totalDeduccion, "totalDeduccionLocal" =>  $totalDeduccionLocal,
                    "companyAddress" =>  $companyAddress, "companyNumber" =>  $companyNumber,
                    "logo" =>  $logo, "color" =>  $color,
                    "userProcess" =>  $userProcess,
                    "payrollTypeName" =>  $payrollTypeName,

                ];
                
            } 
        }

        foreach ($oEmployees as $key => $staffCode) {
            
            $print[] =  DB::select('SELECT * , ( SELECT SUM(amount) FROM '. $table .' ' . $strTransactionType . ' 
                                    AND '. $table .'.countryId =  ' .$countryId. ' AND '. $table .'.companyId =  ' .$companyId. ' AND '. $table .'.payrollNumber = ' .$payrollNumber. ' 
                                    AND '. $table .'.isIncome = 1 AND '. $table .'.staffCode = '. "'" .$staffCode['code'] . "'" . ') as asignacion, 
                                    ( SELECT SUM(localAmount) FROM '. $table .' ' . $strTransactionType . ' AND '. $table .'.countryId = ' .$countryId. ' AND '. $table .'.companyId = ' .$companyId. ' 
                                        AND '. $table .'.payrollNumber = ' .$payrollNumber. ' AND '. $table .'.isIncome = 1 AND '. $table .'.staffCode = '. "'" .$staffCode['code'] . "'" . ') as asignacionLocal, 
                                    ( SELECT SUM(amount) FROM '. $table .' ' . $strTransactionType . ' AND '. $table .'.countryId = ' .$countryId. ' AND '. $table .'.companyId = ' .$companyId. ' AND '. $table .'.payrollNumber = ' .$payrollNumber. ' 
                                        AND '. $table .'.isIncome = 0 AND '. $table .'.staffCode = '. "'" .$staffCode['code'] . "'" . ') as deduccion,
                                    ( SELECT SUM(localAmount) FROM '. $table .' ' . $strTransactionType . ' AND '. $table .'.countryId = ' .$countryId. ' AND '. $table .'.companyId = ' .$companyId. '
                                        AND '. $table .'.payrollNumber = ' .$payrollNumber. ' AND '. $table .'.isIncome = 0 AND '. $table .'.staffCode = '. "'" .$staffCode['code'] . "'" . ') as deduccionLocal 
                            FROM `'. $table .'` ' . $strTransactionType . ' AND '. $table .'.countryId =' . $countryId . ' AND '. $table .'.companyId =' . $companyId . ' AND '. $table .'.payrollNumber =' .$payrollNumber . ' 
                            AND '. $table .'.staffCode = ' . "'". $staffCode['code']. "' ORDER BY  $table.transactionTypeCode");
        }

        // print_r($print);
        
        // echo $strStaffCode;
        return $print;

        
        // return $strTransaction;
    }

}
