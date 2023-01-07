<?php

namespace App;

use App;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProposalNote extends Model
{
    //traits
    // use SoftDeletes;

    public $timestamps = false;

    protected $table      = 'proposal_note';
    protected $primaryKey = 'propNoteId';
    protected $fillable = ['propNoteId','proposalId','noteId','noteName'];
  
//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
   public function note()
   {
       return $this->belongsTo('App\Note', 'noteId','noteId');
   }
//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------

// //------------------------------------
//     public function getAllByProposal($proposalId)
//     {
//         $result = $this->where('proposalId', $proposalId)
//             ->orderBy('propNoteId', 'ASC')
//             ->get();

//         return $result;
//     }
//------------------------------------------
    public function insert($proposalId,$noteId,$noteName) {

     $error = null;

        DB::beginTransaction();
        try {
            //INSERTA UN RENGLON
             $propNote                   = new ProposalNote;
             $propNote->proposalId        = $proposalId;
             $propNote->noteId           = $noteId;
             $propNote->noteName         = $noteName;
             $propNote->save();
            
            $success = true;
            DB::commit();
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
            DB::rollback();
        }

        if ($success) {
            return $result = ['alertType' => 'success', 'message' => 'Notas agregadas Exitosamente'];
        } else {
            return $result = ['alertType' => 'error', 'message' => $error];
        }
    }
//------------------------------------------

//------------------------------------------
    public function deleteAll($id)
    {
           $error = null;

        DB::beginTransaction();
        try {
            //BUSCAR EL RENGLON PARA SACAR SU proposalId y amount
             $oProposalNote = ProposalNote::where('proposalId',$id)->delete();

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
