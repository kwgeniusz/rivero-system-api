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
    
//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
 
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
