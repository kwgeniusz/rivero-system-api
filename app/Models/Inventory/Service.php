<?php

namespace App\Models\Inventory;

use Auth;
use App\Models\Inventory\Service;
use App\Models\Inventory\ServiceCategory;
use App\Models\Intercompany\ServiceEquivalence;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use \Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;
// use Kalnoy\Nestedset\NodeTrait;

class Service extends Model
{
    use SoftDeletes;
    // use \Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

    public $timestamps = false;

    protected $table      = 'in_service';
    protected $primaryKey = 'serviceId';
    protected $fillable   = ['serviceId', 'serviceParentId', 'countryId', 'companyId', 'serviceName','unit','cost'];


    protected $dates = ['deleted_at'];

    // protected $appends = ['cost1','cost2'];

// Change defautl field for recursive librery
 
public function getLocalKeyName()
{
    return 'serviceId';
}
public function getParentKeyName()
{
    return 'serviceParentId';
}
//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
 //Relaciones

    public function categories() 
    {
        return $this->hasOne(ServiceCategory::class, 'categoryId','categoryId');
    }
    //Fin relaciones recursivas
    public function serviceEquivalence()
    {
     return $this->hasOne(ServiceEquivalence::class, 'originServiceId', 'serviceId')
                 ->with('destinationCompany','destinationService');
    }
 //--------------------------------------------------------------------
               /** MUTADORES **/
//--------------------------------------------------------------------
// public function setServiceParentIdAttribute($serviceParentId)
// {
//     if($serviceParentId == null || empty($serviceParentId)) { 
//        return  $this->attributes['serviceParentId'] = 0;
//     }
// }
public function setUnitAttribute($unit)
{
    if($unit == null || empty($unit)) { 
       return  $this->attributes['unit'] = '';
    }
}
public function setCostAttribute($cost)
{
    if($cost == null || empty($cost)) { 
       return  $this->attributes['cost'] = 0;
    }
}
//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
    // public function getAll()
    // {
    //     return $this->orderBy('serviceCode', 'ASC')->get();
    // }
//-----------------------------------------
     public function getAllByCompany($companyId)
    {
        return $this->with('categories')
                    ->where('companyId' , '=' , $companyId)
                    ->orderBy('serviceName', 'ASC')
                    ->get();
    }
//-----------------------------------------
public function getAllByCompanyWithLinkedService($companyId,$linkedCompanyId)
{
    return $this->with(['serviceEquivalence' => function($q) use($linkedCompanyId){ 
        $q->where('destinationCompanyId', $linkedCompanyId);
    }])->where('companyId' , '=' , $companyId)
       ->orderBy('serviceName', 'ASC')
       ->get();
}

public function destinationServiceWithOriginLink($companyId,$companyId2)
{
      return $this->leftjoin('intercompany_service_equivalence',  function($join) use($companyId2) {
             $join->on('service.serviceId', '=', 'intercompany_service_equivalence.destinationServiceId')->where('originCompanyId', '=', $companyId2);
        })->where('companyId' , '=' , $companyId)
          ->orderBy('serviceName', 'ASC')
          ->get();
}
//------------------------------------------
    public function findById($id)
    {
        return $this->where('serviceId', '=', $id)->get();
    }
//------------------------------------------
    public function insertS($countryId,$companyId,$data)
    { 
        $service                  = new Service;
        $service->countryId       = $countryId;
        $service->companyId       = $companyId;
        $service->serviceParentId = $data['serviceParentId'];
        $service->serviceCode     = $data['serviceCode'];
        $service->serviceName     = $data['serviceName'];
        $service->unit            = $data['unit'];
        $service->cost            = $data['cost'];
        $service->created_at      = date('Y-m-d H:i:s');
        $service->userId          = Auth::user()->userId;
        $service->save();
    }
//------------------------------------------
    public function updateS($serviceId,$data)
    { 
        $service                  =  Service::find($serviceId);
        $service->serviceParentId = $data['serviceParentId'];
        $service->serviceCode     = $data['serviceCode'];
        $service->serviceName     = $data['serviceName'];
        $service->unit            = $data['unit'];
        $service->cost            = $data['cost'];
        $service->save();
    }
//------------------------------------------
    public function deleteS($serviceId)
    {
        return $this->where('serviceId', '=', $serviceId)->delete();
    }
//------------------------------------------
}
