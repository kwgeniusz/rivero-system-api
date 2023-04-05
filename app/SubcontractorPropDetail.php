<?php

namespace App;

use App;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Payable;

class SubcontractorPropDetail extends Model
{
    //traits
    // use SoftDeletes;

    public $timestamps = false;

    protected $table      = 'subcontractor_propdetail';
    protected $primaryKey = 'subcontPropDetailId';
    protected $fillable = ['subcontPropDetailId','countryId','companyId','subcontId','propDetailId','transactionTypeId','transactionPercentage', 'transactionUnitCost', 'transactionQuantity','transactionAmount'];
  
    protected $appends = ['transactionAmount'];
//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
   public function invoice()
  {
      return $this->belongsTo('App\Invoice', 'invoiceId', 'invoiceId');
  }   
  public function proposalDetail()
  {
      return $this->hasOne('App\ProposalDetail', 'propDetailId', 'propDetailId');
  }
  public function subcontractor()
  {
      return $this->hasOne('App\Subcontractor', 'subcontId', 'subcontId');
  }
//--------------------------------------------------------------------
    /** Accesores  */
//--------------------------------------------------------------------
   public function getTransactionAmountAttribute($transactionAmount)
    {
       return decrypt($this->attributes['transactionAmount']);
    }
//--------------------------------------------------------------------
    /** Mutadores  */
//--------------------------------------------------------------------
    public function setTransactionAmountAttribute($transactionAmount)
    { 
        $transactionAmount = number_format((float)$transactionAmount, 2, '.', '');
        return $this->attributes['transactionAmount'] = encrypt($transactionAmount);
    } 
//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------  
    public function getAllByInvDetail($propDetailId)
    {
        return $this->with('subcontractor')
                    ->where('propDetailId' , '=' , $propDetailId)
                    ->orderBy('subcontPropDetailId', 'ASC')
                    ->get();
    }
//--------------------------------------------------------------------
    public function verifyAmount($propDetailId,$transactionAmount)
    {
      //es true si puede insertar.
      //es false si NO puede insertar.
        $subcontPropDetails =  $this->getAllByInvDetail($propDetailId);

    if(!$subcontPropDetails->isEmpty()) {
             $total = 0;
           foreach ($subcontPropDetails as $item) {
             $total += $item->transactionAmount;
            }
             $total += $transactionAmount;
   
               if($total > $subcontPropDetails[0]->proposalDetail->amount){
                 // echo "error no se puede superar el monto del servicio.";
                  return false;
               }else{
                 // echo "dale  insertalo"]
                  return true;
            }
      }else{
           $proposalDetail = ProposalDetail::find($propDetailId);

         if($transactionAmount > $proposalDetail->amount){
            return false;
         }else{
            return true;
         }
      }     
   }
//------------------------------------------
    public function insertS($request) {

     $error = null;

        DB::beginTransaction();
        try {

          $verification = $this->verifyAmount($request['propDetailId'],$request['transactionAmount']);
         
             if($verification == false){
               throw new \Exception('Error: No se puede superar el monto del servicio, verifique si existe otro compromiso');
              }

            //INSERTA UN RENGLON
           $subcontInvDetail                         = new SubcontractorPropDetail;
           $subcontInvDetail->subcontId              = $request['subcontId'];
           $subcontInvDetail->invoiceId              = $request['invoiceId'];
           $subcontInvDetail->propDetailId            = $request['propDetailId'];
           $subcontInvDetail->transactionPercentage  = $request['transactionPercentage'];
           $subcontInvDetail->transactionUnitCost    = $request['transactionUnitCost'];
           $subcontInvDetail->transactionQuantity    = $request['transactionQuantity'];
           $subcontInvDetail->transactionAmount      = $request['transactionAmount'];
           $subcontInvDetail->save();
           
            //REALIZA INSERCION EN PAYABLE(CUENTAS POR PAGAR)
            $oPayable = new Payable;
            $oPayable->insertP($subcontInvDetail->subcontPropDetailId,$request['transactionAmount']);
            
            $success = true;
            DB::commit();
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
            DB::rollback();
        }

        if ($success) {
            return $result = ['alertType' => 'success', 'message' => 'Subcontratista agregado a la Propuesta'];
        } else {
            return $result = ['alertType' => 'error', 'message' => $error];
        }
    }
//------------------------------------------
    public function deleteS($subcontPropDetailId)
    {
           $error = null;

        DB::beginTransaction();
        try {
            $oPayable = new Payable;
            $rs = $oPayable->findBySubcont($subcontPropDetailId);
         //NO PERMITIR ELIMINAR SI EL ESTADO DEL PAYABLE ES PAGADO O EN PROCESO
             if($rs[0]->acumAmountPaid <> 0){
                throw new \Exception('Error:No se puede Eliminar, Esta Cuenta por pagar esta en Proceso o ya fue pagada.');
               }  
            //ELIMINAR DE CUENTAS POR PAGAR
            $oPayable->deleteBySubcont($subcontPropDetailId);
            $register = SubcontractorPropDetail::destroy($subcontPropDetailId);
            

             $success = true;
            DB::commit();
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
            DB::rollback();
        }

        if ($success) {
            return $result = ['alertType' => 'success', 'message' => 'Ha Removido al Subcontratista Exitosamente'];
        } else {
            return $result = ['alertType' => 'error', 'message' => $error];
        }
    }
//-----------------------------------------

}
