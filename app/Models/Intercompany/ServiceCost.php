<?php

namespace App\Models\Intercompany;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceCost extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $table      = 'intercompany_service_cost';
    protected $primaryKey = 'intercompanyCostId';        
    protected $fillable   = ['intercompanyCostId','countryId','companyId','projectUseId','serviceId','targetCountryId','targetCompanyId','targetCompanyPercentage','targetCompanyCost','targetSubcontractorPercentage','targetSubcontractorCost'];  
//--------------------------------------------------------------------',
    /** Relations */
//--------------------------------------------------------------------;
 
 
//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
  public function findById($id)
    {
        return $this->where('timeId', '=', $id)->get();
    }


}
