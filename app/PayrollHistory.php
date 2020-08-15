<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class PayrollHistory extends Model
{
    public $timestamps = false;

    protected $table      = 'hrpayroll_history';
    protected $primaryKey = 'hrpayrollHistoryId';

    protected $fillable = ['countryId', 'companyId', 'year', 'payrollNumber', 'payrollTypeId', 'payrollName','staffCode',
                         'staffName', 'transactionTypeCode', 'isIncome', 'hasBalance', 'balance', 'quantity', 
                         'amount','localAmount', 'exchangeRate'];
    


    function listPayRollHistory( $country = 2, $companyId = 4 ){
        return DB::select("SELECT hrpayroll.countryId, country.countryName, 
                            hrpayroll.companyId, company.companyName, 
                            hrpayroll.year, hrpayroll.payrollNumber, hrpayroll.payrollName, hrpayroll.payrollTypeId,
                            SUM(hrpayroll.amount) AS total,
                            SUM(hrpayroll.localAmount) AS totalLocal,
                            hrpayroll.exchangeRate
                        FROM `hrpayroll`
                        INNER JOIN country ON hrpayroll.countryId = country.countryId
                        INNER JOIN company ON hrpayroll.companyId = company.companyId
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
    function delPermanentTracsaction($staffCode, $transactionTypeCode){
        DB::table('hrpermanent_transaction')
                ->where('hrpermanent_transaction.staffCode', '=', $staffCode)
                ->where('hrpermanent_transaction.transactionTypeCode', '=', $transactionTypeCode)
                ->delete();
    }
    function updatePermanentTracsaction($staffCode, $transactionTypeCode, $balance){
        DB::update("UPDATE `hrpermanent_transaction` SET `balance`= $balance
        WHERE`staffCode`= '$staffCode'
        AND `transactionTypeCode` = $transactionTypeCode");
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
