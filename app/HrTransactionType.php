<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HrTransactionType extends Model
{
    public $timestamps = false;

    protected $table      = 'hrtransaction_type';
    protected $primaryKey = 'hrtransactionTypeId';

    protected $fillable = ['countryId', 'companyId', 'transactionTypeCode', 'transactionTypeName', 'salaryBased', 'isIncome',
        'hasBalance'];
    


}
