<?php

namespace App\Models\Inventory;

use Auth;
use DB;
use App\Models\Inventory\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceCategory extends Model
{
    use SoftDeletes;
    use \Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

    public $timestamps = false;

    protected $table      = 'in_service_category';
    protected $primaryKey = 'categoryId';
    protected $fillable   = ['categoryId', 'categoryParentId', 'countryId', 'companyId', 'categoryName'];

    protected $dates = ['deleted_at'];

    // protected $appends = ['cost1','cost2'];
    public function getLocalKeyName()
    {
        return 'categoryId';
    }
    public function getParentKeyName()
    {
        return 'categoryParentId';
    }
//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
 //Relaciones recursivas de padre a busqueda de 

    public function categories() //https://laraveldaily.com/eloquent-recursive-hasmany-relationship-with-unlimited-subcategories/
    {
        return $this->hasMany(ServiceCategory::class, 'categoryParentId')->orderBy('categoryId', 'ASC');
    }

    //Relaciones con el arbol completo
    public function childrenCategoriesTree() //https://laraveldaily.com/eloquent-recursive-hasmany-relationship-with-unlimited-subcategories/#comment-411958
    {
        return $this->categories()->with('childrenCategoriesTree');
    }
    //Relaciones de primer nivel + segundo nivel
    public function childrenCategory()
    {
        return $this->hasMany(ServiceCategory::class, 'categoryParentId')->with('category');
    }
    //------------------------------//
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
        return $this->with('childrenCategoriesTree')
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
//  RECURSIVE QUERIES
  public function markLeafItems($collection, $categoryParentId = NULL)
  {
    foreach ($collection as $item) {

        if (count($item->childrenCategoriesTree) !== 0) {

            $item->leaf = false;

            foreach ($item->childrenCategoriesTree as $children) {

                if (count($children->childrenCategoriesTree) !== 0) {

                    $children->leaf = false;
                    $this->markLeafItems($children->childrenCategoriesTree, $children->categoryId);
                } else {

                    $children->leaf = true;
                    $this->markLeafItems($children->childrenCategoriesTree, $children->categoryId);
                }
            }
        } else {

            $item->leaf = true;
            $this->loadRelatedModels($item);
            dd($item);
            exit();

            //Sustitucion aqui
        }
    }
  }

  public function loadRelatedModels(ServiceCategory $serviceCategory)
  {
     $services = DB::table('in_service')->where('categoryId', $serviceCategory->categoryId)->get();
     $serviceCategory->services = $services;
 
     return $serviceCategory;
 }  
 
 public function showAllCompanyCategoriesHierarchicalMode($companyId)
 {
   $categories = ServiceCategory::with('childrenCategoriesTree')
       ->orderBy('categoryCode', 'ASC')
       ->where('categoryParentId', 0)
       ->where('companyId', $companyId)
       ->get();
       
   
   $this->markLeafItems($categories);

   dd($categories);
   exit();

   return response()->json(['data' => $categories], 200);
 }
}
