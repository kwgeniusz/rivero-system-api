<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PayRollType extends Model
{
    public $timestamps = false;

    protected $table      = 'payroll_type';
    protected $primaryKey = 'payrollTypeId';

    protected $fillable = ['countryId', 'payrollTypeName', 'payrollTypeDescription'];
    


}
