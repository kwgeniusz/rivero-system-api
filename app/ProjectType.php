<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;

class ProjectType extends Model
{

    public $timestamps = false;

    protected $table      = 'project_type';
    protected $primaryKey = 'projectTypeId';
    protected $fillable   = [
        'projectTypeId',
        'projectTypeName',
        'dateCreated',
        'lastUserId',
    ];
    //--------------------------------------------------------------------
    /** Relations */
    //--------------------------------------------------------------------
    public function contract()
    {
        return $this->hasMany('App\Contract', 'projectTypeId', 'projectTypeId');
    }
//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
    public function getAll()
    {
        return $this->orderBy('projectTypeId', 'ASC')->get();
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
