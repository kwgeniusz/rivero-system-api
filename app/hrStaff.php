<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hrStaff extends Model
{
    public $timestamps = false;

    protected $table      = 'hrstaff';
    protected $primaryKey = 'hrstaffId';

    protected $fillable = ['countryId', 'companyId', 'staffCode', 'firstName', 'lastName', 'shortName',
    'idDocument', 'passportNumber','legalNumber', 'departmentId', 'hrpositionId', 'baseSalary', 'baseCurrencyId', 'localSalary',
    'localCurrencyId', 'localDailySalary'];
    


}
