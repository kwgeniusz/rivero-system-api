<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public $timestamps = false;

    protected $table      = 'service';
    protected $primaryKey = 'serviceId';
    protected $fillable   = ['serviceId', 'serviceName', 'hasCost', 'unit1','unit2','cost1','cost2','variableName'];

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
     public function getAllByOffice($officeId)
    {

        return $this->where('officeId' , '=' , $officeId)
          ->orderBy('serviceName', 'ASC')
          ->get();
    }
//------------------------------------------
    public function findById($id)
    {
        return $this->where('serviceId', '=', $id)->get();
    }
//------------------------------------------
    public function insertS($countryId,$officeId,$serviceName,$hasCost,$unit1,$unit2,$cost1,$cost2)
    {
        $service                  = new Service;
        $service->countryId       = $countryId;
        $service->officeId        = $officeId;
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
    public function updateS($serviceId, $serviceName)
    {
        $this->where('serviceId', $serviceId)->update(array(
            'serviceName' => $serviceName,
        ));
    }
//------------------------------------------
    public function deleteS($serviceId)
    {
        return $this->where('serviceId', '=', $serviceId)->delete();
    }
//------------------------------------------
}
