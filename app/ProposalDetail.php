<?php

namespace App;

use App;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProposalDetail extends Model
{
    //traits
    // use SoftDeletes;

    public $timestamps = false;

    protected $table      = 'proposal_detail';
    protected $primaryKey = 'propDetailId';
    protected $fillable = ['propDetailId','proposalId','serviceId','serviceName','unit','unitCost','quantity','amount'];
  
    protected $appends = ['unitCost','amount'];
//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
   public function service()
   {
       return $this->belongsTo('App\Service', 'serviceId','serviceId');
   }
//--------------------------------------------------------------------
    /** Accesores  */
//--------------------------------------------------------------------
    public function getUnitCostAttribute($unitCost)
    {
       return decrypt($this->attributes['unitCost']);
    }
    public function getAmountAttribute($amount)
    {
       return decrypt($this->attributes['amount']);
    }
//--------------------------------------------------------------------
    /** Mutadores  */
//--------------------------------------------------------------------

    public function setUnitCostAttribute($unitCost)
    {
         if($unitCost != null) { 
        $unitCost = number_format((float)$unitCost, 2, '.', '');
    }
        return $this->attributes['unitCost'] = encrypt($unitCost);
    }
     public function setAmountAttribute($amount)
    {
          if($amount != null) { 
        $amount = number_format((float)$amount, 2, '.', '');
    }
        return $this->attributes['amount'] = encrypt($amount);
    }
//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------

//------------------------------------
    public function getAllByProposal($proposalId)
    {
        $result = $this->where('proposalId', $proposalId)
            ->orderBy('itemNumber', 'ASC')
            ->get();

        return $result;
    }
//------------------------------------------
    public function insert($proposalId,$itemNumber,$serviceId,$serviceName,$unit,$unitCost,$quantity,$amount) {

     $error = null;

        DB::beginTransaction();
        try {

              if($amount == '0.00') {
                $amount = null;
              }
              
            //INSERTA UN RENGLON
             $propDetail                   = new ProposalDetail;
             $propDetail->proposalId        = $proposalId;
             $propDetail->itemNumber        = $itemNumber;
             $propDetail->serviceId        = $serviceId;
             $propDetail->serviceName      = $serviceName;
             $propDetail->unit             = $unit;
             $propDetail->unitCost         = $unitCost;
             $propDetail->quantity         = $quantity;
             $propDetail->amount           = $amount;
             $propDetail->save();
            
            //REALIZA ACTUALIZACION EN PROPUESTA
            $oProposal = new Proposal;
            $oProposal->updateProposalTotal('+', $proposalId, $amount);
            
            $success = true;
            DB::commit();
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
            DB::rollback();
        }

        if ($success) {
            return $result = ['alertType' => 'success', 'message' => 'Reglon Agregado Exitosamente'];
        } else {
            return $result = ['alertType' => 'error', 'message' => $error];
        }
    }
//------------------------------------------

//------------------------------------------
    public function deleteProp($id)
    {
           $error = null;

        DB::beginTransaction();
        try {
            //ELIMINA TODOS LOS ITEMS DE LA PROPUESTA
             $oProposalDetail = ProposalDetail::where('proposalId',$id)->delete();
         
            // //REALIZA ACTUALIZACION EN PROPUESTA
              //BUSCO LA PROPUESTA
            $prop = Proposal::find($id);
            $oProposal = new Proposal; 
            $oProposal->updateProposalTotal('-',$prop->proposalId, $prop->grossTotal); // RESTA TODO EL MONTO DE GROSSTOTAL PARA QUE HAGA EL DESCUENTO.

            $success = true;
            DB::commit();
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
            DB::rollback();
        }

        if ($success) {
            return $result = ['alertType' => 'success', 'message' => 'Reglones Eliminados Exitosamente'];
        } else {
            return $result = ['alertType' => 'error', 'message' => $error];
        }
    }
//-----------------------------------------

}
