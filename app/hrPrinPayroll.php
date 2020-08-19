<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class hrPrinPayroll extends Model
{
    
    function getPayrollList(){
        return DB::select("SELECT hrpayroll_history.*, country.countryName, payroll_type.payrollTypeName, company.companyName
                        FROM `hrpayroll_history`
                        INNER JOIN country ON hrpayroll_history.countryId = country.countryId
                        INNER JOIN company ON hrpayroll_history.companyId = company.companyId
                        INNER JOIN payroll_type ON hrpayroll_history.payrollTypeId = payroll_type.payrollTypeId
                        GROUP BY hrpayroll_history.countryId,hrpayroll_history.companyId,hrpayroll_history.payrollNumber,hrpayroll_history.year
                        ORDER BY hrpayroll_history.companyId, hrpayroll_history.payrollNumber");
    }
    function headerPayroll($countryId, $companyId, $year, $payrollNumber, $payrollTypeId){
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
                ) AS totalasignacion,
                (
                    SELECT SUM(localAmount)  FROM hrpayroll_history
                        WHERE hrpayroll_history.countryId = $countryId
                        AND hrpayroll_history.companyId = $companyId
                        AND hrpayroll_history.year =  $year
                        AND hrpayroll_history.payrollNumber = $payrollNumber
                        AND hrpayroll_history.payrollTypeId =  $payrollTypeId
                        AND hrpayroll_history.isIncome = 1
                ) AS totalasignacionLocal,
                (
                    SELECT SUM(amount)  FROM hrpayroll_history
                        WHERE hrpayroll_history.countryId = $countryId
                        AND hrpayroll_history.companyId = $companyId
                        AND hrpayroll_history.year =  $year
                        AND hrpayroll_history.payrollNumber =  $payrollNumber
                        AND hrpayroll_history.payrollTypeId =  $payrollTypeId
                        AND hrpayroll_history.isIncome = 0
                ) AS totaldeduccion,
                (
                    SELECT SUM(localAmount)  FROM hrpayroll_history
                        WHERE hrpayroll_history.countryId =  $countryId
                        AND hrpayroll_history.companyId =  $companyId
                        AND hrpayroll_history.year =  $year
                        AND hrpayroll_history.payrollNumber = $payrollNumber
                        AND hrpayroll_history.payrollTypeId =  $payrollTypeId
                        AND hrpayroll_history.isIncome = 0
                ) AS totaldeduccionLocal
            
            FROM hrpayroll_history 
            INNER JOIN country ON hrpayroll_history.countryId = country.countryId
            INNER JOIN company ON hrpayroll_history.companyId = company.companyId
            INNER JOIN payroll_type ON hrpayroll_history.payrollTypeId = payroll_type.payrollTypeId
            WHERE hrpayroll_history.countryId = $countryId
                AND hrpayroll_history.companyId = $companyId
                AND hrpayroll_history.year =  $year
                AND hrpayroll_history.payrollNumber =  $payrollNumber
            GROUP BY hrpayroll_history.staffCode");
    }

    function detailPayroll($countryId, $companyId, $year, $payrollNumber, $staffCode) {
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
                                            ) as asignacion,
                                            (
                                            SELECT SUM(localAmount) FROM hrpayroll_history
                                                WHERE hrpayroll_history.countryId = $countryId
                                            AND hrpayroll_history.companyId = $companyId
                                            AND hrpayroll_history.year = $year
                                            AND hrpayroll_history.payrollNumber =$payrollNumber
                                                AND hrpayroll_history.isIncome = 1
                                                AND hrpayroll_history.staffCode = '$staffCode'
                                            ) as asignacionLocal,
                                            (
                                            SELECT SUM(amount) FROM hrpayroll_history
                                                WHERE hrpayroll_history.countryId = $countryId
                                            AND hrpayroll_history.companyId = $companyId
                                            AND hrpayroll_history.year =$year
                                            AND hrpayroll_history.payrollNumber = $payrollNumber
                                                AND hrpayroll_history.isIncome = 0
                                                AND hrpayroll_history.staffCode = '$staffCode'
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
                                    ORDER BY hrpayroll_history.transactionTypeCode");
    } 

}
