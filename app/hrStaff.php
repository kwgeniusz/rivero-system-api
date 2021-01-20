<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

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
    
    function getComboStaff(){
        return DB::table('hrstaff')
                ->select('hrstaff.shortName','hrstaff.staffCode','hrstaff.countryId','hrstaff.companyId')
                ->where('hrstaff.countryId', '=',session('countryId'))
                ->where('hrstaff.companyId', '=',session('companyId'))
                // ->where('hrstaff.companyId', '=',4)
                ->get();
    }

}

