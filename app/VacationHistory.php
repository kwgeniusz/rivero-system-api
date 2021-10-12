<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class VacationHistory extends Model
{
    public $timestamps = false;

    protected $table      = 'hrpayroll_history';
    protected $primaryKey = 'hrpayrollHistoryId';

    protected $fillable = ['countryId', 'companyId', 'year', 'payrollNumber', 'payrollTypeId', 'userProcess', 'payrollName','staffCode', 'idDocument',
        'staffName', 'transactionTypeCode', 'isIncome', 'hasBalance', 'balance', 'quantity', 
        'amount', 'localCurrency','localAmount', 'exchangeRate'];
    


    function listVacationHistory( $country, $companyId ){
        return DB::select("SELECT hrpayroll_history.countryId, country.countryName, 
                            hrpayroll_history.companyId, company.companyName, 
                            hrpayroll_history.year, hrpayroll_history.payrollNumber, hrpayroll_history.payrollName, hrpayroll_history.payrollTypeId,
                            SUM(hrpayroll_history.amount) AS total,
                            SUM(hrpayroll_history.localAmount) AS totalLocal,
                            hrpayroll_history.exchangeRate
                        FROM `hrpayroll_history`
                        INNER JOIN country ON hrpayroll_history.countryId = country.countryId
                        INNER JOIN company ON hrpayroll_history.companyId = company.companyId
                        WHERE hrpayroll_history.countryId = $country
                        AND hrpayroll_history.companyId = $companyId
                        AND hrpayroll_history.payrollCategory = 'vacation'
                        GROUP BY hrpayroll_history.countryId, hrpayroll_history.companyId, hrpayroll_history.payrollNumber,hrpayroll_history.year
                        ORDER BY hrpayroll_history.companyId, hrpayroll_history.payrollNumber");
    }

    function getPreVacation($countryId, $companyId, $year, $payrollNumber){
        return DB::select("SELECT * FROM `hrpayroll` 
                            WHERE countryId = $countryId 
                            AND companyId = $companyId 
                            AND year = $year 
                            AND payrollNumber = $payrollNumber
                            AND payrollCategory = 'vacation'");
    }
    function getStaff($countryId, $companyId, $payrollTypeId){
        return DB::select("SELECT hrstaff.hrstaffId, hrstaff.staffCode, hrstaff.shortName, hrstaff.baseSalary, hrstaff.probationPeriod, hrstaff.employmentDate,
                            hrstaff.probationPeriodEnd, hrstaff.stopSS, hrstaff.blockSS, hrstaff.excTranTypeCode1, hrstaff.excTranTypeCode2, hrstaff.excTranTypeCode3,
                            hrstaff.probationSalary
                            FROM hrstaff 
                                INNER JOIN hrposition ON hrstaff.positionCode = hrposition.positionCode
                                WHERE hrstaff.countryId = $countryId 
                                    AND hrstaff.companyId  = $companyId 
                                    AND hrstaff.payrollTypeId = $payrollTypeId
                                    AND hrstaff.status = 'A'");
    }
    function delPermanentTracsaction($idTransType){
        $hoy = date("Y-m-d H:i:s");
    
        DB::update("UPDATE `hrpermanent_transaction` SET `deleted_at`= '$hoy', `balance` = 0
            WHERE hrpermanent_transaction.hrpermanentTransactionId = $idTransType");
    }
    // function insertPermanentTracsactionBlocked($countryId, $companyId, $staffCode, $transactionTypeCode, $quantity, $amount){
    //     $rs1 = DB::select("select cuotas from `hrpermanent_transaction`
    //     WHERE `hrpermanentTransactionId` = $idTransType");

    //     $cuotas = 0;
    //     $cuota = 0;
    //     foreach ($rs1 as $rs) {
    //         $cuotas  = $rs->cuotas;
    //         $cuota = $cuotas - 1;
    //         DB::update("UPDATE `hrpermanent_transaction` SET `balance`= $balance, `cuotas`= $cuota
    //             WHERE `hrpermanentTransactionId` = $idTransType");
            
    //     }
    //     // $cuota = $cuotas - 1;
    //     // return $cuota;
    //     // DB::update("UPDATE `hrpermanent_transaction` SET `balance`= $balance, `cuotas`= $cuota
    //     // WHERE `staffCode`= '$staffCode'
    //     // AND `transactionTypeCode` = $transactionTypeCode");
    // }

    function delPreVacation($countryId, $companyId, $year, $payrollNumber){
        DB::table('hrpayroll')
                ->where('hrpayroll.countryId', '=', $countryId)
                ->where('hrpayroll.companyId', '=', $companyId)
                ->where('hrpayroll.year', '=', $year)
                ->where('hrpayroll.payrollCategory', '=', 'vacation')
                ->where('hrpayroll.payrollNumber', '=', $payrollNumber)
                ->delete();
    }
    function delVacationControl($countryId, $companyId, $year, $payrollTypeId, $payrollNumber){
        DB::table('hrpayroll_control')
                ->where('hrpayroll_control.countryId', '=', $countryId)
                ->where('hrpayroll_control.companyId', '=', $companyId)
                ->where('hrpayroll_control.payrollTypeId', '=', $payrollTypeId)
                ->where('hrpayroll_control.year', '=', $year)
                ->where('hrpayroll_control.payrollCategory', '=', 'vacation')
                ->where('hrpayroll_control.payrollNumber', '=', $payrollNumber)
                ->delete();
    }

    function updateStatusPiriodVacation($countryId, $companyId, $year, $payrollTypeId, $payrollNumber){
        echo $countryId, $companyId, $year, $payrollTypeId, $payrollNumber;
        DB::update("UPDATE hrperiod SET `updated` = 1
                    WHERE hrperiod.countryId =$countryId 
                    AND hrperiod.companyId =$companyId
                    AND hrperiod.year =$year
                    AND hrperiod.payrollTypeId = $payrollTypeId
                    AND hrperiod.payrollNumber = $payrollNumber");
    }


}
