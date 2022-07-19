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
    use \Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

    public $timestamps = false;

    protected $table      = 'proposal_detail';
    protected $primaryKey = 'propDetailId';
    protected $fillable = ['propDetailId','proposalId','serviceId', 'serviceParentId','serviceName','unit','unitCost','quantity','amount'];
  
    protected $appends = ['unitCost','amount'];

// Change defautl field for recursive librery

    public function getLocalKeyName()
    {
        return 'serviceId';
    }
    public function getParentKeyName()
    {
        return 'serviceParentId';
    }
//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
//Relaciones recursivas

    //Relaciones de primer nivel
    public function proposalDetail() 
    {
        return $this->hasMany(ProposalDetail::class, 'serviceParentId','serviceId');
    }
    //Relaciones con el arbol completo
    public function childrenServiceTree() 
    {
        return $this->proposalDetail()->with('childrenServiceTree');
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

    public function getAllByProposal($proposalId)
    {
        $result = $this->where('proposalId', $proposalId)
            ->orderBy('propDetailId', 'ASC')
            ->get();

        return $result;
    }

    public function getAllByProposalAndGroup($proposalId)
    {
        $result = ProposalDetail::where('serviceParentId', 0)
                                ->where('proposalId', $proposalId)
                                ->get()
                                ->map(function ($items) {
                                    return $items->load('childrenServiceTree');
                                 });

        return $result;
    }
//------------------------------------------
    public function insert($proposalId, $itemNumber, $isCategory ,$serviceId, $serviceParentId ,$serviceName,$unit,$unitCost,$quantity,$amount) {

     $error = '';

        DB::beginTransaction();
        try {

              if($amount == '0.00') {
                $amount = 0.00;
              }
              
            //INSERTA UN RENGLON
             $propDetail                     = new ProposalDetail;
             $propDetail->proposalId         = $proposalId;
             $propDetail->itemNumber         = $itemNumber;
             $propDetail->isCategory         = $isCategory;
             $propDetail->serviceId          = $serviceId;
             $propDetail->serviceParentId    = $serviceParentId;
             $propDetail->serviceName        = $serviceName;
             $propDetail->unit               = $unit;
             $propDetail->unitCost           = $unitCost;
             $propDetail->quantity           = $quantity;
             $propDetail->amount             = $amount;
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
            return ['alertType' => 'success', 'message' => 'Reglon Agregado Exitosamente','entity' => $propDetail];
        } else {
            return ['alertType' => 'error', 'message' => $error];
        }
    }
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

function cascadeBalanceUpdate($proposalId, $selectedService)
{

    DB::beginTransaction();
    try {    
      
     $serviceId = $selectedService->serviceId;
     $amount    = $selectedService->amount;

      if ($selectedService->serviceParentId == 0) { //HAY CAMBIAR ESTA LINEA POR serviceParentId == 0 (porque no tiene padre)
         $serviceParentId = 0;
      } else {
         $serviceParentId = $selectedService->serviceParentId;
      }
  // actualizar saldo en cascada
  $loop = 1;
  $acum = 0;
  // inicio del loop
  while($loop == 1) {

     // actualizar el saldo de cuenta con $serviceId
        if($acum > 0){ 
          $msg = $this->sumAmount($proposalId,$serviceId,$amount);
        }
      // consulta para saber el siguiente nivel de arriba
      $serviceId  = 0;
      $query      =  $this->where('proposalId','=',$proposalId)
                          ->where('serviceId','=',$serviceParentId) //  serviceId = serviceParentId  
                          ->get();
                  
      foreach($query as $row){
          $serviceId          = $row->serviceId;
          if ($row->serviceParentId == 0) { //serviceParentId
             $serviceParentId = 0;          // serviceParentId = 0
          } else {
             $serviceParentId  = $row->serviceParentId;   // serviceParentId = $row-> serviceParentId
          }
      }
      // condicion de salida del ciclo while
      if ($serviceId == 0 ) {
         $loop = 0;
      }
        $acum++;
    }//end of the loop
            $success = true;
            DB::commit();
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
            DB::rollback();
        }

        if ($success) {
            return ['alertType' => 'info', 'message' => 'Actualizacion en cascada Exitosa'];
        } else {
            return ['alertType' => 'error', 'message' => $error];
        }
  }//end of the function

  function sumAmount($proposalId,$serviceId,$amount)
  {
    // obtener $saldos actuales
      DB::beginTransaction();
      try {   
          $query = $this->where('proposalId', '=', $proposalId)
                        ->where('serviceId', '=', $serviceId)
                        ->get();
  
            //Actualizar saldos en tabl acc_general_ledger_balance
            foreach($query as $row){
                  $row->amount    = $row->amount + $amount;
                  $row->save();
            }

           $success = true;
           DB::commit();
      } catch (\Exception $e) {
          $error   = $e->getMessage();
          $success = false;
          DB::rollback();
      }
  
      if ($success) {
        return ['alertType' => 'success', 'message' => 'El monto ha sido sumando en el renglon.'];
      } else {
        return ['alertType' => 'error', 'message' => $error];
      }
   }//end function
}
