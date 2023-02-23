<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;

class ProjectDescription extends Model
{

    public $timestamps = false;

    protected $table      = 'project_description';
    protected $primaryKey = 'projectDescriptionId';
    protected $fillable   = [
        'projectDescriptionId',
        'projectDescriptionName',
        'dateCreated',
        'lastUserId',
    ];
    //--------------------------------------------------------------------
    /** Relations */
    //--------------------------------------------------------------------
    public function contract()
    {
        return $this->hasMany('App\Contract', 'projectDescriptionId', 'projectDescriptionId');
    }
//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
    public function getAll()
    {
        return $this->orderBy('projectDescriptionName', 'ASC')->get();
    }
//------------------------------------------
    public function findById($id)
    {
        return $this->where('projectDescriptionId', '=', $id)->get();
    }
//------------------------------------------
    public function insertPT($projectName, $lastUserId)
    {

        $project                  = new ProjectDescription;
        $project->projectDescriptionName = $projectName;
        $project->dateCreated     = date('Y-m-d H:i:s');
        $project->lastUserId      = Auth::user()->userId;
        $project->save();
    }
//------------------------------------------
    public function updatePT($projectDescriptionId, $projectDescriptionName)
    {
        $this->where('projectDescriptionId', $projectDescriptionId)->update(array(
            'projectDescriptionName' => $projectDescriptionName,
        ));
    }
//------------------------------------------
    public function deletePT($projectDescriptionId)
    {
        return $this->where('projectDescriptionId', '=', $projectDescriptionId)->delete();
    }
//------------------------------------------
}
