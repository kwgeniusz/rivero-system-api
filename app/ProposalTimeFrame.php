<?php

namespace App;

use App;
use DB;
use Illuminate\Database\Eloquent\Model;

class ProposalTimeFrame extends Model
{
    public $timestamps = false;

    protected $table      = 'proposal_time_frame';
    protected $primaryKey = 'propTimeId';
    // protected $fillable = ['propTimeId','proposalId','noteId','noteName'];
  
//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
   public function timeFrame()
   {
       return $this->belongsTo('App\TimeFrame', 'timeId','timeId');
   }
//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
    public function insert($proposalId,$timeId,$timeName) {

     $error = null;

        DB::beginTransaction();
        try {
            //INSERTA UN RENGLON
             $propTime                = new ProposalTimeFrame;
             $propTime->proposalId    = $proposalId;
             $propTime->timeId        = $timeId;
             $propTime->timeName      = $timeName;
             $propTime->save();
            
            $success = true;
            DB::commit();
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
            DB::rollback();
        }

        if ($success) {
            return $result = ['alertType' => 'success', 'message' => 'Time Frame agregados Exitosamente'];
        } else {
            return $result = ['alertType' => 'error', 'message' => $error];
        }
    }
//------------------------------------------
    public function deleteAll($proposalId)
    {
           $error = null;

        DB::beginTransaction();
        try {
            //BUSCAR EL RENGLON PARA SACAR SU proposalId y amount
             $oProposalTime = ProposalTimeFrame::where('proposalId',$proposalId)->delete();

            $success = true;
            DB::commit();
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
            DB::rollback();
        }

        if ($success) {
            return $result = ['alertType' => 'success', 'message' => 'Notas Eliminada Exitosamente'];
        } else {
            return $result = ['alertType' => 'error', 'message' => $error];
        }
    }
//-----------------------------------------

}
