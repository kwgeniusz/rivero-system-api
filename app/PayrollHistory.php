<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class PayrollHistory extends Model
{
    public $timestamps = false;

    protected $table      = 'hrpayroll_history';
    protected $primaryKey = 'hrpayrollHistoryId';

    protected $fillable = ['countryId', 'companyId', 'year', 'payrollNumber', 'payrollTypeId', 'userProcess', 'payrollName','staffCode', 'idDocument',
                         'staffName', 'transactionTypeCode', 'isIncome', 'hasBalance', 'balance', 'quantity', 
                         'amount', 'localCurrency','localAmount', 'exchangeRate'];
    


    function listPayRollHistory( $country, $companyId ){
        return DB::select("SELECT hrpayroll.countryId, country.countryName, 
                            hrpayroll.companyId, company.companyName, 
                            hrpayroll.year, hrpayroll.payrollNumber, hrpayroll.payrollName, hrpayroll.payrollTypeId,
                            SUM(hrpayroll.amount) AS total,
                            SUM(hrpayroll.localAmount) AS totalLocal,
                            hrpayroll.exchangeRate
                        FROM `hrpayroll`
                        INNER JOIN country ON hrpayroll.countryId = country.countryId
                        INNER JOIN company ON hrpayroll.companyId = company.companyId
                        WHERE hrpayroll.countryId = $country
                        AND hrpayroll.companyId = $companyId
                        GROUP BY hrpayroll.countryId, hrpayroll.companyId, hrpayroll.payrollNumber,hrpayroll.year
                        ORDER BY hrpayroll.companyId, hrpayroll.payrollNumber");
    }

    function getPrePayRoll($countryId, $companyId, $year, $payrollNumber){
        return DB::select("SELECT * FROM `hrpayroll` 
                            WHERE countryId = $countryId 
                            AND companyId = $companyId 
                            AND year = $year 
                            AND payrollNumber = $payrollNumber");
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
    function updatePermanentTracsaction($idTransType, $balance){
        $rs1 = DB::select("select cuotas from `hrpermanent_transaction`
        WHERE `hrpermanentTransactionId` = $idTransType");

        $cuotas = 0;
        $cuota = 0;
        foreach ($rs1 as $rs) {
            $cuotas  = $rs->cuotas;
            $cuota = $cuotas - 1;
            DB::update("UPDATE `hrpermanent_transaction` SET `balance`= $balance, `cuotas`= $cuota
                WHERE `hrpermanentTransactionId` = $idTransType");
            
        }
        // $cuota = $cuotas - 1;
        // return $cuota;
        // DB::update("UPDATE `hrpermanent_transaction` SET `balance`= $balance, `cuotas`= $cuota
        // WHERE `staffCode`= '$staffCode'
        // AND `transactionTypeCode` = $transactionTypeCode");
    }

    function delPrePayroll($countryId, $companyId, $year, $payrollNumber){
        DB::table('hrpayroll')
                ->where('hrpayroll.countryId', '=', $countryId)
                ->where('hrpayroll.companyId', '=', $companyId)
                ->where('hrpayroll.year', '=', $year)
                ->where('hrpayroll.payrollNumber', '=', $payrollNumber)
                ->delete();
    }
    function delPayrollControl($countryId, $companyId, $year, $payrollTypeId, $payrollNumber){
        DB::table('hrpayroll_control')
                ->where('hrpayroll_control.countryId', '=', $countryId)
                ->where('hrpayroll_control.companyId', '=', $companyId)
                ->where('hrpayroll_control.payrollTypeId', '=', $payrollTypeId)
                ->where('hrpayroll_control.year', '=', $year)
                ->where('hrpayroll_control.payrollNumber', '=', $payrollNumber)
                ->delete();
    }

    function updateStatusPiriod($countryId, $companyId, $year, $payrollTypeId, $payrollNumber){
        echo $countryId, $companyId, $year, $payrollTypeId, $payrollNumber;
        DB::update("UPDATE hrperiod SET `updated` = 1
                    WHERE hrperiod.countryId =$countryId 
                    AND hrperiod.companyId =$companyId
                    AND hrperiod.year =$year
                    AND hrperiod.payrollTypeId = $payrollTypeId
                    AND hrperiod.payrollNumber = $payrollNumber");
    }

    // function insertPayollHistory(){
    //     $hrpayroll = new PayrollHistory();
    //     $hrpayroll->countryId = $countryId;
    //     $hrpayroll->companyId = $companyId;
    //     $hrpayroll->year = $year;
    //     $hrpayroll->payrollNumber = $payrollNumber;
    //     $hrpayroll->payrollName = $payrollName;
    //     $hrpayroll->staffCode = $staffCode;
    //     $hrpayroll->staffName = $staffName;
    //     $hrpayroll->transactionTypeCode = $transactionTypeCode;
    //     $hrpayroll->isIncome = $isIncome;
    //     $hrpayroll->hasBalance = $hasBalance;
    //     $hrpayroll->balance = $balance;
    //     $hrpayroll->quantity = $quantity;
    //     $hrpayroll->amount = $amount;
    //     $hrpayroll->localAmount = $localAmount;
    //     $hrpayroll->exchangeRate = $exchangeRate;
    //     $hrpayroll->save();
    // }

}
