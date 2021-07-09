<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CostCategory extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $table      = 'cost_category';
    protected $primaryKey = 'costCategoryId';
    protected $fillable   = ['costCategoryId', 'serviceName', 'hasCost', 'unit1','unit2','cost1','cost2','variableName'];

    // protected $appends = ['costSubcategory'];
    protected $dates = ['deleted_at'];

    // protected $appends = ['cost1','cost2'];
//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
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
    /** Relations */
//--------------------------------------------------------------------

    public function costSubcategory()
    {
        return $this->hasMany('App\CostCategory', 'parentCostCategoryId', 'costCategoryId');
    }
    public function allCostSubcategory()
    {
        return $this->costSubcategory()->with('allCostSubcategory');
    } 
//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
    public function getAll()
   {
       return $this->where('parentCostCategoryId' , '=' , 0)
                   ->with('allCostSubcategory')
                   ->orderBy('costCategoryCode', 'ASC')
                   ->get();
    }
    public function getAllSubCategoryById($costCategoryId)
    {
        return $this->where('parentCostCategoryId' , '=' , $costCategoryId)
                    ->orderBy('costCategoryCode', 'ASC')
                    ->get();
    }

//------------------------------------------
    public function findById($id)
    {
        return $this->where('costCategoryId', '=', $id)->get();
    }
//------------------------------------------
    public function insertS($countryId,$companyId,$serviceName,$hasCost,$unit1,$unit2,$cost1,$cost2)
    {
        $service                  = new Service;
        $service->countryId       = $countryId;
        $service->companyId        = $companyId;
        $service->serviceName     = $serviceName;
        $service->hasCost         = $hasCost;
        $service->unit1           = $unit1;
        $service->unit2           = $unit2;
        $service->cost1           = $cost1;
        $service->cost2           = $cost2;
        $service->created_at     = date('Y-m-d H:i:s');
        $service->userId      = Auth::user()->userId;
        $service->save();
    }
//------------------------------------------
    public function updateS($costCategoryId,$serviceName,$cost1 ='',$cost2 = '')
    {
        $this->where('costCategoryId', $costCategoryId)->update(array(
            'serviceName' => $serviceName,
            'cost1' => $cost1,
            'cost2' => $cost2,
        ));
    }
//------------------------------------------
    public function deleteS($costCategoryId)
    {
        return $this->where('costCategoryId', '=', $costCategoryId)->delete();
    }
//------------------------------------------
}
