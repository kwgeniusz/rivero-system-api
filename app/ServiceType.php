<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;

class ServiceType extends Model
{
    public $timestamps = false;

    protected $table      = 'service_type';
    protected $primaryKey = 'serviceTypeId';
    protected $fillable   = ['serviceTypeId',
        'serviceTypeName', 'dateCreated', 'lastUserId'];

//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
    public function contract()
    {
        return $this->hasMany('App\Contract', 'serviceTypeId', 'serviceTypeId');
    }
//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
    public function getAll()
    {
        return $this->orderBy('serviceTypeId', 'ASC')->get();
    }
//------------------------------------------
    public function findById($id)
    {
        return $this->where('serviceTypeId', '=', $id)->get();
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
