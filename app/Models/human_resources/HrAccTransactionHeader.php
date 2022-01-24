<?php

namespace App\Models\human_resources;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class HrAccTransactionHeader extends Model
{
    public $timestamps = false;

    protected $table      = 'acc_transaction_header_tmp';
    protected $primaryKey = 'headerId';

    protected $guarded = ['headerId'];

    protected $dates = [
        'entryDate',
    ];

    public static function getPayrollHistoryByPeriod($companyId, $countryId, $year, $payrollNumber){

        $listPayrollType = DB::table('hrpayroll_history')
            ->where('hrpayroll_history.companyId', '=', $companyId)
            ->where('hrpayroll_history.countryId', '=', $countryId)
            ->where('hrpayroll_history.year', '=', $year)
            ->where('hrpayroll_history.payrollNumber', '=', $payrollNumber)
            ->get();
        return $listPayrollType;
    }

    public static function transactionTypeCode($transactionTypeCode){

        $accEquivalence = DB::table('acc_equivalence')
            ->where('acc_equivalence.dataSource', '=', $transactionTypeCode)
            ->get();
        return $accEquivalence;
    }
    public static function GetGeneralLedgerId($account){

        return collect(DB::table('acc_general_ledger')
            ->where('acc_general_ledger.accountCode', '=', $account)
            ->select('acc_general_ledger.generalLedgerId')
            ->get()->first());
    }
}
