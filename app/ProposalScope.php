<?php

namespace App;

use App;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProposalScope extends Model
{
    //traits
    // use SoftDeletes;

    public $timestamps = false;

    protected $table      = 'proposal_scope';
    protected $primaryKey = 'propScopeId';
    protected $fillable = ['propScopeId','proposalId','description'];
  
//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------

// //------------------------------------
//     public function getAllByProposal($proposalId)
//     {
//         $result = $this->where('proposalId', $proposalId)
//             ->orderBy('propScopeId', 'ASC')
//             ->get();

//         return $result;
//     }
//------------------------------------------
    public function insert($proposalId,$description) {

     $error = null;

        DB::beginTransaction();
        try {
            //INSERTA UN RENGLON
             $propScope                   = new ProposalScope;
             $propScope->proposalId        = $proposalId;
             $propScope->description      = $description;
             $propScope->save();
            
            $success = true;
            DB::commit();
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
            DB::rollback();
        }

        if ($success) {
            return $result = ['alertType' => 'success', 'message' => 'Alcances agregados Exitosamente'];
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
             $oProposalScope = ProposalScope::where('proposalId',$id)->delete();

            $success = true;
            DB::commit();
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
            DB::rollback();
        }

        if ($success) {
            return $result = ['alertType' => 'success', 'message' => 'Alcances Eliminados Exitosamente'];
        } else {
            return $result = ['alertType' => 'error', 'message' => $error];
        }
    }
//-----------------------------------------

}
