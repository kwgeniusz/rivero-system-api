<?php

namespace App;

use App;
use DB;
use Illuminate\Database\Eloquent\Model;

class ProposalTerm extends Model
{
    public $timestamps = false;

    protected $table      = 'proposal_term';
    protected $primaryKey = 'propTermId';
    protected $fillable   = ['propTermId','proposalId','termId','termName'];
  
//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
    public function insert($proposalId,$termId,$termName) {

     $error = null;

        DB::beginTransaction();
        try {
            //INSERTA UN RENGLON
             $propTerm                = new ProposalTerm;
             $propTerm->proposalId    = $proposalId;
             $propTerm->termId        = $termId;
             $propTerm->termName      = $termName;
             $propTerm->save();
            
            $success = true;
            DB::commit();
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
            DB::rollback();
        }

        if ($success) {
            return $result = ['alertType' => 'success', 'message' => 'Terminos agregados Exitosamente'];
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
            $oProposalTerm = ProposalTerm::where('proposalId',$proposalId)->delete();

            $success = true;
            DB::commit();
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
            DB::rollback();
        }

        if ($success) {
            return $result = ['alertType' => 'success', 'message' => 'Terminos Eliminados'];
        } else {
            return $result = ['alertType' => 'error', 'message' => $error];
        }
    }
//-----------------------------------------

}
