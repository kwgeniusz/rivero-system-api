<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class RrhhDepartment extends Model
{
    public $timestamps = false;

    protected $table      = 'department';
    protected $primaryKey = 'departmentId';

    protected $fillable = ['departmentId','companyId', 'departmentName', 'parentDepartmentId'];
}
