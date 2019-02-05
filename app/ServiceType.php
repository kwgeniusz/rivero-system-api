<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class ServiceType extends Model
{
    public    $timestamps = false;

    protected $table ='service_type';
    protected $primaryKey = 'serviceTypeId';
    protected $fillable = [ 'projectTypeId','serviceTypeId',
    'serviceTypeName','dateCreated','lastUserId' ];

//--------------------------------------------------------------------
/** Relations */
//--------------------------------------------------------------------  
    public function projectType() {  
         return $this->belongsTo('App\ProjectType','projectTypeId');
    }
//--------------------------------------------------------------------
/** Function of Models */
//--------------------------------------------------------------------
  public function getAll() {
     return $this->orderBy('serviceTypeId','ASC')->get();
  }
//------------------------------------------
  public function findById($id) {
       return $this->where('serviceTypeId', '=', $id)->get(); 
   }
//------------------------------------------
  public function insertST($projectTypeId,$serviceTypeName) {
       
    $service = new ServiceType;
    $service->projectTypeId = $projectTypeId;
    $service->serviceTypeName = $serviceTypeName;
    $service->dateCreated = date('Y-m-d H:i:s');
    $service->lastUserId = Auth::user()->userId;
    $service->save();
   }
//------------------------------------------
   public function updateST($serviceTypeId,$projectTypeId,$serviceTypeName) {		
       $this->where('serviceTypeId', $serviceTypeId)->update(array(
             'projectTypeId'  => $projectTypeId,
             'serviceTypeName'  => $serviceTypeName,
       ));	
    }
//------------------------------------------
    public function deleteST($serviceTypeId) {		
       return $this->where('serviceTypeId', '=', $serviceTypeId)->delete(); 	
    }	
//------------------------------------------
}
