<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    public $timestamps = false;

    protected $table      = 'hrprocess';
    protected $primaryKey = 'hrprocessId';

    protected $fillable = ['countryId', 'companyId', 'processCode', 'processName'];
    


}
