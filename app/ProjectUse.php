<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;

class ProjectUse extends Model
{
    public $timestamps = false;

    protected $table      = 'project_use';
    protected $primaryKey = 'projectUseId';
    protected $fillable   = ['projectUseId',
        'projectUseName', 'dateCreated', 'lastUserId'];

//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
    public function contract()
    {
        return $this->hasMany('App\Contract', 'projectUseId', 'projectUseId');
    }
//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
    public function getAll()
    {
        return $this->orderBy('projectUseId', 'ASC')->get();
    }
//------------------------------------------
    public function findById($id)
    {
        return $this->where('projectUseId', '=', $id)->get();
    }
//------------------------------------------
    public function insertST($projectUseName)
    {

        $service                  = new ProjectUse;
        $service->projectUseName  = $projectUseName;
        $service->dateCreated     = date('Y-m-d H:i:s');
        $service->lastUserId      = Auth::user()->userId;
        $service->save();
    }
//------------------------------------------
    public function updateST($projectUseId, $projectUseName)
    {
        $this->where('projectUseId', $projectUseId)->update(array(
            'projectUseName' => $projectUseName,
        ));
    }
//------------------------------------------
    public function deleteST($projectUseId)
    {
        return $this->where('projectUseId', '=', $projectUseId)->delete();
    }
//------------------------------------------
}
