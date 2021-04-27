<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TimeFrame extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $table      = 'time_frame';
    protected $primaryKey = 'timeId';
    protected $fillable = ['timeId','countryId','companyId','timeName','deleted_at'];

    protected $dates = ['deleted_at'];

//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
     public function proposal()
    {
        return $this->belongsToMany('App\Proposal');
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
    public function insertT($countryId,$companyId,$timeName)
    {
        $time                  = new TimeFrame;
        $time->countryId       = $countryId;
        $time->companyId       = $companyId;
        $time->timeName        = $timeName;
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
}
