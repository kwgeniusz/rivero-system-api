<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Periods extends Model
{
    public $timestamps = false;

    protected $table      = 'hrperiod';
    protected $primaryKey = 'periodId';

    protected $fillable = ['countryId', 'companyId', 'year', 'payrollTypeId', 'payrollNumber','periodName', 'periodFrom',
    'periodTo', 'updated'];
    


}
