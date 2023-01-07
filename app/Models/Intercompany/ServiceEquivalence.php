<?php

namespace App\Models\Intercompany;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Company;
use App\Service;

class ServiceEquivalence extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $table      = 'intercompany_service_equivalence';
    protected $primaryKey = 'serviceEquivId';
    protected $fillable   = ['originServiceId', 'originCompanyId', 'destinationServiceId', 'destinationCompanyId','unit2','cost1','cost2','variableName'];

//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------

   public function destinationCompany()
   {
    return $this->hasOne(Company::class, 'companyId', 'destinationCompanyId');
   }

   public function destinationService()
   {
    return $this->hasOne(Service::class, 'serviceId', 'destinationServiceId');
   }
 //--------------------------------------------------------------------
    /** Accesores  */
//--------------------------------------------------------------------
//     public function getCost1Attribute($cost1)
//     {
//         return decrypt($cost1);
//     }
//     public function getCost2Attribute($cost2)
//     {
//         return decrypt($cost2);
//     }
// //--------------------------------------------------------------------
    /** Mutadores  */
//--------------------------------------------------------------------

    // public function setCost1Attribute($cost1)
    // {
    //     return $this->attributes['cost1'] = encrypt($cost1);
    // }
    //  public function setCost2Attribute($cost2)
    // {
    //     return $this->attributes['cost2'] = encrypt($cost2);
    // }s
//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
    public function insertS($localService,$destinationService)
    {             
        $equivalence                       = new ServiceEquivalence;
        $equivalence->originServiceId      = $localService['serviceId'];
        $equivalence->originCompanyId      = $localService['companyId'];
        $equivalence->destinationServiceId = $destinationService['serviceId'];
        $equivalence->destinationCompanyId = $destinationService['companyId'];
        $equivalence->save();
    }
//------------------------------------------
    public function deleteS($serviceId)
    {
        return $this->where('serviceId', '=', $serviceId)->delete();
    }
//------------------------------------------
}
