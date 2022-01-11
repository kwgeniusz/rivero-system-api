<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class PayRollType extends Model
{
    public $timestamps = false;

    protected $table      = 'payroll_type';
    protected $primaryKey = 'payrollTypeId';

    protected $fillable = ['countryId', 'payrollTypeName', 'payrollTypeDescription'];
    
    function getPayrollType(){
        $countryId = session('countryId');
        $listPayrollType = DB::table('payroll_type')
            ->where('payroll_type.countryId', '=', $countryId)
            ->get();
        return $listPayrollType;
    }


    
}
