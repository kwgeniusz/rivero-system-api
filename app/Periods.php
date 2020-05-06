<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Periods extends Model
{
    public $timestamps = false;

    protected $table      = 'period';
    protected $primaryKey = 'periodId';

    protected $fillable = ['countryId', 'companyId', 'year', 'payrollTypeId', 'periodName', 'periodFrom',
    'periodTo', 'updated'];
    


}
