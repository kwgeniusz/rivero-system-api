<?php

namespace App\Models\Intercompany;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Company;
use App\TimeFrame;

class TimeFrameEquivalence extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $table      = 'intercompany_time_frame_equivalence';
    protected $primaryKey = 'timeEquivId';
    protected $fillable   = ['originTimeId', 'originCompanyId', 'destinationTimeId', 'destinationCompanyId','unit2','cost1','cost2','variableName'];

//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------

   public function destinationCompany()
   {
    return $this->hasOne(Company::class, 'companyId', 'destinationCompanyId');
   }

   public function destinationTime()
   {
    return $this->hasOne(TimeFrame::class, 'timeId', 'destinationTimeId');
   }
 
//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
  public function findById($id)
    {
        return $this->where('timeId', '=', $id)->get();
    }
//------------------------------------------
    public function insertTime($localTime,$destinationTime)
    {             
    //    dd($localTime);
        $timeFrame                       = new TimeFrameEquivalence;
        $timeFrame->originTimeId         = $localTime['timeId'];
        $timeFrame->originCompanyId      = $localTime['companyId'];
        $timeFrame->destinationTimeId    = $destinationTime['timeId'];
        $timeFrame->destinationCompanyId = $destinationTime['companyId'];
        $timeFrame->save();
    }
//------------------------------------------
    public function deleteS($timeId)
    {
        return $this->where('timeId', '=', $timeId)->delete();
    }
//------------------------------------------


}
