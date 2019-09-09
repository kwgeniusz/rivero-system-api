<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{

    public $timestamps = false;

    protected $table      = 'Permission';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'id',
        'name',
        'guard_name',
    ];
    //--------------------------------------------------------------------
    /** Relations */
    //--------------------------------------------------------------------

//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
    public function getAll()
    {
        return $this->orderBy('projectTypeName', 'ASC')->get();
    }
//------------------------------------------
    public function findById($id)
    {
        return $this->where('projectTypeId', '=', $id)->get();
    }
//------------------------------------------
    public function insertPT($projectName, $lastUserId)
    {

        $project                  = new ProjectType;
        $project->projectTypeName = $projectName;
        $project->dateCreated     = date('Y-m-d H:i:s');
        $project->lastUserId      = Auth::user()->userId;
        $project->save();
    }
//------------------------------------------
    public function updatePT($projectTypeId, $projectTypeName)
    {
        $this->where('projectTypeId', $projectTypeId)->update(array(
            'projectTypeName' => $projectTypeName,
        ));
    }
//------------------------------------------
    public function deletePT($projectTypeId)
    {
        return $this->where('projectTypeId', '=', $projectTypeId)->delete();
    }
//------------------------------------------
}