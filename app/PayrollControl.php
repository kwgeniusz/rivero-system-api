<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PayrollControl extends Model
{
    public $timestamps = false;

    protected $table      = 'hrpayroll_control';
    protected $primaryKey = 'hrpayrollControlId';

    protected $fillable = ['countryId', 'companyId', 'payrollTypeId', 'year', 'payrollNumber','payrollName', 'processCode'];
    


}
