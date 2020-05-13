<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HrPosition extends Model
{
    public $timestamps = false;

    protected $table      = 'hrposition';
    protected $primaryKey = 'hrpositionId';

    protected $fillable = ['countryId', 'positioncode', 'positionName', 'baseSalary', 'baseCurrencyId', 'localSalary',
        'localCurrencyId', 'localDailySalary'];
    


}
