<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public $timestamps = false;

    protected $table      = 'company';
    protected $primaryKey = 'companyId';

    protected $fillable = ['companyName', 'companyShortName', 'companyNumber', 'countryId', 'officeId', 'companyAddress'];
    


}
