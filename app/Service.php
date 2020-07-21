<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $table      = 'service';
    protected $primaryKey = 'serviceId';
    protected $fillable   = ['serviceId', 'serviceName', 'hasCost', 'unit1','unit2','cost1','cost2','variableName'];

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
    /** Function of Models */
//--------------------------------------------------------------------
    public function getAll()
    {
        return $this->orderBy('serviceName', 'ASC')->get();
    }
//-----------------------------------------
     public function getAllByOffice($companyId)
    {

        return $this->where('companyId' , '=' , $companyId)
          ->orderBy('serviceName', 'ASC')
          ->get();
    }
//------------------------------------------
    public function findById($id)
    {
        return $this->where('serviceId', '=', $id)->get();
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
        // $service->lastUserId      = Auth::user()->userId;
        $service->save();
    }
//------------------------------------------
    public function updateS($serviceId,$serviceName,$cost1 ='',$cost2 = '')
    {
        $this->where('serviceId', $serviceId)->update(array(
            'serviceName' => $serviceName,
            'cost1' => $cost1,
            'cost2' => $cost2,
        ));
    }
//------------------------------------------
    public function deleteS($serviceId)
    {
        return $this->where('serviceId', '=', $serviceId)->delete();
    }
//------------------------------------------
}
