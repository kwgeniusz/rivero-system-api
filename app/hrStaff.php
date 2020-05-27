<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class hrStaff extends Model
{
    use SoftDeletes;
    public $timestamps = false;
    protected $table      = 'hrstaff';
    protected $primaryKey = 'hrstaffId';
    protected $dates = ['deleted_at'];
   
    protected $fillable = ['countryId', 'companyId', 'shortName', 'firstName', 'idDocument', 'lastName',
    'passportNumber', 'legalNumber','staffCode', 'departmentId', 'payrollTypeId', 'positionCode', 'baseSalary', 'baseCurrencyId',
    'localSalary', 'localCurrencyId', 'localDailySalary', 'excTranTypeCode1', 'excTranTypeCode2', 'excTranTypeCode3', 'status', 'deleted_at'];
    


}
