<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    public $timestamps = false;

    protected $table      = 'hrpayroll';
    protected $primaryKey = 'hrpayrollId';

    protected $fillable = ['countryId', 'companyId', 'year', 'payrollNumber', 'payrollTypeId', 'payrollName','staffCode',
                         'staffName', 'transactionTypeCode', 'isIncome', 'hasBalance', 'balance','quantity', 'amount','localAmount', 'exchangeRate'];
    


}
