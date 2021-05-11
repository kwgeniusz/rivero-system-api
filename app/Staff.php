<?php

namespace App;

use App\Contract;
use App\Company;
use App\Position;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Staff extends Model
{
    public $timestamps = false;

    protected $table      = 'hrstaff';
    protected $primaryKey = 'hrstaffId';

    protected $fillable = [
        'staffId',
        'staffCategoryId',
        'countryId',
        'companyId',
        'userId',
        'fullName',
        'positionId',
    ];
//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
    public function contract()
    {
        return $this->belongsToMany('App\Contract');
    }
    public function position()
    {
        return $this->belongsTo('App\Position', 'positionId');
    }
    public function company()
    {
        return $this->belongsTo('App\Company', 'companyId');
    }
//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
    public function getAll()
    {
        return $this->orderBy('staffId', 'ASC')->get();
    }
    public function getAvailableStaff($contractId)
    {
        $result = DB::select("SELECT staff.staffId,staff.fullName FROM staff 
                             LEFT JOIN contract_staff ON contract_staff.staffId = staff.staffId
                             AND contract_staff.contractId = $contractId 
                             WHERE  contract_staff.staffId IS NULL and positionId='8' ");

        return $result;
    }
//------------------------------------------

}
