<?php

namespace App\Models\Inventory;

use Auth;
use App\Models\Inventory\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceCategory extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $table      = 'in_service_category';
    protected $primaryKey = 'categoryId';
    protected $fillable   = ['categoryId', 'categoryParentId', 'countryId', 'companyId', 'categoryName'];

    protected $dates = ['deleted_at'];

    // protected $appends = ['cost1','cost2'];

//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
 //Relaciones recursivas de padre a busqueda de 

    //Relaciones de primer nivel
    public function subcategory() 
    {
        return $this->hasMany(ServiceCategory::class, 'categoryParentId')->orderBy('categoryId', 'ASC');
    }
    //Relaciones de primer nivel + segundo nivel
    public function childrenCategory()
    {
        return $this->hasMany(ServiceCategory::class, 'categoryParentId')->with('subcategory');
    }
    //------------------------------//
    //Relaciones con el arbol completo
    public function childrenCategoryTree() 
    {
        return $this->subcategory()->with('childrenCategoryTree');
    }
    //Fin relaciones recursivas
 //--------------------------------------------------------------------
               /** MUTADORES **/
//--------------------------------------------------------------------
// public function setcategoryParentIdAttribute($categoryParentId)
// {
//     if($categoryParentId == null || empty($categoryParentId)) { 
//        return  $this->attributes['categoryParentId'] = 0;
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
        return $this->with('childrenCategoryTree')
                    ->where('companyId' , '=' , $companyId)
                    ->where('categoryParentId' , '=' , 0)
                    ->orderBy('categoryId', 'ASC')
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
        $service->categoryParentId = $data['categoryParentId'];
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
        $service->categoryParentId = $data['categoryParentId'];
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
