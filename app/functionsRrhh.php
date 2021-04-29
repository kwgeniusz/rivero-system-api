<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class functionsRrhh extends Model
{
   
    function getNetSalary($staff, $countryId, $companyId){
        // calcula el salario neto del empleado

        $neto[] = DB::select("SELECT SUM(hrpermanent_transaction.amount) AS bonos, hrstaff.baseSalary
                                FROM hrpermanent_transaction
                                    INNER JOIN hrtransaction_type ON hrpermanent_transaction.transactionTypeCode = hrtransaction_type.transactionTypeCode
                                    INNER JOIN hrstaff ON hrpermanent_transaction.staffCode = hrstaff.staffCode
                                WHERE hrpermanent_transaction.staffCode = '$staff'
                                AND (hrpermanent_transaction.transactionTypeCode = 1003
                                    OR hrpermanent_transaction.transactionTypeCode = 1002 
                                    OR hrpermanent_transaction.transactionTypeCode = 1007)
                                AND hrpermanent_transaction.blocked = 0
                                AND hrtransaction_type.countryId = $countryId
                                AND hrtransaction_type.companyId = $companyId");
      
    return $neto;
    }

    function getPreviousBalance($staff){
        $countryId = session('countryId');
        $companyId = session('companyId');
        return DB::select("SELECT SUM(hrpermanent_transaction.balance) AS prestamos 
                                FROM hrpermanent_transaction 
                                INNER JOIN hrtransaction_type ON hrpermanent_transaction.transactionTypeCode = hrtransaction_type.transactionTypeCode 
                                INNER JOIN hrstaff ON hrpermanent_transaction.staffCode = hrstaff.staffCode 
                            WHERE hrpermanent_transaction.staffCode = '$staff' 
                            AND hrpermanent_transaction.deleted_at IS NULL
                            AND hrtransaction_type.isIncome = 0 
                            AND hrtransaction_type.salaryBased = 0
                            AND hrtransaction_type.hasBalance = 1
                            AND hrtransaction_type.countryId = $countryId 
                            AND hrtransaction_type.companyId = $companyId");
    }

    // reportes
    function getStaffReceipt(){
        $countryId = session('countryId');
        $companyId = session('companyId');
        return DB::select("SELECT `staffCode`,`shortName`,`idDocument` 
                            FROM `hrstaff` 
                            WHERE `countryId`= $countryId
                            AND `companyId`  = $companyId
                            AND `status` ='A'");
    }
    function getHistoryReceipt($staff){
        $countryId = session('countryId');
        $companyId = session('companyId');

        $rs = DB::select("SELECT hrpayroll_history.`countryId`, hrpayroll_history.`companyId`, hrpayroll_history.payrollName, hrpayroll_history.year,
                            hrpayroll_history.payrollNumber,hrpayroll_history.staffCode, hrpayroll_history.isIncome, SUM(hrpayroll_history.amount) AS amount
                                FROM hrpayroll_history 
                            WHERE hrpayroll_history.staffCode = '$staff'
                            AND  hrpayroll_history.isIncome = 1
                            AND hrpayroll_history.countryId = $countryId
                            AND hrpayroll_history.companyId = $companyId
                            GROUP BY hrpayroll_history.year,hrpayroll_history.payrollNumber");
        return $rs;
    }

}
