<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hrStaff extends Model
{
    public $timestamps = false;

    protected $table      = 'hrstaff';
    protected $primaryKey = 'hrstaffId';

    protected $fillable = ['countryId', 'companyId', 'shortName', 'firstName', 'idDocument', 'lastName',
    'passportNumber', 'legalNumber','staffCode', 'departmentId', 'payrollTypeId', 'positionCode', 'baseSalary', 'baseCurrencyId',
    'localSalary', 'localCurrencyId', 'localDailySalary', 'excTranTypeCode1', 'excTranTypeCode2', 'excTranTypeCode3', 'status'];
    


}
