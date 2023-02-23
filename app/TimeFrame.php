<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Intercompany\TimeFrameEquivalence;

class TimeFrame extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $table      = 'time_frame';
    protected $primaryKey = 'timeId';
    protected $fillable = ['timeId','countryId','companyId','timeName','daysRepresented','deleted_at'];

    protected $dates = ['deleted_at'];

//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
     public function proposal()
    {
        return $this->belongsToMany('App\Proposal');
    }

    public function timeFrameEquivalence()
    {
     return $this->hasOne(TimeFrameEquivalence::class, 'originTimeId', 'timeId')
                 ->with('destinationCompany','destinationTime');
    }
//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
     public function findById($id)
    {
        return $this->where('timeId', '=', $id)->get();
    }
    public function getAllByCompany($companyId)
    {
        return $this->where('companyId' , '=' , $companyId)
          ->orderBy('timeName', 'ASC')
          ->get();
    }
//------------------------------------------
    public function insertT($countryId,$companyId,$timeName,$daysRepresented)
    {
        $time                  = new TimeFrame;
        $time->countryId       = $countryId;
        $time->companyId       = $companyId;
        $time->timeName        = $timeName;
        $time->daysRepresented        = $daysRepresented;
        $time->save();
    }

//------------------------------------------
    public function updateT($timeId, $timeName)
    {
        $this->where('timeId', $timeId)->update(array(
            'timeName' => $timeName,
        ));
    }
//------------------------------------------
    public function deleteT($timeId)
    {
        return $this->where('timeId', '=', $timeId)->delete();
    }
//------------------------------------------

public function getAllByCompanyWithLinkedTime($companyId,$linkedCompanyId)
{
    return $this->with(['timeFrameEquivalence' => function($q) use($linkedCompanyId){ 
        $q->where('destinationCompanyId', $linkedCompanyId);
    }])->where('companyId' , '=' , $companyId)
       ->orderBy('timeName', 'ASC')
       ->get();
}

public function destinationTimeWithOriginLink($companyId,$companyId2)
{

      return $this->leftjoin('intercompany_time_frame_equivalence',  function($join) use($companyId2) {
             $join->on('time_frame.timeId', '=', 'intercompany_time_frame_equivalence.destinationTimeId')->where('originCompanyId', '=', $companyId2);
        })->where('companyId' , '=' , $companyId)
          ->orderBy('timeName', 'ASC')
          ->get();
}

}
