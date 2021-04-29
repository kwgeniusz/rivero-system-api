<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class HrTransactionType extends Model
{
    public $timestamps = false;

    protected $table      = 'hrtransaction_type';
    protected $primaryKey = 'hrtransactionTypeId';

    protected $fillable = ['countryId', 'companyId', 'transactionTypeCode', 'transactionTypeName', 'salaryBased', 'isIncome',
        'hasBalance', 'blockSS','debitAccount','creditAccount','accTax','accChristmas','accSeniority'];
    
    function getComboTransactionType($country = 2,$company = 5 ){
        return DB::table('hrtransaction_type')
                ->select('hrtransaction_type.*')
                ->where('hrtransaction_type.companyId', '=',$company)
                ->where('hrtransaction_type.countryId', '=',$country)
                ->orderBy('transactionTypeCode', 'asc')
                ->get();
    }
     

}
