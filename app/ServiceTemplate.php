<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;

class ServiceTemplate extends Model
{
    public $timestamps = false;

    protected $table      = 'service_template';
    protected $primaryKey = 'serviceTemId';
    protected $fillable   = ['serviceTemId', 'ServiceTemName'];

    // protected $appends = ['cost1','cost2'];
//--------------------------------------------------------------------
    /** Relations */
//-------------------------------------------------------------------
    public function service()
    {
        return $this->belongsToMany('App\Service', 'service_template_detail', 'serviceTemId', 'serviceId')->withPivot('serviceTemDetailId');
    }
//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
//------------------------------------------
    public function findById($id)
    {
        return $this->where('serviceTemId', '=', $id)->get();
    }
//------------------------------------------    
    public function getAll()
    {
        return $this->orderBy('serviceTemId', 'ASC')->get();
    }
//------------------------------------------
    public function insertST($serviceTemName)
    {

        $service                  = new ServiceType;
        $service->serviceTemName = $serviceTemName;
        $service->save();
    }
//------------------------------------------
    public function updateST($serviceTemId, $serviceTemName)
    {
        $this->where('serviceTemId', $serviceTemId)->update(array(
            'serviceTemName' => $serviceTemName,
        ));
    }
//------------------------------------------
    public function deleteST($serviceTemId)
    {
        return $this->where('serviceTemId', '=', $serviceTemId)->delete();
    }
//------------------------------------------
}
