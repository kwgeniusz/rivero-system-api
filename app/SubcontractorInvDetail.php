<?php

namespace App;

use App;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Payable;

class SubcontractorInvDetail extends Model
{
    //traits
    // use SoftDeletes;

    public $timestamps = false;

    protected $table      = 'subcontractor_invdetail';
    protected $primaryKey = 'subcontInvDetailId';
    protected $fillable = ['subcontInvDetailId','countryId','officeId','subcontId','invDetailId','transactionTypeId','transactionPercentage','transactionAmount'];
  
    protected $appends = ['transactionAmount'];
//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
  public function invoiceDetail()
  {
      return $this->hasOne('App\InvoiceDetail', 'invDetailId', 'invDetailId');
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
    public function getAllByInvDetail($invDetailId)
    {
        return $this->with('subcontractor')
                    ->where('invDetailId' , '=' , $invDetailId)
                    ->orderBy('subcontInvDetailId', 'ASC')
                    ->get();
    }
//--------------------------------------------------------------------
    public function verifyAmount($invDetailId,$transactionAmount)
    {
      //es true si puede insertar.
      //es false si NO puede insertar.
        $subcontInvDetails =  $this->getAllByInvDetail($invDetailId);

    if(!$subcontInvDetails->isEmpty()) {
             $total = 0;
           foreach ($subcontInvDetails as $item) {
             $total += $item->transactionAmount;
            }
             $total += $transactionAmount;
   
               if($total > $subcontInvDetails[0]->invoiceDetail->amount){
                 // echo "error no se puede superar el monto del servicio.";
                  return false;
               }else{
                 // echo "dale  insertalo"]
                  return true;
            }
      }else{
           $invoiceDetail = InvoiceDetail::find($invDetailId);

         if($transactionAmount > $invoiceDetail->amount){
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

          $verification = $this->verifyAmount($request['invDetailId'],$request['transactionAmount']);
         
             if($verification == false){
               throw new \Exception('Error: No se puede superar el monto del servicio, verifique si existe otro compromiso');
              }
            //INSERTA UN RENGLON
           $subcontInvDetail                         = new SubcontractorInvDetail;
           $subcontInvDetail->countryId              = session('countryId');
           $subcontInvDetail->officeId               = session('officeId');
           $subcontInvDetail->subcontId              = $request['subcontId'];
           $subcontInvDetail->invDetailId            = $request['invDetailId'];
           $subcontInvDetail->transactionTypeId      = null;
           $subcontInvDetail->transactionPercentage  = $request['transactionPercentage'];
           $subcontInvDetail->transactionAmount      = $request['transactionAmount'];
           $subcontInvDetail->save();
           
            //REALIZA INSERCION EN PAYABLE(CUENTAS POR PAGAR)
            $oPayable = new Payable;
            $oPayable->insertP($subcontInvDetail->subcontInvDetailId,$request['transactionAmount']);
            
            $success = true;
            DB::commit();
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
            DB::rollback();
        }

        if ($success) {
            return $result = ['alertType' => 'success', 'message' => 'Subcontratista agregado a la Factura'];
        } else {
            return $result = ['alertType' => 'error', 'message' => $error];
        }
    }
//------------------------------------------

//------------------------------------------
    public function deleteS($subcontInvDetailId)
    {
           $error = null;

        DB::beginTransaction();
        try {
            //ELIMINAR DE CUENTAS POR PAGAR
            $oPayable = new Payable;
            $oPayable->deleteBySubcont($subcontInvDetailId);
            //NO PERMITIR ELIMINAR SI EL ESTADO DEL PAYABLE ES PAGADO O EN PROCESO
            $register = SubcontractorInvDetail::destroy($subcontInvDetailId);
            

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
