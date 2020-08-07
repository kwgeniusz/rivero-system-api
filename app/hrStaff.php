<?php

namespace App;

use DB;
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
    'passportNumber', 'legalNumber','staffCode', 'departmentId', 'payrollTypeId', 'positionCode', 'employmentDate', 'probationPeriod', 'probationPeriodEnd',
    'baseSalary', 'probationSalary', 'baseCurrencyId',
    'localSalary', 'localCurrencyId', 'localDailySalary', 'stopSS', 'blockSS', 'excTranTypeCode1', 'excTranTypeCode2', 'excTranTypeCode3', 'status', 'deleted_at'];
    
    function getComboStaff($country = 2, $company = 4){
        return DB::table('hrstaff')
                ->select('hrstaff.shortName','hrstaff.staffCode','hrstaff.countryId','hrstaff.companyId')
                ->where('hrstaff.countryId', '=',$country)
                ->where('hrstaff.companyId', '=',$company)
                // ->where('hrstaff.companyId', '=',4)
                ->get();
    }

}
