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
    // }
//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
    public function getAll()
    {
        return $this->orderBy('serviceId', 'ASC')->get();
    }
//------------------------------------------
    public function findById($id)
    {
        return $this->where('serviceId', '=', $id)->get();
    }
//------------------------------------------
    public function insertST($serviceTypeName)
    {

        $service                  = new ServiceType;
        $service->serviceTypeName = $serviceTypeName;
        $service->dateCreated     = date('Y-m-d H:i:s');
        $service->lastUserId      = Auth::user()->userId;
        $service->save();
    }
//------------------------------------------
    public function updateST($serviceTypeId, $serviceTypeName)
    {
        $this->where('serviceTypeId', $serviceTypeId)->update(array(
            'serviceTypeName' => $serviceTypeName,
        ));
    }
//------------------------------------------
    public function deleteST($serviceTypeId)
    {
        return $this->where('serviceTypeId', '=', $serviceTypeId)->delete();
    }
//------------------------------------------
}
